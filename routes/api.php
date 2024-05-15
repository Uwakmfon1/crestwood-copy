<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InvestmentController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\PackageController;
use App\Http\Controllers\API\PaymentController;
use App\Http\Controllers\API\ReferralController;
use App\Http\Controllers\API\RolloverController;
use App\Http\Controllers\API\TradeController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api'], function () {
    Route::group(['prefix' => 'auth'], function (){
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/me', [AuthController::class, 'me']);
        Route::post('/email/resend', [AuthController::class, 'resendEmailVerificationLink'])->middleware(['throttle:3,1']);
        Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
        Route::post('/password/reset/otp', [AuthController::class, 'sendPasswordResetOtp'])->middleware(['throttle:3,1']);
        Route::post('/password/reset', [AuthController::class, 'resetPassword']);
    });

    Route::group(['middleware' => 'auth:api'], function (){
        Route::get('/referrals', [ReferralController::class, 'index']);

        Route::get('/packages', [PackageController::class, 'index']);
        Route::get('/packages/{package}/show', [PackageController::class, 'show']);

        Route::post('/invest', [InvestmentController::class, 'store']);
        Route::get('/investments', [InvestmentController::class, 'index']);
        Route::get('/investments/{investment}/show', [InvestmentController::class, 'show']);
        Route::post('/investment/rollover', [RolloverController::class, 'store']);

        Route::get('/transactions', [TransactionController::class, 'index']);
        Route::get('/transactions/{transaction}/show', [TransactionController::class, 'show']);
        Route::post('/deposit', [TransactionController::class, 'deposit']);
        Route::post('/withdraw', [TransactionController::class, 'withdraw']);
        Route::post('/payment/initialize', [PaymentController::class, 'initialize']);

        Route::get('/trades', [TradeController::class, 'index']);
        Route::get('/trades/{trade}/show', [TradeController::class, 'show']);
        Route::post('/buy', [TradeController::class, 'buy']);
        Route::post('/sell', [TradeController::class, 'sell']);
        Route::post('/balance', [WalletController::class, 'getBalance']);

        Route::post('/profile/update', [HomeController::class, 'updateProfile']);
        Route::post('/bank/verify', [HomeController::class, 'verifyBank']);
        Route::post('/password/custom/change', [HomeController::class, 'changePassword']);
        Route::get('/rates', [HomeController::class, 'getRates']);
        Route::get('/activity/summary', [HomeController::class, 'activitySummary']);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/{notification}/show', [NotificationController::class, 'show']);
        Route::get('/notifications/read', [NotificationController::class, 'read']);
    });

    Route::get('/app/version', [HomeController::class, 'appVersion']);
    Route::get('/bank/details', [HomeController::class, 'bank'])->name('payment.webhook');
    Route::post('/payment/{type}/webhook', [\App\Http\Controllers\PaymentController::class, 'handlePaymentWebhook'])->name('payment.webhook');

    Route::post('/monnify-payment/callback', [PaymentController::class, 'handleWebhook'])->name('payment.callback');
    Route::get('/paystack/callback', [PaymentController::class, 'handleGatewayCallback'])->name('paystack.callback');

    Route::get('/info', [WalletController::class, 'getPrice']);
});
