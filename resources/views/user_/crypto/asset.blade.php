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
                <h1 class="page-title fw-medium fs-18 mb-2">Assets</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Assets
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
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
                                        <span class="d-block mb-2 fw-medium">Trading Balance</span>
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
                                        <span class="d-block mb-2 fw-medium">Total Asset</span>
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
                                                    <th>Asset</th>
                                                    <th>Current Price</th>
                                                    <th>Lots Size</th>
                                                    <th>Amount</th>
                                                    <th>Profit</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($assets as  $key=>$asset)
                                                    @php
                                                        $investmentAmount = $asset->purchase_amount * $asset->quantity; 
                                                        
                                                        $currentValue = $asset->crypto['price'] * $asset->quantity;

                                                        $profit = $currentValue - $investmentAmount;

                                                        $percentageDifference = ($investmentAmount > 0) ? (($currentValue - $investmentAmount) / $investmentAmount) * 100 : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>
                                                            <div class="d-flex align-items-start gap-3">
                                                                <span class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                                    <img src="{{ $asset->crypto['img'] }}" alt="" class="invert-1">
                                                                </span>
                                                                <div class="flex-fill lh-1">
                                                                    <a href="javascript:void(0);" class="d-block mb-1 fs-14 fw-medium">{{ $asset->crypto['name'] }}</a>
                                                                    <span class="d-block fs-12 text-muted">{{ $asset->crypto['symbol'] }}</span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>${{ number_format($asset->crypto['price'], 2) }}</td>
                                                        <td>{{ number_format($asset->quantity, 6) }}</td>
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
                                                            <a href="{{ route('asset.view', $asset->crypto['id']) }}" class="btn bg-primary-transparent text-primary btn-wave waves-effect waves-light">
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
                                                                                                        <h5 class="fw-semibold mb-1">${{ number_format($asset->crypto['price'], 2) }}</h5>
                                                                                                        <span class="fs-12">
                                                                                                            Today 
                                                                                                            <span class="{{ $asset->crypto['changes_percentage'] < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                                                                                <i class="{{ $asset->crypto['changes_percentage'] < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                                                {{ number_format($asset->crypto['changes_percentage'], 2) }}%
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
                                                                                                        <h5 class="fw-semibold mb-1">$<span id="wallet-price-{{ $key }}">{{ number_format($asset->crypto['price'] * $asset['quantity'], 2) }}</span></h5>
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
                                                                                    <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="Enter Quantity..." aria-label="Stock Quantity" min="0.001" data-key="{{ $key }}" data-price="{{ $asset->crypto['price'] }}" value="{{ $asset['quantity'] }}" required>
                                                                                <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                                                                            </div>
                                                                            <div>
                                                                                <input type="hidden" name="stock_id" value="{{ $asset->crypto['id'] }}">
                                                                                <input type="hidden" name="stock_symbol" value="{{ $asset->crypto['symbol'] }}">
                                                                                <input type="hidden" name="amount" value="{{ $asset->crypto['price'] }}">
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
                                                                                                        <h5 class="fw-semibold mb-1">${{ number_format($asset->crypto['price'], 2) }}</h5>
                                                                                                        <span class="fs-12">
                                                                                                            Today 
                                                                                                            <span class="{{ $asset->crypto['changes_percentage'] < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                                                                                <i class="{{ $asset->crypto['changes_percentage'] < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                                                {{ number_format($asset->crypto['changes_percentage'], 2) }}%
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
                                                                                                        <h5 class="fw-semibold mb-1">$<span id="wallet-price-{{ $key }}">{{ number_format($asset->crypto['price'] * 0.001, 2) }}</span></h5>
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
                                                                                <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="Enter Quantity..." aria-label="Stock Quantity" value="0.001" min="0.001" data-key="{{ $key }}" data-price="{{ $asset->crypto['price'] }}" required>
                                                                                <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                                                                            </div>
                                                                            <div>
                                                                                <input type="hidden" name="stock_id" value="{{ $asset->crypto['id'] }}">
                                                                                <input type="hidden" name="stock_symbol" value="{{ $asset->crypto['symbol'] }}">
                                                                                <input type="hidden" name="amount" value="{{ $asset->crypto['price'] }}">
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
                                                                                ["{{ $asset->crypto['name'] }}", "{{ $asset->crypto['symbol'] }}|1M"]
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
                                                                                ["{{ $asset->crypto['name'] }}", "{{ $asset->crypto['symbol'] }}|1M"]
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
                                    <div class="text-fixed-dark mb-2">Equity Balance <span class="ms-2 d-inline-block text-success op-5"><i class="fe fe-arrow-up-right text-success"></i>0.25%</span>
                                    </div>
                                    <h4 class="fw-semibold mb-0 text-fixed-dark">${{ number_format($totalAmount, 2) }}</h4>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M216,40H72A16,16,0,0,0,56,56V72H40A16,16,0,0,0,24,88V200a16,16,0,0,0,16,16H184a16,16,0,0,0,16-16V184h16a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40ZM172,72a12,12,0,1,1-12,12A12,12,0,0,1,172,72Zm12,128H40V88H56v80a16,16,0,0,0,16,16H184Zm32-32H72V120.69l30.34-30.35a8,8,0,0,1,11.32,0L163.31,140,189,114.34a8,8,0,0,1,11.31,0L216,130.07V168Z"></path></svg>                                                           </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium fs18">Profit/Loss</span>
                                        <span class="text-success fs-11 d-block">0.32%</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-12">$0.22</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M74.34,85.66A8,8,0,0,1,85.66,74.34L120,108.69V24a8,8,0,0,1,16,0v84.69l34.34-34.35a8,8,0,0,1,11.32,11.32l-48,48a8,8,0,0,1-11.32,0ZM240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H84.4a4,4,0,0,1,2.83,1.17L111,145A24,24,0,0,0,145,145l23.8-23.8A4,4,0,0,1,171.6,120H224A16,16,0,0,1,240,136Zm-40,32a12,12,0,1,0-12,12A12,12,0,0,0,200,168Z"></path></svg></div>                                                            </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Balance</span>
                                        <span class="text-success fs-12 d-block">+1.5%</span>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M120,56v48a16,16,0,0,1-16,16H56a16,16,0,0,1-16-16V56A16,16,0,0,1,56,40h48A16,16,0,0,1,120,56Zm80-16H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V56A16,16,0,0,0,200,40Zm-96,96H56a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,104,136Zm96,0H152a16,16,0,0,0-16,16v48a16,16,0,0,0,16,16h48a16,16,0,0,0,16-16V152A16,16,0,0,0,200,136Z"></path></svg></div>                                                            </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Asset</span>
                                        <span class="text-muted fs-12 d-block">Owned assets</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">{{ $asset ? $asset->count() : 0 }}</span>
                                    </div>
                                </div>
                            </li>
                            <li class="list-group-item">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="main-card-icon primary">
                                        <div class="avatar avatar-md bg-light">
                                            <div class="avatar avatar-sm svg-primary">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M245,110.64A16,16,0,0,0,232,104H216V88a16,16,0,0,0-16-16H130.67L102.94,51.2a16.14,16.14,0,0,0-9.6-3.2H40A16,16,0,0,0,24,64V208h0a8,8,0,0,0,8,8H211.1a8,8,0,0,0,7.59-5.47l28.49-85.47A16.05,16.05,0,0,0,245,110.64ZM93.34,64,123.2,86.4A8,8,0,0,0,128,88h72v16H69.77a16,16,0,0,0-15.18,10.94L40,158.7V64Z"></path></svg>                                                                </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="fw-medium">Total Profit</span>
                                        <span class="text-success fs-12 d-block">-35%</span>
                                    </div>
                                    <div>
                                        <span class="fw-medium text-muted mb-0 fs-14">$0.98</span>
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
                                <div onclick="window.location='{{ route('crypto.show', ['stock' => $data['id'], 'symbol' => $data['symbol']]) }}';" class="d-flex align-items-center justify-content-between">
                                    <div class="d-flex align-items-start flex-wrap gap-2">
                                        <div>
                                            <span class="avatar avatar-md bg-primary-transparent avatar-rounded p-2">
                                                <!-- <span class="avatar avatar-sm bg-primary p-2 avatar-rounded">
                                                    <i class="ri-bank-line fs-18"></i> 
                                                </span> -->
                                                <img src="{{ $data->img }}" class="avatar avatar-rounded" alt="">
                                            </span> 
                                        </div>
                                        <div>
                                            <a href="javascript:void(0);">
                                                <span class="d-block fw-medium mb-1">{{ $data->name }}</span>
                                            </a>
                                            <span class="d-block fs-11 text-muted">{{ $data->symbol }}</span>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fw-medium">${{ $data->price }}</span>
                                        <span class="text-success fs-12">{{ $data->change }}%</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach
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
@endsection