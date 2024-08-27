@extends('layouts.user.auth')

@section('title', '| Login')

@section('content')
<!-- Start::app-content -->

<div class="container-lg">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="rounded my-4 bg-white basic-page">
                    <div class="basicpage-border"></div>
                    <div class="basicpage-border1"></div>
                    <div class="card-body p-5">
                        <div class="mb-3 d-flex justify-content-center"> 
                            <a href="index.html"> 
                                <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo"> 
                                <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                            </a> 
                        </div>
                        <p class="h4 fw-semibold mb-2 text-center">Sign Up</p>
                        <p class="mb-4 text-muted fw-normal text-center">Join us by creating a free account !</p>
                        <form action="{{ route('register') }}" method="post">
                            @csrf
                            <div class="row gy-3">
                                <div class="col-xl-12">
                                    <label for="name" class="form-label text-default">Name</label>
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter name...">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <label for="email" class="form-label text-default">Email address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Enter email...">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <label for="signup-password" class="form-label text-default">Password</label>
                                    <div class="input-group">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="signup-password" placeholder="Enter Password...">
                                        <a href="javascript:void(0);" class="input-group-text text-muted" onclick="createpassword('signup-password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                    </div>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="password-confirm" class="form-label text-default">Confirm Password</label>
                                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password...">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="ref" class="form-label text-default">Referral Code</label>
                                        <input id="ref" type="text" value="{{ request('ref') ?? old('ref') }}" class="form-control" name="ref" placeholder="(optional)">
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
                            <button class="btn btn-primary-light btn-md btn-icon">
                                    <i class="ti ti-mail  fs-18"></i>
                            </button>
                            <button class="btn btn-primary-light btn-md btn-icon">
                                    <i class="ti ti-brand-facebook  fs-18"></i>
                            </button>
                        </div> -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    Create Account
                                </button>
                            </div>
                        </form>
                        <div class="text-center">
                            <p class="text-muted mt-3 mb-0">Already have an account? <a href="{{ route('login') }}" class="text-primary">Sign In</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- End::app-content -->
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
