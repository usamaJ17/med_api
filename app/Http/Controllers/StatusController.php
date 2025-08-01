<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusReaction;
use App\Models\MutedStatusNotification;
use App\Models\StatusFlag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    /**
     * GET /api/status?filter=muted|unmuted
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->query('filter', 'unmuted');

        $mutedIds = $user->mutedStatusNotifications()->pluck('muted_user_id');

        $query = Status::with(['user', 'reactions.user', 'views'])
            ->where('expires_at', '>', now())
            ->where('scheduled_at', '<=', now());

        if ($filter === 'muted') {
            $query->whereIn('user_id', $mutedIds);
        } else {
            $query->whereNotIn('user_id', $mutedIds);
        }

        if(isset($request->user_id)){
            $query->where('user_id' , $request->user_id);
        }

        $statuses = $query
            ->latest()
            ->get()
            ->map(function ($status) {
                return [
                    'id' => $status->id,
                    'user_id' => $status->user_id,
                    'user_name' => $status->user->fullName(),
                    'user_profile_picture_url' => $status->user->getProfileImageAttribute(),
                    'caption' => $status->caption,
                    'media_url' => $status->getFirstMediaUrl('status_media'),
                    'expires_at' => $status->expires_at,
                    'duration' => $status->duration,
                    'viewed' => $status->wasViewedBy(Auth::id()),
                    'reaction' => optional($status->reactionBy(Auth::id()))->emoji,
                    'total_reactions' => $status->reactions->count(),
                    'view_count' => $status->views->count(),
                ];
            });

        return response()->json([
            'status' => 200,
            'message' => 'Status list fetched successfully',
            'data' => $statuses,
        ], 200);
    }


    /**
     * POST /api/status
     */
    public function store(Request $request)
    {
        $request->validate([
            'caption' => 'nullable|string|max:255',
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240',
            'scheduled_at' => 'nullable|date|after_or_equal:now'
        ]);

        $userId = Auth::id();

        $start = $request->scheduled_at ? Carbon::parse($request->scheduled_at) : now();
        $end = $start->copy()->addHours(24);

        $conflict = Status::where('user_id', $userId)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('scheduled_at', '<', $end)
                        ->whereRaw('DATE_ADD(IFNULL(scheduled_at, created_at), INTERVAL 24 HOUR) > ?', [$start]);
                });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'status' => 409,
                'message' => 'You already have an active or scheduled status that overlaps this time range.'
            ], 409);
        }

        $status = Status::create([
            'user_id' => $userId,
            'caption' => $request->caption,
            'duration' => $request->duration ?? '00:00:05',
            'scheduled_at' => $request->scheduled_at ? Carbon::parse($request->scheduled_at) : Carbon::now(),
            'expires_at' => $end,
        ]);

        if ($request->hasFile('media')) {
            $media = $status->addMediaFromRequest('media')->toMediaCollection('status_media');
        }

        return response()->json([
            'status' => 201,
            'message' => 'Status created successfully',
            'data' => $status
        ], 201);
    }


    /**
     * GET /api/status/{id}
     * (also marks it as viewed)
     */
    public function show($id)
    {
        $status = Status::with(['user', 'reactions.user', 'views'])->findOrFail($id);

        // Track view
        if (!$status->wasViewedBy(Auth::id())) {
            $status->views()->create(['viewer_id' => Auth::id()]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Status fetched successfully',
            'data' => [
                'id' => $status->id,
                'user_name' => $status->user->fullName(),
                'caption' => $status->caption,
                'media_url' => $status->getFirstMediaUrl('status_media'),
                'expires_at' => $status->expires_at,
                'view_count' => $status->views->count(),
                'reactions' => $status->reactions
                    ->groupBy('emoji')
                    ->map(fn($group) => [
                        'count' => $group->count(),
                        'users' => $group->pluck('user.name'),
                    ]),
            ]
        ], 200);
    }


    /**
     * POST /api/status/{id}/react
     */
    public function react(Request $request, $id)
    {
        $request->validate([
            'emoji' => 'required|string|max:10',
        ]);

        $status = Status::findOrFail($id);

        StatusReaction::updateOrCreate(
            ['status_id' => $status->id, 'user_id' => Auth::id()],
            ['emoji' => $request->emoji]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Reaction recorded successfully',
        ], 200);
    }

    /**
     * POST /api/status/{id}/flag
     */
    public function flag(Request $request, $id)
    {
        $status = Status::findOrFail($id);

        StatusFlag::updateOrCreate(
            ['status_id' => $status->id, 'user_id' => Auth::id()],
            ['reason' => $request->input('reason')]
        );

        return response()->json([
            'status' => 200,
            'message' => 'Status flagged for review successfully',
        ], 200);
    }

    /**
     * POST /api/mute/{id}
     */
    public function mute($id)
    {
        if (Auth::id() == $id) {
            return response()->json(['error' => 'You cannot mute yourself'], 400);
        }

        MutedStatusNotification::firstOrCreate([
            'user_id' => Auth::id(),
            'muted_user_id' => $id,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'User muted successfully'
        ], 200);
    }

    /**
     * DELETE /api/mute/{id}
     */
    public function unmute($id)
    {
        MutedStatusNotification::where('user_id', Auth::id())
            ->where('muted_user_id', $id)
            ->delete();

        return response()->json([
            'status' => 200,
            'message' => 'User unmuted successfully'
        ], 200);
    }

    // admin routes
    public function adminIndex()
    {
        $statuses = Status::with('user')
            ->where('expires_at', '>', now())
            ->latest()
            ->get();

        return view('dashboard.status.index', compact('statuses'));
    }

    public function adminInappropriate()
    {
        $statuses = Status::with(['user', 'flags'])
            ->whereHas('flags')
            ->get()
            ->sortByDesc(fn($status) => $status->flags->count());

        return view('dashboard.status.inappropriate', compact('statuses'));
    }

    public function adminDestroy($id)
    {
        $status = Status::findOrFail($id);
        $status->delete();

        return redirect()->back()->with('success', 'Status deleted successfully.');
    }
}
