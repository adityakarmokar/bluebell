<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserServiceTokenController;
use App\Http\Controllers\TermsConditionsController;
use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\HomeBannerController;

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

// User login and signup
Route::post('user-signup', [Usercontroller::class, 'user_signup']);
Route::post('user-login', [Usercontroller::class, 'user_login']);
Route::post('user-verifyotp', [Usercontroller::class, 'user_verifyotp']);

Route::middleware('auth:sanctum')->group(function(){

    // User Routes
    Route::get('fetch-user-profile', [Usercontroller::class, 'fetch_userprofile']);
    Route::post('add-user-details', [Usercontroller::class, 'add_userdetails']);
    Route::post('account-delete', [Usercontroller::class, 'account_delete']);

    
    // Services Routes
    Route::get('service-list', [ServiceController::class, 'service_list']);
    Route::get('fetch-single-service', [ServiceController::class, 'fetch_single_service']);

    // Token Routes
    Route::post('user-token-list', [UserServiceTokenController::class, 'token_list']);
    Route::post('generate-new-token', [UserServiceTokenController::class, 'generate_new_token']);
    Route::post('token-upload-documents', [UserServiceTokenController::class, 'token_upload_documents']);
    Route::get('view-token-details', [TokenController::class, 'view_token_details']);

    Route::get('fetch-terms-conditions', [TermsConditionsController::class, 'fetch_data_api']);
    Route::get('fetch-privacy-policy', [PrivacyPolicyController::class, 'fetch_data_api']);
    Route::get('fetch-about-us', [AboutUsController::class, 'fetch_data_api']);
    Route::get('fetch-contact-us', [ContactUsController::class, 'fetch_data_api']);
  
  	Route::get('fetch-banners', [HomeBannerController::class, 'fetch_banner_api']);
  
  	Route::get('download-filed-document', [UserServiceTokenController::class, 'download_filed_document']);
  	Route::get('payment-history', [UserServiceTokenController::class, 'payment_history']);

});


