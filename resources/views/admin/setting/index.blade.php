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



@endphp

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-body">
                <a href="#crypto" class="btn btn-sm btn-primary">Cryptocurrency</a>
                <a href="#bank" class="btn btn-sm btn-primary">Bank</a>
                <a href="#others" class="btn btn-sm btn-primary">Others</a>
            </div>
        </div>
    </div>
    <div class="col-12" id="crypto">
        <h4 class="my-3">Cryptocurrency Settings</h4>
        <div class="row">
            <div class="col-lg-6 my-1">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Network Address</h6>
                        <form class="pb-3" action="{{ route('admin.store.networks') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="network" class="form-label">Select Coin</label>
                                <select name="account_coin_id" id="coin" class="form-control">
                                    <option value="">Select a Coin</option>
                                    @foreach($coins as $network)
                                        <option value="{{ $network->id }}">{{ $network->name }} ({{ $network->symbol }})</option>
                                    @endforeach
                                </select>
                                @error('account_network_id')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="network" class="form-label">Network Address</label>
                                <input type="text" name="network" id="networks" class="form-control" placeholder="Enter Network" value="{{ old('network') }}">
                                @error('network')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
                        <h6 class="mt-2 card-title">Wallet Address</h6>
                        <form class="pb-3" action="{{ route('admin.addresses.store') }}" method="POST">
                            @csrf
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

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 my-1">
                <div class="card">
                    <div class="card-body">
                        <form class="pt-2" action="{{ route('admin.settings.notes') }}" method="POST">
                            @csrf
                            <h6 class="card-title">Edit Note</h6>
                            <div class="my-4">
                                <label for="crypto_note">Note:</label>
                                <textarea name="crypto_note" id="crypto_note" class="form-control" cols="50" rows="20">{{ $setting->crypto_note }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-2">Wallet Addresses</h5>
                        <div class="row">
                        @foreach($networks as $data)
                            <div class="col-lg-4 col-md-6">
                                <div class="mb-3">
                                    <label for="network" class="form-label">{{ $data->name }} ({{ $data->symbol }})</label>
                                    <div class="d-flex">
                                        
                                        <input class="form-control" type="text" value="{{ $data->addresses->isNotEmpty() ? $data->addresses->first()->address : 'Not set' }}" disabled>
                                        
                                        <!-- Delete Network Form -->
                                        <form action="{{ route('admin.destroy.networks', $data->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger mx-1">
                                                <i data-feather="x-circle" class="icon-md text-white"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mt-3" id="bank">
        <h4 class="my-3">Banks Settings</h4>
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.bank') }}" method="POST">
                            @csrf
                            <div class="my-4">
                                <label for="account_name">Account Name:</label>
                                <input type="text" class="form-control" name="account_name" value="{{ $setting->account_name }}">
                            </div>
                            <div class="my-4">
                                <label for="account_number">Account Number:</label>
                                <input type="text" class="form-control" name="account_number" value="{{ $setting->account_number }}">
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
                                <label for="swift_code">Swift Code:</label>
                                <input type="text" class="form-control" name="swift_code" value="{{ $setting->swift_code }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_reference">Bank Reference:</label>
                                <input type="text" class="form-control" name="bank_reference" value="{{ $setting->bank_reference }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_reference">Routing Number:</label>
                                <input type="text" class="form-control" name="routing" value="{{ $setting->routing }}">
                            </div>
                            <div class="my-4">
                                <label for="bank_note_initial"> Note (Initial):</label>
                                <textarea name="bank_note_initial" id="bank_note_initial" class="form-control" cols="30" rows="10">{{ $setting->bank_note_initial }}</textarea>
                            </div>
                            <div class="my-4">
                                <label for="bank_note_final"> Note (Final):</label>
                                <textarea name="bank_note_final" id="bank_note_final" class="form-control" cols="30" rows="10">{{ $setting->bank_note_final }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Settings</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6" id="others">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Other Settings</h6>
                        <form action="{{ route('admin.settings.save') }}" id="otherSettingForm" method="POST">
                            @csrf
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
    </div>
</div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const noteIds = ['crypto_note', 'bank_note_initial', 'bank_note_final']; // List of IDs to initialize CKEditor for

            noteIds.forEach(id => {
                CKEDITOR.replace(id, {
                    toolbar: [
                        { name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'RemoveFormat'] },
                        { name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                        { name: 'links', items: ['Link', 'Unlink'] },
                        { name: 'insert', items: ['Image', 'Table', 'HorizontalRule'] },
                    ],
                });
            });

            CKEDITOR.editorConfig = function (config) {
                config.versionCheck = false;
            };
        });
    </script>

    <style>
        .cke_notifications_area
        {
            display: none;
        }
    </style>


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
