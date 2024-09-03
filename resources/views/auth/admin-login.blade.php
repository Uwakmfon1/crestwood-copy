@extends('layouts.auth')

@section('title', '| Login')

@section('content')
    <div class="col-md-8 pl-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <h5 class="text-muted font-weight-normal mb-4">Welcome back! Log in to your account.</h5>
            @if(session('error'))
                <div class="alert alert-fill-danger" role="alert">
                    <i data-feather="alert-circle" class="mr-2"></i>
                    <strong class="small">{{ session('error') }}</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form class="forms-sample" method="POST" action="{{ route('admin.login') }}">
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
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
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
                <div class="my-3">
                    <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Login</button>
                </div>
                <a class="small" href="{{ route('admin.password.request') }}">
                    {{ __('Forgot Your Password?') }}
                </a>
            </form>
        </div>
    </div>
@endsection