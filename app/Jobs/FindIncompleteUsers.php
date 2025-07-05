<?php

namespace App\Jobs;

use App\Models\EmailNotifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class FindIncompleteUsers implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
    }

    public function handle(): void
    {
        $now = now();

        $users = User::whereHas('roles', fn ($q) => $q->where('name', 'medical'))
            ->where('is_verified', 0)
            ->where('is_unsubscribed', 0)
            ->whereNotNull('email_verified_at')
            ->where(function ($query) {
                $query->doesntHave('professionalDetails')
                    ->orWhereHas('professionalDetails', fn ($q) => $q->doesntHave('media'));
            })
            ->get();

        foreach ($users as $user) {
            $email = $user->email;
            $lastScheduled = EmailNotifications::where('email', $email)
                ->where('type', 'incomplete_user')
                ->orderByDesc('scheduled_at')
                ->first();

            Log::info('Processing user: ' . $user->id . ' - ' . $email);

            $nextTime = null;

            if (!$lastScheduled) {
                Log::info('Initial scheduling for user: ' . $user->id . ' - ' . $email);
                $verifiedAt = Carbon::parse($user->email_verified_at);
                $diff = $now->diffInHours($verifiedAt);

                if ($diff >= 24) {
                    Log::info('DIFF IS 24 for user: ' . $user->id . ' - ' . $email);
                    $nextTime = $now->copy();
                }
            } else {
                Log::info('IN ELSE for user: ' . $user->id . ' - ' . $email . ' is ' . $lastScheduled->scheduled_at);
                $last = Carbon::parse($lastScheduled->scheduled_at);
                $diff = $now->diffInHours($last);

                if ($diff >= 72) {
                    Log::info('DIFF IS 72 for user: ' . $user->id . ' - ' . $email);
                    $nextTime = $now->copy();
                }
            }

            if ($nextTime) {
                Log::info('IN nextTime for user: ' . $user->id . ' - ' . $email . ' at ' . $nextTime);
                EmailNotifications::create([
                    'email' => $email,
                    'name' => $user->name,
                    'type' => 'incomplete_user',
                    'scheduled_at' => $nextTime,
                ]);
            }
        }
    }
}