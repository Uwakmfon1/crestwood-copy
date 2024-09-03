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

    /* select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    } */

</style>

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        @include('partials.users.alert')   
        
        <div class="card custom-card">
            <div class="card-header">
                <div class="card-title">
                    Update Profile
                </div>
            </div>
            <div class="card-body d-flex align-items-start">
                <div class="row">
                    <div class="col-md-4">
                        <div class="nav flex-column nav-pills me-3 tab-style-7" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link text-start active" id="main-profile-tab" data-bs-toggle="pill" data-bs-target="#main-profile" type="button" role="tab" aria-controls="main-profile" aria-selected="true"><i class="ri-shield-user-line me-1 align-middle d-inline-block"></i>Account Information</button>
                        <button class="nav-link text-start" id="man-password-tab" data-bs-toggle="pill" data-bs-target="#man-password" type="button" role="tab" aria-controls="man-password" aria-selected="false" tabindex="-1"><i class="ri-u-disk-line me-1 align-middle d-inline-block"></i>Payment Methond</button>
                        <button class="nav-link text-start" id="main-team-tab" data-bs-toggle="pill" data-bs-target="#main-team" type="button" role="tab" aria-controls="main-team" aria-selected="false" tabindex="-1"><i class="ri-group-line me-1 align-middle d-inline-block"></i>Personal Information</button>
                        <button class="nav-link text-start" id="main-billing-tab" data-bs-toggle="pill" data-bs-target="#main-billing" type="button" role="tab" aria-controls="main-billing" aria-selected="false" tabindex="-1"><i class="ri-bill-line me-1 align-middle d-inline-block"></i>Identity & Verification</button>
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

                                <div class="register-page my-4">
                                    <div class="fs-15 fw-medium d-sm-flex d-block align-items-center justify-content-between mb-3">
                                        <div>Next of kin:</div>
                                    </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
