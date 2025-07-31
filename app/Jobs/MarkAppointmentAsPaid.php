<?php

namespace App\Jobs;

use App\Helper\GlobalHelper;
use App\Mail\AppointmentCompleted;
use App\Models\EscrowTransaction;
use App\Models\Notifications;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class MarkAppointmentAsPaid implements ShouldQueue
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
        $now = Carbon::now();
        $completedAppointments = \App\Models\Appointment::where('status', 'upcoming')
        ->where('is_paid', 1)
        ->whereRaw("STR_TO_DATE(CONCAT(appointment_date, ' ', appointment_time), '%Y-%m-%d %H:%i:%s') <= ?", [$now])
        ->get();

        foreach ($completedAppointments as $appointment) {
            $appointment->update(['status' => 'completed']);
            $professional = User::find($appointment->med_id);
            $user = User::find($appointment->user_id);
            Mail::to([$professional->email])
                ->send(new AppointmentCompleted($professional->name_title . " " . $professional->first_name . " " . $professional->last_name, $user->first_name . " " . $user->last_name));

            $notificationData = [
                'title' => 'Appointment Completed',
                'description' => "Great Job! Your consultation with $user->first_name $user->last_name is complete. Keep up the amazing care with follow-ups over the next 7 days. Your payment will be ready for withdrawal after that. Thank you for your dedication! 🚀",
                'type' => 'Appointment',
                'from_user_id' => $appointment->med_id,
                'to_user_id' => $appointment->med_id,
                'is_read' => 0,
            ];
            Notifications::create($notificationData);
            EscrowTransaction::create([
                'user_id'        => $appointment->med_id,
                'appointment_id' => $appointment->id,
                'amount'         => GlobalHelper::getAmountAfterCommission($appointment->fee_int),
                'total_fee'      => $appointment->fee_int,
                'status'         => 'pending',
                'release_at'     => Carbon::now()->addDays(7)
            ]);
        }
    }
}
