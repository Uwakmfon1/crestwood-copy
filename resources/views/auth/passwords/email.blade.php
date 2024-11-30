@extends('layouts.user.auth')

@section('content')
<div class="container">
    <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            <div class="rounded my-4 bg-white basic-page">
                <div class="basicpage-border"></div>
                <div class="basicpage-border1"></div>
                <div class="auth-form-wrapper px-4 py-5">
                    @if (session('status'))
                        <div class="alert alert-fill-success" role="alert">
                            <i data-feather="check-circle" class="mr-2"></i>
                            <strong class="small">{{ session('status') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <h5 class="text-muted font-weight-normal mb-4">Send Password Reset Link</h5>
                    <form class="forms-sample" method="POST" action="{{ route('password.email') }}">
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
                        <div class="my-3">
                            <button type="submit" class="btn btn-primary mr-2 mb-2 mb-md-0 text-white">Send Password Reset Link</button>
                        </div>
                        <a href="{{ route('login') }}" class="d-block mt-2 text-muted">Back to Sign in</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
