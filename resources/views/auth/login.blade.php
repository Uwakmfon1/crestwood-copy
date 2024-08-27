{{-- @extends('layouts.auth')

@section('title', '| Login')

@section('content')
    <div class="col-md-8 pl-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
            @if (session('error'))
                <div class="alert alert-fill-danger" role="alert">
                    <i data-feather="alert-circle" class="mr-2"></i>
                    <strong class="small">{{ session('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form class="forms-sample" method="POST" action="{{ route('login') }}">
                @csrf
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
                <div class="form-check form-check-flat form-check-primary">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        Remember me
                    </label>
                </div>
                <div class="my-3 d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Login</button>

                </div>
                <a href="{{ route('register') }}" class="d-block mt-2 text-muted">Not a user? Sign up</a>
            </form>
        </div>
    </div>
@endsection --}}


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
                        <div class="alert alert-fill-danger" role="alert">
                            <i data-feather="alert-circle" class="mr-2"></i>
                            <strong class="small">{{ session('error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <label for="email" class="form-label text-default">Email address</label>
                                <input name="email" type="text" class="form-control" id="email" placeholder="Enter email...">
                            </div>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="col-xl-12 mb-2">
                                <label for="password" class="form-label text-default d-block">Password<a href="reset-password-basic.html" class="float-end  link-danger op-5 fw-medium fs-12">Forget password ?</a></label>
                                <div class="input-group">
                                    <input name="password" type="password" class="form-control" id="password" placeholder="password">
                                    <a href="javascript:void(0);" class="input-group-text text-muted" onclick="createpassword('password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
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
                        {{-- <div class="text-center my-3 authentication-barrier">
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
                        </div> --}}
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
