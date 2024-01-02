@extends('layouts.auth')

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
{{--                    <div>--}}
{{--                        <a href="{{ route('auth.social.attempt', 'facebook') }}" class="btn btn-sm btn-facebook">--}}
{{--                            <i class="fab fa-facebook-f"></i>--}}
{{--                        </a>--}}
{{--                        <a href="{{ route('auth.social.attempt', 'google') }}" class="btn btn-sm btn-google">--}}
{{--                            <i class="fab fa-google-plus-g"></i>--}}
{{--                        </a>--}}
{{--                    </div>--}}
                </div>
                <a href="{{ route('login') }}" class="d-block mt-2 text-muted">Already a user? Sign in</a>
            </form>
        </div>
    </div>
@endsection
