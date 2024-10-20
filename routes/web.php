<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DynamicCatagoryController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\SignalingController;
use App\Http\Controllers\SupportGroupController;
use App\Http\Controllers\TweekController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cert_test',function(){
    return view('cert_test');
});

Route::get('/sym', function () {
    Artisan::call('storage:link');
    return 'success';
});

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');
Route::get('/graph', [HelperController::class, 'graphs'])->name('graph.form');

Route::get('/login', [DashboardController::class, 'login'])->name('login.form');
Route::post('/login', [AuthController::class, 'adminLogin'])->name('login');
Route::post('/logout', [AuthController::class, 'AdminLogout'])->name('logout');

Route::middleware(['adminCheck'])->prefix('portal')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('patient', PatientController::class);
    Route::resource('medical', MedicalController::class);
    Route::resource('tweek', TweekController::class);
    Route::resource('reminder', ReminderController::class);
    Route::resource('user', UserController::class);
    Route::get('articles', [ArticleController::class,'index'])->name('articles.admin.index');
    Route::post('articles/status', [ArticleController::class,'status'])->name('articles.admin.status');
    Route::get('articles/details/{id}', [ArticleController::class,'show'])->name('articles.admin.show');

    Route::get('export/medical', [MedicalController::class,'export'])->name('medical.export');
    Route::get('verification/medical', [MedicalController::class,'verification_requests'])->name('medical.verify');
    Route::post('complete_verification', [MedicalController::class,'completeVerification'])->name('complete_verification');
    Route::post('emergency_status', [MedicalController::class,'emergencyStatus'])->name('emergency_status');
    Route::post('night_emergency_status', [MedicalController::class,'nightEmergencyStatus'])->name('night_emergency_status');
    Route::resource('support_groups', SupportGroupController::class);
    // dynamic
    Route::get('dynamic/title', [DynamicCatagoryController::class,'title'])->name('dynamic.title');
    Route::delete('dynamic/title/delete/{name}', [DynamicCatagoryController::class,'deleteTitle'])->name('dynamic.title.delete');
    Route::post('dynamic/title/store', [DynamicCatagoryController::class,'storeTitle'])->name('dynamic.title.store');

    Route::get('dynamic/professional_docs', [DynamicCatagoryController::class,'professionalDocs'])->name('dynamic.professional_docs');
    Route::delete('dynamic/professional_docs/delete/{name}', [DynamicCatagoryController::class,'deleteProfessionalDocs'])->name('dynamic.professional_docs.delete');
    Route::post('dynamic/professional_docs/store', [DynamicCatagoryController::class,'storeProfessionalDocs'])->name('dynamic.professional_docs.store');

    Route::get('dynamic/rank', [DynamicCatagoryController::class,'rank'])->name('dynamic.rank');
    Route::delete('dynamic/rank/delete/{name}', [DynamicCatagoryController::class,'deleterank'])->name('dynamic.rank.delete');
    Route::post('dynamic/rank/store', [DynamicCatagoryController::class,'storerank'])->name('dynamic.rank.store');

    Route::get('dynamic/category', [DynamicCatagoryController::class,'category'])->name('dynamic.category');
    Route::delete('dynamic/category/delete/{id}', [DynamicCatagoryController::class,'deleteCategory'])->name('dynamic.category.delete');
    Route::post('dynamic/category/store', [DynamicCatagoryController::class,'storeCategory'])->name('dynamic.category.store');

    Route::get('payments/transactions', [PaymentController::class,'transactions'])->name('payments.transactions');
    Route::get('payments/payouts', [PaymentController::class,'payouts'])->name('payments.payouts');

    Route::get('emergencyhelp/index', [EmergencyController::class,'simple'])->name('emergencyhelp.simple');
    Route::get('emergencyhelp/midnight', [EmergencyController::class,'midnight'])->name('emergencyhelp.midnight');
    Route::post('payments/payouts/action', [PaymentController::class,'payoutsAction'])->name('payments.payouts.action');

    Route::get('appointments', [AppointmentController::class,'listAll'])->name('appointments.index');

});

Route::get('test_pay_stack',function(){
    $url = "https://api.paystack.co/transaction/initialize";

    $fields = [
        'email' => "usamajalal17@gmail.com",
        'amount' => "300",
    ];

    $fields_string = http_build_query($fields);

    //open connection
    $ch = curl_init();
    
    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Authorization: Bearer sk_test_cbc24109b14a97d55fcbe9933b5720b0acda8744",
        "Cache-Control: no-cache",
    ));
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    $result = curl_exec($ch);
    dd($result);
    echo $result;
});