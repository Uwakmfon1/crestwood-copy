@extends('layouts.user.index')

<style>
    .account_select {
        border-radius: 20px !important; 
        border: 1px solid #f0f0f0;
        /* cursor: pointer; */
    }

    .account_select:hover {
        border: 1px solid grey;
        cursor: pointer;
    }

    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    .wizard-tab .wizard-nav.dots .wizard-step span {
        cursor: pointer;
        font-weight: 400;
        font-size: 13px;
    }

</style>

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
    @include('partials.users.alert')
        <!-- Page Header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
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
            <div class="col-xxl-9">
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
                        <div
                            class="mt-4 mb-3 d-flex align-items-center flex-wrap gap-3 justify-content-between">
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
                                        <p class="mb-0 fs-12 text-muted fw-medium">Wallet</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M224,118.31V200a8,8,0,0,1-8,8H40a8,8,0,0,1-8-8V118.31h0A191.14,191.14,0,0,0,128,144,191.08,191.08,0,0,0,224,118.31Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M104,112a8,8,0,0,1,8-8h32a8,8,0,0,1,0,16H112A8,8,0,0,1,104,112ZM232,72V200a16,16,0,0,1-16,16H40a16,16,0,0,1-16-16V72A16,16,0,0,1,40,56H80V48a24,24,0,0,1,24-24h48a24,24,0,0,1,24,24v8h40A16,16,0,0,1,232,72ZM96,56h64V48a8,8,0,0,0-8-8H104a8,8,0,0,0-8,8ZM40,72v41.62A184.07,184.07,0,0,0,128,136a184,184,0,0,0,88-22.39V72ZM216,200V131.63A200.25,200.25,0,0,1,128,152a200.19,200.19,0,0,1-88-20.36V200H216Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($trading)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Trade</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M208,40H48a8,8,0,0,0-8,8V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V48A8,8,0,0,0,208,40ZM57.78,216A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,70.22,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM68.67,208A64.45,64.45,0,0,1,87.8,182.2a64,64,0,0,1,80.4,0A64.45,64.45,0,0,1,187.33,208ZM208,208h-3.67a79.87,79.87,0,0,0-46.69-50.29,48,48,0,1,0-59.28,0A79.87,79.87,0,0,0,51.67,208H48V48H208V208Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Savings</p>
                                    </div>
                                </div>
                                <div class="py-2 px-3 rounded d-flex align-items-center border gap-3">
                                    <div class="main-card-icon success">
                                        <div class="avatar avatar-sm bg-primary-transparent svg-primary">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                fill="#000000" viewBox="0 0 256 256">
                                                <path
                                                    d="M208,40H48a8,8,0,0,0-8,8V208a8,8,0,0,0,8,8H208a8,8,0,0,0,8-8V48A8,8,0,0,0,208,40ZM57.78,216A72,72,0,0,1,128,160a40,40,0,1,1,40-40,40,40,0,0,1-40,40,72,72,0,0,1,70.22,56Z"
                                                    opacity="0.2"></path>
                                                <path
                                                    d="M208,32H48A16,16,0,0,0,32,48V208a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V48A16,16,0,0,0,208,32ZM96,120a32,32,0,1,1,32,32A32,32,0,0,1,96,120ZM68.67,208A64.45,64.45,0,0,1,87.8,182.2a64,64,0,0,1,80.4,0A64.45,64.45,0,0,1,187.33,208ZM208,208h-3.67a79.87,79.87,0,0,0-46.69-50.29,48,48,0,1,0-59.28,0A79.87,79.87,0,0,0,51.67,208H48V48H208V208Z">
                                                </path>
                                            </svg>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="fw-semibold h6 mb-0">{{ number_format($savings)  }}</p>
                                        <p class="mb-0 fs-12 text-muted fw-medium">Investment</p>
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
                                        <button class="nav-link text-start" id="man-password-tab" data-bs-toggle="pill" data-bs-target="#man-password" type="button" role="tab" aria-controls="man-password" aria-selected="false" tabindex="-1"><i class="ri-u-disk-line me-1 align-middle d-inline-block"></i>Payment Methond</button>
                                        <button class="nav-link text-start" id="main-team-tab" data-bs-toggle="pill" data-bs-target="#main-team" type="button" role="tab" aria-controls="main-team" aria-selected="false" tabindex="-1"><i class="ri-group-line me-1 align-middle d-inline-block"></i>Personal Information</button>
                                        <button class="nav-link text-start" id="main-nextkin-tab" data-bs-toggle="pill" data-bs-target="#main-nextkin" type="button" role="tab" aria-controls="main-nextkin" aria-selected="false" tabindex="-1"><i class="ri-group-line me-1 align-middle d-inline-block"></i>Next of kin</button>
                                        <button class="nav-link text-start" id="main-billing-tab" data-bs-toggle="pill" data-bs-target="#main-billing" type="button" role="tab" aria-controls="main-billing" aria-selected="false" tabindex="-1"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Identity & Verification</button>
                                        <button class="nav-link text-start" id="main-password-tab" data-bs-toggle="pill" data-bs-target="#main-password" type="button" role="tab" aria-controls="main-password" aria-selected="false" tabindex="-1"><i class="ri-user-line me-1 align-middle d-inline-block"></i>Password</button>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content" id="v-pills-tabContent">
                                            <div class="tab-pane show active" id="main-profile" role="tabpanel" tabindex="0" aria-labelledby="main-profile-tab">
                                                <div class="d-sm-flex">
                                                    <div>
                                                        <div class="my-md-auto mt-4 ms-md-3">
                                                            <!-- <h5 class="font-weight-semibold ms-2 mb-1 pb-0">Adam Smith</h5> -->
                                                            <div class="row gy-3">
                                                                <div class="me-3">
                                                                    <span class="avatar avatar-xl bg-dark-transparent rounded-circle p-3">
                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="img">
                                                                    </span>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label mt-2 text-muted fs-12" for="avatar">Avatar</label>
                                                                        <input type="file" id="avatar" name="avatar" class="form-control"/>
                                                                        @error('avatar')
                                                                            <span class="text-danger small" role="alert">
                                                                                <strong>{{ $message }}</strong>
                                                                            </span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <!-- Full Name -->
                                                                <div class="col-xl-12">
                                                                    <label for="first_name" class="form-label">First name</label>
                                                                    <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                                                        placeholder="Enter first name..." value="{{ $user->first_name }}" required>
                                                                    @error('first_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <label for="last_name" class="form-label">Last name</label>
                                                                    <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                                                        placeholder="Enter last name..." value="{{ $user->last_name }}" required>
                                                                    @error('last_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12">
                                                                    <label for="email" class="form-label">Email address</label>
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
                                                                    <label for="phonez" class="form-label d-block">Phone Number</label>
                                                                    <input class="form-control" id="phone" type="tel" name="phone" disabled value="{{ $user->phone }}"> 
                                                                    <input type="hidden" id="phoneCode" name="phone_code">
                                                                    @error('phone')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-success">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="acct-type" role="tabpanel" tabindex="0" aria-labelledby="acct-type-tab">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="flexCheckChecked1" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-success-transparent">
                                                                            <i class="bi bi-hospital"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked1">Savings Account</label>
                                                                        <span class="fs-11 text-muted">Lorem, ipsum dolor sit.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-success rounded-circle" type="checkbox" value="" id="flexCheckChecked1" name="test[]">
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="flexCheckChecked2" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-orange-transparent">
                                                                            <i class="bi bi-hospital"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked2">Investment Account</label>
                                                                        <span class="fs-11 text-muted">Lorem, ipsum dolor sit.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-warning rounded-circle" type="checkbox" value="" id="flexCheckChecked2" name="test[]">
                                                                    </div>
                                                                </div>
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label for="flexCheckChecked3" style="width: 100%; margin: 10px 0px;">
                                                                <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select m-auto">
                                                                    <div>
                                                                        <span class="avatar avatar-md avatar-rounded bg-info-transparent">
                                                                            <i class="bi bi-hospital"></i>
                                                                        </span>
                                                                    </div>
                                                                    <div class="flex-fill">
                                                                        <label class="form-check-label d-block fw-medium fs-14" for="flexCheckChecked3">Trading Account</label>
                                                                        <span class="fs-11 text-muted">Lorem, ipsum dolor sit.</span>
                                                                    </div>
                                                                    <div>
                                                                        <input class="form-check-input form-checked-info rounded-circle" type="checkbox" value="" id="flexCheckChecked3" name="test[]">
                                                                    </div>
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
                                                            <a class="nav-link active" data-bs-toggle="tab" role="tab" href="#home1-justified" aria-selected="false" tabindex="-1">Bank Account</a>
                                                        </li>
                                                        <li class="nav-item" role="presentation">
                                                            <a class="nav-link" data-bs-toggle="tab" role="tab" href="#about1-justified" aria-selected="true">Wallet Information</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane text-muted active show" id="home1-justified" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="bank_name" class="form-label">Bank Name</label>
                                                                    <input name="bank_name" type="text" class="form-control @error('bank_name') is-invalid @enderror" id="bank_name"
                                                                        placeholder="Enter bank name..." value="{{ old('bank_name') }}">
                                                                    @error('bank_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="account_number" class="form-label">Account Number</label>
                                                                    <input name="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror" id="account_number"
                                                                        placeholder="Enter bank name..." value="{{ old('account_number') }}">
                                                                    @error('account_number')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="account_name" class="form-label">Account Name</label>
                                                                    <input name="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name"
                                                                        placeholder="Enter bank name..." value="{{ old('account_name') }}">
                                                                    @error('account_name')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="account_info" class="form-label">Other Information</label>
                                                                    <textarea class="form-control @error('account_info') is-invalid @enderror" name="account_info" id="account_info" rows="3" cols="10">{{ old('account_info') }}</textarea>
                                                                    @error('account_info')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-success">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane text-muted" id="about1-justified" role="tabpanel">
                                                            <div class="row">
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="wallet_asset" class="form-label">Asset</label>
                                                                    <input name="wallet_asset" type="text" class="form-control @error('wallet_asset') is-invalid @enderror" id="wallet_asset"
                                                                        placeholder="Enter wallet asset..." value="{{ old('wallet_asset') }}">
                                                                    @error('wallet_asset')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="wallet_network" class="form-label">Network</label>
                                                                    <input name="wallet_network" type="number" class="form-control @error('wallet_network') is-invalid @enderror" id="wallet_network"
                                                                        placeholder="Enter wallet network..." value="{{ old('wallet_network') }}">
                                                                    @error('wallet_network')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div class="col-xl-12 my-2">
                                                                    <label for="wallet_address" class="form-label">Wallet Address</label>
                                                                    <input name="wallet_address" type="number" class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address"
                                                                        placeholder="Enter wallet address..." value="{{ old('wallet_address') }}">
                                                                    @error('wallet_address')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                                <div>
                                                                    <button class="btn btn-success">Submit</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-team" role="tabpanel" aria-labelledby="main-team-tab" tabindex="0">
                                                <div class="register-page my-4">
                                                    <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                        <div>Personal Information:</div>
                                                    </div>
                                                    <div class="row gy-3">
                                                        <div class="col-lg-6">
                                                            <label class="form-label">Loaction Type</label>
                                                            <select name="location" id="location" class="form-control text-dark text-capitalize @error('location') is-invalid @enderror ">
                                                                <option value="">Select Loaction Type</option>
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
                                                            <label class="form-label">Country</label>
                                                            <select name="country" id="country" class="form-control text-dark text-capitalize @error('country') is-invalid @enderror" required>
                                                                <option value="">Select Country</option>
                                                                @foreach(\App\Models\Country::get() as $country)
                                                                    <option value="{{ $country->name }}" data-phone-code="{{ $country->phone_code }}" 
                                                                        {{ old('nk_country') == $country->name ? 'selected' : '' }}>
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
                                                            <label class="form-label">Select State</label>
                                                            <select name="state" id="state" class="form-control @error('state') is-invalid @enderror" data-trigger required>
                                                                <option value="">Select Country</option>
                                                                @if(old('state'))
                                                                    <option value="{{ old('state') }}" selected>{{ old('state') }}</option>
                                                                @endif
                                                            </select>
                                                            @error('state')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <label for="postal_code" class="form-label">Postal Code</label>
                                                            <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
                                                                placeholder="Enter postal code..." value="{{ old('postal_code') }}">
                                                            @error('postal_code')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <label class="form-label" for="address">Address</label>
                                                            <textarea class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Enter address..." rows="3" cols="10" >{{ old('address') }}</textarea>
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <label class="form-label" for="address">Address line 2</label>
                                                            <textarea class="form-control @error('address2') is-invalid @enderror" name="address2" id="address2" placeholder="Enter address..." rows="3" cols="10">{{ old('address') }}</textarea>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-nextkin" role="tabpanel" aria-labelledby="main-nextkin-tab" tabindex="0">
                                                <div class="register-page my-4">
                                                    <!-- <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                        <div>Next of kin:</div>
                                                    </div> -->
                                                    <div class="row gy-3">
                                                        <div class="col-xl-6">
                                                            <label for="nk_name" class="form-label">Full Name</label>
                                                            <input name="nk_name" type="text" class="form-control @error('nk_name') is-invalid @enderror" id="nk_name"
                                                                placeholder="Enter name..." value="{{ old('nk_name') }}" required>
                                                            @error('nk_name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <label for="phone-validation" class="form-label d-block">Phone Number</label>
                                                            <input class="form-control" id="phone-validation" type="tel" name="nk_phone" style="width: 260px;" required>
                                                            @error('nk_phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label class="form-label">Relationship</label>
                                                            <select name="nk_relationship" id="nk_relationship" class="form-control text-dark text-capitalize @error('nk_relationship') is-invalid @enderror " required>
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
                                                            <label class="form-label">Country</label>
                                                            <select name="nk_country" id="nk_country" class="form-control text-dark text-capitalize @error('nk_country') is-invalid @enderror" required>
                                                                <option value="">Select Country</option>
                                                                @foreach(\App\Models\Country::get() as $country)
                                                                    <option value="{{ $country->name }}" data-phone-code="{{ $country->phone_code }}" 
                                                                        {{ old('nk_country') == $country->name ? 'selected' : '' }}>
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
                                                            <label class="form-label">Select State</label>
                                                            <select name="nk_state" id="nk_state" class="form-control @error('nk_state') is-invalid @enderror" data-trigger required>
                                                                <option value="">Select State</option>
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
                                                            <label class="form-label">Address</label>
                                                            <input type="text" name="nk_address" id="nk_address" class="form-control @error('nk_address') is-invalid @enderror"
                                                                placeholder="Enter address..." value="{{ old('nk_address') }}" required>
                                                            @error('nk_address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <label class="form-label">Postal Code</label>
                                                            <input type="text" name="nk_postal" id="nk_postal" class="form-control @error('nk_postal') is-invalid @enderror"
                                                                placeholder="Enter postal code..." value="{{ old('nk_postal') }}" required>
                                                            @error('nk_postal')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <button class="btn btn-success">Submit</button>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-billing" role="tabpanel" aria-labelledby="main-billing-tab" tabindex="0">
                                                <div class="row">
                                                    <div class="col-md-12 my-2">
                                                        <label class="form-label mt-2 text-muted fs-12" for="avatar">ID Type</label>
                                                        <select class="form-select" name="" id="">
                                                            <option value="">Select Type</option>
                                                            <option value="">Driver's License</option>
                                                            <option value="">International Passport</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12 my-2">
                                                        <label class="form-label mt-2 text-muted fs-12" for="id_number">Identification Number</label>
                                                        <input type="text" id="id_number" name="avatar" class="form-control"/>
                                                    </div>
                                                    <div class="col-md-12 my-2">
                                                        <label class="form-label mt-2 text-muted fs-12" for="avatar">Upload Image (Front)</label>
                                                        <input type="file" id="avatar" name="avatar" class="form-control"/>
                                                    </div>
                                                    <div class="col-md-12 my-2">
                                                        <label class="form-label mt-2 text-muted fs-12" for="avatar">Upload Image (Back)</label>
                                                        <input type="file" id="avatar" name="avatar" class="form-control"/>
                                                    </div>
                                                    <div class="my-2">
                                                        <button class="btn btn-success">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane" id="main-password" role="tabpanel" aria-labelledby="main-password-tab" tabindex="0">
                                                <form action="" method="post">
                                                    <div class="row">
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
                            Personal Info
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
                                <div><span class="fw-medium me-2">Phone :</span><span class="text-muted">+1
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
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Identification
                        </div>
                    </div>
                    <div class="card-body p-0">
                        @if(auth()->user()['identification'])
                            <div class="mt-2">
                                <img class="img-fluid" style="border-radius: 5px" src="{{ asset(auth()->user()['identification']) }}" alt="Identification">
                            </div>
                            <div class="mt-2 text-right">
                                <button onclick="confirmFormSubmit('downloadFileForm')" class="btn btn-sm btn-primary"><i class="icon-sm" data-feather="download"></i></button>
                            </div>
                            <form id="downloadFileForm" action="{{ route('download') }}" method="POST">
                                @csrf
                                <label>
                                    <input type="hidden" name="path" value="{{ auth()->user()['identification'] }}">
                                </label>
                            </form>
                        @else
                            <div class="mt-2">
                                <img class="img-fluid px-2 py-2" style="border-radius: 5px; max-width: 200px;" src="https://cdn.icon-icons.com/icons2/1760/PNG/512/4105938-account-card-id-identification-identity-card-profile-user-profile_113929.png" alt="Identification">
                                <p class="px-3">
                                    Not set...
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                {{-- <div class="card custom-card">
                        <div class="card-body">
                            <h6 class="card-title fs-15">Change Password</h6>
                            <form class="forms-sample" @if(!auth()->user()->authenticatedWithSocials()) action="{{ route('password.custom.update') }}" method="POST"  @endif id="changePasswordForm">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="old_password">Old Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="old_password" class="form-control" id="old_password" autocomplete="off" placeholder="Old Password">
                                    @error('old_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="new_password">Old Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="new_password" class="form-control" id="new_password" autocomplete="off" placeholder="New Password">
                                    @error('new_password')
                                        <strong class="small font-weight-bold text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label mt-2 text-muted fs-12" for="confirm_password">Confirm Password</label>
                                    <input type="password" @if(auth()->user()->authenticatedWithSocials()) disabled @endif name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" placeholder="Confirm Password">
                                </div>
                                @if(auth()->user()->authenticatedWithSocials())
                                    <button disabled type="button" class="btn btn-primary mr-2 my-3">Change Password</button>
                                @else
                                    <button type="button" onclick="confirmFormSubmit('changePasswordForm')" class="btn btn-primary mr-2 mt-3">Change Password</button>
                                @endif
                            </form>
                        </div>
                </div> --}}
            </div>
        </div>
        <!-- End:: row-1 -->

    </div>
</div>
<!-- End::app-content -->


@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('select[name="country"]').on('change', function() {
            $("select").attr("data-trigger", "");
            var countryID = $(this).val();
            if(countryID)
                $.ajax({
                    url: '/getStates/'+encodeURI(countryID),
                    type: "GET",
                    dataType: "json",
                    success:function(data) {
                        console.log(data);
                        // $('#state').removeAttr('data-trigger');
                    $('select[name="state"]').empty()
                        .append('<option value="">Select State</option>')
                    $.each(data, function(key, value) {
                        // console.log(value.name, key);
                        $('select[name="state"]').append('<option value="'+ value.name +'">'+ value.name.charAt(0).toUpperCase() + value.name.slice(1) +'</option>');
                        });
                    }

                });

            else
                $('select[name="state"]').empty()
                    .append('<option value="">Select A Country</option>')

        });
    });

    function getPhoneCode(obj){
        document.getElementById('phone_code').innerHTML = obj.options[obj.selectedIndex].getAttribute('data-code');
        document.getElementById('phone_code_input').value = obj.options[obj.selectedIndex].getAttribute('data-code');
    }
    $(document).ready(function (){
        let bankList = $('#bankList');
        let bankCode = $('#bankCode');
        let accountNumber = $('#account_number');
        let accountName = $('#account_name');
        let verifyingDisplay = $('#verifyingDisplay');
        bankList.on('change', function (){
            $("#bankList option").each(function(){
                if($(this).val() === $('#bankList').val()){
                    bankCode.val($(this).attr('data-code'))
                }
            })
            verifyAccountNumber();
        });
        accountNumber.on('input', verifyAccountNumber);
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
                    },
                    error: function (err){
                        let msg = 'Error processing verification';
                        verifyingDisplay.removeClass('text-info');
                        verifyingDisplay.addClass('text-danger');
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
@endsection