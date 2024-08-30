@extends('layouts.user.auth')

@section('title', '| Login')

@section('content')
<!-- Start::app-content -->

<div class="row authentication authentication-cover-main mx-0">

    <div class="col-xxl-5 col-xl-5 col-lg-12 d-xl-block d-none px-0">
        <div class="authentication-cover overflow-hidden">
            <div class="row justify-content-center">
                <div class="col-xl-7">
                <div class="aunthentication-content p-5  rounded text-center">
                    <img width="100" src="https://spruko.com/demo/vertix/dist/assets/images/media/media-89.png" alt="img" class="mb-4">
                    <div>
                        <h2 class="fs-4 text-fixed-white lh-base">Welcome!</h2>
                        <p class="mb-0 fs-14 lh-base text-fixed-white op-8">
                            Sign in to manage your account and explore personalized features. Your security is our priority—enter your credentials with confidence.
                        </p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xxl-7 col-xl-7">
        <div class="row justify-content-center cover-background align-items-center h-100">
            <div id="square-1"></div>
            <div class="col-xxl-12 col-xl-9 col-lg-6 col-md-6 col-sm-12 col-12">
                <div class="authentication-cover-logo mb-4 justify-content-center d-flex mt-4"> 
                    <a href="index.html"> 
                        <img src="https://spruko.com/demo/vertix/dist/assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo">  
                        <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                    </a> 
                </div>
                <div class="card custom-card cover-bg  shadow-none my-auto">
                    <div class="card-body p-5">
                        <p class="h4 mb-1 fw-semibold">Sign In</p>
                        <p class="mb-4 text-muted fw-normal">Welcome back !</p>
                        @if (session('error'))
                            <div class="alert alert-fill-danger" role="alert">
                                <i data-feather="alert-circle" class="mr-2"></i>
                                <strong class="small">{{ session('error') }}</strong>
                            </div>
                        @endif
                        <div class="card custom-card">
                            <form class="wizard wizard-tab horizontal" method="POST" action="{{ route('register') }}">
                             @csrf
                                <aside class="wizard-content container">
                                    <div class=" wizard-step " data-title="Personal Information"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="row justify-content-center">
                                            <div class="col-xl-12">
                                                <div class="register-page">
                                                    <div class="row gy-3">
                                                        <!-- Full Name -->
                                                        <div class="col-xl-6">
                                                            <label for="name" class="form-label">Full Name</label>
                                                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                                                placeholder="Enter name..." value="{{ old('name') }}">
                                                            @error('name')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Email Address -->
                                                        <div class="col-xl-6">
                                                            <label for="email" class="form-label">Email address</label>
                                                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                                placeholder="Enter email..." value="{{ old('email') }}">
                                                            @error('email')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Country -->
                                                        <div class="col-xl-6">
                                                            <label class="form-label">Country</label>
                                                            <select name="country" id="country" class="form-control text-dark text-capitalize @error('country') is-invalid @enderror">
                                                                <option value="">Select Country</option>
                                                                @foreach(\App\Models\Country::all() as $country)
                                                                    <option value="{{ $country->name }}" data-phone-code="{{ $country->phone_code }}" {{ old('country') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                                                @endforeach
                                                            </select>
                                                            @error('country')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- State -->
                                                        <div class="col-xl-6">
                                                            <label class="form-label">Select State</label>
                                                            <select name="state" id="state" class="form-control @error('state') is-invalid @enderror">
                                                                <option value="">Select State</option>
                                                            </select>
                                                            @error('state')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Address -->
                                                        <div class="col-xl-6">
                                                            <label for="address" class="form-label">Address</label>
                                                            <input name="address" type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                                                                placeholder="Enter address..." value="{{ old('address') }}">
                                                            @error('address')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Phone Number -->
                                                        <div class="col-xl-6">
                                                            <label for="phone" class="form-label">Phone Number</label>
                                                            <div class="input-group">
                                                                <span class="input-group-text" id="phone_code">+0</span>
                                                                <input name="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                                                    placeholder="Enter Phone Number" aria-label="Phone Number" aria-describedby="phone_code" value="{{ old('phone') }}">
                                                            </div>
                                                            @error('phone')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Password -->
                                                        <div class="col-xl-6">
                                                            <label for="password" class="form-label">Enter Password</label>
                                                            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                                                                placeholder="Enter Password">
                                                            @error('password')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                            @enderror
                                                        </div>
                                                        <!-- Confirm Password -->
                                                        <div class="col-xl-6">
                                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                                            <input name="password_confirmation" type="password" class="form-control" id="password_confirmation"
                                                                placeholder="Confirm Password">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-7">
                                                <div class="login-page d-none">
                                                    <h6 class="mb-3">Sign In :</h6>
                                                    <div class="row justify-content-center gy-4">
                                                        <div class="col-xl-12">
                                                            <label for="email-adress" class="form-label">Email
                                                                Address</label>
                                                            <input type="text" class="form-control " id="email-adress"
                                                                placeholder="Enter Email Adress">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <label for="password" class="form-label">Enter
                                                                Password</label>
                                                            <input type="text" class="form-control " id="password"
                                                                placeholder="Enter Password">
                                                        </div>
                                                        <div class="col-xl-12">
                                                            <div class="d-grid">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-primary px-4">Login</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" wizard-step active" data-title="Select Account"
                                        data-id="2e8WqSV3slGIpTbnjcJzmDwBQaHrfh0Z">
                                        <div class="row gy-4">
                                            <div class="col-xl-4">
                                                <div class="col">
                                                    <div class="form-check d-flex align-items-center gap-1 py-4 px-6 border" style="border-radius: 20px !important;">
                                                        <div>
                                                            <span class="avatar avatar-lg avatar-rounded bg-success-transparent">
                                                                <i class="bi bi-hospital fs-5"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <label class="form-check-label d-block fw-medium fs-15" for="flexCheckChecked2">Trading Account</label>
                                                            <span class="fs-12 text-muted">Lorem, ipsum dolor sit.</span>
                                                        </div>
                                                        <div>
                                                            <input class="form-check-input form-checked-success rounded-circle" type="checkbox" value="" id="flexCheckChecked2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="col">
                                                    <div class="form-check d-flex align-items-center gap-1 py-4 px-6 border" style="border-radius: 20px !important;">
                                                        <div>
                                                            <span class="avatar avatar-lg avatar-rounded bg-orange-transparent">
                                                                <i class="bi bi-hospital fs-5"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <label class="form-check-label d-block fw-medium fs-15" for="flexCheckChecked3">Savings Account</label>
                                                            <span class="fs-12 text-muted">Lorem, ipsum dolor sit.</span>
                                                        </div>
                                                        <div>
                                                            <input class="form-check-input form-checked-orange rounded-circle" type="checkbox" value="" id="flexCheckChecked3">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-4">
                                                <div class="col">
                                                    <div class="form-check d-flex align-items-center gap-1 py-4 px-6 border" style="border-radius: 20px !important;">
                                                        <div>
                                                            <span class="avatar avatar-lg avatar-rounded bg-info-transparent">
                                                                <i class="bi bi-hospital fs-5"></i>
                                                            </span>
                                                        </div>
                                                        <div class="flex-fill">
                                                            <label class="form-check-label d-block fw-medium fs-15" for="flexCheckChecked4">Investment Account</label>
                                                            <span class="fs-12 text-muted">Lorem, ipsum dolor sit.</span>
                                                        </div>
                                                        <div>
                                                            <input class="form-check-input form-checked-info rounded-circle" type="checkbox" value="" id="flexCheckChecked4">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Wallet"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div>
                                                    <!-- Wallet Address -->
                                                    <div class="mb-3">
                                                        <label for="wallet" class="form-label">Wallet Address</label>
                                                        <input name="wallet" type="text" class="form-control @error('wallet') is-invalid @enderror"
                                                            placeholder="Enter Wallet address..." value="{{ old('wallet') }}">
                                                        @error('wallet')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <!-- Wallet Type -->
                                                    <div class="mb-3">
                                                        <label for="wallet_type" class="form-label">Wallet Type</label>
                                                        <select name="wallet_type" id="wallet_type" class="form-control @error('wallet_type') is-invalid @enderror">
                                                            <option value="">Select Wallet</option>
                                                            <option value="bnb" {{ old('wallet_type') == 'bnb' ? 'selected' : '' }}>BNB Wallet</option>
                                                            <option value="eth" {{ old('wallet_type') == 'eth' ? 'selected' : '' }}>ETH Blockchain</option>
                                                        </select>
                                                        @error('wallet_type')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Others"
                                        data-id="H53WJiv9blN17MYTztq4g8U6eSVkaZDx">
                                        <div class="register-page">
                                            <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                                <div>Next of kin:</div>
                                            </div>
                                            <div class="row gy-3">
                                                <div class="col-xl-6">
                                                    <label for="nk_name" class="form-label">Name</label>
                                                    <input name="nk_name" type="text" class="form-control @error('nk_name') is-invalid @enderror" id="nk_name"
                                                        placeholder="Enter name..." value="{{ old('nk_name') }}">
                                                    @error('nk_name')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label class="form-label">Country</label>
                                                    <select name="nk_country" id="nk_country" class="form-control text-dark text-capitalize @error('nk_country') is-invalid @enderror">
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
                                                    <select name="nk_state" id="nk_states" class="form-control @error('nk_state') is-invalid @enderror" data-trigger>
                                                        <option value="">Select State</option>
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
                                                        placeholder="Enter address..." value="{{ old('nk_address') }}">
                                                    @error('nk_address')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="col-xl-12">
                                                    <label class="form-label">Phone Number</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text" id="nk_phone_code">+0</span>
                                                        <input type="text" name="nk_phone" class="form-control @error('nk_phone') is-invalid @enderror"
                                                            placeholder="Enter Phone Number" aria-label="Phone Number" aria-describedby="phone-code"
                                                            value="{{ old('nk_phone') }}">
                                                        @error('nk_phone')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="wizard-step" data-title="Confirmation"
                                        data-id="dOM0iRAyJXsLTr9b3KZfQ2jNv4pgn6Gu" data-limit="3">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="checkout-payment-success">
                                                    <div class="mb-4">
                                                        <h5 class="text-success fw-medium">Great Job!</h5>
                                                    </div>
                                                    <!-- <div class="mb-4">
                                                        <img src="../assets/images/ecommerce/png/24.png" alt="" class="img-fluid">
                                                    </div> -->
                                                    <div class="mb-4">
                                                        <p class="mb-1 fs-14">You've done a good job by filling all the necessary information</p>
                                                        <p class="text-muted">Thank you for your time.</p>
                                                    </div>
                                                    <button class="btn btn-success" type="submit">Submit Form</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </aside>
                            </form>
                        </div>
                    <div class="text-center">
                        <p class="text-muted mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
                    </div>
                    </div>
                </div>
            </div>
            <div id="circle-1"></div>
        </div>
    </div>
</div>

<!-- End::app-content -->
@endsection

@section('scripts')

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('FIre!!');
    
    document.getElementById('country').addEventListener('change', function() {
        var countryID = this.value;
        var phoneCode = this.options[this.selectedIndex].getAttribute('data-phone-code');

        console.log(countryID, phoneCode);
        

        // Update phone code span
        var phoneCodeElement = document.getElementById('phone_code');
        phoneCodeElement.textContent = `${phoneCode}`;

        // Append phone code to the phone input value
        var phoneInput = document.getElementById('phone');
        if (phoneInput) {
            // Remove existing phone code if present
            phoneInput.value = phoneInput.value.replace(/^\+\d+/, '');
            // Prepend the new phone code
            phoneInput.value = `+${phoneCode} ${phoneInput.value}`;
        }

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
                        option.value = state.id;
                        option.textContent = state.name.charAt(0).toUpperCase() + state.name.slice(1);
                        stateSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));
        }
    });

    document.getElementById('state').addEventListener('change', function() {
        var stateID = this.value;

        // Clear city dropdown
        var citySelect = document.getElementById('city');
        citySelect.innerHTML = '<option value="">Select City</option>';

        if (stateID) {
            fetch('/getCities/' + encodeURIComponent(stateID))
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(city) {
                        var option = document.createElement('option');
                        option.value = city.id;
                        option.textContent = city.name.charAt(0).toUpperCase() + city.name.slice(1);
                        citySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching cities:', error));
        }
    });

    document.getElementById('nk_country').addEventListener('change', function() {
        var nk_countryID = this.value;
        var nk_phoneCode = this.options[this.selectedIndex].getAttribute('data-phone-code');

        console.log(nk_countryID, nk_phoneCode);
        

        // Update phone code span
        var phoneCodeElement = document.getElementById('nk_phone_code');
            phoneCodeElement.textContent = `${nk_phoneCode}`;

        // Clear state and city dropdowns
        var nk_stateSelect = document.getElementById('nk_states');
        nk_stateSelect.innerHTML = '<option value="">Select State</option>';

        if (nk_countryID) {
            fetch('/getStates/' + encodeURIComponent(nk_countryID))
                .then(response => response.json())
                .then(data => {
                    data.forEach(function(state) {
                        var option = document.createElement('option');
                        option.value = state.id;
                        option.textContent = state.name.charAt(0).toUpperCase() + state.name.slice(1);
                        nk_stateSelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching states:', error));
        }
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
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
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
