<?php

namespace App\Services;

use App\Models\Appointment;
use App\Models\TransactionHistory;
use App\Models\User;
use App\Models\UserWallet;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Processes the payment for a given appointment, applying the user's wallet balance first.
     * This is the first step in the payment flow.
     *
     * @param User $user The authenticated user.
     * @param Appointment $appointment The appointment being paid for.
     * @return array A result array indicating the payment status and amounts.
     */
    public function processAppointmentPayment(User $user, Appointment $appointment): array
    {
        $wallet = UserWallet::where('user_id', $user->id)->first();

        if (!$wallet) {
            $wallet = new UserWallet(['user_id' => $user->id, 'balance' => 0]);
        }

        // Use the 'fee_int' attribute from your Appointment model.
        $fee = $appointment->fee_int;

        // If wallet has no balance, the user must pay the full amount via the gateway.
        if ($wallet->balance <= 0) {
            return [
                'flow_status'      => 'requires_gateway_payment',
                'wallet_applied'   => 0,
                'amount_to_pay'    => $fee,
                'message'          => 'Please pay the full appointment fee.',
            ];
        }

        // If wallet has sufficient balance, proceed with the payment.
        return DB::transaction(function () use ($user, $wallet, $appointment, $fee) {

            if ($wallet->balance >= $fee) {

                $wallet->decrement('balance', $fee);
                TransactionHistory::create([
                    'user_id'                 => $user->id,
                    'appointment_id'          => $appointment->id,
                    'transaction_amount'      => $fee,
                    'transaction_gateway'     => 'wallet',
                    'transaction_id'          => 'WALLET_PAY_' . uniqid(),
                    'transaction_type'        => 'Appointment Payment',
                    'transaction_description' => 'Full payment for Appointment #' . $appointment->id,
                ]);

                $appointment->update(['is_paid' => 1, 'status' => 'Scheduled']);

                return [
                    'flow_status'      => 'completed_by_wallet',
                    'wallet_applied'   => $fee,
                    'amount_to_pay'    => 0,
                    'message'          => 'Payment successful. Your appointment is confirmed.',
                ];

            } else {
                $amountFromWallet = $wallet->balance;
                $remainingAmount = $fee - $amountFromWallet;
                $wallet->update(['balance' => 0]);
                
                TransactionHistory::create([
                    'user_id'                 => $user->id,
                    'appointment_id'          => $appointment->id,
                    'transaction_amount'      => $amountFromWallet,
                    'transaction_gateway'     => 'wallet',
                    'transaction_id'          => 'WALLET_PARTIAL_' . uniqid(),
                    'transaction_type'        => 'Appointment Partial Payment',
                    'transaction_description' => 'Partial wallet payment for Appointment #' . $appointment->id,
                ]);
                
                $appointment->update(['status' => 'Pending Gateway Payment']);

                return [
                    'flow_status'      => 'requires_gateway_payment',
                    'wallet_applied'   => $amountFromWallet,
                    'amount_to_pay'    => $remainingAmount,
                    'message'          => 'Your wallet balance has been applied. Please pay the remaining amount.',
                ];
            }
        });
    }
}
