<?php

namespace App\Jobs;

use App\Models\EscrowTransaction;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateEscrowStatus implements ShouldQueue
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
        $escrowPayments = EscrowTransaction::where('status', 'pending')->where('release_at', '<=', now())->get();
        foreach ($escrowPayments as $payment) {
            $payment->update(['status' => 'completed']);
        }
    }
}
