<?php

use App\Http\Controllers\API\HomeController;
use App\Http\Controllers\API\InvestmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Auth\EmailverificationController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController as ControllersHomeController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TradeController as ControllersTradeController;
use App\Http\Controllers\TradingController;

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

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/bonds', [FrontendController::class, 'bonds'])->name('bonds');
Route::get('/ira', [FrontendController::class, 'ira'])->name('ira');
Route::get('/portfolio', [FrontendController::class, 'portfolio'])->name('portfolio');
Route::get('/socially', [FrontendController::class, 'socially'])->name('socially');
Route::get('/crypto', [FrontendController::class, 'crypto'])->name('cryptoinvest');
Route::get('/performance', [FrontendController::class, 'performance'])->name('performance');
Route::get('/reserve', [FrontendController::class, 'reserve'])->name('reserve');
Route::get('/checking', [FrontendController::class, 'checking'])->name('checking');
Route::get('/rewards', [FrontendController::class, 'rewards'])->name('rewards');
Route::get('/expert', [FrontendController::class, 'expert'])->name('expert');
Route::get('/retirement', [FrontendController::class, 'retirement'])->name('retirement');
Route::get('/goals', [FrontendController::class, 'goals'])->name('goals');
Route::get('/dash', [FrontendController::class, 'dash'])->name('dash');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/review', [FrontendController::class, 'review'])->name('review');
Route::get('/philosophy', [FrontendController::class, 'philosophy'])->name('philosophy');
Route::get('/pricing', [FrontendController::class, 'pricing'])->name('pricing');
Route::get('/press', [FrontendController::class, 'press'])->name('press');
Route::get('/article', [FrontendController::class, 'article'])->name('article');
Route::get('/video', [FrontendController::class, 'video'])->name('video');
Route::get('/employee', [FrontendController::class, 'employee'])->name('employee');
Route::get('/help', [FrontendController::class, 'help'])->name('help');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');

Route::get('/investing', [FrontendController::class, 'investment'])->name('investment');
Route::get('/cash', [FrontendController::class, 'cash'])->name('cash');
Route::get('/stocks', [FrontendController::class, 'stocks'])->name('stocks');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/retirement', [FrontendController::class, 'retirement'])->name('retirement');
Route::get('/college', [FrontendController::class, 'college'])->name('college');

Route::get('/career', [FrontendController::class, 'career'])->name('career');
Route::get('/charitable', [FrontendController::class, 'charitable'])->name('charitable');
Route::get('/howitworks', [FrontendController::class, 'howitworks'])->name('howitworks');
Route::get('/referral', [FrontendController::class, 'referal'])->name('referal');
Route::get('/tax', [FrontendController::class, 'tax'])->name('tax');
Route::get('/legal', [FrontendController::class, 'tax'])->name('legal');
Route::get('/resources', [FrontendController::class, 'review'])->name('resources');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');




Auth::routes(['verify' => true]);

Route::post('/logout/verification', function () {
    Auth::logout();
    return redirect('/register');
})->name('logout.verification');

Route::post('/logout/2fa', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout.two-factor');

Route::get('/user/verify-two-factor', [EmailverificationController::class, 'verify2Factor'])->name('user.verifyTwoFactor');
Route::post('/verify-two-factor', [EmailverificationController::class, 'verifyTwoFactor'])->name('verifyTwoFactor');
Route::get('/resend-two-factor', [EmailverificationController::class, 'sendTwoFactorCode'])->name('resendTwoFactor');

Route::get('/auth/{provider}/attempt', [App\Http\Controllers\Auth\SocialController::class, 'redirect'])->name('auth.social.attempt');
Route::get('/login/{provider}/callback', [App\Http\Controllers\Auth\SocialController::class, 'socialLoginAttempt'])->name('auth.social.login.attempt');
Route::get('/market/{product}/chart', [App\Http\Controllers\HomeController::class, 'showMarket'])->name('market.show');
Route::get('/getStates/{name}', [App\Http\Controllers\HomeController::class, 'getState'])->name('user.getstate');
Route::get('/user/registration/kyc', [App\Http\Controllers\HomeController::class, 'kyc'])->name('user.kyc');
Route::post('/user/registration/kyc/update', [App\Http\Controllers\HomeController::class, 'updateUserInfo'])->name('update.kyc');


Route::group(['middleware' => ['auth', 'unverified']], function (){
    Route::get('/email/verify', [EmailverificationController::class, 'verify'])->name('verification.notice');
    Route::post('/email/verify-with-code', [EmailverificationController::class, 'verifyWithCode'])->name('verification.verify.code');
    Route::get('/email/verify/{id}/{hash}', [EmailverificationController::class, 'verifyMail'])->middleware(['signed'])->name('verification.verify');
    Route::get('/email/verification-notification', [EmailverificationController::class, 'resend'])->middleware(['throttle:6,1'])->name('verification.send');
});

Route::group(['middleware' => ['auth','verified', 'active_user', 'profile_completed', '2fa']], function (){
    Route::get('/email/verification/success', [App\Http\Controllers\HomeController::class, 'verificationSuccess']);
    Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
    Route::post('/password/custom/update', [App\Http\Controllers\HomeController::class, 'changePassword'])->name('password.custom.update');
    Route::post('/profile/update', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/profile/update/settings', [App\Http\Controllers\HomeController::class, 'tabUpdates'])->name('profile.data');
    // Route::get('/getStates/{name}', [App\Http\Controllers\HomeController::class, 'getState'])->name('user.getstate');
    Route::get('/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('settings');
    Route::post('/user/update-two-factor', [App\Http\Controllers\HomeController::class, 'updateTwoFactorStatus'])->name('profile.updateTwoFactor');


    // Route::group(['middleware' => ['profile_completed']], function (){
        // Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
        Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
        Route::get('/dashboard/investment', [App\Http\Controllers\HomeController::class, 'investmentDashboard'])->name('dashboard.investment');
        Route::get('/dashboard/trading', [App\Http\Controllers\HomeController::class, 'tradingDashboard'])->name('dashboard.trading');
        Route::get('/packages', [App\Http\Controllers\PackageController::class, 'index'])->name('packages');
        Route::get('/investments', [App\Http\Controllers\InvestmentController::class, 'index'])->name('investments');
        Route::get('/investment/history', [App\Http\Controllers\InvestmentController::class, 'history'])->name('investments.history');
        Route::get('/investments/{investment}/show', [App\Http\Controllers\InvestmentController::class, 'show'])->name('investments.show');
        Route::get('/invest/{package}', [App\Http\Controllers\InvestmentController::class, 'invest'])->name('invest');
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
        Route::post('/deposit', [App\Http\Controllers\WalletController::class, 'deposit'])->name('deposit');
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
        Route::get('/savings/history', [SavingsController::class, 'history'])->name('savings.history');
        Route::post('/savings/plan/payment/{savings}', [SavingsController::class, 'savingsPayment'])->name('savings.payment');

        // Interest for Admin
        Route::get('/savings/interest/{savings}', [SavingsController::class, 'savingsInterest'])->name('savings.interest');
        Route::post('/savings/interest/{saveTransaction}/withdraw', [SavingsController::class, 'withdrawInterest'])->name('interest.withdaw');


        Route::get('/test/jods', [App\Http\Controllers\CommandController::class, 'handleSavings']);

        Route::post('/account/generate', [WalletController::class, 'generateVirtualAccount'])->name('create.virtual_account');


        Route::get('/payment/callback', [PaymentController::class, 'handlePaymentCallback'])->name('payment.callback');
        Route::get('/payment/initiate', [PaymentController::class, 'initiatePayment'])->name('payment.initiate');

        Route::get('/payment/auth', [PaymentController::class, 'charge'])->name('make.charge');

        Route::post('/trading/stock', [TradingController::class, 'store'])->name('trade.stock');
        Route::get('/trade', [TradingController::class, 'index'])->name('tradings');
        Route::get('/user/crypto', [TradingController::class, 'crypto'])->name('crypto');
        Route::get('/trade/{stock}/{symbol}', [TradingController::class, 'show'])->name('trade.show');

        Route::get('/user/stocks/holdings', [TradingController::class, 'asset'])->name('assets');
        Route::get('/wallet/history', [App\Http\Controllers\TransactionController::class, 'history'])->name('transactions.history');
        Route::post('/balance/topup', [WalletController::class, 'walletSwap'])->name('swap.balance');

        Route::get('/user/asset/view/{stock}', [TradingController::class, 'showAsset'])->name('user.asset');
        Route::get('/wallet-balance', [WalletController::class, 'getWalletBalance'])->name('wallet.balance');
        
        Route::post('/trade/{tradeTransaction}/close', [TradingController::class, 'closeTrade'])->name('trade.close');
        Route::post('/trade/{trade}/close/all', [TradingController::class, 'closeAllTrades'])->name('trade.close.all');

        Route::post('/trading/crypto', [TradingController::class, 'storeCrypto'])->name('trade.crypto');
        Route::get('/user/asset/holdings', [TradingController::class, 'cryptoAsset'])->name('crypto.assets');
        Route::get('/crypto/{stock}/{symbol}', [TradingController::class, 'showCrypto'])->name('crypto.show');
        Route::get('/user/crypto/view/{stock}', [TradingController::class, 'showCryptoTrade'])->name('asset.view');
        Route::post('/asset/{trade}/close/all', [TradingController::class, 'closeAllAssets'])->name('asset.close.all');

        //:: For Developmenent :://

        // Route::get('/wallet-balance/reset', [WalletController::class, 'walletReset'])->name('wallet.reset');
        Route::get('/investment/profit/{investment}', [App\Http\Controllers\InvestmentController::class, 'storeProfit'])->name('invest.profit');

        //:: For Developmenent :://

        Route::get('/wallet/deposit', [WalletController::class, 'depo'])->name('wallet.deposit');

        Route::get('/support/ticket', [SupportController::class, 'index'])->name('support.index');
        Route::get('/support/ticket/{support}', [SupportController::class, 'show'])->name('support.show');
        Route::get('/support/create', [SupportController::class, 'create'])->name('support.create');
        Route::post('/support/ticket/store', [SupportController::class, 'store'])->name('support.store');
        Route::delete('/support/ticket/{id}', [SupportController::class, 'destroy'])->name('support.destroy');
        Route::post('/support/ticket/{support}/respond', [SupportController::class, 'reply'])->name('support.reply');

        Route::get('/update/kyc', [App\Http\Controllers\HomeController::class, 'user_kyc'])->name('kyc.index');
        Route::post('/update/kyc/submit', [App\Http\Controllers\HomeController::class, 'storeKYC'])->name('kyc.post');
        Route::get('/start/savings/{id}', [App\Http\Controllers\SavingsController::class, 'questionaire'])->name('savings.start');

        Route::get('/fetch/plans', [SavingsController::class, 'fetchPlan'])->name('get.plans');
        Route::get('/fetch/plans/{id}', [SavingsController::class, 'getPlanDetails'])->name('plans.savings');
        Route::post('/support/ticket/{support}/respond', [SupportController::class, 'reply'])->name('support.reply');

        Route::post('/user/mode', [App\Http\Controllers\HomeController::class, 'userMode'])->name('change.mode');
        Route::post('/watchlist', [App\Http\Controllers\HomeController::class, 'storeWatchlist'])->name('add.watchlist');
    // });
});
