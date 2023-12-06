@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Verify Your Email Address') }}</div>

                <div class="card-body">
                    @if (session('message'))
                        <div class="alert alert-fill-success" role="alert">
                            <i data-feather="check-circle" class="mr-2"></i>
                            <strong class="small">A fresh verification link has been sent to your email address.</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if (session('otp-error'))
                        <div class="alert alert-fill-danger" role="alert">
                            <i data-feather="alert-circle" class="mr-2"></i>
                            <strong class="small">{{ session('otp-error') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    {{ __('Before proceeding, please check your email for a verification link or OTP.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                    </form>
                    <form method="POST" action="{{ route('verification.verify.code') }}">
                        @csrf
                        <div class="input-group mt-3">
                            <input type="number" name="otp" required value="{{ old('otp') }}" step="any" class="form-control" placeholder="OTP">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Verify with OTP</button>
                            </div>
                        </div>
                        @error('otp')
                            <div>
                                <strong class="small font-weight-bold text-danger">
                                    {{ $message }}
                                </strong>
                            </div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
