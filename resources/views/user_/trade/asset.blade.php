@extends('layouts.user.index')

@section('styles')

<link rel="stylesheet" href="{{ asset('asset/libs/swiper/swiper-bundle.min.css') }}">

<style>
    /* Hide default number input arrows */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield; /* For Firefox */
    }
</style>

@endsection

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        @include('partials.users.alert')

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Stock Holdings</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Holdings
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Deposit
                </button>
                <a class="btn btn-primary btn-wave waves-effect waves-light" href="{{ route('savings.create') }}">
                    <i class="ri-upload-2-line me-2"></i> Withdraw
                </a> -->
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xl-9">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card icon-overlay">
                            <span class="icon svg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,56V90.06h0a44,44,0,1,0-56,67.88h0V192H40a8,8,0,0,1-8-8V56a8,8,0,0,1,8-8H216A8,8,0,0,1,224,56Z" opacity="0.2"></path><path d="M128,136a8,8,0,0,1-8,8H72a8,8,0,0,1,0-16h48A8,8,0,0,1,128,136Zm-8-40H72a8,8,0,0,0,0,16h48a8,8,0,0,0,0-16Zm112,65.47V224A8,8,0,0,1,220,231l-24-13.74L172,231A8,8,0,0,1,160,224V200H40a16,16,0,0,1-16-16V56A16,16,0,0,1,40,40H216a16,16,0,0,1,16,16V86.53a51.88,51.88,0,0,1,0,74.94ZM160,184V161.47A52,52,0,0,1,216,76V56H40V184Zm56-12a51.88,51.88,0,0,1-40,0v38.22l16-9.16a8,8,0,0,1,7.94,0l16,9.16Zm16-48a36,36,0,1,0-36,36A36,36,0,0,0,232,124Z"></path></svg>
                            </span>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start gap-3 flex-wrap">
                                        <div
                                            class="avatar avatar-lg bg-primary-transparent border border-primary border-opacity-10">
                                            <div class="avatar avatar-md bg-primary svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <circle cx="128" cy="96" r="48" opacity="0.2" />
                                                    <circle cx="128" cy="96" r="80" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <circle cx="128" cy="96" r="48" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <polyline
                                                        points="176 160 176 240 127.99 216 80 240 80 160.01"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    <div class="lh-1">
                                        <span class="d-block mb-2 fw-medium">Available Trading Balance 
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Funds available for buying new stocks or assets." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                        <h4 class="mb-1 fw-semibold">${{ number_format($balance, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="card custom-card icon-overlay">
                            <span class="icon svg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M224,80V192a8,8,0,0,1-8,8H56a16,16,0,0,1-16-16V56A16,16,0,0,0,56,72H216A8,8,0,0,1,224,80Z" opacity="0.2"></path><path d="M216,64H56a8,8,0,0,1,0-16H192a8,8,0,0,0,0-16H56A24,24,0,0,0,32,56V184a24,24,0,0,0,24,24H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64Zm0,128H56a8,8,0,0,1-8-8V78.63A23.84,23.84,0,0,0,56,80H216Zm-48-60a12,12,0,1,1,12,12A12,12,0,0,1,168,132Z"></path></svg>
                            </span>
                            <div class="card-body p-4">
                                <div class="d-flex align-items-start gap-3 flex-wrap">
                                        <div
                                            class="avatar avatar-lg bg-primary-transparent border border-primary border-opacity-10">
                                            <div class="avatar avatar-md bg-primary svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <path d="M128,128h24a40,40,0,0,1,0,80H128Z" opacity="0.2" />
                                                    <path d="M128,48H112a40,40,0,0,0,0,80h16Z" opacity="0.2" />
                                                    <line x1="128" y1="24" x2="128" y2="48" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="128" y1="208" x2="128" y2="232" fill="none"
                                                        stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                    <path
                                                        d="M184,88a40,40,0,0,0-40-40H112a40,40,0,0,0,0,80h40a40,40,0,0,1,0,80H104a40,40,0,0,1-40-40"
                                                        fill="none" stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    <div class="lh-1">
                                        <span class="d-block mb-2 fw-medium">Investing
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Total value of stocks currently held in your portfolio." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                        <h4 class="mb-0 fw-semibold mb-1">${{ number_format($totalAmount, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="col-xxl-12 col-xl-12">
                            <div class="card custom-card">
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="min-height: 540px;">
                                        <table class="table text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>Stocks</th>
                                                    <th>Current Price</th>
                                                    <th>Quantity</th>
                                                    <th>Invested Amount</th>
                                                    <th>Open P/L</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assets as  $key=>$asset)
                                                    @php
                                                        $investmentAmount = $asset->purchase_amount * $asset->quantity; 
                                                        
                                                        $currentValue = $asset->stock['price'] * $asset->quantity;

                                                        $profit = $currentValue - $investmentAmount;

                                                        $percentageDifference = ($investmentAmount>= 0) ? (($currentValue - $investmentAmount) / $investmentAmount) * 100 : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-start gap-3">
                                                                <span class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                                    <img src="{{ $asset->stock['img'] }}" alt="" class="invert-1">
                                                                </span>
                                                                <div class="flex-fill lh-1">
                                                                    <a href="javascript:void(0);" class="d-block mb-1 fs-14 fw-medium">{{ $asset->stock['name'] }}</a>
                                                                    <span class="d-block fs-12 text-muted">{{ $asset->stock['symbol'] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>${{ number_format($asset->stock['price'], 2) }}</td>
                                                        <td>{{ number_format($asset->quantity, 3) }}</td>
                                                        <td>
                                                            <span class="badge bg-dark-transparent">${{ number_format($investmentAmount, 2) }}</span>
                                                        </td>
                                                        <td>
                                                            ${{ number_format($profit, 2) }}
                                                            <span class="mx-2 badge {{ $percentageDifference < 0 ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                                                {{ number_format($percentageDifference, 2) }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('user.asset', $asset->stock['id']) }}" class="btn bg-primary-transparent text-primary btn-wave waves-effect waves-light">
                                                                View
                                                            </a>
                                                        </td>
                                                    </tr>

                                                    <div class="modal fade" id="exampleModal{{ $asset->id }}sell" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content" style="height: 500px; max-width: 650px !important;">
                                                                <div class="modal-body p-2" style="height: 100%;">
                                                                    <div id="tradingview-widget-{{ $asset->id }}" style="height: 60%;"></div>
                                                                    <div class="">
                                                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                                                            <div class="flex-grow-1 my-1">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="card-body p-3 d-flex gap-2">
                                                                                                <div>
                                                                                                    <span class="avatar avatar-sm bg-primary svg-white">
                                                                                                        <i class="ti ti-school fs-18"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div>
                                                                                                    <span class="d-block mb-1 fs-12 text-muted">Stock Price</span>
                                                                                                    <h5 class="fw-semibold mb-1">${{ number_format($asset->stock['price'], 2) }}</h5>
                                                                                                    <span class="fs-12">
                                                                                                        Today 
                                                                                                        <span class="{{ $asset->stock['changes_percentage'] < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                                                                            <i class="{{ $asset->stock['changes_percentage'] < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                                            {{ number_format($asset->stock['changes_percentage'], 2) }}%
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="card-body p-3 d-flex gap-2">
                                                                                                <div>
                                                                                                    <span class="avatar avatar-sm bg-primary svg-white">
                                                                                                        <i class="ti ti-school fs-18"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div>
                                                                                                    <span class="d-block mb-1 fs-12 text-muted">Wallet Price</span>
                                                                                                    <h5 class="fw-semibold mb-1">$<span id="wallet-price-{{ $key }}">{{ number_format($asset->stock['price'] * $asset['quantity'], 2) }}</span></h5>
                                                                                                    <span class="fs-12">
                                                                                                        Quantity <span class="text-primary fs-10 fw-bold ms-1 d-inline-block" id="quantity-display-{{ $key }}">{{ $asset['quantity'] }} Unit{{ $asset['quantity'] > 1 ? 's' : '' }}</span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <form action="{{ route('trade.stock') }}" method="post">
                                                                        @csrf
                                                                        <div class="input-group my-1">
                                                                            <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 20px 0px 0px 20px;">&lt;</button>
                                                                                <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="Enter Quantity..." aria-label="Stock Quantity" min="0.001" data-key="{{ $key }}" data-price="{{ $asset->stock['price'] }}" value="{{ $asset['quantity'] }}" required>
                                                                            <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                                                                        </div>
                                                                        <div>
                                                                            <input type="hidden" name="stock_id" value="{{ $asset->stock['id'] }}">
                                                                            <input type="hidden" name="stock_symbol" value="{{ $asset->stock['symbol'] }}">
                                                                            <input type="hidden" name="amount" value="{{ $asset->stock['price'] }}">
                                                                            <input type="hidden" name="type" value="sell">
                                                                        </div>
                                                                        <button class="my-1 btn btn-wave btn-md btn-danger waves-effect waves-light w-100" type="submit">
                                                                            SELL NOW <i class="ri-arrow-right-line align-middle"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal fade" id="exampleModal{{ $asset->id }}buy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content" style="height: 500px; max-width: 650px !important;">
                                                                <div class="modal-body p-2" style="height: 100%;">
                                                                    <div id="tradingview-widget-{{ $asset->id }}buy" style="height: 60%;"></div>
                                                                    <div class="">
                                                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                                                            <div class="flex-grow-1 my-1">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="card-body p-3 d-flex gap-2">
                                                                                                <div>
                                                                                                    <span class="avatar avatar-sm bg-primary svg-white">
                                                                                                        <i class="ti ti-school fs-18"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div>
                                                                                                    <span class="d-block mb-1 fs-12 text-muted">Stock Price</span>
                                                                                                    <h5 class="fw-semibold mb-1">${{ number_format($asset->stock['price'], 2) }}</h5>
                                                                                                    <span class="fs-12">
                                                                                                        Today 
                                                                                                        <span class="{{ $asset->stock['changes_percentage'] < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                                                                            <i class="{{ $asset->stock['changes_percentage'] < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                                            {{ number_format($asset->stock['changes_percentage'], 2) }}%
                                                                                                        </span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-6">
                                                                                        <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="card-body p-3 d-flex gap-2">
                                                                                                <div>
                                                                                                    <span class="avatar avatar-sm bg-primary svg-white">
                                                                                                        <i class="ti ti-school fs-18"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div>
                                                                                                    <span class="d-block mb-1 fs-12 text-muted">Wallet Price</span>
                                                                                                    <h5 class="fw-semibold mb-1">$<span id="wallet-price-{{ $key }}">{{ number_format($asset->stock['price'] * 0.001, 2) }}</span></h5>
                                                                                                    <span class="fs-12">
                                                                                                        Quantity <span class="text-primary fs-10 fw-bold ms-1 d-inline-block" id="quantity-display-{{ $key }}">0.001 Unit</span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <form action="{{ route('trade.stock') }}" method="post">
                                                                        @csrf
                                                                        <div class="input-group my-1">
                                                                            <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 20px 0px 0px 20px;">&lt;</button>
                                                                            <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="Enter Quantity..." aria-label="Stock Quantity" value="0.001" min="0.001" data-key="{{ $key }}" data-price="{{ $asset->stock['price'] }}" required>
                                                                            <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                                                                        </div>
                                                                        <div>
                                                                            <input type="hidden" name="stock_id" value="{{ $asset->stock['id'] }}">
                                                                            <input type="hidden" name="stock_symbol" value="{{ $asset->stock['symbol'] }}">
                                                                            <input type="hidden" name="amount" value="{{ $asset->stock['price'] }}">
                                                                            <input type="hidden" name="type" value="buy">
                                                                        </div>
                                                                        <button class="my-1 btn btn-wave btn-md btn-success waves-effect waves-light w-100" type="submit">
                                                                            BUY NOW <i class="ri-arrow-right-line align-middle"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <script>
                                                        document.addEventListener('DOMContentLoaded', function() {
                                                            $("#exampleModal{{ $asset->id }}sell").on('shown.bs.modal', function() {
                                                                var widgetContainer = document.getElementById("tradingview-widget-{{ $asset->id }}");

                                                                if (!widgetContainer.dataset.loaded) { // Check if the widget is already loaded
                                                                    widgetContainer.dataset.loaded = true; // Mark as loaded to prevent reloading

                                                                    var script = document.createElement('script');
                                                                    script.type = 'text/javascript';
                                                                    script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js';
                                                                    script.async = true;

                                                                    script.textContent = JSON.stringify({
                                                                        "symbols": [
                                                                            ["{{ $asset->stock['name'] }}", "{{ $asset->stock['symbol'] }}|1M"]
                                                                        ],
                                                                        "chartOnly": false,
                                                                        "width": "100%",
                                                                        "height": "100%",
                                                                        "locale": "en",
                                                                        "colorTheme": "light",
                                                                        "autosize": true,
                                                                        "showVolume": false,
                                                                        "showMA": false,
                                                                        "hideDateRanges": false,
                                                                        "hideMarketStatus": false,
                                                                        "hideSymbolLogo": false,
                                                                        "scalePosition": "right",
                                                                        "scaleMode": "Normal",
                                                                        "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
                                                                        "fontSize": "10",
                                                                        "noTimeScale": false,
                                                                        "valuesTracking": "1",
                                                                        "changeMode": "price-and-percent",
                                                                        "chartType": "area",
                                                                        "maLineColor": "#2962FF",
                                                                        "maLineWidth": 1,
                                                                        "maLength": 9,
                                                                        "headerFontSize": "medium",
                                                                        "lineWidth": 2,
                                                                        "lineType": 0,
                                                                        "dateRanges": [
                                                                            "1d|1",
                                                                            "1m|30",
                                                                            "3m|60",
                                                                            "12m|1D",
                                                                            "60m|1W",
                                                                            "all|1M"
                                                                        ]
                                                                    });

                                                                    widgetContainer.appendChild(script); // Append the script to the container
                                                                }
                                                            });
                                                            $("#exampleModal{{ $asset->id }}buy").on('shown.bs.modal', function() {
                                                                var widgetContainer = document.getElementById("tradingview-widget-{{ $asset->id }}buy");

                                                                if (!widgetContainer.dataset.loaded) { // Check if the widget is already loaded
                                                                    widgetContainer.dataset.loaded = true; // Mark as loaded to prevent reloading

                                                                    var script = document.createElement('script');
                                                                    script.type = 'text/javascript';
                                                                    script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js';
                                                                    script.async = true;

                                                                    script.textContent = JSON.stringify({
                                                                        "symbols": [
                                                                            ["{{ $asset->stock['name'] }}", "{{ $asset->stock['symbol'] }}|1M"]
                                                                        ],
                                                                        "chartOnly": false,
                                                                        "width": "100%",
                                                                        "height": "100%",
                                                                        "locale": "en",
                                                                        "colorTheme": "light",
                                                                        "autosize": true,
                                                                        "showVolume": false,
                                                                        "showMA": false,
                                                                        "hideDateRanges": false,
                                                                        "hideMarketStatus": false,
                                                                        "hideSymbolLogo": false,
                                                                        "scalePosition": "right",
                                                                        "scaleMode": "Normal",
                                                                        "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
                                                                        "fontSize": "10",
                                                                        "noTimeScale": false,
                                                                        "valuesTracking": "1",
                                                                        "changeMode": "price-and-percent",
                                                                        "chartType": "area",
                                                                        "maLineColor": "#2962FF",
                                                                        "maLineWidth": 1,
                                                                        "maLength": 9,
                                                                        "headerFontSize": "medium",
                                                                        "lineWidth": 2,
                                                                        "lineType": 0,
                                                                        "dateRanges": [
                                                                            "1d|1",
                                                                            "1m|30",
                                                                            "3m|60",
                                                                            "12m|1D",
                                                                            "60m|1W",
                                                                            "all|1M"
                                                                        ]
                                                                    });

                                                                    widgetContainer.appendChild(script); // Append the script to the container
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        @if($assets->count() == 0)
                                            <tr>
                                                <p class="py-4 text-center">
                                                    No assets...
                                                </p>
                                            </tr>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card overflow-hidden">
                    <div class="card-body">
                        <!-- <div class="card custom-card bg-primary"> -->
                            <div class="card-body p-2">
                                <div class="">
                                    <div class="text-fixed-dark mb-2">Stock Portfolio Value
                                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Total current value of your stocks portfolio, including unrealized profits or losses." class="text-muted mx-1">
                                            <i class="fe fe-info"></i>
                                        </a>
                                    </div>
                                    <h4 class="fw-semibold mb-0 text-fixed-dark">${{ number_format($equityBalance, 2) }}  
                                        <span class="ms-2 d-inline-block text-success op-5">
                                            <span class="@if($equityBalancePercent>= 0) text-success @else text-danger @endif fs-12 d-block">{{ number_format($equityBalancePercent, 2) }}%</span>
                                        </span>
                                    </h4>
                                </div>
                            </div>
                        <!-- </div> -->
                    </div>
                    <div class="card-footer p-0">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M136,16a8,8,0,0,1,8,8V96.69l34.34-34.34a8,8,0,0,1,11.32,11.31L136,131.31,86.34,81.66a8,8,0,1,1,11.32-11.31L128,96.69V24A8,8,0,0,1,136,16ZM128,144l50.66,50.66a8,8,0,1,1-11.32,11.31L136,159.31V232a8,8,0,0,1-16,0V159.31l-31.34,31.34a8,8,0,0,1-11.32-11.31L128,144Z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium fs18"> Open P/L</span>
                                        <span class="@if($equityBalancePercent>= 0) text-success @else text-danger @endif fs-11 d-block">{{ number_format($equityBalancePercent, 2) }}%</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">${{ number_format($totalProfit, 2) }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm0,192a88,88,0,1,1,88-88A88.1,88.1,0,0,1,128,216Zm16-144a8,8,0,0,1,8,8v4a8,8,0,0,1-8,8H108a12,12,0,0,0,0,24h24a28,28,0,0,1,0,56H128v4a8,8,0,0,1-16,0v-4a8,8,0,0,1,8-8h20a12,12,0,0,0,0-24H108a28,28,0,0,1,0-56h12V80a8,8,0,0,1,16,0v4Z"></path>
                                                </svg>
                                            </div>                                                            
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Amount</span>
                                        <span class="text-muted fs-12 d-block">Asset amount</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">${{ number_format($totalAmount, 2) }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M216,64H176V56a24,24,0,0,0-24-24H104A24,24,0,0,0,80,56v8H40A16,16,0,0,0,24,80V200a16,16,0,0,0,16,16H216a16,16,0,0,0,16-16V80A16,16,0,0,0,216,64ZM96,56a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96ZM40,80H216V104H40ZM216,200H40V120H216v80Z"></path>
                                                </svg>
                                            </div>                                                            
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Asset</span>
                                        <span class="text-muted fs-12 d-block">Owned assets</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">{{ $assetNumber }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M216,56H160a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16h56a16,16,0,0,0,16-16V72A16,16,0,0,0,216,56Zm0,48H160V72h56Zm0,48H160a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16h56a16,16,0,0,0,16-16V168A16,16,0,0,0,216,152Zm0,48H160V168h56ZM96,56H40A16,16,0,0,0,24,72v32a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V72A16,16,0,0,0,96,56ZM96,104H40V72H96ZM96,152H40a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V168A16,16,0,0,0,96,152Zm0,48H40V168H96Z"></path>
                                                </svg>                                                          
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Quantity</span>
                                        <span class="text-muted fs-12 d-block">Asset Quantity</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">{{ number_format($totalAssetQuantity, 2) }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M216,56H160a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16h56a16,16,0,0,0,16-16V72A16,16,0,0,0,216,56Zm0,48H160V72h56Zm0,48H160a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16h56a16,16,0,0,0,16-16V168A16,16,0,0,0,216,152Zm0,48H160V168h56ZM96,56H40A16,16,0,0,0,24,72v32a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V72A16,16,0,0,0,96,56ZM96,104H40V72H96ZM96,152H40a16,16,0,0,0-16,16v32a16,16,0,0,0,16,16H96a16,16,0,0,0,16-16V168A16,16,0,0,0,96,152Zm0,48H40V168H96Z"></path>
                                                </svg>                                                          
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Today’s Change
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="The dollar and percentage change in your stocks portfolio value for the current trading day." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                        <span class="text-muted fs-12 d-block">{{ number_format(($equityBalancePercent - (15/100 * 100)), 2) }}%</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">${{ number_format(($totalProfit - (15/100 * 100)), 2) }}</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Watch list
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled transactions-list mb-0">
                            @foreach($watchList as $data)
                                <li>
                                    <div onclick="window.location='{{ route('trade.show', ['stock' => $data['id'], 'symbol' => $data['symbol']]) }}';" class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-start flex-wrap gap-2">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary-transparent avatar-rounded p-2">
                                                    <img src="{{ $data->img }}" class="avatar avatar-rounded" alt="">
                                                </span> 
                                            </div>
                                            <div>
                                                <a href="javascript:void(0);">
                                                    <span class="d-block fw-medium mb-1 fs-12">{{ $data->name }}</span>
                                                </a>
                                                <span class="d-block fs-11 text-muted">{{ $data->symbol }}</span>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="d-block fw-bold fs-12">${{ $data->price }}</span>
                                            <span class="text-success fs-11">{{ $data->change }}%</span>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                            @if($watchList->count() < 1)
                                <p class="text-center my-5 py-4">No data</p>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->
         <div class="row">
            <div class="col-9">

            </div>
            <div class="col-3">
            </div>
         </div>

            <!-- Start:: row-2 -->
            <div class="row">
                
            </div>
            <!-- End:: row-2 -->
    </div>
</div>
<!-- End::app-content -->
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
    // Function to update the wallet price
    function updateWalletPrice($input) {
        const key = $input.data('key'); // Get the key for the current stock
        const pricePerUnit = parseFloat($input.data('price')); // Get the price for the current stock
        const quantity = Math.max(0.001, parseFloat($input.val()) || 0.001); // Ensure quantity is at least 0.001
        const totalPrice = pricePerUnit * quantity;

        // Update the wallet price and quantity display
        $('#wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $('#quantity-display-' + key).text(`${quantity} Unit${quantity > 1 ? 's' : ''}`);
    }

    // Handle input change directly
    $('.quantity-input').on('input', function() {
        updateWalletPrice($(this));
    });

    // Handle increment
    $('.increment-btn').click(function() {
        let $input = $(this).siblings('.quantity-input');
        let step = parseFloat($input.attr('step')) || 1;
        let currentValue = parseFloat($input.val()) || 0.001;
        $input.val((currentValue + step).toFixed(3)); // Ensure 3 decimal places
        updateWalletPrice($input);
    });

    // Handle decrement
    $('.decrement-btn').click(function() {
        let $input = $(this).siblings('.quantity-input');
        let step = parseFloat($input.attr('step')) || 1;
        let currentValue = parseFloat($input.val()) || 0.001;
        let minValue = parseFloat($input.attr('min')) || 0.001;
        let newValue = (currentValue - step).toFixed(3);
            if (newValue >= minValue) {
                $input.val(newValue); // Ensure it doesn't go below the minimum value
                updateWalletPrice($input);
            }
        });
    });

</script>
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>
<script>
    /* area chart-datetime x-axis chart */
    var options = {
        series: [{
            data: [
                [1327359600000, 30.95],
                [1327446000000, 31.34],
                [1327532400000, 31.18],
                [1327618800000, 31.05],
                [1327878000000, 31.00],
                [1327964400000, 30.95],
                [1328050800000, 31.24],
                [1328137200000, 31.29],
                [1328223600000, 31.85],
                [1328482800000, 31.86],
                [1328569200000, 32.28],
                [1328655600000, 32.10],
                [1328742000000, 32.65],
                [1328828400000, 32.21],
                [1329087600000, 32.35],
                [1329174000000, 32.44],
                [1329260400000, 32.46],
                [1329346800000, 32.86],
                [1329433200000, 32.75],
                [1329778800000, 32.54],
                [1329865200000, 32.33],
                [1329951600000, 32.97],
                [1330038000000, 33.41],
                [1330297200000, 33.27],
                [1330383600000, 33.27],
                [1330470000000, 32.89],
                [1330556400000, 33.10],
                [1330642800000, 33.73],
                [1330902000000, 33.22],
                [1330988400000, 31.99],
                [1331074800000, 32.41],
                [1331161200000, 33.05],
                [1331247600000, 33.64],
                [1331506800000, 33.56],
                [1331593200000, 34.22],
                [1331679600000, 33.77],
                [1331766000000, 34.17],
                [1331852400000, 33.82],
                [1332111600000, 34.51],
                [1332198000000, 33.16],
                [1332284400000, 33.56],
                [1332370800000, 33.71],
                [1332457200000, 33.81],
                [1332712800000, 34.40],
                [1332799200000, 34.63],
                [1332885600000, 34.46],
                [1332972000000, 34.48],
                [1333058400000, 34.31],
                [1333317600000, 34.70],
                [1333404000000, 34.31],
                [1333490400000, 33.46],
                [1333576800000, 33.59],
                [1333922400000, 33.22],
                [1334008800000, 32.61],
                [1334095200000, 33.01],
                [1334181600000, 33.55],
                [1334268000000, 33.18],
                [1334527200000, 32.84],
                [1334613600000, 33.84],
                [1334700000000, 33.39],
                [1334786400000, 32.91],
                [1334872800000, 33.06],
                [1335132000000, 32.62],
                [1335218400000, 32.40],
                [1335304800000, 33.13],
                [1335391200000, 33.26],
                [1335477600000, 33.58],
                [1335736800000, 33.55],
                [1335823200000, 33.77],
                [1335909600000, 33.76],
                [1335996000000, 33.32],
                [1336082400000, 32.61],
                [1336341600000, 32.52],
                [1336428000000, 32.67],
                [1336514400000, 32.52],
                [1336600800000, 31.92],
                [1336687200000, 32.20],
                [1336946400000, 32.23],
                [1337032800000, 32.33],
                [1337119200000, 32.36],
                [1337205600000, 32.01],
                [1337292000000, 31.31],
                [1337551200000, 32.01],
                [1337637600000, 32.01],
                [1337724000000, 32.18],
                [1337810400000, 31.54],
                [1337896800000, 31.60],
                [1338242400000, 32.05],
                [1338328800000, 31.29],
                [1338415200000, 31.05],
                [1338501600000, 29.82],
                [1338760800000, 30.31],
                [1338847200000, 30.70],
                [1338933600000, 31.69],
                [1339020000000, 31.32],
                [1339106400000, 31.65],
                [1339365600000, 31.13],
                [1339452000000, 31.77],
                [1339538400000, 31.79],
                [1339624800000, 31.67],
                [1339711200000, 32.39],
                [1339970400000, 32.63],
                [1340056800000, 32.89],
                [1340143200000, 31.99],
                [1340229600000, 31.23],
                [1340316000000, 31.57],
                [1340575200000, 30.84],
                [1340661600000, 31.07],
                [1340748000000, 31.41],
                [1340834400000, 31.17],
                [1340920800000, 32.37],
                [1341180000000, 32.19],
                [1341266400000, 32.51],
                [1341439200000, 32.53],
                [1341525600000, 31.37],
                [1341784800000, 30.43],
                [1341871200000, 30.44],
                [1341957600000, 30.20],
                [1342044000000, 30.14],
                [1342130400000, 30.65],
                [1342389600000, 30.40],
                [1342476000000, 30.65],
                [1342562400000, 31.43],
                [1342648800000, 31.89],
                [1342735200000, 31.38],
                [1342994400000, 30.64],
                [1343080800000, 30.02],
                [1343167200000, 30.33],
                [1343253600000, 30.95],
                [1343340000000, 31.89],
                [1343599200000, 31.01],
                [1343685600000, 30.88],
                [1343772000000, 30.69],
                [1343858400000, 30.58],
                [1343944800000, 32.02],
                [1344204000000, 32.14],
                [1344290400000, 32.37],
                [1344376800000, 32.51],
                [1344463200000, 32.65],
                [1344549600000, 32.64],
                [1344808800000, 32.27],
                [1344895200000, 32.10],
                [1344981600000, 32.91],
                [1345068000000, 33.65],
                [1345154400000, 33.80],
                [1345413600000, 33.92],
                [1345500000000, 33.75],
                [1345586400000, 33.84],
                [1345672800000, 33.50],
                [1345759200000, 32.26],
                [1346018400000, 32.32],
                [1346104800000, 32.06],
                [1346191200000, 31.96],
                [1346277600000, 31.46],
                [1346364000000, 31.27],
                [1346709600000, 31.43],
                [1346796000000, 32.26],
                [1346882400000, 32.79],
                [1346968800000, 32.46],
                [1347228000000, 32.13],
                [1347314400000, 32.43],
                [1347400800000, 32.42],
                [1347487200000, 32.81],
                [1347573600000, 33.34],
                [1347832800000, 33.41],
                [1347919200000, 32.57],
                [1348005600000, 33.12],
                [1348092000000, 34.53],
                [1348178400000, 33.83],
                [1348437600000, 33.41],
                [1348524000000, 32.90],
                [1348610400000, 32.53],
                [1348696800000, 32.80],
                [1348783200000, 32.44],
                [1349042400000, 32.62],
                [1349128800000, 32.57],
                [1349215200000, 32.60],
                [1349301600000, 32.68],
                [1349388000000, 32.47],
                [1349647200000, 32.23],
                [1349733600000, 31.68],
                [1349820000000, 31.51],
                [1349906400000, 31.78],
                [1349992800000, 31.94],
                [1350252000000, 32.33],
                [1350338400000, 33.24],
                [1350424800000, 33.44],
                [1350511200000, 33.48],
                [1350597600000, 33.24],
                [1350856800000, 33.49],
                [1350943200000, 33.31],
                [1351029600000, 33.36],
                [1351116000000, 33.40],
                [1351202400000, 34.01],
                [1351638000000, 34.02],
                [1351724400000, 34.36],
                [1351810800000, 34.39],
                [1352070000000, 34.24],
                [1352156400000, 34.39],
                [1352242800000, 33.47],
                [1352329200000, 32.98],
                [1352415600000, 32.90],
                [1352674800000, 32.70],
                [1352761200000, 32.54],
                [1352847600000, 32.23],
                [1352934000000, 32.64],
                [1353020400000, 32.65],
                [1353279600000, 32.92],
                [1353366000000, 32.64],
                [1353452400000, 32.84],
                [1353625200000, 33.40],
                [1353884400000, 33.30],
                [1353970800000, 33.18],
                [1354057200000, 33.88],
                [1354143600000, 34.09],
                [1354230000000, 34.61],
                [1354489200000, 34.70],
                [1354575600000, 35.30],
                [1354662000000, 35.40],
                [1354748400000, 35.14],
                [1354834800000, 35.48],
                [1355094000000, 35.75],
                [1355180400000, 35.54],
                [1355266800000, 35.96],
                [1355353200000, 35.53],
                [1355439600000, 37.56],
                [1355698800000, 37.42],
                [1355785200000, 37.49],
                [1355871600000, 38.09],
                [1355958000000, 37.87],
                [1356044400000, 37.71],
                [1356303600000, 37.53],
                [1356476400000, 37.55],
                [1356562800000, 37.30],
                [1356649200000, 36.90],
                [1356908400000, 37.68],
                [1357081200000, 38.34],
                [1357167600000, 37.75],
                [1357254000000, 38.13],
                [1357513200000, 37.94],
                [1357599600000, 38.14],
                [1357686000000, 38.66],
                [1357772400000, 38.62],
                [1357858800000, 38.09],
                [1358118000000, 38.16],
                [1358204400000, 38.15],
                [1358290800000, 37.88],
                [1358377200000, 37.73],
                [1358463600000, 37.98],
                [1358809200000, 37.95],
                [1358895600000, 38.25],
                [1358982000000, 38.10],
                [1359068400000, 38.32],
                [1359327600000, 38.24],
                [1359414000000, 38.52],
                [1359500400000, 37.94],
                [1359586800000, 37.83],
                [1359673200000, 38.34],
                [1359932400000, 38.10],
                [1360018800000, 38.51],
                [1360105200000, 38.40],
                [1360191600000, 38.07],
                [1360278000000, 39.12],
                [1360537200000, 38.64],
                [1360623600000, 38.89],
                [1360710000000, 38.81],
                [1360796400000, 38.61],
                [1360882800000, 38.63],
                [1361228400000, 38.99],
                [1361314800000, 38.77],
                [1361401200000, 38.34],
                [1361487600000, 38.55],
                [1361746800000, 38.11],
                [1361833200000, 38.59],
                [1361919600000, 39.60],
            ]
        }],
        chart: {
            id: 'area-datetime',
            type: 'area',
            height: 400,
            zoom: {
                autoScaleYaxis: true
            }
        },
        colors: ["#8274ff"],
        // annotations: {
        //     yaxis: [{
        //         y: 30,
        //         borderColor: '#999',
        //         label: {
        //             show: true,
        //             text: 'Support',
        //             style: {
        //                 color: "#fff",
        //                 background: '#00E396'
        //             }
        //         }
        //     }],
        //     xaxis: [{
        //         x: new Date('14 Nov 2012').getTime(),
        //         borderColor: '#999',
        //         yAxisIndex: 0,
        //         label: {
        //             show: true,
        //             text: 'Rally',
        //             style: {
        //                 color: "#fff",
        //                 background: '#775DD0'
        //             }
        //         }
        //     }]
        // },
        grid: {
            // borderColor: '#f2f5f7',
        },
        dataLabels: {
            enabled: false
        },
        markers: {
            size: 0,
            style: 'hollow',
        },
        xaxis: {
            type: 'datetime',
            min: new Date('01 Mar 2012').getTime(),
            tickAmount: 1,
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-xaxis-label',
                },
            }
        },
        yaxis: {
            labels: {
                show: true,
                style: {
                    colors: "#8c9097",
                    fontSize: '10px',
                    fontWeight: 400,
                    cssClass: 'apexcharts-yaxis-label',
                },
            }
        },
        tooltip: {
            x: {
                format: 'dd MMM yyyy'
            }
        },
        fill: {
            type: 'gradient',
            gradient: {
                shadeIntensity: 1,
                opacityFrom: 0.7,
                opacityTo: 0.9,
                stops: [0, 100]
            }
        },
    };
    var chart = new ApexCharts(document.querySelector("#area-datetime"), options);
    chart.render();
</script>
@endsection