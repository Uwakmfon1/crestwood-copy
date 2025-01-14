@extends('layouts.user.index')

@section('title', ' Dashboard')

@section('styles')

<link rel="stylesheet" href="{{ asset('asset/libs/swiper/swiper-bundle.min.css') }}">

@endsection

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
                    <i class="fe fe-dollar-sign me-2"></i> Cash
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
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($savings, 2) }} 
                                            <span class="text-success ms-2 d-inline-block fs-12">{{ number_format($savingsPercentage, 2) }}% <i class="ti ti-arrow-narrow-up"></i></span>
                                        </h4>
                                        <span class="text-muted fs-12">Savings Account
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Total value of funds across all savings accounts." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
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
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($investment, 2) }} 
                                            <span class="text-success ms-2 d-inline-block fs-12">{{ number_format($investmentPercentage, 2) }}% <i class="ti ti-arrow-narrow-up"></i></span>
                                        </h4>
                                        <span class="text-muted fs-12">Managed Investment
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Total value of investments across all packages." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
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
                                        <h4 class="fw-semibold mb-1">&#36;{{ number_format($trading, 2) }} 
                                            <span class="@if($tradingPercentage >= 0) text-success @else text-danger @endif ms-2 d-inline-block fs-12">{{ number_format($tradingPercentage, 2) }}% <i class="ti ti-arrow-narrow-up"></i></span>
                                        </h4>
                                        <span class="text-muted fs-12">Available Trading Balance
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Funds available for placing new trades." class="text-muted mx-1">
                                                <i class="fe fe-info"></i>
                                            </a>
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
                <div class="card custom-card card-bg-primary crypto-card pt-2">
                    <div class="card-body">
                        <div>
                            <span class="text-fixed-white op-8">Total Portfolio Value 
                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="The total value of all funds in your account, including savings, investments, and trading balances." class="text-fixed-white mx-1">
                                    <i class="fe fe-info"></i>
                                </a>
                            </span>
                            <h4 class="fw-semibold d-block text-fixed-white mt-2">
                                {{ number_format($portfolio, 2) }}
                                <span class="fs-12 ms-1 d-inline-flex" style="margin-top: -5px;">USD</span>
                            </h4>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="text-center p-2 my-2 bg-white-transparent rounded">
                                    <div class="d-flex">
                                        <span class="fs-10 tooltip-container">Reserved Fund 
                                            <a href="javascript:void(0);" class="tooltip-trigger text-fixed-white mx-1"  data-tooltip="Funds available for withdrawal or transfer, not currently in use.">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="d-flex">
                                        <span class="fs-18 fw-semibold text-start">{{ number_format($lockedFunds, 2) }} USD</span>
                                    </div>
                                    <div class="mt-1">  </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="audience-report"></div>
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
                                        <h6 class="fw-semibold fs-14"> &#36;{{ number_format($savings, 2) }}  <span class="fs-9 text-muted">{{ number_format($savingsPercentage, 2) }}% </span></h6>
                                    </div>
                                    <div class="col-4 border-end border-inline-end-dashed text-center">
                                        <p class="text-muted mb-1 fs-10">Investment</p>
                                        <h6 class="fw-semibold fs-14"> &#36;{{ number_format($investment, 2) }}  <span class="fs-9 text-muted">{{ number_format($investmentPercentage, 2) }}% </span></h6>
                                    </div>
                                    <div class="col-4 text-center">
                                        <p class="text-muted mb-1 fs-10">Trading</p>
                                        <h6 class="fw-semibold fs-14"> &#36;{{ number_format($trading, 2) }}  <span class="fs-9 text-muted">{{ number_format($tradingPercentage, 2) }}% </span></h6>
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
                            @foreach ($slidesData as $slide)
                            <div class="swiper-slide">
                                <div class="card custom-card">
                                    <div class="card-body">
                                        <div class="d-flex gap-2 flex-wrap align-items-center justify-content-between p-3 border rounded bg-{{ $slide['colorClass'] }}-transparent">
                                            <div class="d-flex flex-fill align-items-center">
                                                <div class="me-2">
                                                    <span class="avatar avatar-sm rounded-circle bg-dark bg-opacity-10 border border-white p-2">
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
<!-- <script src="{{ asset('asset/js/custom.js') }}"></script> -->

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
