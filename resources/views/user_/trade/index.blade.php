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
        <div class="mt-3">
            <div class="tradingview-widget-container">
                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-ticker-tape.js" async>
                    {
                        "symbols": [
                            {
                            "description": "",
                            "proName": "NASDAQ:NVDA"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:TSLA"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:AAPL"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:AMZN"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:META"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:AMD"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:MSFT"
                            },
                            {
                            "description": "",
                            "proName": "NYSE:BABA"
                            },
                            {
                            "description": "",
                            "proName": "NYSE:PLTR"
                            },
                            {
                            "description": "",
                            "proName": "NASDAQ:NFLX"
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
                                        <span class="d-block fw-medium fs-14">Stocks</span>
                                        <span class="d-block text-muted fs-12">Stock Holdings</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="text-success fs-12 d-block">{{ $tradeCount }}</span>
                                        <span class="fs-12 text-muted">Stocks</span>
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
                                    <a href="{{ route('assets') }}" class="py-2 fs-11 text-primary fw-semibold">View Holdings<i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
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
                                            "symbol": "NASDAQ:TSLA",
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
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-primary-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-primary p-2">
                                                        <i class="bi bi-people fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">Microsoft</span>
                                                    <span class="d-block fs-12">$304.25</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-success d-block">1.76%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-success">+$5.25</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-warning-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-warning p-2">
                                                        <i class="bi bi-bag fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">NVIDIA</span>
                                                    <span class="d-block fs-12">$219.87</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-danger d-block">2.45%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-danger">-$5.56</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-danger-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-danger p-2">
                                                        <i class="bi bi-heart fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">Pfizer</span>
                                                    <span class="d-block fs-12">$43.25</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-danger d-block">3.00%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-danger">-$1.34</span>
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
                                                        <i class="bi bi-geo-alt fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">Walmart</span>
                                                    <span class="d-block fs-12">$153.50</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-success d-block">0.75%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-success">+$1.15</span>
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
                                                        <i class="bi bi-soundwave fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">Intel</span>
                                                    <span class="d-block fs-12">$30.18</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-danger d-block">1.20%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-danger">-$0.36</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-dark-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-dark p-2">
                                                        <i class="bi bi-mic fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span class="d-block mb-2 text-default fw-medium">Coca-Cola</span>
                                                    <span class="d-block fs-12">$63.10</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-success d-block">0.85%<i class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-success">+$0.53</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                "Apple",
                                "AAPL|1D"
                                ],
                                [
                                "Google",
                                "GOOGL|1D"
                                ],
                                [
                                "Microsoft",
                                "MSFT|1D"
                                ],
                                [
                                "NASDAQ:NVDA|1D"
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
                                <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-hotlists.js" async>
                                    {
                                        "colorTheme": "light",
                                        "dateRange": "1M",
                                        "exchange": "US",
                                        "showChart": true,
                                        "locale": "en",
                                        "largeChartUrl": "",
                                        "isTransparent": false,
                                        "showSymbolLogo": false,
                                        "showFloatingTooltip": false,
                                        "width": "100%",
                                        "height": "550",
                                        "plotLineColorGrowing": "rgba(201, 10, 255, 1)",
                                        "plotLineColorFalling": "rgba(201, 10, 255, 1)",
                                        "gridLineColor": "rgba(42, 46, 57, 0)",
                                        "scaleFontColor": "rgba(19, 23, 34, 1)",
                                        "belowLineFillColorGrowing": "rgba(41, 98, 255, 0.12)",
                                        "belowLineFillColorFalling": "rgba(41, 98, 255, 0.12)",
                                        "belowLineFillColorGrowingBottom": "rgba(41, 98, 255, 0)",
                                        "belowLineFillColorFallingBottom": "rgba(41, 98, 255, 0)",
                                        "symbolActiveColor": "rgba(41, 98, 255, 0.12)"
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

        {{-- <div class="row">
            <div class="col-xl-9" style="height: 485px;">
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-market-quotes.js" async>
                        {
                            "width": "100%",
                            "height": "95%",
                            "symbolsGroups": [
                                {
                                    "name": "Crestwood Stock",
                                    "symbols": [
                                        {
                                            "name": "NASDAQ:AAPL",
                                            "displayName": "Apple Inc."
                                        },
                                        {
                                            "name": "NASDAQ:MSFT",
                                            "displayName": "Microsoft Corporation"
                                        },
                                        {
                                            "name": "NASDAQ:GOOG",
                                            "displayName": "Alphabet Inc. (Google)"
                                        },
                                        {
                                            "name": "NASDAQ:AMZN",
                                            "displayName": "Amazon.com, Inc."
                                        },
                                        {
                                            "name": "NASDAQ:TSLA",
                                            "displayName": "Tesla, Inc."
                                        },
                                        {
                                            "name": "NASDAQ:NVDA",
                                            "displayName": "NVIDIA Corporation"
                                        },
                                        {
                                            "name": "NASDAQ:META",
                                            "displayName": "Meta Platforms, Inc."
                                        },
                                        {
                                            "name": "NYSE:BRK.B",
                                            "displayName": "Berkshire Hathaway Inc."
                                        },
                                        {
                                            "name": "NASDAQ:CRWD",
                                            "displayName": "CrowdStrike Holdings, Inc."
                                        },
                                        {
                                            "name": "NYSE:TSM",
                                            "displayName": "Taiwan Semiconductor Manufacturing Company Limited"
                                        },
                                        {
                                            "name": "NASDAQ:AMD",
                                            "displayName": "Advanced Micro Devices, Inc."
                                        },
                                        {
                                            "name": "NASDAQ:SOFI",
                                            "displayName": "SoFi Technologies, Inc."
                                        },
                                        {
                                            "name": "NYSE:NKE",
                                            "displayName": "Nike, Inc."
                                        },
                                        {
                                            "name": "NYSE:V",
                                            "displayName": "Visa Inc."
                                        },
                                        {
                                            "name": "NYSE:JPM",
                                            "displayName": "JPMorgan Chase & Co."
                                        },
                                        {
                                            "name": "NASDAQ:ARM",
                                            "displayName": "Arm Holdings plc"
                                        },
                                        {
                                            "name": "NASDAQ:PYPL",
                                            "displayName": "PayPal Holdings, Inc."
                                        },
                                        {
                                            "name": "NASDAQ:INTC",
                                            "displayName": "Intel Corporation"
                                        },
                                        {
                                            "name": "NASDAQ:ADBE",
                                            "displayName": "Adobe Inc."
                                        },
                                        {
                                            "name": "NASDAQ:CSCO",
                                            "displayName": "Cisco Systems, Inc."
                                        },
                                        {
                                            "name": "NASDAQ:SBUX",
                                            "displayName": "Starbucks Corporation"
                                        },
                                        {
                                            "name": "NASDAQ:QCOM",
                                            "displayName": "Qualcomm Incorporated"
                                        },
                                        {
                                            "name": "NYSE:BABA",
                                            "displayName": "Alibaba Group Holding Limited"
                                        },
                                        {
                                            "name": "NASDAQ:ORCL",
                                            "displayName": "Oracle Corporation"
                                        }
                                    ]
                                }
                            ],
                            "showSymbolLogo": true,
                            "isTransparent": false,
                            "colorTheme": "light",
                            "locale": "en",
                            "backgroundColor": "#ffffff"
                        }
                    </script>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">My Watchlist</div>
                        <a href="javascript:void(0);" class="fs-12 text-muted py-1 tag-link"> View All<i class="ti ti-arrow-narrow-right ms-1"></i> </a>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled watchlist-list mb-0">
                            <li>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-primary avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M208,216H160L48,40H96Z" opacity="0.2"></path>
                                                    <path d="M214.75,211.71l-62.6-98.38,61.77-67.95a8,8,0,0,0-11.84-10.76L143.24,99.34,102.75,35.71A8,8,0,0,0,96,32H48a8,8,0,0,0-6.75,12.3l62.6,98.37-61.77,68a8,8,0,1,0,11.84,10.76l58.84-64.72,40.49,63.63A8,8,0,0,0,160,224h48a8,8,0,0,0,6.75-12.29ZM164.39,208,62.57,48h29L193.43,208Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">TTR</span>
                                        <span class="d-block text-muted fs-12">Twiter.com, Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$234.24</span>
                                        <span class="text-danger fs-12">-0.28%</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-secondary avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M208,104v8a48,48,0,0,1-48,48H136a32,32,0,0,1,32,32v40H104V192a32,32,0,0,1,32-32H112a48,48,0,0,1-48-48v-8a49.28,49.28,0,0,1,8.51-27.3A51.92,51.92,0,0,1,76,32a52,52,0,0,1,43.83,24h32.34A52,52,0,0,1,196,32a51.92,51.92,0,0,1,3.49,44.7A49.28,49.28,0,0,1,208,104Z" opacity="0.2"></path>
                                                    <path d="M208.3,75.68A59.74,59.74,0,0,0,202.93,28,8,8,0,0,0,196,24a59.75,59.75,0,0,0-48,24H124A59.75,59.75,0,0,0,76,24a8,8,0,0,0-6.93,4,59.78,59.78,0,0,0-5.38,47.68A58.14,58.14,0,0,0,56,104v8a56.06,56.06,0,0,0,48.44,55.47A39.8,39.8,0,0,0,96,192v8H72a24,24,0,0,1-24-24A40,40,0,0,0,8,136a8,8,0,0,0,0,16,24,24,0,0,1,24,24,40,40,0,0,0,40,40H96v16a8,8,0,0,0,16,0V192a24,24,0,0,1,48,0v40a8,8,0,0,0,16,0V192a39.8,39.8,0,0,0-8.44-24.53A56.06,56.06,0,0,0,216,112v-8A58,58,0,0,0,208.3,75.68ZM200,112a40,40,0,0,1-40,40H112a40,40,0,0,1-40-40v-8a41.74,41.74,0,0,1,6.9-22.48A8,8,0,0,0,80,73.83a43.81,43.81,0,0,1,.79-33.58,43.88,43.88,0,0,1,32.32,20.06A8,8,0,0,0,119.82,64h32.35a8,8,0,0,0,6.74-3.69,43.87,43.87,0,0,1,32.32-20.06A43.81,43.81,0,0,1,192,73.83a8.09,8.09,0,0,0,1,7.65A41.76,41.76,0,0,1,200,104Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">GTHB</span>
                                        <span class="d-block text-muted fs-12">Gituhb, Demo Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$345.53</span>
                                        <span class="text-success fs-12">+0.56%</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-success avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M128,144h80v72l-80-14.55ZM32,184l64,11.64V144H32ZM128,54.55V112h80V40ZM32,112H96V60.36L32,72Z" opacity="0.2"></path>
                                                    <path d="M208,136H128a8,8,0,0,0-8,8v57.45a8,8,0,0,0,6.57,7.88l80,14.54A7.61,7.61,0,0,0,208,224a8,8,0,0,0,8-8V144A8,8,0,0,0,208,136Zm-8,70.41-64-11.63V152h64ZM96,136H32a8,8,0,0,0-8,8v40a8,8,0,0,0,6.57,7.87l64,11.64a8.54,8.54,0,0,0,1.43.13,8,8,0,0,0,8-8V144A8,8,0,0,0,96,136Zm-8,50.05-48-8.73V152H88ZM213.13,33.86a8,8,0,0,0-6.56-1.73l-80,14.55A8,8,0,0,0,120,54.55V112a8,8,0,0,0,8,8h80a8,8,0,0,0,8-8V40A8,8,0,0,0,213.13,33.86ZM200,104H136V61.22l64-11.63ZM101.13,54.22a8,8,0,0,0-6.56-1.73l-64,11.64A8,8,0,0,0,24,72v40a8,8,0,0,0,8,8H96a8,8,0,0,0,8-8V60.36A8,8,0,0,0,101.13,54.22ZM88,104H40V78.68L88,70Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">
                                            MS</span>
                                        <span class="d-block text-muted fs-12">Micorsoft, Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$1,233.67</span>
                                        <span class="text-success fs-12">+1.98%</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-warning avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M200,160a40,40,0,0,1-40,40H88V48h60a36,36,0,0,1,0,72h12A40,40,0,0,1,200,160Z" opacity="0.2"></path>
                                                    <path d="M178.48,115.7A44,44,0,0,0,152,40.19V24a8,8,0,0,0-16,0V40H120V24a8,8,0,0,0-16,0V40H72a8,8,0,0,0,0,16h8V192H72a8,8,0,0,0,0,16h32v16a8,8,0,0,0,16,0V208h16v16a8,8,0,0,0,16,0V208h8a48,48,0,0,0,18.48-92.3ZM96,56h52a28,28,0,0,1,0,56H96Zm64,136H96V128h64a32,32,0,0,1,0,64Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">
                                            Bitcoin</span>
                                        <span class="d-block text-muted fs-12">Bioset Coin, Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$1,743.18</span>
                                        <span class="text-success fs-12">+0.51%</span>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-info avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M224,128a96,96,0,1,1-96-96A96,96,0,0,1,224,128Z" opacity="0.2"></path>
                                                    <path d="M128,24A104,104,0,1,0,232,128,104.11,104.11,0,0,0,128,24Zm8,191.63V152h24a8,8,0,0,0,0-16H136V112a16,16,0,0,1,16-16h16a8,8,0,0,0,0-16H152a32,32,0,0,0-32,32v24H96a8,8,0,0,0,0,16h24v63.63a88,88,0,1,1,16,0Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">
                                            Facebook</span>
                                        <span class="d-block text-muted fs-12">Facebook, Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$162.63</span>
                                        <span class="text-danger fs-12">-0.15%</span>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-0">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="lh-1">
                                        <span class="avatar avatar-md bg-light p-1">
                                            <span class="avatar avatar-sm bg-danger avatar-rounded svg-white p-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M216,73.52Zm0,99.26c-16.79-11.53-24-30.87-24-52.78,0-18.3,11.68-34.81,24-46.48C204.53,62.66,185,56,168,56a63.72,63.72,0,0,0-40,14h0A63.71,63.71,0,0,0,88.88,56C52,55.5,23.06,86.3,24,123.19a119.62,119.62,0,0,0,37.65,84.12A32,32,0,0,0,83.6,216h87.7a31.75,31.75,0,0,0,23.26-10c15.85-17,21.44-33.2,21.44-33.2Z" opacity="0.2"></path>
                                                    <path d="M223.3,169.59a8.07,8.07,0,0,0-2.8-3.4C203.53,154.53,200,134.64,200,120c0-17.67,13.47-33.06,21.5-40.67a8,8,0,0,0,0-11.62C208.82,55.74,187.82,48,168,48a72.23,72.23,0,0,0-40,12.13,71.56,71.56,0,0,0-90.71,9.09A74.63,74.63,0,0,0,16,123.4a127,127,0,0,0,40.14,89.73A39.8,39.8,0,0,0,83.59,224h87.68a39.84,39.84,0,0,0,29.12-12.57,125,125,0,0,0,17.82-24.6C225.23,174,224.33,172,223.3,169.59Zm-34.63,30.94a23.76,23.76,0,0,1-17.4,7.47H83.59a23.82,23.82,0,0,1-16.44-6.51A111.14,111.14,0,0,1,32,123,58.5,58.5,0,0,1,48.65,80.47,54.81,54.81,0,0,1,88,64h.78A55.45,55.45,0,0,1,123,76.28a8,8,0,0,0,10,0A55.39,55.39,0,0,1,168,64a70.64,70.64,0,0,1,36,10.35c-13,14.52-20,30.47-20,45.65,0,23.77,7.64,42.73,22.18,55.3A105.52,105.52,0,0,1,188.67,200.53ZM128.23,30A40,40,0,0,1,167,0h1a8,8,0,0,1,0,16h-1a24,24,0,0,0-23.24,18,8,8,0,1,1-15.5-4Z">
                                                    </path>
                                                </svg>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex-fill">
                                        <span class="d-block fs-14 fw-medium">
                                            AAPL</span>
                                        <span class="d-block text-muted fs-12">Apple, Inc</span>
                                    </div>
                                    <div class="text-end">
                                        <span class="d-block fs-15 fw-medium">$327.22</span>
                                        <span class="text-success fs-12">+0.60%</span>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Available Stock
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <form action="{{ route('tradings') }}" method="GET" class="d-flex align-items-center gap-2">
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
                                    <a href="{{ route('tradings') }}" class="btn btn-info-transparent btn-sm">Reset</a>
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
                                        <td onclick="window.location='{{ route('trade.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">
                                            <div class="d-flex align-items-start gap-3">
                                                <span class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                    <img src="{{ $stock->img }}" alt="" class="invert-1">
                                                </span>
                                                <div class="flex-fill lh-1">
                                                <a href="javascript:void(0);" class="d-block mb-1 fs-14 fw-medium">{{ $stock->name }}</a>
                                                    <span class="d-block fs-12 text-muted">{{ $stock->symbol }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td onclick="window.location='{{ route('trade.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">${{ $stock->price }}</td>
                                        <td onclick="window.location='{{ route('trade.show', ['stock' => $stock['id'], 'symbol' => $stock['symbol']]) }}';">${{ formatMarketCap($stock->market_cap) }}</td>
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
                                            <a href="{{ route('user.asset', $stock->id) }}" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light">
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
                                                                                    <span class="d-block mb-1 fs-12 text-muted">Purchase</span>
                                                                                    <h5 class="fw-bold fs-24 mb-1">$<span id="wallet-price-{{ $key }}">0.00</span></h5>
                                                                                    <span class="text-muted fs-12">
                                                                                        Quantity: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="quantity-display-{{ $key }}">0.00 Units</span>
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

                                                    <!-- Form for Stock Purchase -->
                                                    <form action="{{ route('trade.stock') }}" method="post">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-6 text-center">
                                                                <label class="text-muted fs-12" for="quantity-input-{{ $key }}">Quantity</label>
                                                                <div class="input-group my-1">
                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                                                    <input type="number" name="quantity" class="form-control text-center quantity-input" id="quantity-input-{{ $key }}" placeholder="0.00" aria-label="Stock Quantity" value="0.0000" data-key="{{ $key }}" data-price="{{ $stock->price }}" min="0.0001" step="0.0001" required>
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
                                                            <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                                                            <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                                                            <input type="hidden" name="amount" value="{{ $stock->price }}">
                                                            <input type="hidden" name="type" value="buy">
                                                        </div>

                                                        <!-- Submit Button -->
                                                        <button class="my-1 btn btn-wave btn-md btn-success waves-effect waves-light w-100" type="submit">
                                                            BUY NOW <i class="ri-arrow-right-line align-middle"></i>
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
                            <div> Showing {{ $stocks->count() }} of {{ $stocks->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
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