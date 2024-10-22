<?php

use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminLoginController::class, 'login'])->name('login.submit');
Route::get('/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/reset', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('password.change.show');
Route::post('/password/reset/change', [AdminResetPasswordController::class, 'reset'])->name('password.update');

Route::group(['middleware' => ['auth:admin', 'active_admin']], function (){
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard')->middleware('permission:View Quick Overview');
    Route::get('/dashboard/investment', [App\Http\Controllers\Admin\HomeController::class, 'investmentDashboard'])->name('dashboard.investment')->middleware('permission:View Investment Dashboard');
    Route::get('/dashboard/trading', [App\Http\Controllers\Admin\HomeController::class, 'tradingDashboard'])->name('dashboard.trading')->middleware('permission:View Trading Dashboard');
    Route::get('/packages', [App\Http\Controllers\Admin\PackageController::class, 'index'])->name('packages')->middleware('permission:View Packages');
    Route::get('/packages/all/secure-access', [App\Http\Controllers\Admin\PackageController::class, 'indexAll'])->middleware('permission:View Packages');
    Route::get('/packages/create', [App\Http\Controllers\Admin\PackageController::class, 'create'])->name('packages.create')->middleware('permission:Create Packages');
    Route::get('/packages/{package}/edit', [App\Http\Controllers\Admin\PackageController::class, 'edit'])->name('packages.edit')->middleware('permission:Edit Packages');
    Route::get('/packages/{package}/investments', [App\Http\Controllers\Admin\PackageController::class, 'investments'])->name('packages.investments')->middleware('permission:View Investments');
    Route::get('/users', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('users')->middleware('permission:View Users');
    Route::get('/users/{user}/show', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('users.show')->middleware('permission:View Users');
    Route::delete('/users/{user}/delete', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('users.delete')->middleware('permission:Delete Users');
    Route::get('/users/{user}/trade/buy', [App\Http\Controllers\Admin\TradeController::class, 'buy'])->name('users.trades.buy')->middleware('permission:Buy Products For Users');
    Route::get('/users/{user}/trade/sell', [App\Http\Controllers\Admin\TradeController::class, 'sell'])->name('users.trades.sell')->middleware('permission:Sell Products For Users');
    Route::get('/users/{user}/invest', [App\Http\Controllers\Admin\InvestmentController::class, 'invest'])->name('users.invest')->middleware('permission:Make Investment For Users');
    Route::get('/users/{user}/investments/{investment}/show', [App\Http\Controllers\Admin\InvestmentController::class, 'showUserInvestment'])->name('users.investment.show')->middleware('permission:View Investments');
    Route::get('/investments', [App\Http\Controllers\Admin\InvestmentController::class, 'index'])->name('investments')->middleware('permission:View Investments');
    Route::get('/investments/{investment}/show', [App\Http\Controllers\Admin\InvestmentController::class, 'show'])->name('investments.show')->middleware('permission:View Investments');
    Route::get('/transactions', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('transactions')->middleware('permission:View Transactions');
    Route::get('/trades', [App\Http\Controllers\Admin\TradeController::class, 'index'])->name('trades')->middleware('permission:View Trades');
    Route::get('/market/chart', [App\Http\Controllers\Admin\HomeController::class, 'market'])->name('market')->middleware('permission:View Market / Statistics');
    Route::get('/maturity/investments', [App\Http\Controllers\Admin\HomeController::class, 'investmentMaturity'])->name('investment.maturity')->middleware('permission:View Investments Maturity');
    Route::get('/referrals', [App\Http\Controllers\Admin\ReferralController::class, 'index'])->name('referrals')->middleware('permission:View Referrals Leaderboard');
    Route::get('/admins', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admins')->middleware('permission:View Admins');
    Route::get('/admins/create', [App\Http\Controllers\Admin\AdminController::class, 'create'])->name('admins.create')->middleware('permission:Create Admins');
    Route::get('/roles', [App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles')->middleware('permission:View Roles');
    Route::get('/roles/create', [App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->middleware('permission:Create Roles');
    Route::get('/roles/{role}/edit', [App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:Edit Roles');
    Route::get('/profile', [App\Http\Controllers\Admin\HomeController::class, 'profile'])->name('profile');
    Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings')->middleware('permission:View Settings');
    Route::get('/email', [App\Http\Controllers\Admin\EmailController::class, 'index'])->name('email')->middleware('permission:View Emails');
    Route::get('/email/new', [App\Http\Controllers\Admin\EmailController::class, 'create'])->name('email.create')->middleware('permission:Send Emails');
    Route::get('/email/{email}/show', [App\Http\Controllers\Admin\EmailController::class, 'show'])->name('email.show')->middleware('permission:View Emails');

    Route::post('/password/custom/update', [App\Http\Controllers\Admin\HomeController::class, 'changePassword'])->name('password.custom.update');
    Route::post('/profile/update', [App\Http\Controllers\Admin\HomeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/packages', [App\Http\Controllers\Admin\PackageController::class, 'store'])->name('packages.store')->middleware('permission:Create Packages');
    Route::put('/packages/{package}/update', [App\Http\Controllers\Admin\PackageController::class, 'update'])->name('packages.update')->middleware('permission:Edit Packages');
    Route::delete('/packages/{package}/destroy', [App\Http\Controllers\Admin\PackageController::class, 'destroy'])->name('packages.destroy')->middleware('permission:Delete Packages');
    Route::post('/admins/store', [App\Http\Controllers\Admin\AdminController::class, 'store'])->name('admins.store')->middleware('permission:Create Admins');
    Route::put('/admins/{admin}/block', [App\Http\Controllers\Admin\AdminController::class, 'block'])->name('admins.block')->middleware('permission:Block Admins');
    Route::put('/admins/{admin}/unblock', [App\Http\Controllers\Admin\AdminController::class, 'unblock'])->name('admins.unblock')->middleware('permission:Unblock Admins');
    Route::post('/admins/role/change', [App\Http\Controllers\Admin\AdminController::class, 'changeRole'])->name('admins.role.change')->middleware('permission:Change Admins Role');
    Route::post('/roles/store', [App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->middleware('permission:Create Roles');
    Route::put('/roles/{role}/update', [App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->middleware('permission:Edit Roles');
    Route::delete('/roles/{role}/destroy', [App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:Delete Roles');
    Route::put('/users/{user}/block', [App\Http\Controllers\Admin\UserController::class, 'block'])->name('users.block')->middleware('permission:Block Users');
    Route::put('/users/{user}/unblock', [App\Http\Controllers\Admin\UserController::class, 'unblock'])->name('users.unblock')->middleware('permission:Unblock Users');
    Route::put('/transactions/{transaction}/approve', [App\Http\Controllers\Admin\TransactionController::class, 'approve'])->name('transactions.approve')->middleware('permission:Approve Transactions');
    Route::put('/transactions/{transaction}/decline', [App\Http\Controllers\Admin\TransactionController::class, 'decline'])->name('transactions.decline')->middleware('permission:Decline Transactions');
    Route::post('/users/invest/store', [App\Http\Controllers\Admin\InvestmentController::class, 'store'])->name('users.invest.store')->middleware('permission:Make Investment For Users');
    Route::post('/email/store', [App\Http\Controllers\Admin\EmailController::class, 'store'])->name('email.store')->middleware('permission:Send Emails');
    Route::post('/investments/rollover', [App\Http\Controllers\Admin\RolloverController::class, 'store'])->name('investments.rollover')->middleware('permission:Rollover Investment For Users');

    Route::post('/users/trade/buy', [App\Http\Controllers\Admin\TradeController::class, 'buyStore'])->name('users.trades.buy.store')->middleware('permission:Buy Products For Users');
    Route::post('/users/trade/sell', [App\Http\Controllers\Admin\TradeController::class, 'sellStore'])->name('users.trades.sell.store')->middleware('permission:Sell Products For Users');
    Route::post('/deposit', [App\Http\Controllers\Admin\TransactionController::class, 'deposit'])->name('deposit')->middleware('permission:Deposit For Users');
    Route::post('/withdraw', [App\Http\Controllers\Admin\TransactionController::class, 'withdraw'])->name('withdraw')->middleware('permission:Withdraw For Users');
    Route::post('/download', [App\Http\Controllers\Admin\HomeController::class, 'download'])->name('download')->middleware('permission:View Users');

    Route::post('/setting/bank/update', [App\Http\Controllers\Admin\SettingController::class, 'updateBankDetails'])->name('bank.update')->middleware('permission:Update Company Bank Details');
    Route::post('/setting/version/update', [App\Http\Controllers\Admin\SettingController::class, 'setMobileAppVersion'])->name('version.update');
    Route::post('/setting/save', [App\Http\Controllers\Admin\SettingController::class, 'saveSettings'])->name('settings.save')->middleware('permission:Update Other Settings');

    Route::get('/payments', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('payments.index')->middleware('permission:View Payments');
    Route::post('/payments/{payment}/resolve', [App\Http\Controllers\Admin\PaymentController::class, 'resolve'])->name('payments.resolve')->middleware('permission:Resolve Payments');

    Route::post('/users/{type}/fetch/ajax', [App\Http\Controllers\Admin\UserController::class, 'fetchUsersWithAjax'])->name('users.ajax')->middleware('permission:View Users');
    Route::post('/investments/{type}/fetch/ajax', [App\Http\Controllers\Admin\InvestmentController::class, 'fetchInvestmentsWithAjax'])->name('investments.ajax')->middleware('permission:View Investments'); 
    Route::post('/maturity/investments/fetch/ajax', [App\Http\Controllers\Admin\HomeController::class, 'fetchInvestmentsMaturityWithAjax'])->name('investments.maturity.ajax')->middleware('permission:View Investments Maturity');
    Route::post('/transactions/{type}/fetch/ajax', [App\Http\Controllers\Admin\TransactionController::class, 'fetchTransactionsWithAjax'])->name('transactions.ajax')->middleware('permission:View Transactions');
    Route::post('/trades/{type}/fetch/ajax', [App\Http\Controllers\Admin\TradeController::class, 'fetchTradesWithAjax'])->name('trades.ajax')->middleware('permission:View Trades');
    Route::post('/payments/fetch/ajax', [App\Http\Controllers\Admin\PaymentController::class, 'fetchPaymentsWithAjax'])->name('payments.ajax')->middleware('permission:View Payments');

    Route::get('/investments/export/{type}/download', [ExportController::class, 'exportInvestments'])->name('investments.export')->middleware('permission:Export Investments CSV');
    Route::get('/transactions/export/{type}/download', [ExportController::class, 'exportTransactions'])->name('transactions.export')->middleware('permission:Export Transactions CSV');
    Route::get('/trades/export/{type}/download', [ExportController::class, 'exportTrades'])->name('trades.export')->middleware('permission:Export Trades CSV');
    Route::get('/users/export/{type}/download', [ExportController::class, 'exportUsers'])->name('users.export')->middleware('permission:Export Users CSV');

    Route::get('/savings/package', [App\Http\Controllers\Admin\SavingsController::class, 'index'])->name('saving.package');
    Route::get('/savings/package/create', [App\Http\Controllers\Admin\SavingsController::class, 'create'])->name('saving.package.create');
    Route::post('/savings/package/store', [App\Http\Controllers\Admin\SavingsController::class, 'store'])->name('saving.package.store');
    Route::get('/savings/package/{package}/edit', [App\Http\Controllers\Admin\SavingsController::class, 'edit'])->name('saving.package.edit');
    Route::put('/savings/package/{package}/update', [App\Http\Controllers\Admin\SavingsController::class, 'update'])->name('saving.package.update');
    Route::delete('/savings/package/{package}/destroy', [App\Http\Controllers\Admin\SavingsController::class, 'destroy'])->name('saving.package.destroy');

    Route::get('/packages/{savings}/savings', [App\Http\Controllers\Admin\SavingsController::class, 'savings'])->name('saving.table');
    Route::post('/savings/{type}/fetch/ajax', [App\Http\Controllers\Admin\SavingsController::class, 'fetchSavingsWithAjax'])->name('savings.ajax'); 
    Route::get('/savings/{saving}/show', [App\Http\Controllers\Admin\SavingsController::class, 'show'])->name('savings.show');
    Route::get('/users/{user}/savings/{saving}/show', [App\Http\Controllers\Admin\SavingsController::class, 'showUserSavings'])->name('users.savings.show');
    Route::get('/savings', [App\Http\Controllers\Admin\SavingsController::class, 'all'])->name('savings')->middleware('permission:View Investments');

    Route::post('/admin/addresses', [App\Http\Controllers\Admin\SettingController::class, 'store'])->name('addresses.store');
    Route::post('/admin/bank/info', [App\Http\Controllers\Admin\SettingController::class, 'depositSettings'])->name('settings.bank');

    Route::get('/support/tickets', [App\Http\Controllers\Admin\SupportController::class, 'index'])->name('support.all');
    Route::get('/support/ticket/{support}', [App\Http\Controllers\Admin\SupportController::class, 'show'])->name('support.view');
    Route::post('/support/ticket/{support}/reply', [App\Http\Controllers\Admin\SupportController::class, 'reply'])->name('support.reply');
});
