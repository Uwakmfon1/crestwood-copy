@extends('layouts.user.index')

@section('content')
<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    .selectdepo:hover {
        border: 1px solid rgb(130, 116, 255);
        cursor: pointer;
    }

    .selectdepo .active {
        border: 1px solid rgb(130, 116, 255);
    }
</style>
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

    @include('partials.users.alert')

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Wallet</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Wallet
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <!-- <a href="{{ route('wallet.deposit') }}" class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#nairaDepositModal"> -->
                <a href="{{ route('wallet.deposit') }}" class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Deposit
                </a>
                <button class="btn btn-primary btn-wave waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#nairaWithdrawalModal">
                    <i class="ri-upload-2-line me-2"></i> Withdraw
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <div class="row">
            <div class="col-xl-3">
                <div class="card custom-card card-bg-success crypto-card py-2">
                    <div class="card-body">
                        <div class="d-flex gap-3 align-items-start">
                            <span class="avatar avatar-lg p-2 svg-white bg-white-transparent shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                    <path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path>
                                    <path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z">
                                    </path>
                                </svg> </span>
                            <div>
                                <span class="text-fixed-white op-8">Portfolio</span>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" class="py-2 fs-16 text-fixed-white show" data-bs-toggle="dropdown" aria-expanded="true"> USD</a>
                                </div>
                            </div>
                        </div>
                        <hr class="text-fixed-white op-1">
                        <div>
                            <span class="text-fixed-white op-8">Total Portfolio Value 
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="The total value of all funds in your account, including savings, investments, and trading balances." class="text-fixed-white mx-1">
                                    <i class="fe fe-info"></i>
                                </a>
                            </span>
                            <h4 class="fw-semibold d-block text-fixed-white mt-2">
                                {{ number_format($wallet, 2) }}
                                <span class="fs-12 ms-1 d-inline-flex" style="margin-top: -5px;">USD</span>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex">
                                        <span class="fs-10 tooltip-container">Available Balance 
                                            <a href="javascript:void(0);" class="tooltip-trigger text-fixed-white mx-1"  data-tooltip="Funds available for withdrawal or transfer, not currently in use.">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="fs-18 fw-semibold text-start">{{ number_format($cash, 2) }} USD</span>
                                    </div>
                                    <div class="mt-1">  </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex">
                                        <span class="fs-10 tooltip-container">Locked Cash 
                                            <a href="javascript:void(0);" class="tooltip-trigger text-fixed-white mx-1"  data-tooltip="Funds actively tied up in investments or savings.">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="fs-18 fw-semibold text-start">{{ number_format($lockedFunds, 2) }} USD</span>
                                    </div>
                                    <div class="mt-1">  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card custom-card bg-black pb-4 py-2">
                    <div class="card-body p-4">
                        <div class="">
                            <div class="text-fixed-white mb-2">Performance Indicator<span class="ms-2 d-inline-block text-fixed-white op-5"><i class="fe fe-arrow-up-right"></i></span>
                            </div>
                            <h4 class="fw-semibold mb-0 text-fixed-white">$0.00 <sub class="fs-12 op-8 d-inline-flex">0.0%</sub></h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Savings Balance
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Funds available to contribute to your savings account." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($savings, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary svg-white"> 
                                        <i class="ti ti-user-circle fs-20"></i>
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <a href="javascript:void(0);" class="py-2 fs-11 text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openSWalletModal">Transfer funds<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Investment Balance
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Funds available to invest in managed investment packages." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($investment, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary  svg-white">
                                        <i class="ti ti-percentage fs-20"></i>
                                    </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap justify-content-between mt-2">
                                    <div>
                                        <a href="javascript:void(0);" class="py-2 fs-11 text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openIWalletModal">Transfer funds<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-12">
                        <div class="card custom-card">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start justify-content-between">
                                    <div>
                                        <div class="mb-1 text-muted">Trading balance
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Funds available to trade in stocks or crypto markets." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </div>
                                        <h4 class="fw-semibold mb-0">
                                            ${{ number_format($trading, 2) }}
                                        </h4>
                                    </div>
                                    <div> <span class="avatar avatar-md bg-primary  svg-white">  <i class="ti ti-users fs-20"></i> </span> </div>
                                </div>
                                <div class="d-flex align-items-end flex-wrap  justify-content-between mt-2">
                                    <div>
                                        <a href="javascript:void(0);" class="py-2 fs-11 text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openTWalletModal">Transfer funds<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card custom-card">
                            <div class="card-header">
                                <div class="card-title">Wallet transaction</div>
                                    <!-- <div id="filter-buttons">
                                        <button onclick="updateChart('daily')">Daily</button>
                                        <button onclick="updateChart('weekly')">Weekly</button>
                                        <button onclick="updateChart('monthly')">Monthly</button>
                                    </div> -->
                            </div>
                            <div class="card-body">
                                <div id="area-spline"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

            <!-- Start:: row-2 -->
            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">
                                Latest Transactions 
                            </div>
                            <div class="d-flex flex-wrap gap-2"> 
                                <!-- <div class="dropdown"> 
                                    <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> 
                                    </a>  
                                </div>  -->
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>S/N</th>
                                            <th>Amount</th>
                                            <th>Account</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $key=>$transaction)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>${{ number_format($transaction['amount'], 2) }}</td>
                                                <td>
                                                    @if($transaction['type'] == 'trade')
                                                        <span class="badge bg-pink-transparent">Trading</span>
                                                    @elseif($transaction['type'] == 'save')
                                                        <span class="badge bg-info-transparent">Savings</span>
                                                    @elseif($transaction['type'] == 'invest')
                                                        <span class="badge bg-primary-transparent">Investment</span>
                                                    @elseif($transaction['type'] == 'wallet')
                                                        <span class="badge bg-dark-transparent">Wallet</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction['description'] }}</td>
                                                <td>
                                                    @if($transaction['method'] == 'credit')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Credit</span>
                                                    @elseif($transaction['method'] == 'debit')
                                                        <span class="badge bg-danger-transparent"><i class="ri-info-fill align-middle me-1"></i>Debit</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($transaction['status'] == 'approved')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Approved</span>
                                                    @elseif($transaction['status'] == 'pending')
                                                        <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                    @elseif($transaction['status'] == 'declined')
                                                        <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Declined</span>
                                                    @endif
                                                </td>
                                                <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                        @if($transactions->count() == 0)
                                            <tr>
                                                <p class="py-4 text-center">
                                                    No Transactions...
                                                </p>
                                            </tr>
                                        @endif

                                        <div class="card-footer border-top-0">
                                            <div class="d-flex align-items-center">
                                                <div> Showing {{ $transactions->count() }} of {{ $transactions->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                                <div class="ms-auto">
                                                </div>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-2 -->
    </div>
</div>
<!-- End::app-content -->

<div class="modal fade" id="nairaWithdrawalModal" tabindex="-1" role="dialog" aria-labelledby="nairaWithdrawalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <form method="POST" action="{{ route('withdraw') }}" id="depositForm">
                @csrf
                <div class="my-4">
                    <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Make a Withdrwal</h5>
                </div>
                <div class="modal-body">
                    <div class="row mx-auto" id="depoSelect" style="max-width: 600px;">
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo" id="selectCrypto">
                                <div class="card-body d-flex align-items-center rounded">
                                    <span class="avatar avatar-sm bg-primary me-2 shadow-avatar">
                                        <img class="p-1" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Bitcoin.svg/2048px-Bitcoin.svg.png" alt="">
                                    </span>
                                    <h5 class="fw-medium fs-13 mt-2 mx-2"> 
                                        Cryptocurrency
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo" id="selectBank">
                                <div class="card-body d-flex align-items-center rounded">
                                    <span class="avatar avatar-sm bg-primary me-2 shadow-avatar">
                                        <img class="p-1" src="https://pngimg.com/d/bank_PNG24.png" alt="">
                                    </span>
                                    <h5 class="fw-medium fs-13 mt-2 mx-2"> 
                                        Bank
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="crypto" class="d-none">
                        <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                            <div class="col-xl-12">
                                <div class="input-group"> 
                                    <input type="number" style="font-size: 14px" step="any" class="form-control amountWithdraw" name="amount" id="coin-amount" placeholder="Enter amount..." required min="10">
                                    <input type="hidden" name="account_type" id="account_type" value="crypto">
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                </div>
                                @error('amount')
                                    <strong class="small text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>
                        </div>

                        <div class="my-4">
                            <h4 class="text-center fs-13">You are about to make a withdrwal of <strong class="fw-bold text-primary amount-val-coin">0 USD</strong></h4>
                            <p class="text-center text-muted fs-10">Exchange Rate: 1 USD - 1.00 USDT</strong></p>
                        </div>
                        <div class="">
                            <div class="my-2">
                                <p class="text-center fs-12 fw-medium">You are making a withdrwal to the following wallet detail</p>
                            </div>
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12" style="max-width: 500px;">
                                    <div class="my-3">
                                        <label class="form-label fs-12 text-muted" for="coin-select">Cryptocurrency</label>
                                        <div class="input-group"> 
                                            <button type="button" class="input-group-text btn btn-grey btn-wave text-dark" style="border-right: 0px;">
                                                <img id="coin-img" width="23" class="rounded-circle" style="border-left: 0px; opacity: .3;" src="https://cdn4.iconfinder.com/data/icons/cryptocoins/227/USDT-alt-512.png" alt="USDT">
                                            </button>
                                            <select name="coin" id="coin-select" class="form-control py-2 fw-bold">
                                                <option value="usdt">USDT</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <label class="form-label fs-12 text-muted" for="network-select">Wallet Network</label>
                                        <div class="input-group"> 
                                            <select name="network" id="network-select" class="form-control py-2 fw-bold">
                                                <option value="">Select Network</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="my-3">
                                        <label for="wallet_address" class="form-label text-muted fs-12">Wallet Address</label>
                                        <input name="wallet_address" type="text" class="form-control @error('wallet_address') is-invalid @enderror fw-bold" id="wallet_address"
                                            placeholder="Enter your wallet address" value="{{ auth()->user()['wallet_address'] }}">
                                        @error('wallet_address')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="bank" class="d-none">
                        <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                            <div class="col-xl-12">
                                <div class="input-group"> 
                                    <input type="number" style="font-size: 14px" step="any" class="form-control amountDeposit" name="amount" id="bank-amount" placeholder="Enter amount..." required min="10">
                                    <input type="hidden" name="account_type" value="bank" id="acct_type">
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                </div>
                                @error('amount')
                                    <strong class="small text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>
                        </div>

                        <div class="my-4">
                            <h4 class="text-center fs-13">You are about to make a withdrwal of <strong class="fw-bold text-primary amount-val-bank">0 USD</strong></h4>
                            <p class="text-center text-muted fs-10">Exchange Rate: 1 USD - 1.00 USD</strong></p>
                        </div>
                        <div class="">
                            <div class="my-2">
                                <p class="text-center fs-12 fw-medium">You are making a withdrwal to the following account detail</p>
                            </div>
                            <div class="row d-flex justify-content-center mx-auto">
                                <div class="col-xl-12" style="max-width: 500px;">
                                    <div class="row">
                                        <div class="col-xl-12 my-2 tooltip-container">
                                            <label for="account_name" class="form-label text-muted fs-12">Account Name</label>
                                            <input name="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror fw-bold" id="account_name" value="{{ auth()->user()['first_name'] }} {{ auth()->user()['last_name'] }}" disabled>
                                        </div>
                                        <div class="col-xl-12 my-2">
                                            <label for="account_number" class="form-label text-muted fs-12">Account Number</label>
                                            <input name="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror fw-bold" id="account_number" step="1" min="1"
                                                placeholder="Enter your bank account number" value="{{ auth()->user()['account_number'] }}">
                                        </div>
                                        <div class="col-xl-12 my-2">
                                            <label for="bank_name" class="form-label text-muted fs-12">Bank Name</label>
                                            <input name="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror fw-bold" id="bank_name"
                                                placeholder="Enter bank name..." value="{{ auth()->user()['bank_name'] }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-6 tooltip-container">
                                                <label for="swiss_code" class="form-label text-muted fs-12">SWIFT Code (optional)</label>
                                                <input name="swiss_code" type="number" class="form-control @error('swiss_code') is-invalid @enderror fw-bold" id="swiss_code"
                                                    placeholder="Enter SWIFT Code..." value="{{ auth()->user()['swiss_code'] }}">
                                            </div>
                                            <div class="col-6">
                                                <label for="reference" class="form-label text-muted fs-12">Reference</label>
                                                <input name="reference" type="text" class="form-control @error('reference') is-invalid @enderror fw-bold" id="reference"
                                                    placeholder="Optional reference for your bank account" value="{{ auth()->user()['reference'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none" id="depositFooter">
                    <button type="submit"  class="btn btn-primary-transparent" style="width: 100%;" >Confirm Withdrawal</button>
                    <button type="button" class="btn btn-secondary-transparent" style="width: 100%;" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('partials.users.modal.topup')

<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>

<script>
    $(document).ready(function () {

        // Fetch coins on page load
        fetchCoins();

        // Variables to hold selected coin rate and symbol
        let selectedCoinRate = 0;
        let selectedCoinSymbol = '';
        

        $('#amountWithdrawal').on('input', function () {
            const val = parseFloat($('#amountWithdrawal').val()).toLocaleString();
            $('.amount-val').text(val + ' USD');
        });

        // Trigger display update on input change for amount
        $('.amountDeposit').on('input', function () {
            updateDisplay();
        });

        $('#bank-amount').on('input', function () {
            const usdAmount = parseFloat($('#bank-amount').val()) || 0;

            $('.amount-val-bank').text(usdAmount.toLocaleString() + ' USD');
        });

        $('#coin-amount').on('input', function () {
            const usdAmount = parseFloat($('#coin-amount').val()) || 0;

            $('.amount-val-coin').text(usdAmount.toLocaleString() + ' USD');
        });

        // Fetch networks and update display based on coin selection
        $('#coin-select').on('change', function () {
            const coinId = $(this).val();
            if (coinId) {
                fetchNetworks(coinId);

                // Retrieve selected coin data from response
                const coin = coins.find(c => c.id == coinId);
                selectedCoinRate = parseFloat(coin.rate); // Make sure rate is correctly parsed
                selectedCoinSymbol = coin.symbol;

                // Update the exchange rate and symbol display
                $('#exchange-rate').text(selectedCoinRate.toFixed(5)); // Display the rate with 5 decimal places
                $('#selected-coin-symbol').text(selectedCoinSymbol); // Display selected coin symbol
                updateDisplay();
            } else {
                // Reset if no coin is selected
                $('#network-select').html('<option value="">Select Network</option>').prop('disabled', true);
                $('#address-display').val('Select network first').prop('disabled', true);
                resetDisplay();
            }
        });

        // Fetch address based on network selection
        $('#network-select').on('change', function () {
            const networkId = $(this).val();
            if (networkId) {
                fetchAddress(networkId);
            } else {
                $('#address-display').val('Select network first').prop('disabled', true);
            }
        });

        // Function to update the display with calculated coin amount
        function updateDisplay() {
            const usdAmount = parseFloat($('.amountDeposit').val()) || 0; // Get entered USD amount
            const coinAmount = usdAmount / selectedCoinRate; // Calculate equivalent coin amount

            if (!isNaN(coinAmount) && selectedCoinRate > 0) {
                // Update displayed amount in selected coin
                $('.amount-val').text(coinAmount.toFixed(5) + ' ' + selectedCoinSymbol);

                $('#coin-value').prop('value', coinAmount.toFixed(5));
            } else {
                // Reset display if invalid input or no coin selected
                $('.amount-val').text('0 ' + selectedCoinSymbol);
            }
        }

        // Function to reset the display if no coin is selected
        function resetDisplay() {
            selectedCoinRate = 0;
            selectedCoinSymbol = '';
            $('#exchange-rate').text(0);
            $('#selected-coin-symbol').text('');
            $('.amount-val').text('0');
        }

        // Function to fetch coins (no change here)
        function fetchCoins() {
            $.ajax({
                url: '/api/deposit/coin',
                type: 'GET',
                success: function (response) {
                    coins = response.data;
                    let options = '<option value="">Select Coin</option>';
                    response.data.forEach(function (coin) {
                        options += `<option value="${coin.id}">${coin.name} (${coin.symbol})</option>`;
                    });
                    $('#coin-select').html(options);
                }
            });
        }

        // Function to fetch networks (no change here)
        function fetchNetworks(coinId) {
            $.ajax({
                url: `/api/deposit/networks/${coinId}`,
                type: 'GET',
                success: function (response) {
                    let options = '<option value="">Select Network</option>';
                    response.data.forEach(function (network) {
                        options += `<option value="${network.id}">${network.name} </option>`;
                    });
                    $('#network-select').html(options).prop('disabled', false);
                    $('#address-display').val('Select network first').prop('disabled', true);
                }
            });
        }

        // Function to fetch address (no change here)
        function fetchAddress(networkId) {
            $.ajax({
                url: `/api/deposit/address/${networkId}`,
                type: 'GET',
                success: function (response) {
                    if(response.data && response.data.address) {
                        $('#address-display').val(response.data.address).prop('disabled', true);
                    } else {
                        $('#address-display').val('Address not available').prop('disabled', true);
                    }
                }
            });
        }
    });

    document.getElementById('selectCrypto').addEventListener('click', function() {
        // Show crypto fields, hide bank fields
        document.getElementById('crypto').classList.remove('d-none');
        document.getElementById('bank').classList.add('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.remove('d-none');
    });

    document.getElementById('selectBank').addEventListener('click', function() {
        // Show bank fields, hide crypto fields
        document.getElementById('crypto').classList.add('d-none');
        document.getElementById('bank').classList.remove('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.remove('d-none');
    });

    $(document).ready(function() {
        // Hide both the crypto and bank sections initially
        $('#crypto').hide();
        $('#bank').hide();

        // Handle click event for selecting cryptocurrency
        $('#selectCrypto').click(function() {
            // Show the crypto section and hide the bank section
            $('#crypto').show();
            $('#bank').hide();

            // Enable all input fields inside #crypto
            // $('#crypto').find('input, select').prop('disabled', false);
            $('#coin-amount').prop('disabled', false);
            $('#account_type').prop('disabled', false);

            // Disable all input fields inside #bank
            $('#bank').find('input, select').prop('disabled', true);

            // Add active state to the selected option
            $('#selectCrypto').addClass('active');
            $('#selectBank').removeClass('active');
        });

        // Handle click event for selecting bank
        $('#selectBank').click(function() {
            // Show the bank section and hide the crypto section
            $('#bank').show();
            $('#crypto').hide();

            // Enable all input fields inside #bank
            $('#bank-amount').prop('disabled', false);
            $('#acct_type').prop('disabled', false);

            // Disable all input fields inside #crypto
            $('#crypto').find('input, select').prop('disabled', true);

            // Add active state to the selected option
            $('#selectBank').addClass('active');
            $('#selectCrypto').removeClass('active');
        });

        // Function to handle copy to clipboard
        function copyToClipboard(text, button) {
            // Use the modern clipboard API to copy text
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    // Change button text on successful copy
                    $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');

                    // Revert button text after 3 seconds
                    setTimeout(function() {
                        $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
                    }, 3000);
                }).catch(function(error) {
                    console.error('Failed to copy text: ', error);
                });
            } else {
                // Fallback to older execCommand method (for older browsers)
                var tempInput = $("<input>");
                $("body").append(tempInput);
                tempInput.val(text).select();
                document.execCommand("copy");
                tempInput.remove();

                // Change button text on successful copy
                $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');

                // Revert button text after 3 seconds
                setTimeout(function() {
                    $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
                }, 3000);
            }
        }

        // Attach click event for copy buttons
        $('.copy-btn').on('click', function() {
            // Find the input field next to the button and get its value
            var textToCopy = $(this).closest('.input-group').find('input').val();
            copyToClipboard(textToCopy, this);
        });

        // Initially disable all input fields (just in case)
        $('#crypto').find('input, select').prop('disabled', true);
        $('#bank').find('input, select').prop('disabled', true);
    });

    // Convert the PHP data into JavaScript arrays
    var dates = @json($dates->toArray());
    var alignedSavings = @json($alignedSavings->toArray());
    var alignedInvestments = @json($alignedInvestments->toArray());
    var alignedTrading = @json($alignedTrading->toArray());

    var options = {
        series: [{
            name: 'Savings',
            data: alignedSavings // Use the aligned savings data from the controller
        }, {
            name: 'Investments',
            data: alignedInvestments // Use the aligned investments data
        }, {
            name: 'Trading',
            data: alignedTrading // Use the aligned trading data
        }],
        chart: {
            height: 320,
            type: 'area'
        },
        colors: ["#8274ff", "#ff6937", "#58c437"],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        grid: {
            borderColor: '#f2f5f7',
        },
        xaxis: {
            type: 'datetime',
            categories: dates,
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-label',
                },
            }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-yaxis-label',
                },
            }
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    // Initialize the chart
    var chart = new ApexCharts(document.querySelector("#area-spline"), options);
    chart.render();

    // Function to update the chart based on time filter (daily, weekly, monthly)
    function updateChart(timeframe) {
        var filteredDates = [];
        var filteredSavings = [];
        var filteredInvestments = [];
        var filteredTrading = [];

        // Filter data based on selected timeframe
        switch (timeframe) {
            case 'daily':
                filteredDates = dates.slice(-7);
                filteredSavings = alignedSavings.slice(-7);
                filteredInvestments = alignedInvestments.slice(-7);
                filteredTrading = alignedTrading.slice(-7);
                break;
            case 'weekly':
                filteredDates = dates.slice(-30);
                filteredSavings = alignedSavings.slice(-30);
                filteredInvestments = alignedInvestments.slice(-30);
                filteredTrading = alignedTrading.slice(-30);
                break;
            case 'monthly':
                filteredDates = dates.slice(-365);
                filteredSavings = alignedSavings.slice(-365);
                filteredInvestments = alignedInvestments.slice(-365);
                filteredTrading = alignedTrading.slice(-365);
                break;
        }

        // Update the chart data
        chart.updateOptions({
            xaxis: {
                categories: filteredDates
            },
            series: [{
                name: 'Savings',
                data: filteredSavings
            }, {
                name: 'Investments',
                data: filteredInvestments
            }, {
                name: 'Trading',
                data: filteredTrading
            }]
        });
    }

    // Event listener for changing the timeframe (daily, weekly, monthly)
    $('.timeframe-select').on('change', function () {
        var timeframe = $(this).val();
        updateChart(timeframe);
    });


    $(document).ready(function () {
        // Fetch coins on page load
        fetchCoins();

        // Variables to hold selected coin rate and symbol
        let selectedCoinRate = 0;
        let selectedCoinSymbol = '';
        let coins = []; // Store coins data for reference

        // Default values from server-side data
        const defaultCoinId = "{{ auth()->user()['wallet_asset'] }}";
        const defaultNetworkId = "{{ auth()->user()['wallet_network'] }}";

        // Trigger display update on input change for amount
        $('.amountDeposit').on('input', function () {
            updateDisplay();
        });

        $('#bank-amount').on('input', function () {
            const usdAmount = parseFloat($('#bank-amount').val()) || 0;
            $('.amount-val-bank').text(usdAmount.toFixed(2) + ' USD');
        });

        const coinImages = {
            ETH: 'https://cryptologos.cc/logos/ethereum-eth-logo.png',
            BTC: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
            TRX: 'https://cdn-icons-png.flaticon.com/512/12114/12114250.png',
            USDT: 'https://icons.iconarchive.com/icons/cjdowner/cryptocurrency-flat/512/Tether-USDT-icon.png'
        };

        // Fetch networks and update display based on coin selection
        $('#coin-select').on('change', function () {
            const coinId = $(this).val();
            if (coinId) {
                fetchNetworks(coinId);

                // Retrieve selected coin data from response
                const coin = coins.find(c => c.id == coinId);
                selectedCoinRate = parseFloat(coin.rate); // Make sure rate is correctly parsed
                selectedCoinSymbol = coin.symbol;

                // Update the exchange rate and symbol display
                $('#exchange-rate').text(selectedCoinRate.toFixed(5)); // Display the rate with 5 decimal places
                $('#selected-coin-symbol').text(selectedCoinSymbol); // Display selected coin symbol
                updateDisplay();

                const selectedImg = coinImages[selectedCoinSymbol] || ''; // Get the image for the selected coin
                $('#coin-img').attr('src', selectedImg); // Update the image source
                $('#coin-img').attr('style', 'opacity: 1;'); // Update the image source
            } else {
                resetDisplay();
            }
        });

        // Fetch address based on network selection
        $('#network-select').on('change', function () {
            const networkId = $(this).val();
            if (networkId) {
                fetchAddress(networkId);
            } else {
                $('#address-display').val('Select network first').prop('disabled', true);
            }
        });

        // Function to update the display with calculated coin amount
        function updateDisplay() {
            const usdAmount = parseFloat($('.amountDeposit').val()) || 0; // Get entered USD amount
            const coinAmount = usdAmount / selectedCoinRate; // Calculate equivalent coin amount

            if (!isNaN(coinAmount) && selectedCoinRate > 0) {
                $('.amount-val').text(coinAmount.toFixed(5) + ' ' + selectedCoinSymbol);
                $('#coin-value').prop('value', coinAmount.toFixed(5));
            } else {
                $('.amount-val').text('0 ' + selectedCoinSymbol);
            }
        }

        // Function to reset the display if no coin is selected
        function resetDisplay() {
            selectedCoinRate = 0;
            selectedCoinSymbol = '';
            $('#exchange-rate').text(0);
            $('#selected-coin-symbol').text('');
            $('.amount-val').text('0');
        }

        // Function to fetch coins and set default selection
        function fetchCoins() {
            $.ajax({
                url: '/api/deposit/coin',
                type: 'GET',
                success: function (response) {
                    coins = response.data;
                    let options = '<option value="">Select Cryptocurrency</option>';
                    response.data.forEach(function (coin) {
                        options += `<option value="${coin.id}">${coin.name} (${coin.symbol})</option>`;
                    });
                    $('#coin-select').html(options);

                    // Set default coin if available
                    if (defaultCoinId) {
                        $('#coin-select').val(defaultCoinId).trigger('change');
                    }
                }
            });
        }

        // Function to fetch networks and set default selection
        function fetchNetworks(coinId) {
            $.ajax({
                url: `/api/deposit/networks/${coinId}`,
                type: 'GET',
                success: function (response) {
                    let options = '<option value="">Select Network</option>';
                    response.data.forEach(function (network) {
                        options += `<option value="${network.id}">${network.name}</option>`;
                    });
                    $('#network-select').html(options).prop('disabled', true);

                    // Set default network if available
                    if (defaultNetworkId) {
                        $('#network-select').val(defaultNetworkId).trigger('change');
                    }
                }
            });
        }

        // Function to fetch address
        function fetchAddress(networkId) {
            $.ajax({
                url: `/api/deposit/address/${networkId}`,
                type: 'GET',
                success: function (response) {
                    if (response.data && response.data.address) {
                        $('#address-display').val(response.data.address).prop('disabled', true);
                    } else {
                        $('#address-display').val('Address not available').prop('disabled', true);
                    }
                }
            });
        }
    });

    $('#network-select').prop('disabled', true);
</script>

@endsection