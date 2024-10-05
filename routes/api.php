<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentHoursController;
use App\Http\Controllers\Api\AppointmentSummaryController;
use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\EmergencyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupportGroupController;
use App\Http\Controllers\VitalSignsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

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

Broadcast::routes(['middleware' => ['auth:sanctum']]);

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
  Route::get('get_time_zone',[HelperController::class,'getTimeZone']);
  Route::get('get_device_token',[HelperController::class,'getDeviceToken']);
  Route::get('/professional_titles', [HelperController::class, 'getProfessionalTitles']);
  Route::post('/professional_titles', [HelperController::class, 'saveProfessionalTitles']);
});


Route::middleware(['auth:sanctum','cros'])->group(function () {
  Route::post('logout',[AuthController::class,'logout']);
  Route::post('device_token',[AuthController::class,'saveDeviceToken']);
  Route::post('app_feedback',[HelperController::class,'saveUserFeedback']);

  Route::get('professional_info',[ProfileController::class,'getProfessionalDetails']);
  Route::post('professional_info',[ProfileController::class,'saveProfessionalDetails']);
  Route::get('medical_info',[ProfileController::class,'getMedicalDetails']);
  Route::post('medical_info',[ProfileController::class,'saveMedicalDetails']);
  Route::post('personal_info',[AuthController::class,'savePersonalDetails']);
  Route::post('language',[AuthController::class,'saveLanguage']);
  Route::get('get_share_message', [HelperController::class, 'shareMessage']);
  Route::post('notifications',[NotificationController::class,'save']);
  Route::post('notifications/status',[NotificationController::class,'changeStatus']);
  Route::get('notifications',[NotificationController::class,'getAll']);
  Route::delete('notifications/{id}',[NotificationController::class,'delete']);

  Route::apiResource('articles', ArticleController::class);
  Route::post('articles/update/{id}', [ArticleController::class, 'update']);

  Route::post('articles/{article}/comments', [CommentController::class, 'store']);
  Route::delete('comments/{comment}', [CommentController::class, 'destroy']);
  Route::get('get_comments/{article_id}', [CommentController::class, 'getComments']);

  Route::post('articles/{article}/likes', [LikeController::class, 'store']);
  Route::delete('articles/{article}/likes', [LikeController::class, 'destroy']);
  Route::get('check_like/{article}', [LikeController::class, 'checkLike']);

  Route::post('articles/share/{article_id}', [ArticleController::class, 'addShare']);

  // Support Groups
  Route::get('support_groups', [SupportGroupController::class, 'index']);

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
  Route::post('professional/request_verification',[HelperController::class,'RequestVerification']);

  Route::post('payment/record',[PaymentController::class,'recordPayment']);
  Route::get('medical_professionals',[ProfileController::class,'getMedicalProfessionals']);

  Route::get('get_emergency_professionals',[EmergencyController::class,'getEmergencyProfessionals']);
  Route::resource('emergency_help', EmergencyController::class);
  Route::apiResource('vitals', VitalSignsController::class);
  Route::get('get_clinical_notes',[VitalSignsController::class,'getNotes']);
  Route::get('clinical_notes_fields', [VitalSignsController::class, 'getFields']);
  Route::post('save_clinical_notes',[VitalSignsController::class,'saveNotes']);
  Route::post('clinical_notes_comment',[VitalSignsController::class,'saveComment']);

  Route::post('appointment_summary_fields', [AppointmentSummaryController::class, 'addSummaryField']);
  Route::get('appointment_summary_fields', [AppointmentSummaryController::class, 'getSummaryField']);

  Route::post('appointment_summary', [AppointmentSummaryController::class, 'store']);
  Route::get('appointment_summary', [AppointmentSummaryController::class, 'view']);

  Route::post('appointment_summary_document', [AppointmentSummaryController::class, 'uploadDocument']);
  Route::get('appointment_summary_document', [AppointmentSummaryController::class, 'getDocument']);
  
  Route::post('clinical_notes_fields', [VitalSignsController::class, 'addCustomField']);

  // sub accounts
  Route::get('get_sub_accounts',[AuthController::class,'getSubAccounts']);
  Route::get('login_as_sub',[AuthController::class,'loginToSubAccount']);

  // chat APIs
  Route::get('chats',[ChatController::class,'getAllChats']);
  Route::post('send_message',[ChatController::class,'sendMessage']);
  Route::get('get_messages',[ChatController::class,'getMessage']);
  Route::get('get_new_messages',[ChatController::class,'getNewMessage']);
  Route::delete('delete_messages',[ChatController::class,'deleteMessage']);
  // Route::get('new_chats',[ChatController::class,'createChatBox']);

  // followers and following
  Route::post('follow',[HelperController::class,'follow']);
  Route::get('followers',[HelperController::class,'getFollowers']);
  Route::get('following',[HelperController::class,'getFollowing']);
  Route::post('unfollow',[HelperController::class,'unfollow']);
  Route::get('check_follow',[HelperController::class,'checkFollow']);

  // transactions

  Route::post('save_transactions',[PaymentController::class,'saveTransactions']);
  Route::get('professional_payments',[PaymentController::class,'getProfessionalPayments']);
  Route::post('request_payout',[PaymentController::class,'requestPayout']);
  Route::get('professional_payout',[PaymentController::class,'getPayout']);
  


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

Route::get('get_sdk_key',[HelperController::class,'getSdkKey']);