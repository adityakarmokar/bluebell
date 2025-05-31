<?php

use App\Http\Controllers\AboutUsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AnnouncementsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\HomeBannerController;

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
Route::get('privacypolicy', [UserController::class, 'web']);
Route::get('delete-account', [UserController::class, 'delete_account']);
Route::get('logout', function () {

    session()->pull('id', null);

    return redirect('/');

});

Route::get('login',[AdminController::class, 'login'])->name('login');
Route::post('admin-login',[AdminController::class, 'admin_login']);
Route::post('admin-otp',[AdminController::class, 'admin_otp']);

Route::group(['middleware'=>'checkauth'], function(){
    
    Route::get('/', [AdminController::class, 'dashboard']);

    // Users Route
    Route::group(['middleware' => ['permission:search_client']], function() {        
        Route::get('users', [UserController::class, 'index']);
        Route::get('user-add', [UserController::class, 'create']);
        Route::post('user-add', [UserController::class, 'store']);
        Route::get('view-user/{user}', [UserController::class, 'fetch_user'])->name('view.user');
        Route::post('toggle-user/{id}', [UserController::class, 'toggle_user'])->name('user.toggleStatus');
        Route::get('user-edit/{user}', [UserController::class, 'fetch_user'])->name('user.edit');
        Route::put('user-edit/{user}', [UserController::class, 'update'])->name('user.update');
        Route::post('/user-delete', [UserController::class, 'destroy']);
        Route::get('search-user', [UserController::class, 'searchUser'])->name('search-user');
        Route::post('user-validate-request', [UserController::class, 'validate_request'])->name('user.validate_request');
        Route::post('user-validate-aadhar', [UserController::class, 'validate_aadhar'])->name('user.validate_aadhar');
        Route::post('user-validate-phone', [UserController::class, 'validate_phone'])->name('user.validate_phone');
        Route::get('user-tokens/{user}', [UserController::class, 'user_tokens'])->name('view_user_token');
    });


    // Services controller
    Route::group(['middleware' => ['permission:services']], function() {        
        Route::get('services', [ServiceController::class, 'index']);
        Route::get('service-add', [ServiceController::class, 'create']);
        Route::post('service-add', [ServiceController::class, 'store']);
        Route::post('toggle-service/{id}', [ServiceController::class, 'toggle_service'])->name('service.toggleStatus');
        Route::get('service-edit/{service}', [ServiceController::class, 'fetch_service'])->name('service.edit');
        Route::put('service-edit/{service}', [ServiceController::class, 'update'])->name('service.update');
        Route::post('service-delete', [ServiceController::class, 'destroy']);
    });

    // Token Controller
    Route::group(['middleware' => ['permission:search_token']], function() {    
        Route::get('tokens', [TokenController::class, 'index']);
        Route::get('pending-payment-token', [TokenController::class, 'pending_payment']);
        Route::get('paid-payment-token', [TokenController::class, 'paid_payment']);
        Route::get('inactive-token', [TokenController::class, 'inacitive_token']);
        Route::get('token-add', [TokenController::class, 'create']);
        Route::post('token-generate', [TokenController::class, 'generate']);
        Route::post('toggle-token/{id}', [TokenController::class, 'toggle_token'])->name('token.toggleStatus');
        Route::get('token-document-upload/{token}', [TokenController::class, 'view_document_upload'])->name('token.upload_document');
        Route::post('token-document-upload/{token}', [TokenController::class, 'upload_document'])->name('token.document.upload');
        Route::get('token-document-upload-edit/{token}', [TokenController::class, 'edit_document_upload'])->name('token.upload_document_edit');
        Route::post('token-document-upload-edit/{token}', [TokenController::class, 'edit_document_upload_submit'])->name('token.upload_document_edit_submit');
        Route::post('token-delete', [TokenController::class, 'destroy']);
        Route::get('token/{token}/token-confirm-payment', [TokenController::class, 'confirm_payment'])->name('token.confirm_payment');
        Route::post('token/{token}/token-confirm-status', [TokenController::class, 'payment_done'])->name('token.payment_done');
        Route::get('view-token/{token}', [TokenController::class, 'view_token'])->name('view.token');
        Route::post('token-change-status', [TokenController::class, 'change_status_token'])->name('token.change.status');
        Route::post('change-payment-status', [TokenController::class, 'change_payment_status']);
        Route::post('save-filed-document', [TokenController::class, 'save_filed_document']);
        Route::post('token-check-status', [TokenController::class, 'check_status_token'])->name('token.check.status');
      	Route::post('change-payment-status-upi', [TokenController::class, 'change_payment_status_upi']);

    });

    Route::group(['middleware' => ['permission:cms']], function() {    
        // Update Terms Conditions
        Route::get('terms-conditions', [TermsConditionsController::class, 'fetch_data']);
        Route::post('update-terms-conditions', [TermsConditionsController::class, 'update_data']);

        // Update Privacy Policy
        Route::get('privacy-policy', [PrivacyPolicyController::class, 'fetch_data']);
        Route::post('update-privacy-policy', [PrivacyPolicyController::class, 'update_data']);

        // Update about-us
        Route::get('about-us', [AboutUsController::class, 'fetch_data']);
        Route::post('update-about-us', [AboutUsController::class, 'update_data']);

        // Update contact-us
        Route::get('contact-us', [ContactUsController::class, 'fetch_data']);
        Route::post('update-contact-us', [ContactUsController::class, 'update_data']);
      
      	Route::get('banners', [HomeBannerController::class, 'banner']);
        Route::post('update-banners', [HomeBannerController::class, 'save_banner']);
      	Route::post('banner-delete', [HomeBannerController::class, 'delete_banner']);
      
    });

    
    Route::group(['middleware' => ['permission:payments']], function() { 
        Route::get('payments', [PaymentsController::class, 'index']);

    });


    Route::group(['middleware' => ['permission:announcements']], function() { 
        Route::get('announcements', [AnnouncementsController::class, 'index']);
    });
    

    Route::group(['middleware' => ['permission:team_users']], function() {
        // Teams/Users
        Route::get('team', [TeamsController::class, 'index']);
        Route::get('view-team/{team}', [TeamsController::class, 'view']);
        Route::get('team-add', [TeamsController::class, 'create']);
        Route::post('team-add', [TeamsController::class, 'store']);
        Route::post('toggle-team/{id}', [TeamsController::class, 'toggle_team'])->name('team.toggleStatus');
        Route::get('team-edit/{team}', [TeamsController::class, 'fetch_team'])->name('team.edit');
        Route::put('team-edit/{team}', [TeamsController::class, 'update'])->name('team.update');
        Route::post('team-delete', [TeamsController::class, 'destroy']);
        Route::post('update-permissions', [TeamsController::class, 'update_permissions']);

        Route::get('admins', [AdminUserController::class, 'index']);
        Route::get('admin-add', [AdminUserController::class, 'create']);
        Route::post('admin-add', [AdminUserController::class, 'store']);
        Route::get('admin-edit/{admin}', [AdminUserController::class, 'fetch_admin'])->name('admin.edit');
        Route::put('admin-edit/{admin}', [AdminUserController::class, 'update'])->name('admin.update');
        Route::post('admin-delete', [AdminUserController::class, 'destroy']);
    });

    Route::group(['middleware'=> ['permission:reports']], function() {

        Route::get('reports', [ReportsController::class,'index']);

    });

    Route::get('user-ledger/{user}', [ReportsController::class, 'user_ledger'])->name('user_ledger');
    

});

Route::get('/update-payments-user-id', function () {
    DB::statement("
        UPDATE payments
        JOIN tokens ON payments.token_id = tokens.id
        SET payments.user_id = tokens.user_id
        WHERE payments.user_id IS NULL
    ");

    return 'User IDs updated in payments table.';
});

