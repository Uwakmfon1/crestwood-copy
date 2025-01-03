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

    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }

    @media (max-width: 500px) {
        .stock-scrol {
            margin-left: -20px;
            min-width: 1000px !important;
        }
    }
</style>

@endsection

@php
    function formatMarketCap($value) {
        if ($value >= 1000000000) {
            return round($value / 1000000000, 2) . 'B';
        } elseif ($value >= 1000000) {
            return round($value / 1000000, 2) . 'M';
        } elseif ($value >= 1000) {
            return round($value / 1000, 2) . 'K';
        }
        return $value;
    }
@endphp

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
@include('partials.users.alert')
    <div class="container-fluid">
        <!-- End::page-header -->
        <div class="mt-3 stock-scrol">
            <div class="tradingview-widget-container">
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                        "symbols": [
                            {
                            "description": "",
                            "proName": "BITSTAMP:BTCUSD"
                            },
                            {
                            "description": "",
                            "proName": "COINBASE:ETHUSD"
                            },
                            {
                            "description": "",
                            "proName": "COINBASE:SOLUSD"
                            },
                            {
                            "description": "",
                            "proName": "BINANCE:ADAUSD"
                            },
                            {
                            "description": "",
                            "proName": "BITSTAMP:XRPUSD"
                            },
                            {
                            "description": "",
                            "proName": "BINANCE:HMSTRUSD"
                            },
                            {
                            "description": "",
                            "proName": "BINANCE:DOGSUSD"
                            }
                        ],
                        "showSymbolLogo": true,
                        "isTransparent": false,
                        "displayMode": "adaptive",
                        "colorTheme": "light",
                        "locale": "en"
                    }
                </script>
            </div>
        </div>
        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xl-12 mt-4">
            <div class="row">
                    <div class="col-xxl-4 col-md-4 col-sm-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="lh-1">
                                        <div class="avatar avatar-md  bg-primary-transparent">
                                            <div class="avatar avatar-sm  bg-primary  svg-white">
                                                <i class="fe fe-tag mx-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fw-medium fs-14">Trading</span>
                                        <span class="d-block text-muted fs-12">Wallet balance</span>
                                    </div>
                                    <!-- <div class="text-end">
                                        <span class="fs-12 text-muted">Apple</span>
                                        <span class="text-primary fs-12 d-block">+0.28%</span>
                                    </div> -->
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fs-11 text-muted">Amount</span>
                                        <span class="fs-20  fw-semibold d-block">${{ number_format($balance, 2) }}</span>
                                    </div>
                                    <div id="apple-stock-chart"></div>
                                </div>
                                <div class="mt-1">
                                    <a href="javascript:void(0);" class="py-2 fs-11 text-primary fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openTradingModal">Top Up Wallet <i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    <div class="lh-1">
                                        <div class="avatar avatar-md  bg-primary-transparent">
                                            <div class="avatar avatar-sm  bg-primary  svg-white">
                                                <i class="fe fe-tag mx-2"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fw-medium fs-14">Asset</span>
                                        <span class="d-block text-muted fs-12">Asset Holdings</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-success fs-12 d-block">{{ $tradeCount }}</span>
                                        <span class="fs-12 text-muted">Asset</span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div>
                                        <span class="fs-11 text-muted">Amount</span>
                                        <span class="fs-20 fw-semibold d-block">${{ number_format($totalStocks, 2) }}</span>
                                    </div>
                                    <!-- <div id="nvidia-stock"></div> -->
                                </div>
                                <div class="mt-1">
                                    <a href="{{ route('crypto.assets') }}" class="py-2 fs-11 text-primary fw-semibold">View Assets<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-md-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <!-- TradingView Widget BEGIN -->
                                <div class="tradingview-widget-container">
                                    <div class="tradingview-widget-container__widget" style="border: none;"></div>
                                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-mini-symbol-overview.js" async>
                                        {
                                            "symbol": "SOL",
                                            "width": "100%",
                                            "height": "130",
                                            "locale": "en",
                                            "dateRange": "12M",
                                            "colorTheme": "light",
                                            "isTransparent": false,
                                            "autosize": false,
                                            "largeChartUrl": ""
                                        }
                                    </script>
                                </div>
                                <!-- TradingView Widget END -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12">
            <div class="d-flex align-items-center justify-content-between">
                <div class="swiper swiper-basic">
                    <div class="swiper-wrapper">
                        @foreach ($slidesData as $slide)
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-{{ $slide['colorClass'] }}-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm rounded-circle bg-dark bg-opacity-25 border border-white p-2">
                                                        <img src="{{ $slide['icon'] }}" alt="{{ $slide['icon'] }}">
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 100px;" title="{{ $slide['name'] }}">
                                                        {{ $slide['name'] }}
                                                    </span>
                                                    <span class="d-block fs-12 fw-bold">{{ $slide['price'] }}</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="{{ strpos($slide['percentageChange'], '-') !== false ? 'text-danger' : 'text-success' }} d-block">
                                                    {{ $slide['percentageChange'] }}
                                                    <i class="ti {{ $slide['changeDirection'] }}"></i>
                                                </span>
                                                <span class="text-{{ $slide['colorClass'] }} d-block fs-10">{{ $slide['changeAmount'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        <!-- Stock Cards -->

        {{-- <h4 class="mb-3">Stocks</h4>
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 bg-success-transparent border">
                            <div class="d-flex flex-fill align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-sm bg-success p-2">
                                        <i class="bi bi-apple fs-18"></i>
                                    </span>
                                </div>
                                <div class="lh-1">
                                    <span class="d-block mb-2 text-default fw-medium">Apple</span>
                                    <span class="d-block fs-12">$12,289.44</span>
                                </div>
                            </div>
                            <div class="fs-12 text-end">
                                <span class="text-success d-block">0.14%<i class="ti ti-arrow-bear-right"></i></span>
                                <span class="d-block text-success">+$1,780.80</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-secondary-transparent">
                            <div class="d-flex flex-fill align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-sm bg-secondary p-2">
                                        <i class="bi bi-currency-bitcoin fs-18"></i>
                                    </span>
                                </div>
                                <div class="lh-1">
                                    <span class="d-block mb-2 text-default fw-medium">Bitcoin</span>
                                    <span class="d-block fs-12">$58,151.02</span>
                                </div>
                            </div>
                            <div class="fs-12 text-end">
                                <span class="text-success d-block">2.14%<i class="ti ti-arrow-bear-right"></i></span>
                                <span class="d-block text-success">+$5,745.62</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-info-transparent">
                            <div class="d-flex flex-fill align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-sm bg-info p-2">
                                        <i class="bi bi-card-list fs-18"></i>
                                    </span>
                                </div>
                                <div class="lh-1">
                                    <span class="d-block mb-2 text-default fw-medium">Tesla</span>
                                    <span class="d-block fs-12">$14,452.36</span>
                                </div>
                            </div>
                            <div class="fs-12 text-end">
                                <span class="text-danger d-block">4.02%<i class="ti ti-arrow-bear-right"></i></span>
                                <span class="d-block text-info">+$4,125.63</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="swiper-slide">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex flex-wrap align-items-center justify-content-between p-3 border rounded bg-dark-transparent">
                            <div class="d-flex flex-fill align-items-center">
                                <div class="me-2">
                                    <span class="avatar avatar-sm bg-dark p-2">
                                        <i class="bi bi-gift fs-18"></i>
                                    </span>
                                </div>
                                <div class="lh-1">
                                    <span class="d-block mb-2 text-default fw-medium">Amazon</span>
                                    <span class="d-block fs-12">$63,251.11</span>
                                </div>
                            </div>
                            <div class="fs-12 text-end">
                                <span class="text-success d-block">5.14%<i class="ti ti-arrow-bear-right"></i></span>
                                <span class="d-block text-dark">+$936.30</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div> --}}
        <!-- End:: row-1 -->

        <!-- Start:: row-3 -->
        <div class="row">
            <div class="col-xl-9" style="height: 580px;">
                <div class="tradingview-widget-container" style="height: max-content;">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
                        { 
                            "symbols": [
                                [
                                "Bitcoin",
                                "BTCUSD|1D"
                                ],
                                [
                                "Ethereum",
                                "ETHUSD|1D"
                                ],
                                [
                                "Litecoin",
                                "LTCUSD|1D"
                                ],
                                [
                                "Trons",
                                "TRXUSD|1D"
                                ]
                            ],
                            "chartOnly": false,
                            "width": "100%",
                            "height": "95%",
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
                        }
                    </script>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-6">
                        <div class="card custom-card">
                            <!-- TradingView Widget BEGIN -->
                            <div class="tradingview-widget-container">
                            <div class="tradingview-widget-container__widget"></div>
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-overview.js" async>
                                    {
                                        "colorTheme": "light",
                                        "dateRange": "1M",
                                        "showChart": true,
                                        "locale": "en",
                                        "largeChartUrl": "",
                                        "isTransparent": false,
                                        "showSymbolLogo": true,
                                        "showFloatingTooltip": false,
                                        "width": "100%",
                                        "height": "550",
                                        "plotLineColorGrowing": "rgba(152, 0, 255, 1)",
                                        "plotLineColorFalling": "rgba(152, 0, 255, 1)",
                                        "gridLineColor": "rgba(42, 46, 57, 0)",
                                        "scaleFontColor": "rgba(19, 23, 34, 1)",
                                        "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
                                        "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
                                        "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
                                        "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
                                        "symbolActiveColor": "rgba(41, 98, 255, 0.12)",
                                        "tabs": [
                                            {
                                            "title": "Crypto",
                                            "symbols": [
                                                {
                                                "s": "BITSTAMP:BTCUSD"
                                                },
                                                {
                                                "s": "BINANCE:ETHUSDT"
                                                },
                                                {
                                                "s": "COINBASE:SOLUSD"
                                                },
                                                {
                                                "s": "BINANCE:SUIUSDT"
                                                },
                                                {
                                                "s": "BINANCE:PEPEUSDT"
                                                },
                                                {
                                                "s": "BINANCE:ADAUSDT"
                                                },
                                                {
                                                "s": "BINANCE:ADAUSDT"
                                                }
                                            ]
                                            },
                                            {
                                            "title": "Future",
                                            "symbols": [
                                                {
                                                "s": "CME_MINI:NQ1!"
                                                },
                                                {
                                                "s": "CME_MINI:ES1!"
                                                },
                                                {
                                                "s": "CME_MINI:MES1!"
                                                },
                                                {
                                                "s": "NSE:BANKNIFTY1!"
                                                },
                                                {
                                                "s": "CME:6B1!"
                                                },
                                                {
                                                "s": "CME:6B1!"
                                                },
                                                {
                                                "s": "NYMEX:NG1!"
                                                }
                                            ]
                                            }
                                        ]
                                    }
                                </script>
                            </div>
                            <!-- TradingView Widget END -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-3 -->

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Available Assets
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <form action="{{ route('crypto') }}" method="GET" class="d-flex align-items-center gap-2">
                                <div class="input-group">
                                    <!-- The search input will retain the previous search query if it exists -->
                                    <input 
                                        name="search" 
                                        class="form-control form-control-sm" 
                                        type="text" 
                                        placeholder="Search Here" 
                                        value="{{ request()->get('search') }}"
                                        aria-label="Search"
                                    >
                                    <button type="submit" class="btn btn-primary btn-sm">Search</button>
                                    <a href="{{ route('crypto') }}" class="btn btn-info-transparent btn-sm">Reset</a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Market Cap</th>
                                        <th scope="col">Change</th>
                                        <th scope="col">Change(%)</th>
                                        <th scope="col">Volume</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stocks as $key => $stock)

                                    <tr style="cursor: pointer;">
                                        <td onclick="window.location='{{ route('crypto.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">
                                            <div class="d-flex align-items-start gap-3">
                                                <span class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                    <img src="{{ $stock->img }}" alt="" class="invert-1 bg-dark bg-opacity-25">
                                                </span>
                                                <div class="flex-fill lh-1">
                                                <a href="javascript:void(0);" class="d-block mb-1 fs-14 fw-medium">{{ $stock->name }}</a>
                                                    <span class="d-block fs-12 text-muted">{{ $stock->symbol }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td onclick="window.location='{{ route('crypto.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">${{ number_format($stock->price, 2) }}</td>
                                        <td onclick="window.location='{{ route('crypto.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">${{ formatMarketCap($stock->market_cap) }}</td>
                                        <td>
                                            <span class="badge {{ $stock->change < 0 ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                                {{ $stock->change }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $stock->changes_percentage < 0 ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                                {{ number_format($stock->changes_percentage, 2) }}%
                                            </span>
                                        </td>
                                        <td>{{ formatMarketCap($stock->volume) }}</td>
                                        <td>
                                            <button class="btn bg-success-transparent text-success btn-wave waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $stock->id }}buy">
                                                BUY
                                            </button>
                                            <!-- <button class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $stock->id }}sell">
                                                SELL
                                            </button> -->
                                            <a href="{{ route('asset.view', $stock->id) }}" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light">
                                                SELL
                                            </a>
                                        </td>
                                    </tr>

                                    <div class="modal fade" id="exampleModal{{ $stock->id }}buy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content" style="height: 600px; max-width: 650px !important;">
                                                <div class="modal-body p-2" style="height: 100%;">
                                                    <div id="tradingview-widget-{{ $stock->id }}" style="height: 55%;"></div>
                                                    <div class="">
                                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                                            <div class="flex-grow-1 my-1">
                                                                <div class="card custom-card overflow-hidden">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                            <div class="px-3 py-4">
                                                                                <div>
                                                                                    <span class="d-block mb-1 fs-12 text-muted">Amount</span>
                                                                                    <h5 class="fw-bold fs-24 mb-1">$<span id="wallet-price-{{ $key }}">0.00</span></h5>
                                                                                    <span class="text-muted fs-12">
                                                                                        Lot Size: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="quantity-display-{{ $key }}">0.00 Units</span>
                                                                                    </span>
                                                                                </div>
                                                                            </div> 
                                                                        </div>
                                                                        <div class="text-end" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                            <div class="px-3 py-4">
                                                                                <span class="d-block mb-1 fs-12 text-muted">Coin Price</span>
                                                                                <h5 class="fw-bold fs-24 mb-1">${{ number_format($stock->price, 2) }}</h5>
                                                                                <span class="fs-12 text-muted">
                                                                                    Today 
                                                                                    <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-14 fw-bold ms-1 d-inline-block">
                                                                                        <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                        {{ number_format($stock->changes_percentage, 2) }}%
                                                                                    </span>
                                                                                </span>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Form for Stock Purchase -->
                                                    <form action="{{ route('trade.crypto') }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-6 text-center">
                                                                <label class="text-muted fs-12" for="quantity-input-{{ $key }}">Lots</label>
                                                                <div class="input-group my-1">
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                                                    <input type="number" name="lots" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="0.00" aria-label="Stock Quantity" value="0.0000" data-key="{{ $key }}" data-price="{{ $stock->price }}" min="0.0001" step="0.0001" required>
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 5px 5px 0px;">+</button>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 text-center">
                                                                <label class="text-muted fs-12" for="amount-input-{{ $key }}">Amount</label>
                                                                <div class="input-group my-1">
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave" style="border-radius: 5px 0px 0px 5px;">$</button>
                                                                    <input type="number" name="amountX" class="form-control text-center amount-input" id="amount-input-{{ $key }}" placeholder="0.0000" aria-label="Stock Amount" value="0.00" data-key="{{ $key }}" data-price="{{ $stock->price }}" min="0.0000000000" step="0.000000001" required>
                                                                    <!-- Optional button for amount -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden Inputs -->
                                                        <div>
                                                            <input type="hidden" name="crypto_id" value="{{ $stock->id }}">
                                                            <input type="hidden" name="crypto_symbol" value="{{ $stock->symbol }}">
                                                            <input type="hidden" name="amount" value="{{ $stock->price }}">
                                                            <input type="hidden" name="type" value="buy">
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <button class="my-1 btn btn-wave btn-md btn-success waves-effect waves-light w-100" type="submit">
                                                            BUY <i class="ri-arrow-right-line align-middle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="modal fade" id="exampleModal{{ $stock->id }}sell" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content" style="height: 600px; max-width: 650px !important;">
                                                <div class="modal-body p-2" style="height: 100%;">
                                                    <div id="tradingview-widget-{{ $stock->id }}sell" style="height: 55%;"></div>
                                                    <div class="">
                                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                                            <div class="flex-grow-1 my-1">
                                                                <div class="card custom-card overflow-hidden">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                            <div class="px-3 py-4">
                                                                                <div>
                                                                                    <span class="d-block mb-1 fs-12 text-muted">Sale</span>
                                                                                    <h5 class="fw-bold fs-24 mb-1">$<span id="sell-wallet-price-{{ $key }}">0.00</span></h5>
                                                                                    <span class="text-muted fs-12">
                                                                                        Quantity: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="sell-quantity-display-{{ $key }}">0.00 Units</span>
                                                                                    </span>
                                                                                </div>
                                                                            </div> 
                                                                        </div>
                                                                        <div class="text-end" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                            <div class="px-3 py-4">
                                                                                <span class="d-block mb-1 fs-12 text-muted">Stock Price</span>
                                                                                <h5 class="fw-bold fs-24 mb-1">${{ number_format($stock->price, 2) }}</h5>
                                                                                <span class="fs-12 text-muted">
                                                                                    Today 
                                                                                    <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-14 fw-bold ms-1 d-inline-block">
                                                                                        <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                        {{ number_format($stock->changes_percentage, 2) }}%
                                                                                    </span>
                                                                                </span>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Form for Stock Sale -->
                                                    <form action="{{ route('trade.stock') }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-6 text-center">
                                                                <label class="text-muted fs-12" for="sell-quantity-input-{{ $key }}">Quantity</label>
                                                                <div class="input-group my-1">
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                                                    <input type="number" name="quantity" class="form-control text-center sell-quantity-input" id="sell-quantity-input-{{ $key }}" placeholder="0.00" aria-label="Stock Quantity" value="0.0000" data-key="{{ $key }}" data-price="{{ $stock->price }}" min="0.0001" step="0.0001" required>
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-increment-btn" style="border-radius: 0px 5px 5px 0px;">+</button>
                                                                </div>
                                                            </div>

                                                            <div class="col-6 text-center">
                                                                <label class="text-muted fs-12" for="sell-amount-input-{{ $key }}">Amount</label>
                                                                <div class="input-group my-1">
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave" style="border-radius: 5px 0px 0px 5px;">$</button>
                                                                    <input type="number" name="amountX" class="form-control text-center sell-amount-input" id="sell-amount-input-{{ $key }}" placeholder="0.00" aria-label="Stock Amount" value="0.00" data-key="{{ $key }}" data-price="{{ $stock->price }}" min="0.00" step="0.0001" required>
                                                                    <!-- Optional button for amount -->
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Hidden Inputs -->
                                                        <div>
                                                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                                            <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                                                            <input type="hidden" name="amount" value="{{ $stock->price }}">
                                                            <input type="hidden" name="type" value="sell">
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <button class="my-1 btn btn-wave btn-md btn-danger waves-effect waves-light w-100" type="submit">
                                                            SELL NOW <i class="ri-arrow-right-line align-middle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            $('#exampleModal{{ $stock->id }}buy').on('shown.bs.modal', function() {
                                                var widgetContainer = document.getElementById('tradingview-widget-{{ $stock->id }}');

                                                if (!widgetContainer.dataset.loaded) { // Check if the widget is already loaded
                                                    widgetContainer.dataset.loaded = true; // Mark as loaded to prevent reloading

                                                    var script = document.createElement('script');
                                                    script.type = 'text/javascript';
                                                    script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js';
                                                    script.async = true;

                                                    script.innerHTML = JSON.stringify({
                                                        "symbols": [
                                                            ["{{ $stock->name }}", "{{ $stock->symbol }}|1M"]
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
                                            $('#exampleModal{{ $stock->id }}sell').on('shown.bs.modal', function() {
                                                var widgetContainer = document.getElementById('tradingview-widget-{{ $stock->id }}sell');

                                                if (!widgetContainer.dataset.loaded) { // Check if the widget is already loaded
                                                    widgetContainer.dataset.loaded = true; // Mark as loaded to prevent reloading

                                                    var script = document.createElement('script');
                                                    script.type = 'text/javascript';
                                                    script.src = 'https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js';
                                                    script.async = true;

                                                    script.innerHTML = JSON.stringify({
                                                        "symbols": [
                                                            ["{{ $stock->name }}", "{{ $stock->symbol }}|1M"]
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
                        </div>
                    </div>
                    <div class="card-footer border-top-0">
                        <div class="d-flex align-items-center">
                            <!-- <div> Showing {{ $stocks->count() }} of {{ $stocks->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div> -->
                            <div class="ms-auto">
                                <nav aria-label="Page navigation" class="pagination-style-4">
                                    {{ $stocks->links() }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include('partials.users.modal.topup')
                    
    </div>
</div>
<!-- End::app-content -->

@endsection

@section('scripts')

<script type="text/javascript" src="https://s3.tradingview.com/tv.js"></script>

<!-- Apex Charts JS -->
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Swiper JS -->
<script src="{{ asset('asset/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Stocks Dashboard -->
<script src="{{ asset('asset/js/stocks-dashboard.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('asset/js/custom.js') }}"></script>

<script> 
$(document).ready(function() {
    // Function to update wallet price and quantity display
    function updateWalletPriceAndQuantity(key) {
        const $quantityInput = $('#quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0; // Default to 0 if empty
        const totalPrice = pricePerUnit * quantity;

        $('#wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }));
        $('#quantity-display-' + key).text(`${parseFloat(quantity).toFixed(4)} Unit${quantity <= 1 ? 's' : ''}`);
    }

    function updateAmountInput(key) {
        const $quantityInput = $('#quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0;
        const totalPrice = pricePerUnit * quantity;

        $('#amount-input-' + key).val(parseFloat(totalPrice.toFixed(4)));
    }

    // Function to update quantity based on amount
    function updateQuantityFromAmount(key) {
        const $amountInput = $('#amount-input-' + key);
        const pricePerUnit = parseFloat($amountInput.data('price'));
        const amount = parseFloat($amountInput.val()) || 0; // Default to 0 if empty
        const quantity = amount / pricePerUnit;

        $('#quantity-input-' + key).val(quantity.toFixed(4));
        updateWalletPriceAndQuantity(key);
    }

    // Handle input change for amount
    $('.amount-input').on('input', function() {
        const key = $(this).data('key');
        updateQuantityFromAmount(key);
    });

    // Handle input change for quantity manually
    $('.quantity-input').on('input', function() {
        const key = $(this).data('key');
        updateWalletPriceAndQuantity(key);
        updateAmountInput(key);
    });

    // Handle increment button click for quantity
    $('.increment-btn').click(function() {
        const $quantityInput = $(this).siblings('.quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const newValue = (currentValue + step).toFixed(4); // Ensure 4 decimal places

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');
        updateWalletPriceAndQuantity(key);
        // Also update the amount field based on the new quantity
        updateWalletPriceAndQuantity(key); // Update amount
        updateAmountInput(key);
    });

    // Handle decrement button click for quantity
    $('.decrement-btn').click(function() {
        const $quantityInput = $(this).siblings('.quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const minValue = parseFloat($quantityInput.attr('min')) || 0; // Minimum value is 0
        let newValue = (currentValue - step).toFixed(4);

        if (newValue >= minValue) {
            $quantityInput.val(newValue);
            const key = $quantityInput.data('key');
            updateWalletPriceAndQuantity(key);
            // Also update the amount field based on the new quantity
            updateWalletPriceAndQuantity(key); // Update amount
            updateAmountInput(key);
        }
    });
});

$(document).ready(function() {
    // Function to update wallet price and quantity display for sell trade
    function updateSellWalletPriceAndQuantity(key) {
        const $quantityInput = $('#sell-quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0; // Default to 0 if empty
        const totalPrice = pricePerUnit * quantity;

        $('#sell-wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }));
        $('#sell-quantity-display-' + key).text(`${parseFloat(quantity).toFixed(4)} Unit${quantity <= 1 ? 's' : ''}`);
    }

    function updateAmountInput(key) {
        const $quantityInput = $('#sell-quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0;
        const totalPrice = pricePerUnit * quantity;

        $('#sell-amount-input-' + key).val(parseFloat(totalPrice.toFixed(4)));
    }

    // Function to update quantity based on amount for sell trade
    function updateSellQuantityFromAmount(key) {
        const $amountInput = $('#sell-amount-input-' + key);
        const pricePerUnit = parseFloat($amountInput.data('price'));
        const amount = parseFloat($amountInput.val()) || 0; // Default to 0 if empty
        const quantity = amount / pricePerUnit;

        $('#sell-quantity-input-' + key).val(quantity.toFixed(4));
        updateSellWalletPriceAndQuantity(key);
    }

    // Handle input change for amount in sell trade
    $('.sell-amount-input').on('input', function() {
        const key = $(this).data('key');
        updateSellQuantityFromAmount(key);
    });

    // Handle input change for quantity manually in sell trade
    $('.sell-quantity-input').on('input', function() {
        const key = $(this).data('key');
        updateSellWalletPriceAndQuantity(key);
        updateAmountInput(key);
    });

    // Handle increment button click for quantity in sell trade
    $('.sell-increment-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const newValue = (currentValue + step).toFixed(4); // Ensure 4 decimal places

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');
        updateSellWalletPriceAndQuantity(key);
        // Also update the amount field based on the new quantity
        updateSellWalletPriceAndQuantity(key); // Update amount
        updateAmountInput(key);
    });

    // Handle decrement button click for quantity in sell trade
    $('.sell-decrement-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const minValue = parseFloat($quantityInput.attr('min')) || 0; // Minimum value is 0
        let newValue = (currentValue - step).toFixed(4);

        if (newValue >= minValue) {
            $quantityInput.val(newValue);
            const key = $quantityInput.data('key');
            updateSellWalletPriceAndQuantity(key);
            // Also update the amount field based on the new quantity
            updateSellWalletPriceAndQuantity(key); // Update amount
            updateAmountInput(key);
        }
    });
});

</script>

@endsection