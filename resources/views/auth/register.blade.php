
@extends('layouts.user.auth')

@section('title', '| Register')


<style>
    /* Hide the up/down arrows for input[type=number] */
    input[type="number"]::-webkit-outer-spin-button,
    input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield; /* Firefox */
    }
</style>


@section('content')
<!-- Start::app-content -->

<div class="container">
    <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
        <div class="col-xxl-6 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="rounded my-4 bg-white basic-page">
                <div class="basicpage-border"></div>
                <div class="basicpage-border1"></div>
                <div class="card-body p-5">
                    <div class="mb-3 d-flex justify-content-center"> 
                        <a href="{{ route('home') }}"> 
                            <img src="{{ asset('asset/images/logo/logo-dark.png') }}" alt="logo" class="desktop-logo"> 
                            <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>
                    <p class="h4 fw-semibold mb-1 text-center">Sign Up</p>
                    <p class="mb-4 text-muted fw-normal text-center fs-14">Create Your Crestwood Capitals Account</p>
                    @if (session('error'))
                        <div class="alert alert-fill-danger" role="alert">
                            <i data-feather="alert-circle" class="mr-2"></i>
                            <strong class="small">{{ session('error') }}</strong>
                        </div>
                    @endif
                    <form action="{{ route('register') }}" method="post">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-xl-12">
                                <div class="register-page">
                                    <div class="row gy-3">
                                        <!-- Full Name -->
                                        <div class="col-xl-6">
                                            <label for="first_name" class="form-label">First Name</label>
                                            <input name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                                                placeholder="e.g.., John" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <span class="text-danger">
                                                    <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="last_name" class="form-label">Last Name</label>
                                            <input name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" id="last_name"
                                                placeholder="e.g.., Doe" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <span class="text-danger">
                                                    <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="col-xl-6">
                                            <label for="email" class="form-label">Email Address</label>
                                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                                    placeholder="e.g.., john.doe@gmail.com" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">
                                                    <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Phone Number -->
                                        <div class="col-xl-6">
                                            <label for="phone" class="form-label d-block">Phone Number</label>
                                            <div class="input-group">
                                                <select class="input-group-text text-start" style="width: 60px; font-size: 12px; padding:0px 5px;" name="phone_code" id="" style="appearance: none !important;">
                                                    @foreach(\App\Models\Country::orderBy('phone_code', 'asc')->get() as $country)
                                                        <option style="width: 10px;" value="{{ $country->phone_code }}" 
                                                            {{ old('phone_code') == $country->phone_code ? 'selected' : '' }}>
                                                            {{ $country->phone_code }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <input class="form-control" id="phone" type="number" name="phone" required value="{{ old('phone') }}">
                                            </div>
                                            @error('phone')
                                                <span class="text-danger">
                                                    <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <!-- Password -->
                                        <div class="col-xl-6">
                                            <label for="signin-password" class="form-label text-default d-block">Password</label>
                                            <div class="input-group">
                                                <input name="password" type="password" class="form-control" id="signin-password" placeholder="Enter password..." required>
                                                <a href="javascript:void(0);" class="input-group-text bg-white text-muted" onclick="createpassword('signin-password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                                @error('password')
                                                    <span class="text-danger">
                                                        <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <span class="text-primary">
                                                    <strong class="fs-10">Minimum 8 characters, at least one number, and one special character.</strong>
                                                </span>
                                            </div>
                                        </div>
                                        <!-- Confirm Password -->
                                        <div class="col-xl-6">
                                            <label for="password_confirmation" class="form-label text-default d-block">Confirm Password</label>
                                            <div class="input-group">
                                                <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" placeholder="Confirm Password..." required>
                                                <a href="javascript:void(0);" class="input-group-text bg-white text-muted" onclick="createpassword('password_confirmation',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                                @error('password')
                                                    <span class="text-danger">
                                                        <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="text-center my-3 authentication-barrier">
                            <span class="op-4 fs-11">Or SignIn With</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-center gap-3 mb-3 flex-wrap">
                            <button class="btn btn-primary-light btn-md btn-icon">
                                <i class="ti ti-brand-google fs-18"></i>
                            </button>
                        </div> -->
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Sign Up</button>
                        </div>
                    </form>
                    <div class="text-center mt-4 pt-3">
                        <p class="text-muted mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End::app-content -->
@endsection
