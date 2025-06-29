<?php

namespace App\Jobs;

use App\Mail\DeletedNotificationMail;
use App\Models\DeletedNotifications;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendDeletedEmail implements ShouldQueue
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
        $emailToSend = DeletedNotifications::where('scheduled_at', '<', now())->get();

        foreach ($emailToSend as $email) {
            Mail::to($email->email)->send(new DeletedNotificationMail($email->email, $email->name));
            $email->delete();
        }
    }
}
