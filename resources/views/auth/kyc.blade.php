@extends('layouts.user.auth')

@section('title', '| Complete Registration')

@section('content')
<!-- Start::app-content -->

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

<link rel="stylesheet" href="{{ asset('asset/libs/intl-tel-input/build/css/intlTelInput.min.css') }}">

<div class="container">
    <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="solid-dangerToast" class="toast colored-toast bg-danger text-fixed-white" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-danger text-fixed-white">
                    <img class="bd-placeholder-img rounded me-2" src="../assets/images/brand-logos/toggle-dark.png" alt="...">
                    <strong class="me-auto">Vertix</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    <span id="toastMessage">Your toast message here.</span>
                </div>
            </div>
        </div>
        <!-- <div id="square-1"></div> -->
        <div class="col-xxl-7 col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">

    @include('partials.users.alert')
            <div class="rounded my-4 bg-white basic-page">
                <div class="basicpage-border"></div>
                <div class="basicpage-border1"></div>
                <div class="card-body">
                    <div class="card-body px-5 py-4">
                        <div class="mb-3 d-flex justify-content-center"> 
                            <a href="index.html"> 
                                <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo"> 
                                <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                            </a>
                        </div>
                        <p class="h4 mb-1 fw-semibold text-center">Complete Registration</p>
                        <p class="mb-4 text-muted fw-normal text-center">Setup your account with us by completing you registration</p>
                        @if (session('error'))
                            <div class="alert alert-fill-danger" role="alert">
                                <i data-feather="alert-circle" class="mr-2"></i>
                                <strong class="small">{{ session('error') }}</strong>
                            </div>
                        @endif
                        <div class="card custom-card">
                            <form class="wizard wizard-tab horizontal" method="POST" action="{{ route('update.kyc') }}">
                                @csrf
                                <aside class="wizard-content container">
                                    <div class=" wizard-step " data-title="Account Type"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
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
                                                    <div class="form-check d-flex align-items-center gap-1 py-3 px-2 account_select">
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
                                    <div class=" wizard-step active" data-title="Payment Information"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="">
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
                                                                    placeholder="Enter bank name..." value="{{ $user['bank_name'] ? $user['bank_name'] : old('bank_name') }}">
                                                                @error('bank_name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12 my-2">
                                                                <label for="account_number" class="form-label">Account Number</label>
                                                                <input name="account_number" type="number" class="form-control @error('account_number') is-invalid @enderror" id="account_number"
                                                                    placeholder="Enter bank name..." value="{{ $user['account_number'] ? $user['account_number'] : old('account_number') }}">
                                                                @error('account_number')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12 my-2">
                                                                <label for="account_name" class="form-label">Account Name</label>
                                                                <input name="account_name" type="text" class="form-control @error('account_name') is-invalid @enderror" id="account_name"
                                                                    placeholder="Enter bank name..." value="{{ $user['account_name'] ? $user['account_name'] : old('account_name') }}">
                                                                @error('account_name')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12 my-2">
                                                                <label for="account_info" class="form-label">Other Information</label>
                                                                <textarea class="form-control @error('account_info') is-invalid @enderror" name="account_info" id="account_info" rows="3" cols="10">{{ $user['account_info'] ? $user['account_info'] : old('account_info') }}</textarea>
                                                                @error('account_info')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane text-muted" id="about1-justified" role="tabpanel">
                                                        <div class="row">
                                                            <div class="col-xl-12 my-2">
                                                                <label for="wallet_asset" class="form-label">Asset</label>
                                                                <input name="wallet_asset" type="text" class="form-control @error('wallet_asset') is-invalid @enderror" id="wallet_asset"
                                                                    placeholder="Enter wallet asset..." value="{{ $user['wallet_asset'] ? $user['wallet_asset'] : old('wallet_asset') }}">
                                                                @error('wallet_asset')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12 my-2">
                                                                <label for="wallet_network" class="form-label">Network</label>
                                                                <input name="wallet_network" type="number" class="form-control @error('wallet_network') is-invalid @enderror" id="wallet_network"
                                                                    placeholder="Enter wallet network..." value="{{ $user['wallet_network'] ? $user['wallet_network'] : old('wallet_network') }}">
                                                                @error('wallet_network')
                                                                    <span class="invalid-feedback" role="alert">
                                                                        <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-xl-12 my-2">
                                                                <label for="wallet_address" class="form-label">Wallet Address</label>
                                                                <input name="wallet_address" type="number" class="form-control @error('wallet_address') is-invalid @enderror" id="wallet_address"
                                                                    placeholder="Enter wallet address..." value="{{ $user['wallet_address'] ? $user['wallet_address'] : old('wallet_address') }}">
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
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Personal Information"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="register-page">
                                                <div class="row">
                                                    <div class="col-lg-6 my-3">
                                                        <label for="location" class="form-label">Loaction Type</label>
                                                        <select name="location" id="location" class="form-control text-dark text-capitalize @error('location') is-invalid @enderror ">
                                                            <option value="home">Home</option>
                                                            <option value="office">Office</option>
                                                        </select>
                                                        @error('location')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6 my-3">
                                                        <label class="form-label" for="country">Country</label>
                                                        <select name="country" id="country" class="form-control text-dark text-capitalize @error('country') is-invalid @enderror">
                                                            <option value="">Select Country</option>
                                                            @foreach(\App\Models\Country::get() as $country)
                                                                <option value="{{ $country->name }}"
                                                                    {{ old('country') == $country->name ? 'selected' : '' }}>
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
                                                    <div class="col-xl-6 my-3">
                                                        <label class="form-label">Select State</label>
                                                        <select name="state" id="state" class="form-control @error('state') is-invalid @enderror" data-trigger style="height: 35px;">
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
                                                    <div class="col-xl-6 my-3">
                                                        <label for="city" class="form-label">City</label>
                                                        <input name="city" type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                                            placeholder="Enter city..." value="{{ old('city') }}">
                                                        @error('city')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-6 my-3">
                                                        <label class="form-label" for="address">Address</label>
                                                        <input class="form-control @error('address') is-invalid @enderror" name="address" id="address" placeholder="Enter address..." type="text" >{{ old('address') }}</input>
                                                        @error('address')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-xl-6 my-3">
                                                        <label for="postal_code" class="form-label">Postal Code</label>
                                                        <input name="postal_code" type="text" class="form-control @error('postal_code') is-invalid @enderror" id="postal_code"
                                                            placeholder="Enter postal code..." value="{{ old('postal_code') }}">
                                                        @error('postal_code')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Next of Kin"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="register-page">
                                                <div class="row gy-3">
                                                    <div class="col-xl-6">
                                                        <label for="nk_name" class="form-label">Full name</label>
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
                                                        <div class="input-group">
                                                            <select class="input-group-text text-start" style="width: 60px; font-size: 12px; padding:0px 5px;" name="nk_phone_code" id="" style="appearance: none !important;">
                                                                @foreach(\App\Models\Country::orderBy('phone_code', 'asc')->get() as $country)
                                                                    <option style="width: 10px;" value="{{ $country->phone_code }}" 
                                                                        {{ old('phone_code') == $country->phone_code ? 'selected' : '' }}>
                                                                        {{ $country->phone_code }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <input class="form-control" id="phone-val" type="number" name="nk_phone" required value="{{ old('nk_phone') }}">
                                                        </div>
                                                        @error('nk_phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label class="form-label">Relationship</label>
                                                        <select name="nk_relationship" id="nk_relationship" class="form-control text-dark text-capitalize @error('nk_relationship') is-invalid @enderror " required>
                                                            <option value="father" {{ old('nk_relationship') == 'father' ? 'selected' : '' }}>Father</option>
                                                            <option value="mother" {{ old('nk_relationship') == 'mother' ? 'selected' : '' }}>Mother</option>
                                                            <option value="brother/sister" {{ old('nk_relationship') == 'brother/sister' ? 'selected' : '' }}>Brother/Sister</option>
                                                            <option value="cousin/niece" {{ old('nk_relationship') == 'cousin/niece' ? 'selected' : '' }}>Cousin/Niece</option>
                                                            <option value="friend" {{ old('nk_relationship') == 'friend' ? 'selected' : '' }}>Close F riend</option>
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
                                                        <label class="form-label">City</label>
                                                        <input type="text" name="city" id="city" class="form-control @error('city') is-invalid @enderror"
                                                            placeholder="Enter address..." value="{{ old('city') }}" required>
                                                        @error('city')
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
                                                    <div class="col-xl-6">
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
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Finish"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="checkout-payment-success">
                                                    <div class="mb-4">
                                                        <h5 class="text-success fw-medium">Great Job!🎉</h5>
                                                    </div>
                                                    <!-- <div class="mb-4">
                                                        <img src="../assets/images/ecommerce/png/24.png" alt="" class="img-fluid">
                                                    </div> -->
                                                    <div class="mb-4">
                                                        <p class="mb-1 fs-14">You've done a good job by filling all the necessary information</p>
                                                        <p class="text-muted">Thank you for your time.</p>
                                                    </div>
                                                    <button class="btn btn-primary" type="submit">Submit Form</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>
                            </form>
                        </div>
                    <div class="text-center">
                        <p class="text-muted mt-3 mb-0">Already have an account?</p>
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <button class="text-primary" style="background: transparent; border: 0px;" id="logout">Sign In</button>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="circle-1"></div>
    </div>
</div>

<!-- End::app-content -->
@endsection

@section('scripts')

<script src="{{ asset('asset/libs/@tarekraafat/autocomplete.js/autoComplete.min.js') }}"></script>
<script src="{{ asset('asset/libs/intl-tel-input/build/js/intlTelInput.min.js') }}"></script>
<script src="{{ asset('asset/js/form-advanced.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {

    document.getElementById('country').addEventListener('change', function() {
        var countryID = this.value;

        console.log(countryID);

        // Clear state and city dropdowns
        var stateSelect = document.getElementById('state');
        // var citySelect = document.getElementById('city');
        stateSelect.innerHTML = '<option value="">Select State</option>';
        // citySelect.innerHTML = '<option value="">Select City</option>';

        if (countryID) {
            fetch('/getStates/' + encodeURIComponent(countryID))
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(state) {
                        var option = document.createElement('option');
                        option.value = state.name;
                        option.textContent = state.name.charAt(0).toUpperCase() + state.name.slice(1);
                        stateSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));
        }
    });

    document.getElementById('nk_country').addEventListener('change', function() {
        var countryID = this.value;

        console.log(countryID);

        // Clear state and city dropdowns
        var stateSelect = document.getElementById('nk_state');
        // var citySelect = document.getElementById('city');
        stateSelect.innerHTML = '<option value="">Select State</option>';
        // citySelect.innerHTML = '<option value="">Select City</option>';

        if (countryID) {
            fetch('/getStates/' + encodeURIComponent(countryID))
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(state) {
                        var option = document.createElement('option');
                        option.value = state.name;
                        option.textContent = state.name.charAt(0).toUpperCase() + state.name.slice(1);
                        stateSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));
        }
    });
    
    @if ($errors->any())
        // Construct the error message
        let errorMessage = '';
        @foreach ($errors->all() as $error)
            errorMessage += '{{ $error }}\n';
        @endforeach
        
        // Set the toast message
        document.getElementById('toastMessage').innerText = errorMessage;

        // Show the toast
        var toastEl = document.getElementById('dangerToast');
        var toast = new bootstrap.Toast(toastEl);
        toast.show();
    @endif

        const input = document.querySelector("#phone");
        const iti = window.intlTelInput(input, {
            initialCountry: "us",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@24.3.4/build/js/utils.js",
        });

        // Store the instance variable globally
        window.iti = iti;

        // Function to get the phone code and phone number
        function getPhoneDetails() {
            const phoneCode = iti.getSelectedCountryData().dialCode;
            const phoneNumber = iti.getNumber(); // E.164 formatted number

            console.log('Phone Code:', phoneCode);
            console.log('Phone Number:', phoneNumber);

            // Optionally, set these values to hidden fields to include them in form submission
            document.querySelector('#phoneCode').value = phoneCode;
            document.querySelector('#phoneNumber').value = phoneNumber;
            input.value = phoneCode + phoneNumber;
        }

        // Bind to form submission or any event you want
        document.querySelector('form').addEventListener('submit', function () {
            getPhoneDetails();
        });

});
</script>


@endsection

















{{-- @extends('layouts.auth')

@section('title', '| Register')

@section('content')
    <div class="col-md-8 pl-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <h5 class="text-muted font-weight-normal mb-4">Create a free account.</h5>
            <form class="forms-sample" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" autofocus>
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group auth-pass-inputgroup">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                        <button class="btn btn-light shadow-none ms-0" type="button" id="password-addon">
                            <i class="mdi mdi-eye-outline"></i>
                        </button>
                    </div>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                </div>
                <div class="form-group">
                    <label for="ref">Referral Code</label>
                    <input id="ref" type="text" value="{{ request('ref') ?? old('ref') }}" class="form-control" name="ref">
                </div>
                <div class="my-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Register</button>
                </div>
                <a href="{{ route('login') }}" class="d-block mt-2 text-muted">Already a user? Sign in</a>
            </form>
        </div>
    </div> 
@endsection --}}
