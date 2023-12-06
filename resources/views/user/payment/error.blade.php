<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env("APP_NAME") }}</title>
    <link rel="stylesheet" href="{{ asset('assets/vendors/core/core.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/flag-icon-css/css/flag-icon.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo_1/style.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}"/>
</head>
<body>
<div class="main-wrapper">
    <div class="page-wrapper full-page">
        <div class="page-content d-flex align-items-center justify-content-center">

            <div class="row w-100 mx-0 auth-page">
                <div class="col-md-8 col-xl-6 mx-auto d-flex flex-column align-items-center">
                    <img src="{{ asset('assets/images/error.svg') }}" width="200px" class="img-fluid mb-4" alt="error">
                    <h4 class="mb-2">{{ ucfirst($type) }} Payment Failed</h4>
                    <h6 class="text-muted mb-3 text-center">Your payment of ₦ {{ number_format($payment['amount']) }} failed</h6>
                    @if ($type == "deposit")
                        <a href="{{ route('wallet') }}" class="btn btn-primary">My Wallets</a>
                    @elseif($type == "trade")
                        <a href="{{ route('trades') }}" class="btn btn-primary">My Trades</a>
                    @elseif($type == "investment")
                        <a href="{{ route('investments') }}" class="btn btn-primary">My Investments</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/vendors/core/core.js') }}"></script>
<script src="{{ asset('assets/vendors/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/template.js') }}"></script>
</body>
</html>
