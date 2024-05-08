<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\EmailverificationController;
use App\Http\Controllers\SavingsController;

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

Auth::routes(['verify' => true]);

Route::get('/auth/{provider}/attempt', [App\Http\Controllers\Auth\SocialController::class, 'redirect'])->name('auth.social.attempt');
Route::get('/login/{provider}/callback', [App\Http\Controllers\Auth\SocialController::class, 'socialLoginAttempt'])->name('auth.social.login.attempt');
Route::get('/market/{product}/chart', [App\Http\Controllers\HomeController::class, 'showMarket'])->name('market.show');

Route::group(['middleware' => ['auth', 'unverified']], function (){
    Route::get('/email/verify', [EmailverificationController::class, 'verify'])->name('verification.notice');
    Route::post('/email/verify-with-code', [EmailverificationController::class, 'verifyWithCode'])->name('verification.verify.code');
    Route::get('/email/verify/{id}/{hash}', [EmailverificationController::class, 'verifyMail'])->middleware(['signed'])->name('verification.verify');
    Route::post('/email/verification-notification', [EmailverificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');
});

Route::group(['middleware' => ['auth','verified', 'active_user']], function (){
    Route::get('/email/verification/success', [App\Http\Controllers\HomeController::class, 'verificationSuccess']);
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/password/custom/update', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('password.custom.update');
    Route::post('/profile/update', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::get('/getStates/{name}', [App\Http\Controllers\HomeController::class, 'getState'])->name('user.getstate');

    Route::group(['middleware' => ['profile_completed']], function (){
        Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/investment', [App\Http\Controllers\HomeController::class, 'investmentDashboard'])->name('dashboard.investment');
        Route::get('/dashboard/trading', [App\Http\Controllers\HomeController::class, 'tradingDashboard'])->name('dashboard.trading');
        Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages');
        Route::get('/investments', [App\Http\Controllers\InvestmentController::class, 'index'])->name('investments');
        Route::get('/investments/{investment}/show', [App\Http\Controllers\InvestmentController::class, 'show'])->name('investments.show');
        Route::get('/invest', [App\Http\Controllers\InvestmentController::class, 'invest'])->name('invest');
        Route::get('/transactions', [App\Http\Controllers\TransactionController::class, 'index'])->name('transactions');
        Route::get('/trades', [App\Http\Controllers\TradeController::class, 'index'])->name('trades');
        Route::get('/buy', [App\Http\Controllers\TradeController::class, 'showBuyForm'])->name('buy');
        Route::get('/sell', [App\Http\Controllers\TradeController::class, 'showSellForm'])->name('sell');
        Route::get('/market/chart', [App\Http\Controllers\HomeController::class, 'market'])->name('market');
        Route::get('/wallet', [App\Http\Controllers\WalletController::class, 'index'])->name('wallet');
        Route::get('/referrals', [App\Http\Controllers\ReferralController::class, 'index'])->name('referrals');
        Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
        Route::get('/notifications/{notification}/show', [App\Http\Controllers\NotificationController::class, 'show'])->name('notifications.show');

        Route::post('/invest', [App\Http\Controllers\InvestmentController::class, 'store'])->name('invest.store');
        Route::post('/buy', [App\Http\Controllers\TradeController::class, 'buy'])->name('buy.store');
        Route::post('/sell', [App\Http\Controllers\TradeController::class, 'sell'])->name('sell.store');
        Route::post('/deposit', [App\Http\Controllers\TransactionController::class, 'deposit'])->name('deposit');
        Route::post('/withdraw', [App\Http\Controllers\TransactionController::class, 'withdraw'])->name('withdraw');
        Route::get('/notifications/read', [App\Http\Controllers\NotificationController::class, 'read'])->name('notifications.read');
        Route::post('/investments/rollover', [App\Http\Controllers\RolloverController::class, 'store'])->name('investments.rollover');
        Route::post('/download', [App\Http\Controllers\HomeController::class, 'download'])->name('download');

        Route::get('/investments/export/{type}/download', [ExportController::class, 'exportInvestments'])->name('investments.export');
        Route::get('/transactions/export/{type}/download', [ExportController::class, 'exportTransactions'])->name('transactions.export');
        Route::get('/trades/export/{type}/download', [ExportController::class, 'exportTrades'])->name('trades.export');
        
        Route::get('/savings/packages', [SavingsController::class, 'packages'])->name('savingsPackage');
        Route::get('/savings/create', [SavingsController::class, 'create'])->name('savings.create');
        Route::post('/savings/store', [SavingsController::class, 'store'])->name('savings.store');
        Route::get('/savings', [SavingsController::class, 'index'])->name('savings');
        Route::get('/savings/{savings}/show', [SavingsController::class, 'show'])->name('savings.show');
        Route::post('/payment/{savings}', [SavingsController::class, 'makePayment'])->name('make.payment');
        Route::post('/savings/{savings}/settle', [SavingsController::class, 'settlePayment'])->name('settle.payment');

        Route::get('/test/jods', [App\Http\Controllers\CommandController::class, 'handleSavings']);

        Route::post('/account/generate', [WalletController::class, 'generateVirtualAccount'])->name('create.virtual_account');


        Route::get('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');
        Route::get('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');
    });
});
