<?php

use App\Http\Controllers\Api\AppointmentController;
use App\Http\Controllers\Api\AppointmentHoursController;
use App\Http\Controllers\Api\ArticleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;

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
  Route::post('update_forgot_password',[AuthController::class,'UpdateForgotPassword']);
  Route::get('professions',[HelperController::class,'getProfessions']);
  Route::get('ranks',[HelperController::class,'getRanks']);
  Route::get('medical_professionals/meta_data',[ProfileController::class,'getMedicalProfessionalsMetaData']);
  Route::post('/professional_types', [ProfileController::class, 'storeProfessionalType']);
  Route::post('/professional_types/{id}/update', [ProfileController::class, 'updateProfessionalType']);
  Route::get('/professional_types', [ProfileController::class, 'getProfessionalType']);
  Route::delete('/professional_types/{id}', [ProfileController::class, 'deleteProfessionalType']);
});


Route::middleware(['auth:sanctum','cros'])->group(function () {
  Route::post('logout',[AuthController::class,'logout']);
  Route::delete('delete_account/{id}',[HelperController::class,'deleteAccount']);

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

  //
  Route::post('patient/appointments',[AppointmentController::class,'store']);
  Route::post('patient/appointments/{id}/status',[AppointmentController::class,'changeStatus']);
  Route::get('patient/appointments',[AppointmentController::class,'get']);

  Route::get('professional/appointment/patients',[AppointmentController::class,'getMyPatientsAppointments']);
  Route::get('professional/patients',[AppointmentController::class,'getMyPatientsList']);
  
  Route::get('medical_professionals',[ProfileController::class,'getMedicalProfessionals']);
});