<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentHoursController;
use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\PaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['cros'])->group(function () {
  Route::post('register',[AuthController::class,'register']);
  // Route::post('verify_register_otp',[AuthController::class,'registerOtp']);
  Route::post('login',[AuthController::class,'login']);
  Route::post('verify_otp',[AuthController::class,'otp']);
  Route::post('send_forgot_password',[AuthController::class,'SendForgotPassword']);
  Route::post('check_forgot_password_otp',[AuthController::class,'CheckOtpForgotPassword']);
  Route::post('update_forgot_password',[AuthController::class,'UpdateForgotPassword']);
  Route::get('professions',[ProfileController::class, 'getProfessionalType']);
  Route::get('ranks',[HelperController::class,'getRanks']);
  Route::get('medical_professionals/meta_data',[ProfileController::class,'getMedicalProfessionalsMetaData']);
  Route::post('/professional_types', [ProfileController::class, 'storeProfessionalType']);
  Route::post('/professional_types/{id}/update', [ProfileController::class, 'updateProfessionalType']);
  Route::get('/professional_types', [ProfileController::class, 'getProfessionalType']);
  Route::delete('/professional_types/{id}', [ProfileController::class, 'deleteProfessionalType']);
  Route::delete('delete_account/{id}',[HelperController::class,'deleteAccount']);
  Route::post('change_activation',[HelperController::class,'changeActivation']);

  Route::get('/professional_titles', [HelperController::class, 'getProfessionalTitles']);
  Route::post('/professional_titles', [HelperController::class, 'saveProfessionalTitles']);
});


Route::middleware(['auth:sanctum','cros'])->group(function () {
  Route::post('logout',[AuthController::class,'logout']);

  Route::get('professional_info',[ProfileController::class,'getProfessionalDetails']);
  Route::post('professional_info',[ProfileController::class,'saveProfessionalDetails']);
  Route::get('medical_info',[ProfileController::class,'getMedicalDetails']);
  Route::post('medical_info',[ProfileController::class,'saveMedicalDetails']);
  Route::post('personal_info',[AuthController::class,'savePersonalDetails']);
  Route::post('language',[AuthController::class,'saveLanguage']);
  Route::post('notifications',[NotificationController::class,'save']);
  Route::post('notifications/status',[NotificationController::class,'changeStatus']);
  Route::get('notifications',[NotificationController::class,'getAll']);
  Route::delete('notifications/{id}',[NotificationController::class,'delete']);

  Route::apiResource('articles', ArticleController::class);
  Route::post('articles/update/{id}', [ArticleController::class, 'update']);

  Route::post('articles/{article}/comments', [CommentController::class, 'store']);
  Route::delete('comments/{comment}', [CommentController::class, 'destroy']);

  Route::post('articles/{article}/likes', [LikeController::class, 'store']);
  Route::delete('articles/{article}/likes', [LikeController::class, 'destroy']);

  // appointments
  Route::post('/appointments', [AppointmentHoursController::class, 'store']);
  Route::get('/appointments', [AppointmentHoursController::class, 'show']);

  Route::get('/check_availability', [AppointmentHoursController::class, 'checkAvailability']);

  //
  Route::post('patient/appointments',[AppointmentController::class,'store']);
  Route::post('appointments/update',[AppointmentController::class,'update']);
  Route::post('patient/appointments/status',[AppointmentController::class,'changePatientStatus']);
  Route::post('appointments/status',[AppointmentController::class,'changeStatus']);
  Route::get('patient/appointments',[AppointmentController::class,'get']);
  Route::get('subaccount/appointments',[AppointmentController::class,'getSubAccount']);
  Route::post('appointments/paid',[AppointmentController::class,'markAsPaid']);
  Route::get('appointments/pay_for_some',[AppointmentController::class,'payForSome']);

  // review after appointment
  Route::post('appointments/review',[AppointmentController::class,'addReview']);
  Route::post('appointments/review/update',[AppointmentController::class,'updateReview']);
  Route::get('appointments/review',[AppointmentController::class,'getReview']);

  Route::get('professional/appointment/patients',[AppointmentController::class,'getMyPatientsAppointments']);
  Route::get('professional/patients',[AppointmentController::class,'getMyPatientsList']);
  
  Route::get('medical_professionals',[ProfileController::class,'getMedicalProfessionals']);

  // sub accounts
  Route::get('get_sub_accounts',[AuthController::class,'getSubAccounts']);
  Route::get('login_as_sub',[AuthController::class,'loginToSubAccount']);

  // chat APIs
  Route::get('chats',[ChatController::class,'getAllChats']);
  Route::post('send_message',[ChatController::class,'sendMessage']);
  Route::get('get_messages',[ChatController::class,'getMessage']);
  Route::delete('delete_messages',[ChatController::class,'deleteMessage']);
  // Route::get('new_chats',[ChatController::class,'createChatBox']);

});
Route::group(['prefix' => 'payment'], function () {
  Route::group(['prefix' => 'crypto'], function () {
      Route::get('currencies', [PaymentController::class, 'getCryptoCurrencies']);
      Route::get('get_amount', [PaymentController::class, 'getAmount']);
      Route::post('create_payment', [PaymentController::class, 'createPayment']);
      Route::get('check_payment', [PaymentController::class, 'CheckStatus']);
  });
});

Route::post('send_sms',[HelperController::class,'sendSms']);

Route::get('get_sdk_key',[HelperController::class,'getSd
kKey']);