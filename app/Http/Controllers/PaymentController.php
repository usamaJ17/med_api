<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            dd($e->getMessage());
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

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
    public function crypto_call(Request $request)
    {
        $data = $request->all();
        Log::info($data);
    }
    public function getCryptoCurrencies(){
        $client = new Client();
        $headers = [
        'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $request = new Psr7Request('GET', 'https://api-sandbox.nowpayments.io/v1/currencies', $headers);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data,200);
    }
    public function getAmount(Request $request){
        $client = new Client();
        $headers = [
        'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $request = new Psr7Request('GET', env('NOW_PAYMENT_URL').'/estimate?amount='.$request->amount.'&currency_from=usd&currency_to='.$request->currency, $headers);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data,200);
    }
    public function generateRandomString($length = 7) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function createPayment(Request $request){
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
            'Content-Type' => 'application/json'
        ];
        $order_id = $this->generateRandomString();
        $body = '{
            "price_amount": '.$request->amount_usd.',
            "price_currency": "usd",
            "pay_amount": '.$request->amount_crypto.',
            "pay_currency": "'.$request->crypto_name.'",
            "ipn_callback_url": "https://nowpayments.io",
            "order_id": "'.$order_id.'",
            "order_description": "Appointment Payment"
          }';
        $request = new Psr7Request('POST', env('NOW_PAYMENT_URL').'/payment', $headers,$body);
        $res = $client->sendAsync($request)->wait();
        $data = [
            'status' => $res->getStatusCode(),
            'data' => json_decode($res->getBody()->getContents())
        ];
        return response()->json($data,200);
    }
    public function CheckStatus(Request $request){
        $client = new Client();
        $headers = [
            'x-api-key' => env('NOW_PAYMENT_API_KEY'),
        ];
        $res = new Psr7Request('GET', env('NOW_PAYMENT_URL').'/payment'.'/'.$request->payment_id, $headers);
        $request = $client->sendAsync($res)->wait();
        $status = [
            'status' => json_decode($request->getBody()->getContents())->payment_status,
        ];
        $data = [
            'status' => $request->getStatusCode(),
            'data' => $status
        ];
        return response()->json($data,200);
    }
}
