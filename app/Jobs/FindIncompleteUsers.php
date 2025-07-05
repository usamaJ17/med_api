<?php

namespace App\Jobs;

use App\Models\EmailNotifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

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

            $nextTime = null;

            if (!$lastScheduled) {
                $verifiedAt = Carbon::parse($user->email_verified_at);
                $diff = $now->diffInHours($verifiedAt);

                if ($diff >= 24) {
                    $nextTime = $now->copy();
                }
            } else {
                $last = Carbon::parse($lastScheduled->scheduled_at);
                $diff = $now->diffInHours($last);

                if ($diff >= 72) {
                    $nextTime = $now->copy();
                }
            }

            if ($nextTime) {
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