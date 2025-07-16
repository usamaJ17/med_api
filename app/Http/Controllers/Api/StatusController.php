<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\MutedStatus;
use App\Models\Status;
use App\Models\StatusReactions;
use App\Models\StatusViews;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    //
    public function index()
    {
        $statuses = Status::with(['healthProfessional:id,first_name,last_name,email', 'reactions.user:id,first_name,last_name,email'])
            ->withCount('views')
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->get();
        $res = [
            'status' => 200,
            'message' => 'Statuses fetched successfully...',
            'data' => $statuses
        ];
        return response()->json($res, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_path' => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi,mkv,webm|max:10240',
            'caption' => 'required|string|max:1000',
        ]);

        if ($request->hasFile('file_path')) {
            $file = $request->file('file_path');
            $filePath = $file->store('uploads', 'public');
        } else {
            return back()->withErrors(['file_path' => 'Status upload failed.'])->withInput();
        }

        Status::create([
            'user_id' => auth()->id(),
            'file_path' => $filePath,
            'caption' => $request->caption,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Status created successfully...',
        ], 200);
    }

    public function getMutedList()
    {
        try {
            $mutedIds = MutedStatus::where('user_id', auth()->id())->pluck('muted_user_id');

            $statuses = Status::withCount('views')
                ->with([
                    'healthProfessional:id,first_name,last_name,email',
                    'reactions.user:id,first_name,last_name,email'
                ])
                ->where('created_at', '>=', Carbon::now()->subDay())
                ->whereNotIn('user_id', $mutedIds)
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Muted list fetched successfully',
                'data' => $statuses
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch muted list',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function muteStatus($healthProfessionalId)
    {
        try {
            if ($healthProfessionalId == auth()->id()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot mute yourself.'
                ], 400);
            }

            if (!User::find($healthProfessionalId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Health professional not found.'
                ], 404);
            }

            $muted = MutedStatus::firstOrCreate([
                'user_id' => auth()->id(),
                'muted_user_id' => $healthProfessionalId,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Health professional muted.',
                'data' => $muted
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Mute request failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function unmuteStatus($healthProfessionalId)
    {
        try {
            $deleted = MutedStatus::where([
                'user_id' => auth()->id(),
                'muted_user_id' => $healthProfessionalId,
            ])->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => 'Health professional unmuted.'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Mute record not found.'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unmute request failed.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function trackStatusView($id)
    {
        try {
            $status = Status::findOrFail($id);

            StatusViews::firstOrCreate([
                'status_id' => $status->id,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'View recorded'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to record view',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function react(Request $request, $id)
    {
        $request->validate([
            'emoji' => 'required|string|max:20',
        ]);

        try {
            $status = Status::findOrFail($id);
            $reaction = StatusReactions::updateOrCreate(
                [
                    'status_id' => $status->id,
                    'user_id' => auth()->id(),
                ],
                [
                    'emoji' => $request->emoji
                ]
            );

            return response()->json([
                'status' => 201,
                'message' => 'Reaction saved successfully.',
                'data' => $reaction
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Failed to save reaction.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
