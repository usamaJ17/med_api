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
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserWalletController;

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

Route::get('/send-patient-appointment-notifications', [AppointmentController::class, 'sendPatientNotifications']);
Route::get('/send-professional-appointment-notifications', [AppointmentController::class, 'sendProfessionalNotifications']);
Route::get('/send-post-consultation-notifications', [AppointmentController::class, 'sendPostConsultationNotifications']);

Route::middleware(['adminCheck'])->prefix('portal')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('patient', PatientController::class);
    Route::resource('medical', MedicalController::class);
    Route::resource('tweek', TweekController::class);
    Route::resource('reminder', ReminderController::class);
    Route::resource('user', UserController::class);
    Route::get('articles', [ArticleController::class,'index_web'])->name('articles.admin.index');
    Route::post('articles', [ArticleController::class,'store_web'])->name('articles.admin.store');
    Route::post('articles/status', [ArticleController::class,'status'])->name('articles.admin.status');
    Route::get('articles/details/{id}', [ArticleController::class,'show'])->name('articles.admin.show');
    Route::get('articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.admin.edit');
    Route::put('articles/{id}', [ArticleController::class, 'update_web'])->name('articles.admin.update');
    Route::delete('articles/delete/{id}', [ArticleController::class, 'destroy'])->name('articles.delete');
    Route::get('articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::get('articles/{id}/edit_admin', [ArticleController::class, 'edit_admin'])->name('articles.admin.edit');
    Route::post('upload-file', [ArticleController::class, 'upload_file'])->name('upload_file');

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
    Route::post('dynamic/title/update', [DynamicCatagoryController::class, 'updateTitle'])->name('dynamic.title.update');

    Route::get('dynamic/professional_docs', [DynamicCatagoryController::class,'professionalDocs'])->name('dynamic.professional_docs');
    Route::delete('dynamic/professional_docs/delete/{name}', [DynamicCatagoryController::class,'deleteProfessionalDocs'])->name('dynamic.professional_docs.delete');
    Route::post('dynamic/professional_docs/store', [DynamicCatagoryController::class,'storeProfessionalDocs'])->name('dynamic.professional_docs.store');
    Route::post('dynamic/professional_docs/update', [DynamicCatagoryController::class, 'updateProfessionalDocs'])->name('dynamic.professional_docs.update');

    Route::get('dynamic/rank', [DynamicCatagoryController::class,'rank'])->name('dynamic.rank');
    Route::delete('dynamic/rank/delete/{name}', [DynamicCatagoryController::class,'deleterank'])->name('dynamic.rank.delete');
    Route::post('dynamic/rank/store', [DynamicCatagoryController::class,'storerank'])->name('dynamic.rank.store');
    Route::post('dynamic/rank/update', [DynamicCatagoryController::class, 'updateRank'])->name('dynamic.rank.update');

    Route::get('dynamic/category', [DynamicCatagoryController::class,'category'])->name('dynamic.category');
    Route::delete('dynamic/category/delete/{id}', [DynamicCatagoryController::class,'deleteCategory'])->name('dynamic.category.delete');
    Route::post('dynamic/category/store', [DynamicCatagoryController::class,'storeCategory'])->name('dynamic.category.store');
    Route::post('dynamic/category/update', [DynamicCatagoryController::class, 'updateCategory'])->name('dynamic.category.update');

    
    Route::get('dynamic/article_category', [DynamicCatagoryController::class,'article_category'])->name('dynamic.article_category');
    Route::delete('dynamic/article_category/delete/{id}', [DynamicCatagoryController::class,'deleteArticleCategory'])->name('dynamic.article_category.delete');
    Route::post('dynamic/article_category/store', [DynamicCatagoryController::class,'storeArticleCategory'])->name('dynamic.article_category.store');
    Route::post('dynamic/article_category/update', [DynamicCatagoryController::class, 'updateArticleCategory'])->name('dynamic.article_category.update');
    


    Route::get('dynamic/clinical_notes', [DynamicCatagoryController::class,'clinical_notes'])->name('dynamic.clinical_notes');
    Route::delete('dynamic/clinical_notes/delete/{id}', [DynamicCatagoryController::class,'deleteClinicalNotes'])->name('dynamic.clinical_notes.delete');
    Route::post('dynamic/clinical_notes/store', [DynamicCatagoryController::class,'storeClinicalNotes'])->name('dynamic.clinical_notes.store');
    Route::post('dynamic/clinical_notes/update', [DynamicCatagoryController::class, 'updateClinicalNotes'])->name('dynamic.clinical_notes.update');
    
    Route::get('dynamic/consultation_summary', [DynamicCatagoryController::class,'consultation_summary'])->name('dynamic.consultation_summary');
    Route::delete('dynamic/consultation_summary/delete/{id}', [DynamicCatagoryController::class,'deleteCusultationSummary'])->name('dynamic.consultation_summary.delete');
    Route::post('dynamic/consultation_summary/store', [DynamicCatagoryController::class,'storeCusultationSummary'])->name('dynamic.consultation_summary.store');
    Route::post('dynamic/consultation_summary/update', [DynamicCatagoryController::class, 'updateCusultationSummary'])->name('dynamic.consultation_summary.update');
    

    Route::get('refund_history', [PaymentController::class,'refund_history'])->name('refund_history');
    Route::post('refund/status', [PaymentController::class,'refund_status'])->name('refund.status');

    
    Route::get('payments/transactions', [PaymentController::class,'transactions'])->name('payments.transactions');
    Route::get('payments/payouts', [PaymentController::class,'payouts'])->name('payments.payouts');

    Route::get('emergencyhelp/index', [EmergencyController::class,'simple'])->name('emergencyhelp.simple');
    Route::get('emergencyhelp/midnight', [EmergencyController::class,'midnight'])->name('emergencyhelp.midnight');
    Route::post('payments/payouts/action', [PaymentController::class,'payoutsAction'])->name('payments.payouts.action');

    Route::get('appointments', [AppointmentController::class,'listAll'])->name('appointments.index');
    Route::get('feedback', [DashboardController::class,'userFeedback'])->name('dashboard.user-feedback');
    
    Route::get('wallets', [UserWalletController::class, 'index'])->name('wallets.index');
    Route::get('wallets/create', [UserWalletController::class, 'create'])->name('wallets.create');
    Route::post('wallets', [UserWalletController::class, 'store'])->name('wallets.store');
    Route::get('wallets/{wallet}', [UserWalletController::class, 'show'])->name('wallets.show');
    Route::get('wallets/{wallet}/edit', [UserWalletController::class, 'edit'])->name('wallets.edit');
    Route::put('wallets/{wallet}', [UserWalletController::class, 'update'])->name('wallets.update');
    Route::delete('wallets/{wallet}', [UserWalletController::class, 'destroy'])->name('wallets.destroy');
    Route::post('wallets/add-balance', [UserWalletController::class, 'addBalance'])->name('patient.addBalance');


});