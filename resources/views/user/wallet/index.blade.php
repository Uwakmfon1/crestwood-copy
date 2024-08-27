@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Wallets</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if($setting['trade'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="alert-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">Buying of gold is currently unavailable, check back later</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if($setting['withdrawal'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="alert-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">Withdrawal from wallet is currently unavailable, check back later</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <p class="mb-0">Savings Account:</p>
                                <h3 class="fw-600">&#36; {{ number_format($savings, 2) }}</h3>
                            </div>
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <p class="mb-0">Trading Account:</p>
                                <h3 class="fw-600">&#36;{{ number_format($trading, 2) }}</h3>
                            </div>
                            <div class="col-12 col-md-4 mb-3 mb-md-0">
                                <p class="mb-0">Investment Account:</p>
                                <h3 class="fw-600">&#36; {{ number_format($investment, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-5">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-center">Naira Wallet</h5>
                                    <div class="my-2">
                                        <p class="mt-3 small">Total Balance</p>
                                        <h3 class="font-weight-light">₦ {{ number_format(auth()->user()->walletBalance(), 2) }}</h3>
                                    </div>
                                    <div class="mt-3 bg-light py-3 mb-2 d-flex justify-content-around" style="border-radius: 5px">
                                        <button data-toggle="modal" data-target="#nairaDepositModal" class="btn my-2 mx-1 btn-success">
                                            <i class="fa fa-credit-card"></i>
                                            <span class="mt-1 d-block small">Deposit</span>
                                        </button>
                                        @if($setting['withdrawal'] == 1)
                                            <button data-toggle="modal" data-target="#nairaWithdrawalModal" class="btn my-2 mx-1 btn-danger">
                                                <i class="fa fa-money-check"></i>
                                                <span class="mt-1 d-block small">Withdraw</span>
                                            </button>
                                        @else
                                            <button data-toggle="modal" data-target="#" class="btn my-2 mx-1 btn-secondary" disabled>
                                                <i class="fa fa-money-check"></i>
                                                <span class="mt-1 d-block small">Withdraw</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-5">
                            <div class="card">
                                <div class="card-body text-center">
                                    <h5 class="card-title text-center">Ledger Wallet</h5>
                                    <div class="my-2">
                                        <p class="mt-3 small">Total Balance</p>
                                       {{-- <h3 class="font-weight-light">₦ {{  number_format($ledgerBalance, 2) }}</h3> --}}
                                    </div>
                                    <div class="mt-3 bg-light py-3 mb-2 d-flex justify-content-around" style="border-radius: 5px">
                                        <button data-toggle="modal" data-target="#nairaDepositModal" disabled class="btn my-2 mx-1 btn-success">
                                            <i class="fa fa-credit-card"></i>
                                            <span class="mt-1 d-block small">Deposit</span>
                                        </button>
                                        @if($setting['withdrawal'] == 1)
                                            <button data-toggle="modal" data-target="#nairaWithdrawalModal" disabled class="btn my-2 mx-1 btn-danger">
                                                <i class="fa fa-money-check"></i>
                                                <span class="mt-1 d-block small">Withdraw</span>
                                            </button>
                                        @else
                                            <button data-toggle="modal" data-target="#" disabled class="btn my-2 mx-1 btn-secondary" disabled>
                                                <i class="fa fa-money-check"></i>
                                                <span class="mt-1 d-block small">Withdraw</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
