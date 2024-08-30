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
                <button type="button" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-dollar-sign me-2"></i> Wallet
                </button>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                </div>
                <!-- <div class="card custom-card nft-custom-card bg-primary border-0">
                    <div class="card-body p-4">
                        <div class="d-flex flex-wrap gap-5">
                            <div class="">
                                <div class="nft-bid-image">
                                    <img src="../assets/images/nft-images/11.jpg" alt="">
                                </div>
                            </div>
                            <div class="">
                                <h4 class="text-fixed-white mb-2 lh-base">Visual Effects in the Metaverse</h4>
                                <span class="text-fixed-white op-5">Product Id : #12355</span>
                                <div class="d-flex gap-2 mt-2 mb-2">
                                    <span class="avatar avatar-md p-1 bg-white-transparent avatar-rounded"><img
                                            src="../assets/images/faces/6.jpg"></span>
                                    <div>
                                        <span class="d-block fw-medium text-fixed-white">EtherEden</span>
                                        <span class="fs-12 text-muted text-fixed-white op-8">by @Eden
                                            Pixelist</span>
                                    </div>
                                </div>
                                <p class="mb-0 text-fixed-white nft-main-auction-time"> 04hrs : 24m : 38s </p>
                                <div class="mt-5 d-flex flex-wrap gap-2">
                                    <button class="btn btn-white-transparent  btn-wave me-2">Discover
                                        Now</button>
                                    <button
                                        class="btn text-fixed-white border border-white border-opacity-25 btn-wave">View
                                        ArtWork</button>
                                </div>
                            </div>
                            <div class="d-xxl-block d-none">
                                <div class="text-center nft-main-image">
                                    <img src="../assets/images/nft-images/1.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
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
                                        <span class="text-muted fs-12">Savings Balance<span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span></span>

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
                                        <span class="text-muted fs-12">Investment Balance<span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span></span>

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
                                        <span class="text-muted fs-12">Tradning Balance<span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span></span>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-header justify-content-between">
                                <div class="card-title">
                                    Order Status
                                </div>
                                <div class="dropdown">
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
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="order-status"></div>
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
                                    Activity Overview
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
                                        <div class="mb-2">Total Assets</div>
                                        <div class="text-muted mb-0 fs-12 d-flex align-items-center">
                                            <h5 class="fs-4 mb-0 flex-fill fw-medium text-fixed-white">
                                                &#36;{{ number_format($assets, 2) }}
                                            </h5>
                                            <a href="javascript:void(0)" class="text-white fw-semibold">View
                                                All <i class="fe fe-arrow-right"></i></a>
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
                                    Recent Orders
                                </div>
                                <div class="dropdown">
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
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="circle-container">
                                    <div id="recent-orders" class="p-3"></div>
                                    <div class="accets-circle-style"></div>
                                </div>
                                <div class="row mt-0">
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-12">Delivered</p>
                                        <h6 class="fw-semibold">65.7%</h6>
                                    </div>
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-12">Cancelled</p>
                                        <h6 class="fw-semibold">23.2%</h6>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p class="text-muted mb-1 fs-12">Pending</p>
                                        <h6 class="fw-semibold">10.5%</h6>
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
            <div class="col-xxl-9">
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
                            <div class="card-title"> Trending Creators </div>
                        </div>
                        <div class="card-body p-0" id="top-collector">
                            <div class="table-responsive">
                                <table class="table table-hover text-nowrap">
                                    <tbody>
                                        <tr>
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
                                        </tr>
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
                                        <th class="text-center">Price </th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $key=>$transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="me-2 lh-1">
                                                        <span class="avatar avatar-md bg-light p-1">
                                                            <span class="avatar avatar-sm bg-secondary avatar-rounded svg-white p-1">
                                                                @if($transaction['account_type'] == 'trading')
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                                        <path d="M176,80a48,48,0,0,0-94.87-11.45A8,8,0,0,0,90.37,77.3,32,32,0,1,1,56,112a32.15,32.15,0,0,1,6.44-.65,8,8,0,0,0,6.73-12.28A48,48,0,1,0,80,176H48a8,8,0,0,0,0,16H80a48,48,0,1,0,94.87,11.45,8,8,0,0,0-9.24-8.75,32,32,0,1,1,34.4-34.4,8,8,0,0,0,8.75,9.24A48,48,0,1,0,176,80Z" opacity="0.2"></path>
                                                                        <path d="M176,72a8,8,0,0,0,0-16h-8V40a8,8,0,0,0-16,0V56H128V40a8,8,0,0,0-16,0V56H96a8,8,0,0,0,0,16h8V96H96a8,8,0,0,0,0,16h16v16a8,8,0,0,0,16,0V112h24v16a8,8,0,0,0,16,0V112h8a8,8,0,0,0,0-16h-8V72ZM128,104H112V72h16ZM224,160a8,8,0,0,0-8-8H192a48,48,0,0,0-47.13,39.45,8,8,0,0,0,9.24,8.75,32,32,0,1,1-34.4,34.4,8,8,0,0,0-8.75-9.24A48,48,0,1,0,176,160h24A8,8,0,0,0,224,160Zm-96,48a32.15,32.15,0,0,1-6.44.65,8,8,0,0,0-6.73,12.28A48,48,0,1,0,80,176H56a32,32,0,1,1,34.37-34.37,8,8,0,0,0,13.51-8.6A48,48,0,1,0,176,176H192A32,32,0,1,1,128,208Z"></path>
                                                                    </svg>
                                                                @elseif($transaction['account_type'] == 'savings')
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                                        <path d="M232,128a40,40,0,0,0-40-40H186.24A88.08,88.08,0,0,0,24,128c0,28.15,13.11,54.92,36.88,70.19L55.7,221.06A8,8,0,0,0,63.33,232H88a8,8,0,0,0,8-8V208h64v16a8,8,0,0,0,8,8h24.67a8,8,0,0,0,7.63-10.94l-5.64-15.05A88.52,88.52,0,0,0,208,168h24A40,40,0,0,0,232,128ZM104,88a8,8,0,1,1,8-8A8,8,0,0,1,104,88Z" opacity="0.2"></path>
                                                                        <path d="M232,120H216a8,8,0,0,0-8,8,80,80,0,0,1-25.07,58.16,8,8,0,0,0-2.08,8.58l5.64,15.05H168V200a16,16,0,0,0-16-16H104a16,16,0,0,0-16,16v11.79H63.33l5.66-15.06a8,8,0,0,0-2.08-8.58A79.18,79.18,0,0,1,32,128,80.09,80.09,0,0,1,186.24,96H192a8,8,0,0,0,8-8V72.26l10.3,3.43a8,8,0,0,0,2.55.41h16a8,8,0,0,1,0,16H224a8,8,0,0,0-8,8v16A40,40,0,0,0,232,120Zm-128,8a16,16,0,1,0-16-16A16,16,0,0,0,104,128Zm0-32a8,8,0,1,1-8,8A8,8,0,0,1,104,96Z">
                                                                        </path>
                                                                    </svg>
                                                                @elseif($transaction['account_type'] == 'investment')
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256">
                                                                        <path d="M48,88H208a8,8,0,0,0,8-8V56a8,8,0,0,0-4.59-7.21l-80-40a8,8,0,0,0-7.18,0l-80,40A8,8,0,0,0,40,56V80A8,8,0,0,0,48,88Zm80,40a40,40,0,1,0,40,40A40,40,0,0,0,128,128Zm0,64a24,24,0,1,1,24-24A24,24,0,0,1,128,192Zm96-80H192a8,8,0,0,0-8,8v72H72V120a8,8,0,0,0-8-8H32a8,8,0,0,0,0,16H56v72H48a8,8,0,0,0,0,16H208a8,8,0,0,0,0-16h-8V128h24a8,8,0,0,0,0-16ZM200,224H56a8,8,0,0,0,0,16H200a8,8,0,0,0,0-16Z" opacity="0.2"></path>
                                                                        <path d="M218.59,48.79l-80-40a16,16,0,0,0-14.18,0l-80,40A16,16,0,0,0,32,56V80a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V56A16,16,0,0,0,218.59,48.79ZM208,80H48V56l80-40,80,40ZM128,120a48,48,0,1,0,48,48A48,48,0,0,0,128,120Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,200Zm96-80H192a16,16,0,0,0-16,16v64H80V136a16,16,0,0,0-16-16H32a16,16,0,0,0,0,32H48v64a16,16,0,0,0,16,16H200a16,16,0,0,0,16-16V152h8a16,16,0,0,0,0-32Zm-8,96H56v-8H200Z">
                                                                        </path>
                                                                    </svg>
                                                                @endif
                                                            </span>
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <a href="javascript:void(0)" class="fs-14 text-capitalize">{{$transaction['account_type']}}</a>
                                                        <span
                                                            class="d-block text-muted fs-12">{{ $transaction['description'] }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span class="fw-semibold fs-14">${{ number_format($transaction['amount'], 2) }}</span>
                                            </td>
                                            <td>
                                                @if($transaction['type'] == 'deposit')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Credit</span>
                                                @elseif($transaction['type'] == 'withdrawal')
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
                                            <td>
                                                <span class="text-muted">{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($transactions->count() == 0)
                                <tr>
                                    <p class="py-4 text-center">
                                        No Transactions...
                                    </p>
                                </tr>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex align-items-center">
                            <div> Showing 6 Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                            
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

@endsection
