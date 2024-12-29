@extends('layouts.user.auth')

@section('content')
    <div class="container">
        <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                <div class="rounded my-4 bg-white basic-page">
                    <div class="basicpage-border"></div>
                    <div class="basicpage-border1"></div>
                    <div class="auth-form-wrapper px-4 py-5">
                        <div class="mb-3 d-flex justify-content-center"> 
                            <a href="index.html"> 
                                <img src="{{ asset('asset/images/logo/logo-dark.png') }}" alt="logo" class="desktop-logo"> 
                                <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                            </a> 
                        </div>
                        <p class="h4 fw-semibold mb-4 pb-2 text-center fs-20">New Password</p>
                        @if (session('error'))
                            <div class="alert alert-fill-danger">
                                <i data-feather="alert-circle" class="mr-2"></i>
                                <strong class="small">{{ session('error') }}</strong>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="d-flex mx-auto mb-4">
                                <span class="mx-auto px-2 badge rounded-pill bg-success-transparent fs-12 fw-semibold">{{ session('status') }}</span>
                            </div>
                        @endif
                        <form class="forms-sample" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="form-group my-2">
                                <label for="email">Email address</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="Enter your registered emaill...">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="password">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group my-2">
                                <label for="password-confirm">Confirm Password</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                            <div class="my-3">
                                <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Reset Password</button>
                            </div>
                            <!-- <a href="{{ route('login') }}" class="text-primary fs-12 d-block mt-2 text-muted">Back to Sign in</a>s -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
