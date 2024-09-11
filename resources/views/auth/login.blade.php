
@extends('layouts.user.auth')

@section('title', '| Login')

@section('content')
<!-- Start::app-content -->

<div class="container">
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
                    <p class="h4 fw-semibold mb-2 text-center">Sign In</p>
                    <p class="mb-4 text-muted fw-normal text-center">Welcome back !</p>
                    @if (session('error'))
                        <div class="alert alert-fill-danger">
                            <i data-feather="alert-circle" class="mr-2"></i>
                            <strong class="small">{{ session('error') }}</strong>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="signin-username" class="form-label text-default">Email</label>
                                <input name="email" type="text" class="form-control" id="signin-username" placeholder="Enter email...">
                                @error('email')
                                    <span class="text-danger">
                                        <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-xl-12 mb-2">
                                <label for="signin-password" class="form-label text-default d-block">Password<a href="reset-password-basic.html" class="float-end link-primary op-5 fw-medium fs-12">Forget password ?</a></label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control" id="signin-password" placeholder="Enter password...">
                                    <a href="javascript:void(0);" class="input-group-text bg-white text-muted" onclick="createpassword('signin-password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                </div>
                                @error('password')
                                    <span class="text-danger">
                                        <i class="fe fe-info fs-5 mx-1"></i><strong class="fs-10">{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="mt-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                        <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                            Remember password ?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center my-3 authentication-barrier">
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
                        </div>
                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary">Sign In</button>
                        </div>
                    </form>
                    <div class="text-center">
                        <p class="text-muted mt-3 mb-0">Dont have an account? <a href="{{ route('register') }}" class="text-primary">Sign Up</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- End::app-content -->
@endsection
