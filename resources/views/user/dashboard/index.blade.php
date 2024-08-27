@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Quick Overview</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Investments</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">{{ auth()->user()->investments()->where('status', '!=', 'cancelled')->where('status', '!=', 'pending')->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Active Investments</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">₦ {{ number_format(auth()->user()->investments()->where('status', 'active')->sum('amount')) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Trades</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3"> {{ auth()->user()->trades()->where('status', 'success')->sum('grams') }} grams</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Gold Wallet</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3"> {{ round(auth()->user()['goldWallet']['balance'], 6) }} grams</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Silver Wallet</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3"> {{ round(auth()->user()['silverWallet']['balance'], 6) }} grams</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Naira Wallet</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">₦ {{ number_format(auth()->user()['wallet']['balance'], 2) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
{{--                <div class="col-md-4 grid-margin stretch-card">--}}
{{--                    <div class="card">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="d-flex justify-content-between align-items-baseline">--}}
{{--                                <h6 class="card-title mb-0">Total Referral Earning</h6>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-6 col-md-12 col-xl-5">--}}
{{--                                    <h6 class="font-weight-light mt-3">₦ {{ number_format(auth()->user()->referrals()->whereNotNull('amount')->sum('amount'), 2) }}</h6>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">This Month Transactions Chart</h6>
                    </div>
                    <div class="flot-wrapper">
                        <div id="transactionChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">This Year Transaction Chart</h6>
                    </div>
                    <div>
                        <div id="investmentChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Paid Investments Chart</h6>
                    </div>
                    <div id="progressbar1" class="mx-auto"></div>
                    <div class="row mt-4 mb-3">
                        <div class="col-6 d-flex justify-content-end">
                            <div>
                                <label class="d-flex align-items-center justify-content-end tx-10 text-uppercase font-weight-medium">Total Investment <span class="p-1 ml-1 rounded-circle bg-primary-muted"></span></label>
                                <h5 class="font-weight-bold mb-0 text-right">{{ $totalInvestment['hf'] }}</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label class="d-flex align-items-center tx-10 text-uppercase font-weight-medium"><span class="p-1 mr-1 rounded-circle bg-primary"></span> Paid Investment</label>
                                <h5 class="font-weight-bold mb-0">{{ $paidInvestment['hf'] }}</h5>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('investments') }}" class="btn btn-primary btn-block">View Investments</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script>
    <script>
        $(document).ready(function (){
            let transactionChartOptions = {
                chart: {
                    height: 300,
                    type: "line",
                    parentHeightOffset: 0
                },
                colors: ["#f77eb9", "#7ee5e5","#4d8af0"],
                grid: {
                    borderColor: "rgba(77, 138, 240, .1)",
                    padding: {
                        bottom: -6
                    }
                },
                series: [
                    {
                        name: "Transaction",
                        data: {!! json_encode($transactions['month']) !!},
                        color: '#f60780'
                    }
                ],
                markers: {
                    size: 0
                },
                stroke: {
                    width: 2,
                    curve: "smooth",
                    lineCap: "round"
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'left',
                    containerMargin: {
                        top: 30
                    }
                },
                responsive: [
                    {
                        breakpoint: 500,
                        options: {
                            legend: {
                                fontSize: "11px"
                            }
                        }
                    }
                ]
            };
            let transactionChart = new ApexCharts(document.querySelector("#transactionChart"), transactionChartOptions);
            transactionChart.render();

            let investmentChartOptions = {
                chart: {
                    height: 300,
                    type: "bar",
                    parentHeightOffset: 0,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '19%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ["#f77eb9", "#7ee5e5","#4d8af0"],
                grid: {
                    borderColor: "rgba(77, 138, 240, .1)",
                    padding: {
                        bottom: -6
                    }
                },
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                series: [
                    {
                        name: "Transaction",
                        data: {!! json_encode($transactions['year']) !!},
                        color: '#f60780'
                    }
                ],
                markers: {
                    size: 0
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'left',
                    containerMargin: {
                        top: 30
                    }
                },
                responsive: [
                    {
                        breakpoint: 500,
                        options: {
                            legend: {
                                fontSize: "11px"
                            }
                        }
                    }
                ]
            };
            let investmentChart = new ApexCharts(document.querySelector("#investmentChart"), investmentChartOptions);
            investmentChart.render();

            var bar = new ProgressBar.Circle(progressbar1, {
                color: '#f60780',
                trailColor: 'rgba(77, 138, 240, .1)',
                // This has to be the same size as the maximum width to
                // prevent clipping
                strokeWidth: 4,
                trailWidth: 1,
                easing: 'easeInOut',
                duration: 1400,
                text: {
                    autoStyleContainer: false
                },
                from: { color: '#f60780', width: 1 },
                to: { color: '#f60780', width: 4 },
                // Set default step function for all animate calls
                step: function(state, circle) {
                    circle.path.setAttribute('stroke', state.color);
                    circle.path.setAttribute('stroke-width', state.width);

                    var value = Math.round(circle.value() * 100);
                    if (value === 0) {
                        circle.setText('');
                    } else {
                        circle.setText(value + '%');
                    }

                }
            });
            bar.text.style.fontFamily = "'Overpass', sans-serif;";
            bar.text.style.fontSize = '3rem';

            bar.animate({{ $totalInvestment['reg'] > 0 ? $paidInvestment['reg'] / $totalInvestment['reg'] : 0 }});
        });
    </script>
@endsection

































































@extends('layouts.user.index')

@section('styles')
    <!-- <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}"> -->
@endsection

@php
    $user = auth()->user();
    $virtualAccount = json_decode($user['virtual_account'], true);
@endphp

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Investment</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <p class="mb-0">Savings Account:</p>
                            <h3 class="fw-600">&#36; {{ number_format($savings, 2) }}</h3>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <p class="mb-0">Trading Account:</p>
                            <h3 class="fw-600">&#36;{{ number_format($trading, 2) }}</h3>
                        </div>
                        <div class="col-12 col-md-4 mb-3 mb-md-0">
                            <p class="mb-0">Investment Account:</p>
                            <h3 class="fw-600">&#36; {{ number_format($investment, 2) }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Investments</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">{{ auth()->user()->investments()->where('status', '!=', 'cancelled')->where('status', '!=', 'pending')->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Active Investments</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">₦ {{ number_format(auth()->user()->investments()->where('status', 'active')->sum('amount')) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Naira Wallet</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">₦ {{ number_format(auth()->user()['nairaWallet']['balance']) }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 grid-margin stretch-card">
            <div class="card overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-4 mb-md-3">
                        <h6 class="card-title mb-0">This Month Investment Chart</h6>
                    </div>
                    <div class="flot-wrapper">
                        <div id="transactionChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">This Year Investments Chart</h6>
                    </div>
                    <div>
                        <div id="investmentChart"></div>
                    </div>
                </div>
            </div>
        </div>
        @if(auth()->user()->investments()->count() > 0)
            <div class="col-lg-5 col-xl-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Recent Investments</h6>
                        </div>
                        <table class="table">
                            @foreach(auth()->user()->investments()->latest()->take(6)->get() as $investment)
                                <tr>
                                    <td><p>₦ {{ number_format($investment['amount']) }}</p></td>
                                    <td>
                                        <p>{{ $investment->package['name'] }}</p>
                                    </td>
                                    <td>
                                        @if($investment['status'] == 'active')
                                            <span class="badge badge-pill badge-success">Active</span>
                                        @elseif($investment['status'] == 'pending')
                                            <span class="badge badge-pill badge-warning">Pending</span>
                                        @elseif($investment['status'] == 'cancelled')
                                            <span class="badge badge-pill badge-danger">Cancelled</span>
                                        @elseif($investment['status'] == 'settled')
                                            <span class="badge badge-pill badge-secondary">Settled</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <a href="{{ route('investments') }}" class="btn btn-primary btn-block">My Investments</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <!-- <script src="{{ asset('assets/vendors/chartjs/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.js') }}"></script>
    <script src="{{ asset('assets/vendors/jquery.flot/jquery.flot.resize.js') }}"></script>
    <script src="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/progressbar.js/progressbar.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/datepicker.js') }}"></script> -->
    <!-- <script>
        $(document).ready(function (){
            let transactionChartOptions = {
                chart: {
                    height: 300,
                    type: "line",
                    parentHeightOffset: 0
                },
                colors: ["#f77eb9", "#7ee5e5","#4d8af0"],
                grid: {
                    borderColor: "rgba(77, 138, 240, .1)",
                    padding: {
                        bottom: -6
                    }
                },
                series: [
                    {
                        name: "Investment",
                        data: {!! json_encode($investments['month']) !!},
                        color: '#f60780'
                    }
                ],
                markers: {
                    size: 0
                },
                stroke: {
                    width: 2,
                    curve: "smooth",
                    lineCap: "round"
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'left',
                    containerMargin: {
                        top: 30
                    }
                },
                responsive: [
                    {
                        breakpoint: 500,
                        options: {
                            legend: {
                                fontSize: "11px"
                            }
                        }
                    }
                ]
            };
            let transactionChart = new ApexCharts(document.querySelector("#transactionChart"), transactionChartOptions);
            transactionChart.render();

            let investmentChartOptions = {
                chart: {
                    height: 300,
                    type: "bar",
                    parentHeightOffset: 0,
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '19%',
                        endingShape: 'rounded'
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                colors: ["#f77eb9", "#7ee5e5","#4d8af0"],
                grid: {
                    borderColor: "rgba(77, 138, 240, .1)",
                    padding: {
                        bottom: -6
                    }
                },
                labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
                series: [
                    {
                        name: "Investment",
                        data: {!! json_encode($investments['year']) !!},
                        color: '#f60780'
                    }
                ],
                markers: {
                    size: 0
                },
                legend: {
                    show: true,
                    position: "top",
                    horizontalAlign: 'left',
                    containerMargin: {
                        top: 30
                    }
                },
                responsive: [
                    {
                        breakpoint: 500,
                        options: {
                            legend: {
                                fontSize: "11px"
                            }
                        }
                    }
                ]
            };
            let investmentChart = new ApexCharts(document.querySelector("#investmentChart"), investmentChartOptions);
            investmentChart.render();

        });
    </script> -->
@endsection
