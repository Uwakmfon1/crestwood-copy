@extends('layouts.user.index')

@section('styles')

<link rel="stylesheet" href="{{ asset('asset/libs/swiper/swiper-bundle.min.css') }}">

<!-- Prism CSS -->
<link rel="stylesheet" href="{{ asset('asset/libs/prismjs/themes/prism-coy.min.css') }}">

<link rel="stylesheet" href="{{ asset('asset/libs/filepond/filepond.min.css') }}">

<link rel="stylesheet" href="{{ asset('asset/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/libs/dropzone/dropzone.css') }}">

@endsection

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
    @include('partials.users.alert')
    
        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Profile</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Overview</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- <div class="d-flex gap-2">
                <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button>
                <button type="button" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-upload-2-line me-2"></i> Export report
                </button>
            </div> -->
        </div>
        <!-- Page Header Close -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-9 col-xl-9 col-lg-9 col-sm-12">
                <div class="card custom-card profile-card">
                    <img height="160" src="https://img.freepik.com/free-vector/gradient-purple-striped-background_23-2149583760.jpg" class="card-img-top" alt="...">
                    <div class="card-body p-4 pb-0 position-relative">
                        <span class="avatar avatar-xxl avatar-rounded bg-info online">
                            <img width="40" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTr3jhpAFYpzxx39DRuXIYxNPXc0zI5F6IiMQ&s" alt="">
                        </span>
                        @if(auth()->user()['avatar'])
                            <span class="avatar avatar-xxl avatar-rounded bg-info online">
                                <img width="80px"  src="{{ auth()->user()['avatar'] }}" style="border-radius: 5px" alt="{{ auth()->user()['first_name'] }}">
                            </span>
                        @else
                            <span class="avatar avatar-xxl avatar-rounded bg-info online">
                                <img width="40" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTr3jhpAFYpzxx39DRuXIYxNPXc0zI5F6IiMQ&s" alt="">
                            </span>
                        @endif
                        <div class="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                            <div>
                                <h5 class="fw-semibold mb-1"><h6>{{ auth()->user()['name'] }}</h6></h5>
                                <span class="d-block fw-medium text-muted mb-1">{{ auth()->user()['email'] }}</span>
                                <p class="fs-12 mb-0 fw-medium text-muted"> <span class="me-3"><i
                                            class="ri-building-line me-1 align-middle"></i>{{ auth()->user()['created_at']->format('F d, Y') }}</span>
                                </p>
                            </div>
                            <div class="d-flex mb-0 flex-wrap gap-4">
                                <div class="py-2 px-3 rounded d-flex align-items-center border  gap-3">
                                    <div class="main-card-icon secondary">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path d="M136,108A52,52,0,1,1,84,56,52,52,0,0,1,136,108Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M117.25,157.92a60,60,0,1,0-66.5,0A95.83,95.83,0,0,0,3.53,195.63a8,8,0,1,0,13.4,8.74,80,80,0,0,1,134.14,0,8,8,0,0,0,13.4-8.74A95.83,95.83,0,0,0,117.25,157.92ZM40,108a44,44,0,1,1,44,44A44.05,44.05,0,0,1,40,108Zm210.14,98.7a8,8,0,0,1-11.07-2.33A79.83,79.83,0,0,0,172,168a8,8,0,0,1,0-16,44,44,0,1,0-16.34-84.87,8,8,0,1,1-5.94-14.85,60,60,0,0,1,55.53,105.64,95.83,95.83,0,0,1,47.22,37.71A8,8,0,0,1,250.14,206.7Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">${{ number_format($balance, 2)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Account Balance</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <i class="bi bi-coin fs-15"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($trading)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium tooltip-container">Trade 
                                            <a href="javascript:void(0);" class="tooltip-trigger text-muted mx-1"  data-tooltip="Number of executed trades in this account.">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <i class="bi bi-patch-check fs-15"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}
                                        </p>
                                        <p class="mb-0 fs-12 text-muted fw-medium tooltip-container">Savings
                                            <a href="javascript:void(0);" class="tooltip-trigger text-muted mx-1"  data-tooltip="Active savings accounts linked to this profile." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <i class="bi bi-card-list fs-15"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium tooltip-container">Investment
                                            <a href="javascript:void(0);" class="tooltip-trigger text-muted mx-1"  data-tooltip="Active investment packages under this account." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body d-flex align-items-start">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="nav flex-column nav-pills me-3 tab-style-7" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                        <button class="nav-link text-start active" id="main-profile-tab" data-bs-toggle="pill" data-bs-target="#main-profile" type="button" role="tab" aria-controls="main-profile" aria-selected="true"><i class="ri-shield-user-line me-1 align-middle d-inline-block"></i>Account Information</button>
                                        <button class="nav-link text-start" id="acct-type-tab" data-bs-toggle="pill" data-bs-target="#acct-type" type="button" role="tab" aria-controls="acct-type" aria-selected="false" tabindex="-1"><i class="ri-u-disk-line me-1 align-middle d-inline-block"></i>Account Type</button>
                                        <button class="nav-link text-start" id="man-password-tab" data-bs-toggle="pill" data-bs-target="#man-password" type="button" role="tab" aria-controls="man-password" aria-selected="false" tabindex="-1"><i class="ri-u-disk-line me-1 align-middle d-inline-block"></i>Payment Method</button>
                                        <button class="nav-link text-start" id="main-team-tab" data-bs-toggle="pill" data-bs-target="#main-team" type="button" role="tab" aria-controls="main-team" aria-selected="false" tabindex="-1"><i class="ri-user-line me-1 align-middle d-inline-block"></i>Personal Information (KYC)</button>
                                        <button class="nav-link text-start" id="main-kyc-tab" data-bs-toggle="pill" data-bs-target="#main-kyc" type="button" role="tab" aria-controls="main-kyc" aria-selected="false" tabindex="-1"><i class="ri-shield-check-line me-1 align-middle d-inline-block"></i>Additional Verification</button>
                                        <button class="nav-link text-start" id="main-proof-tab" data-bs-toggle="pill" data-bs-target="#main-proof" type="button" role="tab" aria-controls="main-proof" aria-selected="false" tabindex="-1"><i class="ri-map-pin-line me-1 align-middle d-inline-block"></i>Proof of Address</button>
                                        <button class="nav-link text-start" id="main-billing-tab" data-bs-toggle="pill" data-bs-target="#main-billing" type="button" role="tab" aria-controls="main-billing" aria-selected="false" tabindex="-1"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Identity & Verification</button>
                                        <button class="nav-link text-start" id="main-password-tab" data-bs-toggle="pill" data-bs-target="#main-password" type="button" role="tab" aria-controls="main-password" aria-selected="false" tabindex="-1"><i class="fe fe-settings me-1 align-middle d-inline-block"></i>Security Settings</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane show active" id="main-profile" role="tabpanel" tabindex="0" aria-labelledby="main-profile-tab">
                                                <div class="d-sm-flex">
                                                    <div>
                                                        <div class="my-md-auto mt-4 ms-md-3">
                                                            <form action="{{ route('profile.data') }}" method="post" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="screen" value="one">
                                                                <div class="row gy-3">
                                                                    <div class="me-3">
                                                                        <!-- <span class="avatar avatar-xl bg-dark-transparent rounded-circle p-3">
                                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="img">
                                                                        </span> -->
                                                                        <div class="col-md-6">
                                                                            <label class="form-label mt-2 text-muted fs-12" for="avatar">Avatar</label>
                                                                            <input type="file" id="avatar" name="avatar" class="form-control" >
                                                                            @error('avatar')
                                                                                <span class="text-danger small" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <!-- Full Name -->
                                                                    <div class="col-xl-12">
                                                                        <label for="first_name" class="form-label fs-12 text-muted">First name</label>
                                                                        <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                                                            placeholder="Enter first name..." value="{{ $user->first_name }}" required>
                                                                        @error('first_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <label for="last_name" class="form-label fs-12 text-muted">Last name</label>
                                                                        <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                                                            placeholder="Enter last name..." value="{{ $user->last_name }}" required>
                                                                        @error('last_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <label for="email" class="form-label fs-12 text-muted">Email address</label>
                                                                        <!-- <div class="input-group"> -->
                                                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                                                placeholder="Enter email..." value="{{ $user->email }}" disabled>
                                                                            <!-- <button type="submit" class="btn btn-dark input-group-text">Submit</button> -->
                                                                        <!-- </div> -->
                                                                        @error('email')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-xl-12">
                                                                        <label for="phonez" class="form-label d-block fs-12 text-muted">Phone Number</label>
                                                                        <input class="form-control" id="phone" type="tel" name="phone" disabled value="{{ $user->phone }}"> 
                                                                        <input type="hidden" id="phoneCode" name="phone_code">
                                                                        @error('phone')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <button class="btn btn-success" type="submit">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="acct-type" role="tabpanel" tabindex="0" aria-labelledby="acct-type-tab">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label for="flexCheckChecked1" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-success-transparent mx-2">
                                                                            <i class="bi bi-graph-up"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked1">Savings Account</label>
                                                                        <span class="fs-10 text-muted mt-4">A secure account for holding funds with competitive interest rates tailored to your needs.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-success rounded-circle mx-2" type="checkbox" value="" id="flexCheckChecked1" name="test[]" checked>
                                                                    </div>
                                                                </div>
                                                                <div class="mx-2 my-2">
                                                                    <a href="{{ route('savings') }}" class="text-primary fs-10">Manage Account</a> <i class="fe fe-arrow-right me-2 align-middle d-inline-block text-primary fs-10"></i>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="flexCheckChecked2" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-orange-transparent mx-2">
                                                                            <i class="bi bi-card-list"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked2">Investment Account</label>
                                                                        <span class="fs-10 text-muted mt-4">A flexible account for trading stocks, cryptocurrencies, and other financial instruments.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-warning rounded-circle mx-2" type="checkbox" value="" id="flexCheckChecked2" name="test[]" checked>
                                                                    </div>
                                                                </div>
                                                                <div class="mx-2 my-2">
                                                                    <a href="{{ route('investments') }}" class="text-primary fs-10">Manage Account</a> <i class="fe fe-arrow-right me-2 align-middle d-inline-block text-primary fs-10"></i>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="flexCheckChecked3" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select m-auto">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-info-transparent mx-2">
                                                                            <i class="bi bi-coin"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked3">Trading Account</label>
                                                                        <span class="fs-10 text-muted mt-4">A professionally managed account designed for long-term wealth creation and portfolio diversification.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-info rounded-circle mx-2" type="checkbox" value="" id="flexCheckChecked3" name="test[]" checked>
                                                                    </div>
                                                                </div>
                                                                <div class="mx-2 my-2">
                                                                    <a href="{{ route('tradings') }}" class="text-primary fs-10">View Portfolio</a> <i class="fe fe-arrow-right me-2 align-middle d-inline-block text-primary fs-10"></i>
                                                                </div>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="man-password" role="tabpanel" tabindex="0" aria-labelledby="man-password-tab">
                                                <div class="card-body">
                                                    <ul class="nav nav-tabs mb-3 nav-justified nav-style-1 d-sm-flex d-block" role="tablist">
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#home1-justified" aria-selected="false" tabindex="-1">Bank Account Information</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#about1-justified" aria-selected="true">Crypto Wallet Information</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane text-muted active show" id="home1-justified" role="tabpanel">
                                                            <form action="{{ route('profile.data') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="screen" value="three">
                                                                <div class="row">
                                                                    <div class="col-xl-12 my-2 tooltip-container">
                                                                        <label for="account_name" class="form-label text-muted fs-12">Account Name</label>
                                                                        <a href="javascript:void(0);"  class="tooltip-trigger text-muted mx-1"  data-tooltip="This is the name associated with your CrestWood Capital account." class="text-muted mx-1">
                                                                            <i class="fe fe-info"></i>
                                                                        </a>
                                                                        <input name="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name" value="{{ auth()->user()['first_name'] }} {{ auth()->user()['last_name'] }}" disabled>
                                                                        
                                                                        @error('account_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-xl-12 my-2">
                                                                        <label for="account_number" class="form-label text-muted fs-12">Account Number</label>
                                                                        <input name="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror" id="account_number" step="1" min="1"
                                                                            placeholder="Enter your bank account number" value="{{ auth()->user()['account_number'] }}">
                                                                        @error('account_number')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="col-xl-12 my-2">
                                                                        <label for="bank_name" class="form-label text-muted fs-12">Bank Name</label>
                                                                        <input name="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name"
                                                                            placeholder="Enter bank name..." value="{{ auth()->user()['bank_name'] }}">
                                                                        @error('bank_name')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-6 tooltip-container">
                                                                            <label for="swiss_code" class="form-label text-muted fs-12">SWIFT Code (optional)</label>
                                                                            <a href="javascript:void(0);"  class="tooltip-trigger text-muted mx-1"  data-tooltip="This is required for international transfers." class="text-muted mx-1">
                                                                                <i class="fe fe-info"></i>
                                                                            </a>
                                                                            <input name="swiss_code" type="number" class="form-control @error('swiss_code') is-invalid @enderror" id="swiss_code"
                                                                                placeholder="Enter SWIFT Code..." value="{{ auth()->user()['swiss_code'] }}">
                                                                            @error('swiss_code')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                        <div class="col-6">
                                                                            <label for="reference" class="form-label text-muted fs-12">Reference</label>
                                                                            <input name="reference" type="text" class="form-control @error('reference') is-invalid @enderror" id="reference"
                                                                                placeholder="Optional reference for your bank account" value="{{ auth()->user()['reference'] }}">
                                                                            @error('reference')
                                                                                <span class="invalid-feedback" role="alert">
                                                                                    <strong>{{ $message }}</strong>
                                                                                </span>
                                                                            @enderror
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 my-2">
                                                                        <label for="others" class="form-label text-muted fs-12">Other Information</label>
                                                                        <textarea class="form-control @error('others') is-invalid @enderror" name="others" id="others" rows="3" cols="10" placeholder="Enter any other relevant information about this bank account">{{ auth()->user()['account_info'] }}</textarea>
                                                                        @error('others')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <div id="" class="alert alert-primary mt-2">
                                                                            <h4 class="text-danger fs-12 fw-bold">Security Disclaimer:</h4>
                                                                            <div class="">
                                                                                <p class="fs-12 text-muted">Ensure the bank account details provided are accurate. CrestWood Capital will not be responsible for errors caused by incorrect information.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <button class="btn btn-success my-3">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="tab-pane text-muted" id="about1-justified" role="tabpanel">
                                                            <form action="{{ route('profile.data') }}" method="post">
                                                                @csrf
                                                                <input type="hidden" name="screen" value="four">
                                                                <div class="row">
                                                                    <div class="col-xl-12 my-2">
                                                                        <label class="form-label fs-12 text-muted" for="coin-select">Select Cryptocurrency</label>
                                                                        <div class="input-group"> 
                                                                            <button type="button" class="input-group-text btn btn-white btn-wave text-dark" style="border-right: 0px;">
                                                                                <img id="coin-img" width="23" class="rounded-circle" style="border-left: 0px; opacity: .3;" src="https://cdn4.iconfinder.com/data/icons/cryptocoins/227/USDT-alt-512.png" alt="USDT">
                                                                            </button>
                                                                            <select name="coin" id="coin-select" class="form-control py-2">
                                                                                <option value="usdt">USDT</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 my-2 tooltip-container">
                                                                        <label class="form-label fs-12 text-muted" for="network-select">Select Wallet Network</label>
                                                                        <a href="javascript:void(0);"  class="tooltip-trigger text-muted mx-1"  data-tooltip="Choose the correct network for your wallet." class="text-muted mx-1">
                                                                            <i class="fe fe-info"></i>
                                                                        </a>
                                                                        <div class="input-group"> 
                                                                            <select name="network" id="network-select" class="form-control py-2">
                                                                                <option value="">Select Network</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-xl-12 my-2">
                                                                        <label for="wallet_address" class="form-label text-muted fs-12">Wallet Address</label>
                                                                        <input name="wallet_address" type="text" class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address"
                                                                            placeholder="Enter your wallet address" value="{{ auth()->user()['wallet_address'] }}" required>
                                                                        @error('wallet_address')
                                                                            <span class="invalid-feedback" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                    <div>
                                                                        <div id="" class="alert alert-primary mt-2">
                                                                            <h4 class="text-danger fs-12 fw-bold">Security Disclaimer:</h4>
                                                                            <div class="">
                                                                                <p class="fs-12 text-muted">Ensure the wallet address and network match correctly to avoid withdrawal errors or loss of funds.
                                                                                CrestWood Capital will not be responsible for any incorrect wallet details provided.</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div>
                                                                        <button class="btn btn-success mt-2" type="submit">Submit</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-team" role="tabpanel" aria-labelledby="main-team-tab" tabindex="0">
                                                <form action="{{ route('profile.data') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="screen" value="five">
                                                    <div class="register-page my-4">
                                                        <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                            <div>Personal Information:</div>
                                                        </div>
                                                        <div class="row gy-3">
                                                            <!-- Date of Birth -->
                                                            <div class="form-group my-2">
                                                                <label for="dob" class="fs-10 fw-medium my-2 text-muted">Date of Birth</label>
                                                                <input type="date" id="dob" name="dob" class="form-control fw-medium" value="{{ isset($user->dob) ? \Carbon\Carbon::parse($user->dob)->format('Y-m-d') : '' }}">
                                                            </div>

                                                            <!-- SSN/TIN -->
                                                            <div class="form-group my-2">
                                                                <label for="ssn" class="fs-10 fw-medium text-muted my-2">SSN/TIN</label>
                                                                <input type="number" id="ssn" name="ssn" class="form-control fw-medium" value="{{ $user->ssn }}" placeholder="Social Security Number (SSN) or Tax-Identification Number (TIN)">
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label fs-12 text-muted">Loaction Type</label>
                                                                <select name="location" id="location" class="form-control text-dark text-capitalize @error('location') is-invalid @enderror">
                                                                    <option value="home">Home</option>
                                                                    <option value="office">Office</option>
                                                                </select>
                                                                @error('location')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label fs-12 text-muted">Country of Residence</label>
                                                                <select name="country" id="country" class="form-control text-dark text-capitalize @error('country') is-invalid @enderror" required>
                                                                    <option value="">Select Country</option>
                                                                    @foreach(\App\Models\Country::get() as $country)
                                                                        <option value="{{ $country->name }}" 
                                                                            data-phone-code="{{ $country->phone_code }}" 
                                                                            {{ (old('country') ?? $user->country) == $country->name ? 'selected' : '' }}>
                                                                            {{ $country->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('country')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label fs-12 text-muted">State/Province</label>
                                                                <select name="state" id="state" class="form-control text-dark text-capitalize @error('state') is-invalid @enderror" required>
                                                                    <option value="{{ $user->state ? $user->state : '' }}"> {{ $user->state ? $user->state : 'Select State' }}</option>
                                                                    @if(isset($user->country))
                                                                        @foreach(\App\Models\State::where('name', $user->country)->get() as $state)
                                                                            <option value="{{ $state->name }}" 
                                                                                {{ (old('state') ?? $user->state) == $state->name ? 'selected' : '' }}>
                                                                                {{ $state->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                @error('state')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label for="postal_code" class="form-label fs-12 text-muted">Postal Code</label>
                                                                <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
                                                                    placeholder="Enter postal code..." value="{{ $user->postal_code }}">
                                                                @error('postal_code')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label fs-12 text-muted" for="address">Address</label>
                                                                <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Enter address..." rows="3" cols="10" >{{ $user->address }}</textarea>
                                                                @error('address')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label fs-12 text-muted" for="address">Address line 2</label>
                                                                <textarea class="form-control @error('address2') is-invalid @enderror" name="address2" id="address2" placeholder="Enter address..." rows="3" cols="10">{{ $user->address_2 }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="register-page my-4">
                                                        <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                            <div>Emergency Contact:</div>
                                                        </div>
                                                        <div class="row gy-3">
                                                            <div class="col-xl-6">
                                                                <label for="nk_name" class="form-label fs-12 text-muted">Full Name</label>
                                                                <input name="nk_name" type="text" class="form-control @error('nk_name') is-invalid @enderror" id="nk_name"
                                                                    placeholder="Enter name..." value="{{ $user->nk_name }}" required>
                                                                @error('nk_name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label for="phone-validation" class="form-label d-block fs-12 text-muted">Phone Number</label>
                                                                <input class="form-control" id="phone-validation" type="tel" name="nk_phone" style="width: 260px;" required value="{{ $user->nk_phone }}">
                                                                @error('nk_phone')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label fs-12 text-muted">Relationship</label>
                                                                <select name="nk_relationship" id="nk_relationship" class="form-control text-dark text-capitalize @error('nk_relationship') is-invalid @enderror fs-12" required>
                                                                    <option value="parent" {{ old('nk_relationship') == 'parent' ? 'selected' : '' }}>Parent</option>
                                                                    <option value="family" {{ old('nk_relationship') == 'family' ? 'selected' : '' }}>Family</option>
                                                                    <option value="friend" {{ old('nk_relationship') == 'friend' ? 'selected' : '' }}>Friend</option>
                                                                </select>
                                                                @error('nk_relationship')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label class="form-label fs-12 text-muted">Country</label>
                                                                <select name="nk_country" id="nk_country" class="form-control text-dark text-capitalize @error('nk_country') is-invalid @enderror" required>
                                                                    <option value="">Select Country</option>
                                                                    @foreach(\App\Models\Country::get() as $country)
                                                                        <option value="{{ $country->name }}" 
                                                                            data-phone-code="{{ $country->phone_code }}" 
                                                                            {{ (old('nk_country') ?? $user->nk_country) == $country->name ? 'selected' : '' }}>
                                                                            {{ $country->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('nk_country')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label fs-12 text-muted">Select State</label>
                                                                <select name="nk_state" id="nk_state" class="form-control @error('nk_state') is-invalid @enderror" required>
                                                                    <option value="{{ $user->nk_state ? $user->nk_state : '' }}"> {{ $user->nk_state ? $user->nk_state : 'Select State' }}</option>
                                                                    @if(isset($user->nk_country))
                                                                        @foreach(\App\Models\State::where('name', $user->nk_country)->get() as $state)
                                                                            <option value="{{ $state->name }}" 
                                                                                {{ (old('state') ?? $user->nk_state) == $state->name ? 'selected' : '' }}>
                                                                                {{ $state->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    @endif
                                                                    @if(old('nk_state'))
                                                                        <option value="{{ old('nk_country') }}" selected>{{ old('nk_state') }}</option>
                                                                    @endif
                                                                </select>
                                                                @error('nk_state')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-6">
                                                                <label class="form-label fs-12 text-muted">Address</label>
                                                                <input type="text" name="nk_address" id="nk_address" class="form-control @error('nk_address') is-invalid @enderror"
                                                                    placeholder="Enter address..." value="{{ $user->nk_address }}" required>
                                                                @error('nk_address')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12">
                                                                <label class="form-label fs-12 text-muted">Postal Code</label>
                                                                <input type="text" name="nk_postal" id="nk_postal" class="form-control @error('nk_postal') is-invalid @enderror"
                                                                    placeholder="Enter postal code..." value="{{ $user->nk_postal }}}" required>
                                                                @error('nk_postal')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <div id="" class="alert alert-primary mt-2">
                                                            <h4 class="text-danger fs-12 fw-bold">Compliance Disclaimer:</h4>
                                                            <div class="">
                                                                <p class="fs-12 text-muted">All information provided is securely stored and used solely for verification purposes in compliance with applicable laws and CIP (Customer Identification Program) requirements.</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-success my-3" type="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="main-kyc" role="tabpanel" aria-labelledby="main-kyc-tab" tabindex="0">
                                                <form action="{{ route('profile.data') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="screen" value="eight">
                                                    <div class="register-page my-4">
                                                        <div class="row gy-3">
                                                            <div class="col-12">
                                                                <label class="form-label fs-12 text-muted my-2" for="employment_status">Employment Status:</label>
                                                                <select class="form-control" id="employment_status" name="employment_status">
                                                                    <option value="employed">Employed</option>
                                                                    <option value="selfemployed">Self-employed</option>
                                                                    <option value="unemployed">Unemployed</option>
                                                                    <option value="retired">Retired</option>
                                                                </select>
                                                            </div>

                                                            <!-- Annual Income Range -->
                                                            <div class="col-12">
                                                                <label class="form-label fs-12 text-muted my-2" for="income_range">Annual Income Range:</label>
                                                                <select class="form-control" id="income_range" name="income_range">
                                                                    <option value="less_than_50k">Less than $50K</option>
                                                                    <option value="50k_100k">$50K - $100K</option>
                                                                    <option value="over_100k">Over $100K</option>
                                                                </select>
                                                            </div>

                                                            <!-- Source Of Funds -->
                                                            <div class="col-12">
                                                                <label class="form-label fs-12 text-muted my-2" for="source_of_funds">Source Of Funds:</label>
                                                                <select class="form-control" id="source_of_funds" name="source_of_funds">
                                                                    <option value="salary">Salary</option>
                                                                    <option value="investment">Investment</option>
                                                                    <option value="business">Business Income</option>
                                                                    <option value="others">Others</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <button class="btn btn-success" type="submit">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="main-proof" role="tabpanel" aria-labelledby="main-proof-tab" tabindex="0">
                                                <div class="px-3 py-3">
                                                    <div class="card-title">
                                                        <h3 class="fw-bold fs-14">Proof of Address</h3>
                                                    </div>
                                                    <div id="" class="alert alert-warning mt-2">
                                                        <div class="">
                                                            <p class="fs-12 text-dark">Upload a valid proof of address document. This can be a utility bill, bank statement, or government-issued document dated within the last 3 months." "Accepted formats: JPG, PNG, PDF. Max size: 10 MB</p>
                                                        </div>
                                                    </div>

                                                    <div class="">
                                                        <form action="{{ route('profile.data') }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <input type="hidden" name="screen" value="proof">
                                                            <div class="my-3 py-2">
                                                                <p class="fs-14 fw-bold my-2">
                                                                    Upload Proof
                                                                </p>
                                                                <div class="">
                                                                    <input type="file" id="imageUpload" class="form-control" name="proof" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                                                                </div>
                                                            </div>
                                                            @if(auth()->user()['proof'])
                                                                <div class="mt-2 mx-2">
                                                                    <img class="img-fluid" style="border-radius: 5px" src="{{ asset(auth()->user()['proof']) }}" alt="proof">
                                                                </div>
                                                            @endif
                                                            <div id="" class="alert alert-primary my-2">
                                                                <h4 class="text-danger fs-12 fw-bold">Compliance Disclaimer:</h4>
                                                                <div class="">
                                                                    <p class="fs-12 text-muted">In compliance with applicable laws and Customer Identification Program (CIP) requirements, your information will be securely processed.</p>
                                                                </div>
                                                            </div>

                                                            <button type="submit" class="btn btn-primary-light border-1 w-100">Submit</button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-billing" role="tabpanel" aria-labelledby="main-billing-tab" tabindex="0">
                                                <form action="{{ route('profile.data') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="screen" value="seven">
                                                    <div class="row">
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="avatar">ID Type</label>
                                                            <select class="form-control" name="" id="">
                                                                <option value="">Select Type</option>
                                                                <option value="passport">Passport</option>
                                                                <option value="license">Driver's License</option>
                                                                <option value="nationalid">National ID</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="id_number">Identification Number</label>
                                                            <input type="text" id="id_number" name="identity" class="form-control"/>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="avatar">Upload Image (Front)</label>
                                                            <input type="file" id="identification" name="identification" class="form-control"/>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="avatar">Upload Image (Back)</label>
                                                            <input type="file" id="avatar" name="avatar" class="form-control"/>
                                                        </div>
                                                        <div>
                                                            <div id="" class="alert alert-primary mt-2">
                                                                <h4 class="text-danger fs-12 fw-bold">Compliance Notice:</h4>
                                                                <div class="">
                                                                    <p class="fs-12 text-muted">Add a disclaimer below the form: "In compliance with applicable laws and Customer Identification Program (CIP) requirements, your information will be securely processed.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="my-2">
                                                            <button class="btn btn-success">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="tab-pane" id="main-password" role="tabpanel" aria-labelledby="main-password-tab" tabindex="0">
                                                <form action="{{ route('password.custom.update') }}" method="post">
                                                    @csrf
                                                    <div class="row">
                                                        <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                            <div>2 Factor Authentication:</div>
                                                        </div>
                                                        <div class="col-md-12 my-2 mb-3">
                                                            <label class="form-label  text-muted fs-12" for="old_password">Enable 2FA</label>
                                                            <div class="form-check form-check-lg form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="twofactor" data-user-id="{{ $user->id }}" {{ $user->two_factor == 'enabled' ? 'checked' : '' }}>
                                                            </div>
                                                        </div>
                                                        <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-1">
                                                            <div>Reset Password:</div>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="old_password">Old Password</label>
                                                            <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="old_password" class="form-control" id="old_password" autocomplete="off" placeholder="Old Password">
                                                            @error('old_password')
                                                                <strong class="small font-weight-bold text-danger">
                                                                    {{ $message }}
                                                                </strong>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <div class="form-group">
                                                                <label class="form-label mt-2 text-muted fs-12" for="new_password">New Password</label>
                                                                <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="new_password" class="form-control" id="new_password" autocomplete="off" placeholder="New Password">
                                                                @error('new_password')
                                                                    <strong class="small font-weight-bold text-danger">
                                                                        {{ $message }}
                                                                    </strong>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 my-2">
                                                            <label class="form-label mt-2 text-muted fs-12" for="confirm_password">Confirm Password</label>
                                                            <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" placeholder="Confirm Password">
                                                        </div>
                                                        <div class="my-2">
                                                            <button class="btn btn-success">Submit</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header">
                        <div class="card-title">
                            Personal Details & KYC
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Name :</span>
                                <span class="text-muted">{{ $user->first_name }} {{ $user->last_name }}</span>
                            </div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Email :</span><span
                                        class="text-muted">{{ $user->email }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Phone :</span><span class="text-muted">
                                {{ $user->phone ?? 'Not Set' }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Address :</span><span
                                        class="text-muted">{{ $user->address }}</span></div>
                            </li>
                            <li class="list-group-item">
                                <div>
                                    <span class="fw-medium me-2">Joined :</span>
                                    <span class="text-muted">{{ auth()->user()['created_at']->format('F d, Y') }}</span>
                                </div>
                            </li>
                            <li class="d-flex list-group-item">
                                <span class="fw-medium me-2">Two Factor:</span>
                                <div class="form-check form-check-lg form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckReverse" data-user-id="{{ $user->id }}" {{ $user->two_factor == 'enabled' ? 'checked' : '' }}>
                                </div>
                            </li>

                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Referral Code:</span>
                                <span class="text-muted">
                                    <div class="d-flex my-2">
                                        <input type="text" id="refCode" class="form-control" value="{{ auth()->user()['ref_code'] }}" disabled>
                                        <button onclick="copyToClipboard('refCode')" class="btn btn-primary btn-sm">Copy </button>
                                    </div>
                                </span>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div><span class="fw-medium me-2">Referral Link:</span>
                                <span class="text-muted">
                                    <div class="d-flex my-2">
                                        <input type="text" id="refLink" class="form-control" value="{{ url('/register?ref=').auth()->user()['ref_code'] }}" disabled>
                                        <button onclick="copyToClipboard('refLink')" class="btn btn-primary btn-sm">Copy </button>
                                    </div>
                                </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- <div class="card custom-card overflow-hidden">
                    <div class="px-3 py-3">
                        <div class="card-title">
                            <h3 class="fw-bold fs-14">Proof of Address</h3>
                        </div>
                        <div id="" class="alert alert-warning mt-2">
                            <div class="">
                                <p class="fs-12 text-dark">Upload a valid proof of address document. This can be a utility bill, bank statement, or government-issued document dated within the last 3 months." "Accepted formats: JPG, PNG, PDF. Max size: 10 MB</p>
                            </div>
                        </div>

                        <div class="">
                            <form action="{{ route('profile.data') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="screen" value="proof">
                                <div class="my-3 py-2">
                                    <p class="fs-14 fw-bold my-2">
                                        Upload Proof
                                    </p>
                                    <div class="">
                                        <input type="file" id="imageUpload" class="form-control" name="proof" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                                    </div>
                                </div>
                                @if(auth()->user()['proof'])
                                    <div class="mt-2 mx-2">
                                        <img class="img-fluid" style="border-radius: 5px" src="{{ asset(auth()->user()['proof']) }}" alt="proof">
                                    </div>
                                @endif
                                <div id="" class="alert alert-primary my-2">
                                    <h4 class="text-danger fs-12 fw-bold">Compliance Disclaimer:</h4>
                                    <div class="">
                                        <p class="fs-12 text-muted">In compliance with applicable laws and Customer Identification Program (CIP) requirements, your information will be securely processed.</p>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary-light border-1 w-100">Submit</button>
                            </form>

                        </div>
                    </div>
                </div> -->
                <div class="">
                    <!-- <a href="{{ route('kyc.index') }}" class="btn btn-primary-light border-1 w-100">Complete KYC</a> -->
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->

    </div>
</div>
<!-- End::app-content -->

<script>

    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            var countryID = $(this).val();
            if (countryID) {
                $.ajax({
                    url: '/getStates/' + encodeURIComponent(countryID),
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        var stateSelect = $('select[name="state"]');
                        stateSelect.empty().append('<option value=""> Select State </option>');
                        $.each(data, function(key, value) {
                            stateSelect.append('<option value="' + value.name + '">' + value.name.charAt(0).toUpperCase() + value.name.slice(1) + '</option>');
                        });
                    },
                    error: function() {
                        console.error('Error fetching states.');
                    }
                });
            } else {
                $('select[name="state"]').empty().append('<option value="">Select Country</option>');
            }
        });

        // Trigger state population if country is preselected
        // var preselectedCountry = '{{ $user->country }}';
        // if (preselectedCountry) {
        //     $('select[name="country"]').val(preselectedCountry).trigger('change');
        // }

        document.getElementById('nk_country').addEventListener('change', function() {
            var countryID = this.value;

            console.log(countryID);

            // Clear state and city dropdowns
            var stateSelect = document.getElementById('nk_state');
            // var citySelect = document.getElementById('city');
            // stateSelect.innerHTML = '<option value="">Select State</option>';
            // citySelect.innerHTML = '<option value="">Select City</option>';

            if (countryID) {
                fetch('/getStates/' + encodeURIComponent(countryID))
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function(state) {
                            var option = document.createElement('option');
                            option.value = state.name;
                            stateSelect.innerHTML = '<option value="">Select State</option>';
                            option.textContent = state.name.charAt(0).toUpperCase() + state.name.slice(1);
                            stateSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching states:', error));
            }
        });
    });

    function getPhoneCode(obj){
        document.getElementById('phone_code').innerHTML = obj.options[obj.selectedIndex].getAttribute('data-code');
        document.getElementById('phone_code_input').value = obj.options[obj.selectedIndex].getAttribute('data-code');
    }

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
                    $('#network-select').html(options).prop('disabled', false);

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

</script>

<script>
    // Wait for the document to be ready
    $(document).ready(function() {
        $('#flexSwitchCheckReverse, #twofactor').on('change', function() {
            let userId = $(this).data('user-id');
            let newStatus = $(this).prop('checked') ? 'enabled' : 'disabled';

            // Send AJAX request to update the two_factor status
            $.ajax({
                url: '/user/update-two-factor', // Route to update two-factor status
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',  // CSRF token for security
                    user_id: userId,
                    two_factor: newStatus
                },
                success: function(response) {
                    // Handle success (optional, you can show a message)
                    console.log(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle error (optional)
                    console.error('Error:', error);
                }
            });
        });
    });
</script>


@endsection


@section('scripts')

<!-- Prism JS -->
<script src="{{ asset('asset/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('asset/js/prism-custom.js') }}"></script>

<!-- Filepond JS -->
<script src="{{ asset('asset/libs/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js') }}"></script>

<!-- Dropzone JS -->
<script src="{{ asset('asset/libs/dropzone/dropzone-min.js') }}"></script>

<!-- Fileupload JS -->
<script src="{{ asset('asset/js/fileupload.js') }}"></script>

@endsection