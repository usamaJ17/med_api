<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\DashboardController;
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
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/sym', function () {
    Artisan::call('storage:link');
    return 'success';
});

Route::get('/', function () {
    return redirect()->route('dashboard');
})->name('home');

Route::get('/login', [DashboardController::class, 'login'])->name('login.form');
Route::post('/login', [AuthController::class, 'adminLogin'])->name('login');

Route::middleware(['adminCheck'])->prefix('portal')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});
