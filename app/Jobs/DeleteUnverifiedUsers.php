<?php

namespace App\Jobs;

use App\Models\EmailNotifications;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class DeleteUnverifiedUsers implements ShouldQueue
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
        $cutoff = now()->subHours(24);
        $scheduleOffsets = [1, 2, 3];
        $now = now();

        User::whereNull('email_verified_at')
            ->where('temp_role' , '!=', 'admin')
            ->where('created_at', '<', $cutoff)
            ->chunk(50, function ($users) use ($scheduleOffsets, $now) {
                foreach ($users as $user) {
                    foreach ($scheduleOffsets as $days) {
                        EmailNotifications::create([
                            'email' => $user->email,
                            'name' => $user->name,
                            'type' => $user->temp_role,
                            'scheduled_at' => $now->copy()->addDays($days),
                        ]);
                    }
                    $user->forceDelete();
                }
            });
    }
}
