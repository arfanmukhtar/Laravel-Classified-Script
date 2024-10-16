<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\UserController;
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

Route::get('/execute/command/{command}', [App\Http\Controllers\HomeController::class, 'executeCommand'])->name('executeCommand');

Route::get('/clear_cache', [App\Http\Controllers\HomeController::class, 'clearCache']);
Route::get('/createJsonLink/{url}', [App\Http\Controllers\HomeController::class, 'createJsonLink']);

Route::get('auth/{provider}', [SocialController::class, 'redirectToProvider']);
Route::get('auth/{provider}/callback', [SocialController::class, 'handleProviderCallback']);

 // forgot password
 Route::get('/reset/{token}', [App\Http\Controllers\Auth\NewPasswordController::class , "resetLink"])->name('reset.passlink');
 Route::post('/reset/password', [App\Http\Controllers\Auth\NewPasswordController::class , "passwordReset"])->name('reset.passw');
 Route::get('account/verify/{token}', [App\Http\Controllers\Auth\RegisteredUserController::class , "verifyAccount"])->name('verify.account');
 Route::post('account/verify/resend', [App\Http\Controllers\Auth\RegisteredUserController::class , "resendEmail"])->name('resend.email');
 Route::get('verify-account', [App\Http\Controllers\Auth\RegisteredUserController::class , "verifyEmailAccount"])->name('verify-account');

Route::controller(UserController::class)->middleware(['auth' , 'is_verify_email'])->group(function () {
    Route::post('follow-user', 'followUser')->name('follow-user');
});
Route::controller(MessageController::class)->middleware(['auth'])->group(function () {
    Route::post('send-message', 'sendMessage')->name('send-message');
    Route::post('reply-message', 'replyMessage')->name('reply-message');
    Route::post('delete-thread', 'deleteThread')->name('delete-thread');
    Route::get('messages', 'index')->name('personal_inbox');
    Route::get('messages/{id}', 'show')->name('messages.show');
});

Route::group(['prefix' => 'account'], function () {
    Route::controller(AccountController::class)->middleware(['auth' , 'is_verify_email'])->group(function () {
        Route::get('home', 'index')->name('personal_home');
        Route::get('my-ads', 'myAds')->name('my_ads');
        Route::get('favourite-ads', 'favouriteAds')->name('favourite_ads');
        Route::get('saved_search', 'savedSearch')->name('saved_search');
        Route::get('archived_ads', 'archivedAds')->name('archived_ads');
        Route::get('pending-approval', 'pendingApproval')->name('pending-approval');

        Route::get('', 'pendingApproval')->name('pending_approval');
        Route::get('inbox/{id}', 'messageDetail')->name('message_detail');

        Route::post('update-profile', 'updateProfile')->name('updateProfile');
        Route::post('update-profile-photo', 'uploadUserPhoto')->name('uploadUserPhoto');
        Route::post('update-password', 'updatePassword')->name('updatePassword');

        Route::get('edit-ad/{id}', 'editAd')->name('edit-ad');
        Route::get('edit-photos/{id}', 'editPhotos')->name('edit-photos');
        Route::post('delete-photos', 'deletePhoto')->name('delete-photo');
        Route::post('update-photos', 'updatePhoto')->name('update-photo');
        Route::post('get-custom-fields', 'getCustomFields')->name('get-additional-fields');

        Route::post('update-an-ad', 'saveAd')->name('update-ad');

    });
});

Route::group(['prefix' => 'payment'], function () {
    Route::controller(PaymentController::class)->middleware(['auth' , 'is_verify_email'])->group(function () {
        Route::post('charge-payment', 'chargePayment')->name('charge-payment');
        Route::get('paypal-payment', 'paypalPaymentOrder')->name('paypal-payment');
        Route::post('/webhook/paypal', 'PaymentWebhooks')->name('paypal-webhooks');
        Route::get('/paypal/callback', 'paypalCallback')->name('paypal-callback');
        Route::get('/success', 'paymentSuccess')->name('payment-success');
        Route::get('/intent-payment-method', 'intentPaymentMethod')->name('intent-payment-method');

    });
});

require __DIR__.'/auth.php';
require __DIR__.'/backend.php';

