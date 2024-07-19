<?php

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SignalingController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sym', function () {
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('storage:link');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'success';
});
Route::get('/pay', function () {
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.paystack.co/transaction/verify/5port7teby",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Bearer ".env('PAYSTACK_SECRET_KEY'),
        "Cache-Control: no-cache",
      ),
    ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
  
    curl_close($curl);
    
    if ($err) {
      echo "cURL Error #:" . $err;
    } else {
        dd($response);
    }
   
});
// Laravel 8 & 9
Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback'])->name('callback');

Route::any('crypto_call', [PaymentController::class, 'crypto_call'])->name('crypto_call');