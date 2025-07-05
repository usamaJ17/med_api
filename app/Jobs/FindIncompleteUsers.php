<?php

namespace App\Jobs;

use App\Models\EmailNotifications;
use App\Models\User;
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
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $scheduleOffsets = [1, 3];
        $now = now();

        $users = User::whereHas('roles', function ($q) {
            $q->where('name', 'medical');
        })
        ->where('is_verified', 0)
        ->where('is_send_for_incomplete', 0)
        ->whereNotNull('email_verified_at')
        ->where(function ($query) {
            $query->doesntHave('professionalDetails')
                ->orWhereHas('professionalDetails', function ($q) {
                    $q->doesntHave('media');
                });
        })
        ->get();

        foreach ($users as $user) {
            foreach ($scheduleOffsets as $days) {
                EmailNotifications::create([
                    'email' => $user->email,
                    'name' => $user->name,
                    'type' => 'incomplete_user',
                    'scheduled_at' => $now->copy()->addDays($days),
                ]);
            }
            $user->update(['is_send_for_incomplete' => 1]);
        }
    }
}
