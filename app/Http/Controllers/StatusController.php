<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\StatusReaction;
use App\Models\MutedStatusNotification;
use App\Models\StatusFlag;
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

        $query = Status::with('user')
            ->where('expires_at', '>', now());

        if ($filter === 'muted') {
            $query->whereIn('user_id', $mutedIds);
        } else {
            $query->whereNotIn('user_id', $mutedIds);
        }

        $statuses = $query
            ->latest()
            ->get()
            ->map(function ($status) {
                return [
                    'id' => $status->id,
                    'user_id' => $status->user_id,
                    'user_name' => $status->user->name,
                    'caption' => $status->caption,
                    'media_url' => $status->getFirstMediaUrl('status_media'),
                    'expires_at' => $status->expires_at,
                    'viewed' => $status->wasViewedBy(Auth::id()),
                    'reaction' => optional($status->reactionBy(Auth::id()))->emoji,
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
            'media' => 'nullable|file|mimes:jpeg,png,jpg,mp4|max:10240', // 10MB max
        ]);

        $status = Status::create([
            'user_id' => Auth::id(),
            'caption' => $request->caption,
            'expires_at' => now()->addHours(24),
        ]);

        if ($request->hasFile('media')) {
            $status->addMediaFromRequest('media')->toMediaCollection('status_media');
        }

        return response()->json([
            'status' => 201,
            'message' => 'Status created successfully',
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
}
