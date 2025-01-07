<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\AccountAddress;
use App\Models\AccountNetwork;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CommandController;
use App\Models\AccountCoin;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $banks = json_decode(Http::get('https://api.paystack.co/bank')->getBody(), true)['data'];
        }catch (Exception $exception){
            $banks = [];
        }

        // $networks = AccountNetwork::all();

        $coins = AccountCoin::all();

        $addresses = AccountAddress::with('account_network')->get();

        $networks = AccountNetwork::with('addresses')->get();

        return view('admin.setting.index', [
            'banks' => $banks, 
            'setting' => Setting::all()->first(),
            'networks' => $networks,
            'addresses' => $addresses,
            'coins' => $coins,
        ]);
    }

    public function storeNetwork(Request $request)
    {
        $validated = $request->validate([
            'account_coin_id' => 'nullable|exists:account_coins,id',
            'network' => 'required|string',
        ]);

        $coin = AccountCoin::findOrFail($request->account_coin_id);

        if ($request->filled(['account_coin_id', 'network'])) {
            AccountNetwork::create(
                [
                    'account_coin_id' => $validated['account_coin_id'],
                    'name' => $validated['network'],
                    'symbol' => $coin->symbol
                ]
            );
        }

        // Redirect back with a success message
        return redirect()
            ->back()
            ->with('success', 'Crypto settings updated successfully!');
    }

    // Store the new address
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_network_id' => 'nullable|exists:account_networks,id',
            'address' => 'nullable|string',
        ]);

        if ($request->filled(['account_network_id', 'address'])) {
            AccountAddress::updateOrCreate(
                ['account_network_id' => $validated['account_network_id']],
                ['address' => $validated['address']]
            );
        }

        // Redirect back with a success message
        return redirect()
            ->back()
            ->with('success', 'Crypto settings updated successfully!');
    }

    public function storeNote(Request $request)
    {
        $validated = $request->validate([
            'crypto_note' => 'required|string',
        ]);

        if ($request->filled('crypto_note')) {
            $setting = Setting::first();
            if ($setting) {
                $setting->update(['crypto_note' => $validated['crypto_note']]);
            }
        }

        // Redirect back with a success message
        return redirect()
            ->back()
            ->with('success', 'Crypto settings updated successfully!');
    }

    public function updateBankDetails(Request $request): RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'bank_name' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        //        Update bank details
        if (Setting::all()->first()->update([
            'bank_name' => $request['bank_name'],
            'account_name' => $request['account_name'],
            'account_number' => $request['account_number']
        ]))
            return back()->with('success', 'Bank details updated successfully');
        return back()->with('error', 'Error updating bank details');
    }

    public function setMobileAppVersion(Request $request): RedirectResponse
    {
        $request->validate(['ios_version' => 'required', 'android_version' => 'required']);
        $settings = Setting::first();
        if ($settings) $settings->update($request->only(['ios_version', 'android_version']));
        return back()->with('success', 'Mobile app version updated successfully!');
    }

    public function depositSettings(Request $request): RedirectResponse 
    {
        $validator = Validator::make($request->all(), [
            'account_name' => ['required'],
            'account_number' => ['required'],
            'bank_name' => ['required'],
            'bank_address' => ['required'],
            'swift_code' => ['required'],
            'routing' => ['required'],
            'bank_reference' => ['required'],
            'bank_note_initial' => ['required'],
            'bank_note_final' => ['required'],
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        if (Setting::all()->first()->update([
            'account_name' => $request['account_name'],
            'account_number' => $request['account_number'],
            'bank_name' => $request['bank_name'],
            'bank_address' => $request['bank_address'],
            'swift_code' => $request['swift_code'],
            'bank_reference' => $request['bank_reference'],
            'routing' => $request['routing'],
            'bank_note_initial' => $request['bank_note_initial'],
            'bank_note_final' => $request['bank_note_final'],
        ]))
            return back()->with('success', 'Settings updated successfully');
        return back()->with('error', 'Error updating settings');
    }

    public function destroyNetwork(AccountNetwork $network)
    {
        if ($network->delete()){
            return back()->with('success', 'Networks deleted successfully');
        }

        return back()->with('error', 'Error deleting Networks');
    }

    public function saveSettings(Request $request): RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
//            'referral_earning' => ['required'],
//            'buy_rate_plus' => ['required', 'numeric'],
//            'sell_rate_plus' => ['required', 'numeric'],
//            'gold_buy_price_diff' => ['required', 'numeric'],
//            'gold_sell_price_diff' => ['required', 'numeric'],
//            'silver_buy_price_diff' => ['required', 'numeric'],
//            'silver_sell_price_diff' => ['required', 'numeric'],
            'delete_duration' => ['required_if:auto_delete_users,yes'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Update settings
        if (Setting::all()->first()->update([
//            'referral_earning' => $request['referral_earning'],
//            'sell_rate_plus' => $request['sell_rate_plus'],
//            'buy_rate_plus' => $request['buy_rate_plus'],
//            'gold_buy_price_diff' => $request['gold_buy_price_diff'],
//            'gold_sell_price_diff' => $request['gold_sell_price_diff'],
//            'silver_buy_price_diff' => $request['silver_buy_price_diff'],
//            'silver_sell_price_diff' => $request['silver_sell_price_diff'],
            'show_cash' => $request['show_cash'] == 'yes',
            'invest' => $request['invest'] == 'yes',
            'rollover' => $request['rollover'] == 'yes',
//            'trade' => $request['trade'] == 'yes',
            'withdrawal' => $request['withdrawal'] == 'yes',
            'auto_delete_unverified_users' => $request['auto_delete_users'] == 'yes',
            'auto_delete_unverified_users_after' => $request['delete_duration'],
            'exchange_rate_error_mail' => $request['exchange_rate_error_mail'] == 'yes',
            'pending_transaction_mail' => $request['pending_transaction_mail'] == 'yes',
            'error_mail_interval' => $request['error_mail_interval'],
            'pending_transaction_mail_interval' => $request['pending_transaction_mail_interval'],
            'sidebar' => $request['sidebar'],
        ]))
            return back()->with('success', 'Settings updated successfully');
        return back()->with('error', 'Error updating settings');
    }
}
