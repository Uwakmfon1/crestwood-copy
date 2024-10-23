<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\AccountAddress;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CommandController;

class SettingController extends Controller
{
    public function index()
    {
        try {
            $banks = json_decode(Http::get('https://api.paystack.co/bank')->getBody(), true)['data'];
        }catch (Exception $exception){
            $banks = [];
        }
        return view('admin.setting.index', ['banks' => $banks, 'setting' => Setting::all()->first()]);
    }

    // Store the new address
    public function store(Request $request)
    {
        $request->validate([
            'account_network_id' => 'required|exists:account_networks,id',
            'address' => 'required|string|max:255',
        ]);

        AccountAddress::create([
            'account_network_id' => $request->account_network_id,
            'address' => $request->address,
        ]);

        return redirect()->back()->with('success', 'Address added successfully!');
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
            'crypto_note' => ['required'],
            'bank_note_initial' => ['required'],
            'bank_note_final' => ['required'],
            'bank_address' => ['required'],
            'bank_phone' => ['required'],
            'bank_country' => ['required'],
            'bank_state' => ['required'],
            'bank_address_address' => ['required'],
            'account_name' => ['required'],
            'account_number' => ['required'],
            'bank_name' => ['required'],
            'swift_code' => ['required'],
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        if (Setting::all()->first()->update([
            'crypto_note' => $request['crypto_note'],
            'bank_note_initial' => $request['bank_note_initial'],
            'bank_note_final' => $request['bank_note_final'],
            'bank_address' => $request['bank_address'],
            'bank_phone' => $request['bank_phone'],
            'bank_country' => $request['bank_country'],
            'account_name' => $request['account_name'],
            'account_number' => $request['account_number'],
            'bank_name' => $request['bank_name'],
            'swift_code' => $request['swift_code'],
        ]))
            return back()->with('success', 'Settings updated successfully');
        return back()->with('error', 'Error updating settings');
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
