<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Payouts;
use App\Models\TransactionHistory;
use App\Models\UserRefund;
use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
//    public function redirectToGateway()
//    {
//        try {
//            return Paystack::getAuthorizationUrl()->redirectNow();
//        } catch (\Exception $e) {
//            dd($e->getMessage());
//            return Redirect::back()->withMessage(['msg' => 'The paystack token has expired. Please refresh the page and try again.', 'type' => 'error']);
//        }
//    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        dd($paymentDetails);
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }
//    public function crypto_call(Request $request)
//    {
//        $data = $request->all();
//        Log::info($data);
//    }
    public function refund(){
        $refund = UserRefund::with('appointment')->where('user_id',Auth::id())->get();
        $data = [
            'status' => 200,
            'message' => 'Refund History Fetched',
            'data' => $refund
        ];
        return response()->json($data, 200);
    }
    public function payoutsAction(Request $request){
        $payout = Payouts::find($request->id); 
        if($payout){
            $payout->status = $request->status;
            if(isset($request->rejected_reason) && !empty($request->rejected_reason)){
                $payout->rejected_reason = $request->rejected_reason;
            }
            if($request->status == 'completed'){
                $payout->completed_at = now();
            }
            $payout->save();
            return redirect()->back()->with('success', 'Payout Updated Successfully');
        }else{
            return redirect()->back()->with('error', 'Payout Not Found');
        }
    }
    public function getCryptoCurrencies()
    {
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $request = new Psr7Request('GET', env('NOW_PAYMENT_URL') . '/currencies', $headers);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data, 200);
    }
    public function getAmount(Request $request)
    {
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $request = new Psr7Request('GET', env('NOW_PAYMENT_URL') . '/estimate?amount=' . $request->amount . '&currency_from=usd&currency_to=' . $request->currency, $headers);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data, 200);
    }
    public function generateRandomString($length = 7)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function createPayment(Request $request)
    {
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
            'Content-Type' => 'application/json'
        ];
        $order_id = $this->generateRandomString();
        $body = '{
            "price_amount": ' . $request->amount_usd . ',
            "price_currency": "usd",
            "pay_amount": ' . $request->amount_crypto . ',
            "pay_currency": "' . $request->crypto_name . '",
            "ipn_callback_url": "https://nowpayments.io",
            "order_id": "' . $order_id . '",
            "order_description": "Appointment Payment"
          }';
        $request = new Psr7Request('POST', env('NOW_PAYMENT_URL') . '/payment', $headers, $body);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data, 200);
    }
    public function CheckStatus(Request $request)
    {
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $res = new Psr7Request('GET', env('NOW_PAYMENT_URL') . '/payment' . '/' . $request->payment_id, $headers);
        $request = $client->sendAsync($res)->wait();
        $status = [
            'status' => json_decode($request->getBody()->getContents())->payment_status,
        ];
        $data = [
            'status' => $request->getStatusCode(),
            'data' => $status
        ];
        return response()->json($data, 200);
    }
    public function transactions() {
        $transactions = TransactionHistory::all();
        return view('dashboard.payments.transactions.index', compact('transactions'));
    }
    public function payouts() {
        $payouts = Payouts::all();
        return view('dashboard.payments.payouts.index', compact('payouts'));
    }
    public function saveTransactions(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        TransactionHistory::create($request->all());
        $data = [
            'status' => 200,
            'message' => 'Transaction Saved Successfully'
        ];
        return response()->json($data, 200);
    }
    public function getTransactions(Request $request){
        $transactions = TransactionHistory::with('appointment')->where('user_id', auth()->user()->id)->get();
        $data = [
            'status' => 200,
            'message' => 'Transactions Fetched Successfully',
            'data' => $transactions
        ];
        return response()->json($data, 200);
    }
    public function getProfessionalPayments(Request $request)
    {
        $escrowAmount = 0;
        $availableAmount = 0;
        $total = 0;
        $payoutsWithdrawn = Payouts::where('user_id', auth()->user()->id)->where('status', 'completed')->where('completed_at', '!=', null)->sum('amount');

        $appointments = Appointment::where('med_id', auth()->user()->id)
            ->where('is_paid', 1)
            ->get()
            ->map(function ($appointment) use (&$escrowAmount, &$availableAmount) {
                $currentDate = Carbon::now();
                $appointmentDate = Carbon::parse($appointment->appointment_date);

                if ($appointmentDate->isFuture()) {
                    $appointment->status = 'Uncompleted';
                } elseif ($appointmentDate->isToday() || $appointmentDate->isPast()) {
                    $daysDifference = $appointmentDate->diffInDays($currentDate);

                    if ($daysDifference > 7) {
                        $appointment->status = 'Completed';
                        $availableAmount += $appointment->fee_int; // Sum for available amount
                    } else {
                        $appointment->status = 'In Progress';
                        $escrowAmount += $appointment->fee_int; // Sum for escrow amount
                    }
                }

                return [
                    'appointment_id' => $appointment->id,
                    'user_name' => $appointment->patient_name,
                    'appointment_booked_on' => $appointment->created_at,
                    'appointment_date' => $appointment->appointment_date,
                    'amount' => $appointment->fee_int,
                    'status' => $appointment->status,
                    'appointment_type' => $appointment->appointment_type,
                    'transaction_id' => $appointment->transaction_id
                ];
            });
        $pay_data = [
            'escrow_amount' => $escrowAmount,
            'available_amount' => $availableAmount - $payoutsWithdrawn,
            'total_payout' => $payoutsWithdrawn,
            'total_revenue' => $availableAmount + $escrowAmount,
            'appointments' => $appointments,
        ];
        $data = [
            'status' => 200,
            'message' => 'Professional Payments Fetched Successfully',
            'data' => $pay_data,
        ];
        return response()->json($data, 200);
    }
    public function requestPayout(Request $request)
    {
        $availableAmount = 0;

        $appointments = Appointment::where('med_id', auth()->user()->id)
            ->where('is_paid', 1)
            ->get()
            ->map(function ($appointment) use (&$escrowAmount, &$availableAmount) {
                $currentDate = Carbon::now();
                $appointmentDate = Carbon::parse($appointment->appointment_date);

                if (!$appointmentDate->isFuture()) {
                    $daysDifference = $appointmentDate->diffInDays($currentDate);

                    if ($daysDifference > 7) {
                        $availableAmount += $appointment->fee_int; // Sum for available amount
                    }
                }
            });
        $payoutsRequested = Payouts::where('user_id', auth()->user()->id)->where('status','!=' ,'rejected')->sum('amount');
        $availableAmount = $availableAmount - $payoutsRequested;
        if ($availableAmount < $request->amount) {
            $data = [
                'status' => 400,
                'message' => 'Insufficient Funds, you can request upto ' . $availableAmount . ' GHS',
            ];
            return response()->json($data, 400);
        }
        $request->merge(['user_id' => auth()->user()->id]);
        $payout = Payouts::create($request->all());
        $data = [
            'status' => 200,
            'message' => 'Payout Requested Successfully',
            'data' => $payout
        ];
        return response()->json($data, 200);
    }
    public function getPayout(Request $request)
    {
        $payouts = Payouts::where('user_id', auth()->user()->id)->get();
        $data = [
            'status' => 200,
            'message' => 'Payouts Fetched Successfully',
            'data' => $payouts
        ];
        return response()->json($data, 200);
    }
    public function recordPayment(Request $request)
    {
        $request->merge(['user_id' => auth()->user()->id]);
        TransactionHistory::create($request->all());
        $data = [
            'status' => 200,
            'message' => 'Payment Recorded Successfully'
        ];
        return response()->json($data, 200);
    }
}
