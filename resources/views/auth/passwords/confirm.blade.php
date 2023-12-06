@extends('layouts.auth')

@section('content')
    <div class="col-md-8 pl-md-0">
        <div class="auth-form-wrapper px-4 py-5">
            <h5 class="text-muted font-weight-normal mb-4">Confirm password.</h5>
            <p>Please confirm your password before continuing</p>
            <form class="forms-sample" method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                @if (Route::has('password.request'))
                    <a class="small" href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
                <div class="my-3">
                    <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Confirm Password</button>
                </div>
            </form>
        </div>
    </div>
@endsection
