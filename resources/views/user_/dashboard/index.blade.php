@extends('layouts.user.index')

<link rel="stylesheet" href="{{ asset('asset/libs/swiper/swiper-bundle.min.css') }}">

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Dashboard</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                        Overview
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div>
            <div class="d-flex gap-4">
                <a href="{{ route('wallet') }}" class="btn btn-primary-light btn-wave waves-effect waves-light">
                    <i class="fe fe-dollar-sign me-2"></i> Wallet
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
            </div>
            <div class="col-xxl-9">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <line x1="96" y1="64" x2="160" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="128" x2="160" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="192" x2="160" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <rect x="40" y="48" width="176" height="160" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($savings, 2) }}</h4>
                                        <span class="text-muted fs-12">Savings Balance
                                            <!-- <span class="text-success ms-2 d-inline-block">0.45% <i class="ti ti-arrow-narrow-up"></i></span> -->
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <polyline points="24 216 112 104 160 144 232 48" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <path d="M232,216H24a8,8,0,0,1-8-8V48a8,8,0,0,1,8-8H232a8,8,0,0,1,8,8v160A8,8,0,0,1,232,216Z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($investment, 2) }}</h4>
                                        <span class="text-muted fs-12">Investment Balance 
                                            <!-- <span class="text-danger ms-2 d-inline-block">-1.32%<i class="ti ti-arrow-narrow-down"></i></span> -->
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-sm-6">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="">
                                    <div class="d-flex justify-content-between">
                                        <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                            <div class="avatar avatar-sm bg-white-transparent svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256">
                                                    <rect width="256" height="256" fill="none" />
                                                    <line x1="96" y1="64" x2="160" y2="64" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="128" x2="160" y2="128" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <line x1="96" y1="192" x2="160" y2="192" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                    <rect x="40" y="48" width="176" height="160" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3">
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($trading, 2) }}</h4>
                                        <span class="text-muted fs-12">Tradning Balance
                                            <!-- <span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span> -->
                                        </span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Activity Stats
                                </div>
                                <!-- <div class="dropdown">
                                    <a href="javascript:void(0);" class="p-2 fs-12 text-muted"
                                        data-bs-toggle="dropdown" aria-expanded="true"> Sort By <i
                                            class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i>
                                    </a>
                                    <ul class="dropdown-menu" role="menu"
                                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 28px);"
                                        data-popper-placement="bottom-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Week</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a>
                                        </li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Month</a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div id="area-spline"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3">
                <div class="row">
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card card-bg-success ecommerce-card">
                            <div class="card-header border-bottom-0">
                                <div class="card-title text-fixed-white">
                                    Locked Funds
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="d-flex align-items-start gap-3 px-3">
                                    <div class="main-card-icon secondary p-0">
                                        <div
                                            class="avatar avatar-lg p-2 bg-white-transparent svg-white shadow-sm">
                                            <div class="avatar avatar-sm svg-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                    fill="#000000" viewBox="0 0 256 256">
                                                    <path d="M96,40l33.52,88H56Zm104,88H129.52L160,208Z"
                                                        opacity="0.2"></path>
                                                    <path
                                                        d="M240,128a8,8,0,0,1-8,8H204.94l-37.78,75.58A8,8,0,0,1,160,216h-.4a8,8,0,0,1-7.08-5.14L95.35,60.76,63.28,131.31A8,8,0,0,1,56,136H24a8,8,0,0,1,0-16H50.85L88.72,36.69a8,8,0,0,1,14.76.46l57.51,151,31.85-63.71A8,8,0,0,1,200,120h32A8,8,0,0,1,240,128Z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-fill">
                                        <div class="mb-2">Overall locked funds</div>
                                        <div class="text-muted mb-0 fs-18 d-flex align-items-center">
                                            <h5 class="fs-26 fw-bold mb-0 flex-fill fw-medium text-fixed-white" style="margin-top: -8px;">
                                                &#36;{{ number_format($lockedFunds, 2) }}
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="audience-report"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-12 col-xl-12">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Accounts Transaction
                                </div>
                                <!-- <div class="dropdown">
                                    <a href="javascript:void(0);" class="p-2 fs-12 text-muted" data-bs-toggle="dropdown"
                                        aria-expanded="true"> Sort By <i
                                            class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> </a>
                                    <ul class="dropdown-menu" role="menu"
                                        style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 28px);"
                                        data-popper-placement="bottom-end">
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">Last Week</a></li>
                                        <li><a class="dropdown-item" href="javascript:void(0);">This Month</a></li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="card-body">
                                <div class="circle-container">
                                    <div id="recent-orders" class="p-3"></div>
                                    <div class="accets-circle-style"></div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-10">Savings</p>
                                        <h6 class="fw-semibold fs-14">{{ number_format($savingsPercentage, 2) }}%</h6>
                                    </div>
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-10">Investment</p>
                                        <h6 class="fw-semibold fs-14">{{ number_format($investmentPercentage, 2) }}%</h6>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p class="text-muted mb-1 fs-10">Trading</p>
                                        <h6 class="fw-semibold fs-14">{{ number_format($tradingPercentage, 2) }}%</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-12">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="swiper swiper-basic">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 bg-success-transparent border">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-success p-2">
                                                        <i class="bi bi-apple  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Apple</span>
                                                    <span class="d-block fs-12">$12,289.44</span>
                                                </div>
                                            </div>
                                            <div class="fs-12 text-end">
                                                <span class="text-success d-block">0.14%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
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
                                                        <i class="bi bi-currency-bitcoin  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Bitcoin</span>
                                                    <span class="d-block fs-12">$58,151.02</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-success d-block">2.14%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="text-secondary d-block">+$5,745.62</span>
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
                                                        <i class="bi bi-card-list  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Tesla</span>
                                                    <span class="d-block fs-12">$14,452.36</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-danger d-block">4.02%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block text-info">+$4,125.63</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div
                                            class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-dark-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-dark p-2">
                                                        <i class="bi bi-gift  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Amazon</span>
                                                    <span class="d-block fs-12">$63,251.11</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-success d-block">5.14%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="text-dark d-block">+$936.30</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-wrap align-items-center justify-content-between p-3 border rounded bg-danger-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-danger p-2">
                                                        <i class="bi bi-truck  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Aliexpress</span>
                                                    <span class="d-block fs-12">$5,401.50</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-success d-block">3.32%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="d-block">+$4,360.65</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div
                                            class="d-flex flex-wrap align-items-center justify-content-between p-3 border rounded bg-warning-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-warning p-2">
                                                        <i class="bi bi-phone  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Samsung</span>
                                                    <span class="d-block fs-12">$10,732.12</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-danger d-block">1.24%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="text-warning d-block">+$3,221.29</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div
                                            class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-primary-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm bg-primary p-2">
                                                        <i class="bi bi-nvidia  fs-18"></i>
                                                    </span>
                                                </div>
                                                <div class="lh-1">
                                                    <span
                                                        class="d-block mb-2 text-default fw-medium">Nvidia</span>
                                                    <span class="d-block fs-12">$23,235.25</span>
                                                </div>
                                            </div>
                                            <div class=" fs-12 text-end">
                                                <span class="text-success d-block">1.14%<i
                                                        class="ti ti-arrow-bear-right"></i></span>
                                                <span class="text-primary d-block">+$5,745.62</span>
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

        <div class="row">
            <div class="col-xxl-9" style="height: 620px;">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript">
                        // Define all possible symbols
                        const allSymbols = [
                            ["Apple", "AAPL|1D"],
                            ["Google", "GOOGL|1D"],
                            ["Microsoft", "MSFT|1D"],
                            ["Amazon", "AMZN|1D"],
                            ["Tesla", "TSLA|1D"],
                            ["Facebook", "META|1D"],
                            ["Netflix", "NFLX|1D"],
                            ["Nvidia", "NVDA|1D"]
                        ];

                        // Function to shuffle and select a subset of symbols
                        function getRandomSymbols(symbols, count) {
                            for (let i = symbols.length - 1; i > 0; i--) {
                                const j = Math.floor(Math.random() * (i + 1));
                                [symbols[i], symbols[j]] = [symbols[j], symbols[i]];
                            }
                            return symbols.slice(0, count);
                        }

                        // Get 3 random symbols
                        const selectedSymbols = getRandomSymbols(allSymbols, 3);

                        // Inject the symbols into the TradingView widget config
                        const widgetConfig = {
                            "symbols": selectedSymbols,
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
                        };

                        // Create the TradingView widget
                        const script = document.createElement('script');
                        script.src = "https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js";
                        script.async = true;
                        script.innerHTML = JSON.stringify(widgetConfig);
                        document.querySelector('.tradingview-widget-container__widget').appendChild(script);
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

            <div class="col-xxl-3">
                <div class="card custom-card card-bg-grey ecommerce-card" style="background: #09005b;">
                    <!-- TradingView Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-single-quote.js" async>
                            {
                                "symbol": "FX:EURUSD",
                                "width": "100%",
                                "isTransparent": true,
                                "colorTheme": "dark",
                                "locale": "en"
                            }
                        </script>
                    </div>
                    <!-- TradingView Widget END -->
                </div>
                <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-header justify-content-between">
                            <div class="card-title"> Popular Traders </div>
                        </div>
                        <div class="card-body p-0" id="top-collector">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <tbody>
                                        <p class="text-center my-5 py-5">No top traders</p>
                                        <!-- <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Alicia Smith</p>
                                                        <span class="fs-12 text-muted">980 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <p class="mb-0 fw-semibold">$9,223.46</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Alex Carey</p>
                                                        <span class="fs-12 text-muted">126 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <p class="mb-0 fw-semibold">$17,239.09</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Emiley Jack</p>
                                                        <span class="fs-12 text-muted">170 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <p class="mb-0 fw-semibold">$5,902.83</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Jessica</p>
                                                        <span class="fs-12 text-muted">220 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <p class="mb-0 fw-semibold">$3,993.09</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Toni Stark</p>
                                                        <span class="fs-12 text-muted">160 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <p class="mb-0 fw-semibold">$12,124.34</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2"> <span
                                                            class="avatar avatar-md p-1 avatar-rounded bg-light">
                                                            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/59/User-avatar.svg/2048px-User-avatar.svg.png" alt="">
                                                        </span> </div>
                                                    <div class="fw-medium">
                                                        <p class="mb-0">Kiara May</p>
                                                        <span class="fs-12 text-muted">120 Itmes</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0 text-end">
                                                <p class="mb-0 fw-semibold">$2,534.56</p>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Start:: row-3 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card overflow-hidden">
                    <div class="card-header justify-content-between">
                        <div class="card-title">Recent Transaction</div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Account</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $key=>$transaction)
                                        <tr>
                                            <td>
                                                @if($transaction['type'] == 'trade')
                                                    <span class="badge bg-pink-transparent">Trading</span>
                                                @elseif($transaction['type'] == 'save')
                                                    <span class="badge bg-info-transparent">Savings</span>
                                                @elseif($transaction['type'] == 'invest')
                                                    <span class="badge bg-primary-transparent">Investment</span>
                                                @elseif($transaction['type'] == 'wallet')
                                                    <span class="badge bg-dark-transparent">Wallet</span>
                                                @endif
                                            </td>
                                            <td>${{ number_format($transaction['amount'], 2) }}</td>
                                            <td>{{ $transaction['description'] }}</td>
                                            <td>
                                                @if($transaction['method'] == 'credit')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Credit</span>
                                                @elseif($transaction['method'] == 'debit')
                                                    <span class="badge bg-danger-transparent"><i class="ri-info-fill align-middle me-1"></i>Debit</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction['status'] == 'approved')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Approved</span>
                                                @elseif($transaction['status'] == 'pending')
                                                    <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                @elseif($transaction['status'] == 'decline')
                                                    <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Decline</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- @if($transactions->count() == 0)
                                <tr>
                                    <p class="py-4 text-center">
                                        No Transactions...
                                    </p>
                                </tr>
                            @endif --}}
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <div> Showing 10 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-3 -->

    </div>
</div>
<!-- End::app-content -->


<!-- Apex Charts JS -->
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Swiper JS -->
<script src="{{ asset('asset/libs/swiper/swiper-bundle.min.js') }}"></script>

<!-- Stocks Dashboard -->
<script src="{{ asset('asset/js/stocks-dashboard.js') }}"></script>

<!-- Custom JS -->
<script src="{{ asset('asset/js/custom.js') }}"></script>

<script>
    // Convert the PHP data into JavaScript arrays
    var dates = @json($dates->toArray());
    var alignedSavings = @json($alignedSavings->toArray());
    var alignedInvestments = @json($alignedInvestments->toArray());
    var alignedTrading = @json($alignedTrading->toArray());

    var options = {
        series: [{
            name: 'Savings',
            data: alignedSavings // Use the aligned savings data from the controller
        }, {
            name: 'Investments',
            data: alignedInvestments // Use the aligned investments data
        }, {
            name: 'Trading',
            data: alignedTrading // Use the aligned trading data
        }],
        chart: {
            height: 320,
            type: 'area'
        },
        colors: ["#8274ff", "#ff6937", "#58c437"],
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'smooth'
        },
        grid: {
            borderColor: '#f2f5f7',
        },
        xaxis: {
            type: 'datetime',
            categories: dates,
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
                    fontSize: '11px',
                    fontWeight: 600,
                    cssClass: 'apexcharts-yaxis-label',
                },
            }
        },
        tooltip: {
            x: {
                format: 'dd/MM/yy HH:mm'
            },
        },
    };

    var chart = new ApexCharts(document.querySelector("#area-spline"), options);
    chart.render();
</script>

<script>
    // Get the percentages from the backend
    var savingsPercentage = {{ number_format($savingsPercentage, 2) }};
    var investmentPercentage = {{ number_format($investmentPercentage, 2) }};
    var tradingPercentage = {{ number_format($tradingPercentage, 2) }};
    
    /* recent orders */
    var options = {
    series: [savingsPercentage, investmentPercentage, tradingPercentage],
    labels: ["Savings", "Investment", "Trading"],
    chart: {
        height: 215,
        type: 'donut',
    },
    dataLabels: {
        enabled: false,
    },

    legend: {
        show: false,
    },
    stroke: {
        show: true,
        curve: 'smooth',
        lineCap: 'round',
        colors: "#fff",
        width: 0,
        dashArray: 0,
    },
    plotOptions: {
        pie: {
        expandOnClick: false,
        donut: {
            size: '85%',
            background: 'transparent',
            labels: {
            show: true,
            name: {
                show: true,
                fontSize: '20px',
                color: '#495057',
                offsetY: -4
            },
            value: {
                show: true,
                fontSize: '18px',
                color: undefined,
                offsetY: 8,
                formatter: function (val) {
                return val + '%'
                }
            },
            total: {
                show: true,
                showAlways: true,
                label: 'Value',
                fontSize: '18px',
                fontWeight: 600,
                color: '#000000',
            }

            }
        }
        }
    },
    colors: ["var(--primary-color)","var(--primary03)", "var(--primary05)"],
    };
    var chart = new ApexCharts(document.querySelector("#recent-orders"), options);
    chart.render();
    /* recent orders */
</script>

@endsection
