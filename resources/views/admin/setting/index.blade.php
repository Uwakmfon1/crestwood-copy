@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Settings</li>
        </ol>
    </nav>
@endsection

@php 

$networks = \App\Models\AccountNetwork::all();

@endphp

@section('content')
    <div class="row">
        <div class="col-md-6 grid-margin">
            <div class="card">
            @extends('layouts.admin')

            <div class="card-body">
                    <div class="my-3">
                        <form action="{{ route('admin.addresses.store') }}" method="POST">
                            @csrf
                            <h6 class="card-title">Crypto Network</h6>
                            <div class="mb-3">
                                <label for="network" class="form-label">Select Network</label>
                                <select name="account_network_id" id="network" class="form-control">
                                    <option value="">Select a Network</option>
                                    @foreach($networks as $network)
                                        <option value="{{ $network->id }}">{{ $network->name }} ({{ $network->symbol }})</option>
                                    @endforeach
                                </select>
                                @error('account_network_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="address" class="form-label">Wallet Address</label>
                                <input type="text" name="address" id="address" class="form-control" placeholder="No address set" value="{{ old('address') }}">
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Add Address</button>
                        </form>
                    </div>
                </div>

                <div class="card-body">
                    <h6 class="card-title">Bank Details</h6>
                    <form action="{{ route('admin.bank.update') }}" id="bankDetailsForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="bank_name">Bank Name</label>
                            <select name="bank_name" style="height: 40px; font-size: 15px" class="form-control text-dark" id="bankList">
                                @if(count($banks) > 0)
                                    <option value="">Select Bank</option>
                                    @foreach($banks as $bank)
                                        <option @if(old("bank_name") == $bank['name'] || $setting['bank_name'] == $bank['name']) selected @endif value="{{ $bank['name'] }}" data-code="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
                                    @endforeach
                                @else
                                    <option value="">Error Fetching Banks</option>
                                @endif
                            </select>
                            @error('bank_name')
                            <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <input type="hidden" id="bankCode" value="@if(count($banks) > 0) @foreach($banks as $bank) @if($setting['bank_name'] == $bank['name']) {{ $bank['code'] }} @endif @endforeach @endif">
                        </div>
                        <div class="form-group">
                            <label for="account_number">Account Number</label>
                            <input type="number" value="{{ old('account_number') ?? $setting['account_number'] }}" style="height: 40px; font-size: 15px" class="form-control" name="account_number" id="account_number" placeholder="Account Number">
                            @error('account_number')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="account_name" class="d-flex justify-content-between">
                                <span class="d-block">Account Name <span class="text-danger">*</span></span>
                                <span id="verifyingDisplay" class="small d-block"></span>
                            </label>
                            <input type="text" readonly value="{{ old('account_name') ?? $setting['account_name'] }}" style="height: 40px; font-size: 15px" class="form-control" name="account_name" id="account_name" placeholder="Account Name">
                            @error('account_name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        @can('Update Company Bank Details')
                            <button class="btn btn-primary" disabled id="submitButton" onclick="confirmFormSubmit('bankDetailsForm')" type="button">Update Account Details</button>
                        @endcan
                    </form>
                </div>
            </div>

            <div class="card my-5">
                <div class="card-body">
                    <h6 class="card-title">Mobile App Version</h6>
                    <form action="{{ route('admin.version.update') }}" id="versionDetailsForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="android_version">Android Version</label>
                            <input type="text" value="{{ old('android_version') ?? $setting['android_version'] }}" style="height: 40px; font-size: 15px" class="form-control" name="android_version" id="android_version" placeholder="Android Version">
                            @error('android_version')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="ios_version">iOS Version</label>
                            <input type="text" value="{{ old('ios_version') ?? $setting['ios_version'] }}" style="height: 40px; font-size: 15px" class="form-control" name="ios_version" id="ios_version" placeholder="iOS Version">
                            @error('ios_version')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <button class="btn btn-primary" onclick="confirmFormSubmit('versionDetailsForm')" type="button">Update Version</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6 grid-margin">
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-title">Crytocurrency/Bank Information</h6>
                    <div class="">
                        <form action="{{ route('admin.settings.bank') }}" method="POST">
                            @csrf
                            <div class="my-4">
                                <label for="crypto_note">Cryptocurrency Note:</label>
                                <textarea name="crypto_note" id="crypto_note" class="form-control" cols="30" rows="10">{{ $setting->crypto_note }}</textarea>
                            </div>
                            <div class="my-4">
                                <label for="bank_note_initial">Bank Note (Initial):</label>
                                <textarea name="bank_note_initial" id="bank_note_initial" class="form-control" cols="30" rows="10">{{ $setting->bank_note_initial }}</textarea>
                            </div>
                            <div class="my-4">
                                <label for="bank_note_final">Bank Note (Final):</label>
                                <textarea name="bank_note_final" id="bank_note_final" class="form-control" cols="30" rows="10">{{ $setting->bank_note_final }}</textarea>
                            </div>
                            <div class="my-4">
                                <label for="account_name">Account Name:</label>
                                <input type="text" class="form-control" name="account_name" value="{{ $setting->account_name }}">
                            </div>
                            <div class="my-4">
                                <label for="account_number">Account Number:</label>
                                <input type="text" class="form-control" name="account_number" value="{{ $setting->account_number }}">
                            </div>
                            <div class="my-4">
                                <label for="swift_code">Swift Code:</label>
                                <input type="text" class="form-control" name="swift_code" value="{{ $setting->swift_code }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_name">Bank Name:</label>
                                <input type="text" class="form-control" name="bank_name" value="{{ $setting->bank_name }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_address">Bank Address:</label>
                                <input type="text" class="form-control" name="bank_address" value="{{ $setting->bank_address }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_phone">Bank Phone:</label>
                                <input type="text" class="form-control" name="bank_phone" value="{{ $setting->bank_phone }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_country">Bank Country:</label>
                                <input type="text" class="form-control" name="bank_country" value="{{ $setting->bank_country }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_state">Bank State:</label>
                                <input type="text" class="form-control" name="bank_state" value="{{ $setting->bank_state }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_address_address">Address:</label>
                                <input type="text" class="form-control" name="bank_address_address" value="{{ $setting->bank_address_address }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_reference">Bank Reference:</label>
                                <input type="text" class="form-control" name="bank_reference" value="{{ $setting->bank_reference }}">
                            </div>
                            <div class="mt-3">
                                <button class="btn btn-primary" type="submit">Update Settings</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Other Settings</h6>
                    <form action="{{ route('admin.settings.save') }}" id="otherSettingForm" method="POST">
                        @csrf
{{--                        <div class="form-group">--}}
{{--                            <label for="referral_earning">Referral Earning</label>--}}
{{--                            <input type="number" value="{{ old('referral_earning') ?? $setting['referral_earning'] }}" class="form-control" name="referral_earning" id="referral_earning" placeholder="Referral Earning">--}}
{{--                            @error('referral_earning')--}}
{{--                            <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="buy_rate">Trade Buy Rate</label>--}}
{{--                            <div class="input-group mb-3">--}}
{{--                                <span class="input-group-text">{{ $setting['usd_to_ngn'] }} ± </span>--}}
{{--                                <input type="number" id="buy_rate" step="any" value="{{ old('buy_rate_plus') ?? $setting['buy_rate_plus'] }}" name="buy_rate_plus" class="form-control" placeholder="0.00">--}}
{{--                            </div>--}}
{{--                            @error('buy_rate_plus')--}}
{{--                                <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="gold_sell_rate">Trade Sell Rate</label>--}}
{{--                            <div class="input-group mb-3">--}}
{{--                                <span class="input-group-text">{{ $setting['usd_to_ngn'] }} ± </span>--}}
{{--                                <input type="number" id="sell_rate" step="any" value="{{ old('sell_rate_plus') ?? $setting['sell_rate_plus'] }}" name="sell_rate_plus" class="form-control" placeholder="0.00">--}}
{{--                            </div>--}}
{{--                            @error('sell_rate_plus')--}}
{{--                                <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                            @enderror--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="gold_buy_price_diff">Gold Buy Price</label>--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <span class="input-group-text">{{ number_format(\App\Http\Controllers\HomeController::fetchGoldBuyPriceInNGN(true), 2) }} ± </span>--}}
{{--                                        <input type="number" id="gold_buy_price_diff" step="any" value="{{ old('gold_buy_price_diff') ?? $setting['gold_buy_price_diff'] }}" name="gold_buy_price_diff" class="form-control" placeholder="0.00">--}}
{{--                                    </div>--}}
{{--                                    @error('gold_buy_price_diff')--}}
{{--                                    <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="gold_sell_price_diff">Gold Sell Price</label>--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <span class="input-group-text">{{ number_format(\App\Http\Controllers\HomeController::fetchGoldSellPriceInNGN(true), 2) }} ± </span>--}}
{{--                                        <input type="number" id="gold_sell_price_diff" step="any" value="{{ old('gold_sell_price_diff') ?? $setting['gold_sell_price_diff'] }}" name="gold_sell_price_diff" class="form-control" placeholder="0.00">--}}
{{--                                    </div>--}}
{{--                                    @error('gold_sell_price_diff')--}}
{{--                                    <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6">--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="silver_buy_price_diff">Silver Buy Price</label>--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <span class="input-group-text">{{ number_format(\App\Http\Controllers\HomeController::fetchSilverBuyPriceInNGN(true), 2) }} ± </span>--}}
{{--                                        <input type="number" id="silver_buy_price_diff" step="any" value="{{ old('silver_buy_price_diff') ?? $setting['silver_buy_price_diff'] }}" name="silver_buy_price_diff" class="form-control" placeholder="0.00">--}}
{{--                                    </div>--}}
{{--                                    @error('silver_buy_price_diff')--}}
{{--                                    <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                                <div class="form-group">--}}
{{--                                    <label for="silver_sell_price_diff">Silver Sell Price</label>--}}
{{--                                    <div class="input-group mb-3">--}}
{{--                                        <span class="input-group-text">{{ number_format(\App\Http\Controllers\HomeController::fetchSilverSellPriceInNGN(true), 2) }} ± </span>--}}
{{--                                        <input type="number" id="silver_sell_price_diff" step="any" value="{{ old('silver_sell_price_diff') ?? $setting['silver_sell_price_diff'] }}" name="silver_sell_price_diff" class="form-control" placeholder="0.00">--}}
{{--                                    </div>--}}
{{--                                    @error('silver_sell_price_diff')--}}
{{--                                    <span class="text-danger small" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                    @enderror--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="show_cash" value="yes" @if($setting['show_cash'] == 1) checked @endif class="custom-control-input" id="showCash">
                                <label class="custom-control-label" for="showCash">Auto show cash details on dashboard</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="invest" value="yes" @if($setting['invest'] == 1) checked @endif class="custom-control-input" id="makeInvestment">
                                <label class="custom-control-label" for="makeInvestment">Enable users make investments</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="rollover" value="yes" @if($setting['rollover'] == 1) checked @endif class="custom-control-input" id="makeInvestmentRollover">
                                <label class="custom-control-label" for="makeInvestmentRollover">Enable investments rollover</label>
                            </div>
                        </div>
{{--                        <div class="form-group">--}}
{{--                            <div class="custom-control custom-switch">--}}
{{--                                <input type="checkbox" name="trade" value="yes" @if($setting['trade'] == 1) checked @endif class="custom-control-input" id="tradeGold">--}}
{{--                                <label class="custom-control-label" for="tradeGold">Enable users trade</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="withdrawal" value="yes" @if($setting['withdrawal'] == 1) checked @endif class="custom-control-input" id="makeWithdrawal">
                                <label class="custom-control-label" for="makeWithdrawal">Enable users make withdrawals</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="auto_delete_users" value="yes" @if($setting['auto_delete_unverified_users'] == 1) checked @endif class="custom-control-input" id="autoDelete">
                                <label class="custom-control-label" for="autoDelete">Auto delete unverified users</label>
                            </div>
                        </div>
                        <div class="form-group" style="display: none" id="deletionInfo">
                            <label for="autoDeleteDuration">Delete after</label>
                            <select name="delete_duration" class="form-control text-dark" id="autoDelete">
                                <option @if($setting['auto_delete_unverified_users_after'] == '3 days') selected @endif value="3 days">3 days</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '1 week') selected @endif value="1 week">1 week</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '2 week') selected @endif value="2 week">2 weeks</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '3 week') selected @endif value="3 week">3 weeks</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '1 month') selected @endif value="1 month">1 month</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '2 months') selected @endif value="2 months">2 months</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '3 months') selected @endif value="3 months">3 months</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '6 months') selected @endif value="6 months">6 months</option>
                                <option @if($setting['auto_delete_unverified_users_after'] == '1 year') selected @endif value="1 year">1 year</option>
                            </select>
                            @error('delete_duration')
                            <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="pending_transaction_mail" value="yes" @if($setting['pending_transaction_mail'] == 1) checked @endif class="custom-control-input" id="pendingTransaction">
                                <label class="custom-control-label" for="pendingTransaction">Send email on pending transactions</label>
                            </div>
                        </div>
                        <div class="form-group" style="display: none" id="pendingTransactionDuration">
                            <label for="pendingTransactionDurationBox">Check for pending transactions every </label>
                            <select name="pending_transaction_mail_interval" class="form-control text-dark" id="pendingTransactionDurationBox">
                                <option @if($setting['pending_transaction_mail_interval'] == '1 minute') selected @endif value="1 minute">1 minute</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '2 minutes') selected @endif value="2 minutes">2 minutes</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '5 minutes') selected @endif value="5 minutes">5 minutes</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '10 minutes') selected @endif value="10 minutes">10 minutes</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '15 minutes') selected @endif value="15 minutes">15 minutes</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '30 minutes') selected @endif value="30 minutes">30 minutes</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '1 hour') selected @endif value="1 hour">1 hour</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '2 hours') selected @endif value="2 hours">2 hours</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '3 hours') selected @endif value="3 hours">3 hours</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '6 hours') selected @endif value="6 hours">6 hours</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '12 hours') selected @endif value="12 hours">12 hours</option>
                                <option @if($setting['pending_transaction_mail_interval'] == '24 hours') selected @endif value="24 hours">24 hours</option>
                            </select>
                            @error('error_mail_interval')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" name="exchange_rate_error_mail" value="yes" @if($setting['exchange_rate_error_mail'] == 1) checked @endif class="custom-control-input" id="exchangeRateError">
                                <label class="custom-control-label" for="exchangeRateError">Send email on exchange rate update error</label>
                            </div>
                        </div>
                        <div class="form-group" style="display: none" id="updateErrorInfo">
                            <label for="updateErrorInfoDuration">On rate update error, resend email after</label>
                            <select name="error_mail_interval" class="form-control text-dark" id="updateErrorInfoDuration">
                                <option @if($setting['error_mail_interval'] == '30 minutes') selected @endif value="30 minutes">30 minutes</option>
                                <option @if($setting['error_mail_interval'] == '1 hour') selected @endif value="1 hour">1 hour</option>
                                <option @if($setting['error_mail_interval'] == '2 hours') selected @endif value="2 hours">2 hours</option>
                                <option @if($setting['error_mail_interval'] == '3 hours') selected @endif value="3 hours">3 hours</option>
                                <option @if($setting['error_mail_interval'] == '6 hours') selected @endif value="6 hours">6 hours</option>
                                <option @if($setting['error_mail_interval'] == '12 hours') selected @endif value="12 hours">12 hours</option>
                                <option @if($setting['error_mail_interval'] == '24 hours') selected @endif value="24 hours">24 hours</option>
                            </select>
                            @error('error_mail_interval')
                            <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" @if($setting['sidebar'] == 'dark') checked @endif class="form-check-input toggleSideBar" name="sidebar" id="dark" value="dark">
                                    Dark Sidebar
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" @if($setting['sidebar'] == 'light') checked @endif class="form-check-input toggleSideBar" name="sidebar" id="light" value="light">
                                    Light Sidebar
                                </label>
                            </div>
                        </div>
                        @can('Update Other Settings')
                        <button class="btn btn-primary" onclick="confirmFormSubmit('otherSettingForm')" type="button">Update Settings</button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            let bankList = $('#bankList');
            let bankCode = $('#bankCode');
            let accountNumber = $('#account_number');
            let accountName = $('#account_name');
            let verifyingDisplay = $('#verifyingDisplay');
            let submitButton = $('#submitButton');
            let autoDelete = $('#autoDelete');
            let deletionInfo = $('#deletionInfo');
            let exchangeRateError = $('#exchangeRateError');
            let updateErrorInfo = $('#updateErrorInfo');
            let pendingTransaction = $('#pendingTransaction');
            let pendingTransactionDuration = $('#pendingTransactionDuration');
            if (bankList.val() && accountName.val() && accountNumber.val())
                submitButton.prop('disabled', false);
            checkForAutoDelete();
            checkForErrorInfo();
            checkForPendingTransactionNotification();
            bankList.on('change', function (){
                $("#bankList option").each(function(){
                    if($(this).val() === $('#bankList').val()){
                        bankCode.val($(this).attr('data-code'))
                    }
                });
                verifyAccountNumber();
            });
            accountNumber.on('input', verifyAccountNumber);
            autoDelete.on('change', checkForAutoDelete);
            exchangeRateError.on('change', checkForErrorInfo);
            pendingTransaction.on('change', checkForPendingTransactionNotification);
            $('.toggleSideBar').each(function (){
                $(this).on('change', function (){
                    if ($(this).val() === 'dark'){
                        $('body').addClass('sidebar-dark');
                    }else if($(this).val() === 'light'){
                        $('body').removeClass('sidebar-dark');
                    }
                });
            });
            function checkForPendingTransactionNotification()
            {
                if (pendingTransaction.prop('checked')){
                    pendingTransactionDuration.show(500);
                }else{
                    pendingTransactionDuration.hide(500);
                }
            }
            function checkForErrorInfo(){
                if (exchangeRateError.prop('checked')){
                    updateErrorInfo.show(500);
                }else{
                    updateErrorInfo.hide(500);
                }
            }
            function checkForAutoDelete(){
                if (autoDelete.prop('checked')){
                    deletionInfo.show(500);
                }else{
                    deletionInfo.hide(500);
                }
            }
            function verifyAccountNumber(){
                if (bankList.val() && accountNumber.val().length === 10 && bankCode.val()){
                    verifyingDisplay.text('Verifying account number...');
                    verifyingDisplay.removeClass('d-none');
                    verifyingDisplay.removeClass('text-danger');
                    verifyingDisplay.removeClass('text-success');
                    verifyingDisplay.addClass('text-info');
                    $.ajax({
                        url: "https://api.paystack.co/bank/resolve",
                        data: { account_number: accountNumber.val(), bank_code: bankCode.val().trim() },
                        type: "GET",
                        beforeSend: function(xhr){
                            xhr.setRequestHeader('Authorization', 'Bearer {{ env('PAYSTACK_SECRET_KEY') }}');
                            xhr.setRequestHeader('Content-Type', 'application/json');
                            xhr.setRequestHeader('Accept', 'application/json');
                        },
                        success: function(res) {
                            verifyingDisplay.removeClass('text-info');
                            verifyingDisplay.addClass('text-success');
                            verifyingDisplay.text('Account details verified');
                            accountName.val(res.data.account_name);
                            submitButton.prop('disabled', false);
                        },
                        error: function (err){
                            let msg = 'Error processing verification';
                            verifyingDisplay.removeClass('text-info');
                            verifyingDisplay.addClass('text-danger');
                            submitButton.prop('disabled', true);
                            if (parseInt(err.status) === 422){
                                msg = 'Account details doesn\'t match any record';
                            }
                            verifyingDisplay.text(msg);
                        }
                    });
                }else{
                    accountName.val("");
                    verifyingDisplay.addClass('d-none');
                }
            }
        });
    </script>

    <script>
        $(document).ready(function () {
            // Trigger change event when network is selected
            $('#network').on('change', function () {
                var networkId = $(this).val(); // Get selected network id

                if (networkId) {
                    // Make an API request or use an AJAX call to get the address for the selected network
                    $.ajax({
                        url: '/api/deposit/address/' + networkId, // The API route to fetch address based on network
                        type: 'GET',
                        success: function (response) {
                            if (response.data && response.data.address) {
                                $('#address').val(response.data.address); 
                            } else {
                                $('#address').val(''); 
                                $('#address').attr('placeholder', 'No address set'); 
                            }
                        },
                        error: function () {
                            $('#address').val(''); // Handle errors by clearing the field
                            $('#address').attr('placeholder', 'No address set');
                        }
                    });
                } else {
                    // Reset if no network is selected
                    $('#address').val('');
                    $('#address').attr('placeholder', 'No address set');
                }
            });
        });
    </script>
@endsection
