@extends('layouts.user.auth')

@section('title', '| Verify')

@section('content')
<!-- Start::app-content -->

<div class="container-lg">
    <div class="row justify-content-center authentication authentication-basic align-items-center h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            @if (session('message'))
                <div class="alert alert-solid-success alert-dismissible fade show" role="alert">
                    A fresh verification link has been sent to your <strong>email</strong> address.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif

            @if (session('otp-error'))
                <div class="alert alert-solid-danger alert-dismissible fade show" role="alert">
                    {{ session('otp-error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                        <i class="bi bi-x"></i>
                    </button>
                </div>
            @endif
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
                    <p class="h4 mb-4 fw-semibold text-center">Account Verification</p>
                    <div class="row gy-3">
                        <form class="d-inline" method="POST" action="{{ route('verification.verify.code') }}">
                            <div class="col-xl-12 mb-2">
                                @csrf
                                <label for="lockscreen-password" class="form-label text-default">Passcode</label>
                                <div class="input-group">
                                    <input name="otp" required value="{{ old('otp') }}" type="number" class="form-control" id="lockscreen-password" placeholder="Enter code..." maxlength="6">
                                    <a href="javascript:void(0);" class="input-group-text text-muted" onclick="createpassword('lockscreen-password',this)"><i class="ri-eye-off-line align-middle"></i></a>
                                </div>
                                <div class="mt-2">
                                    <div class="form-check">
                                        <!-- <input class="form-check-input" type="checkbox" value="" id="defaultCheck1"> -->
                                        <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                            Did not recieve a code ? <a href="{{ route('verification.send') }}" class="text-primary ms-2 d-inline-block fw-medium" id="resend">Resend</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 d-grid mt-2">
                                <button class="btn btn-primary" type="submit">Verify</button>
                            </div>
                        </form>
                    </div>
                    <div class="text-center mt-3 mb-1">
                        <span class="text-muted fs-12">Hello! <strong> {{ auth()->user()->first_name }} {{ auth()->user()->last_name }} </strong></span>
                    </div>
                    <div class="mx-auto d-flex text-center">
                        <div class="d-flex align-items-center text-cente px-auto mx-auto">
                            <p class="fs-12 text-muted mb-0">Wrong email address</p>
                            <form action="{{ route('logout.verification') }}" method="post">
                                @csrf
                                <button class="text-success border-0 bg-transparent fs-12" type="submit">
                                    Try another
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#resend').on('click', function(e) {
            e.preventDefault(); // Prevent the default link behavior
            $(this).closest('form').submit(); // Submit the form
        });
    });

</script>

<!-- End::app-content -->
@endsection
