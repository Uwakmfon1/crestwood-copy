@extends('layouts.user.auth')

@section('title', '| Verify')

@section('content')
<!-- Start::app-content -->

<div class="container-lg">
    <div class="row justify-content-center align-items-center authentication two-step-verification authentication-basic h-100">
        <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
            @if (session('message'))
                <div class="alert alert-solid-warning alert-dismissible fade show" role="alert">
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
                <form class="d-inline" method="POST" action="{{ route('verification.verify.code') }}">
                    @csrf
                    <div class="mb-3 d-flex justify-content-center"> 
                        <a href="index.html"> 
                            <img src="../assets/images/brand-logos/desktop-logo.png" alt="logo" class="desktop-logo"> 
                            <img src="../assets/images/brand-logos/desktop-dark.png" alt="logo" class="desktop-dark"> 
                        </a> 
                    </div>
                        <p class="h4 mb-2 fw-semibold text-center">Verify Your Account</p>
                        <p class="mb-4 text-muted fw-normal text-center">Enter the 6 digit code sent to the registered email</p>
                    <div class="row gy-3">
                        <div class="col-xl-12 mb-2">
                            <div class="row">
                                <div class="col-12">
                                    <input type="number" name="otp" required value="{{ old('otp') }}" class="form-control text-center" maxlength="6" placeholder="Enter OTP...">
                                </div>
                            </div>
                            <div class="form-check mt-2">
                                <label class="form-check-label text-muted fw-normal fs-12" for="defaultCheck1">
                                        Did not recieve a code ?<a href="{{ route('verification.send') }}" class="text-primary ms-2 d-inline-block fw-medium" id="resend">Resend</a>
                                </label>
                            </div>
                        </div>
                        <div class="col-xl-12 d-grid mt-3">
                            <button class="btn btn-primary" type="submit">Verify</button>
                        </div>
                    </div>
                    <div class="text-center">
                        <p class="fs-12 text-danger mt-3 mb-0"><sup><i class="ri-asterisk"></i></sup>Don't share the verification code with anyone !</p>
                    </div>
                </form>
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
