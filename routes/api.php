<?php

use App\Http\Controllers\Api\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\HelperController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

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
});
Route::post('send_forgot_password',[AuthController::class,'SendForgotPassword'])->middleware('cros');
Route::post('update_forgot_password',[AuthController::class,'UpdateForgotPassword'])->middleware('cros');


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
});
Route::post('change_reseller_status',[AuthController::class,'changeResellerStatus']);
Route::get('professions',[HelperController::class,'getProfessions']);
Route::get('ranks',[HelperController::class,'getRanks']);
