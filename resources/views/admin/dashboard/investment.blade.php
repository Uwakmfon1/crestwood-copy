@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Investment</li>
        </ol>
    </nav>
@endsection

@php
    $setting = \App\Models\Setting::all()->first();
@endphp

@section('content')
    <div class="row">
        <div class="col-12 text-right mb-2">
            <button class="btn btn-sm btn-outline-primary" id="toggleCashDisplayButton">@if($setting['show_cash'] == 1) Hide @else Show @endif</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow">
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Packages</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light mt-3">{{ \App\Models\Package::all()->count() }}</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-0">Total Investments</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h6 class="font-weight-light dashboard-cash-info mt-3" @if($setting['show_cash'] == 0)style="display: none;"@endif>₦ {{ number_format(\App\Models\Investment::query()->where('status', '!=', 'cancelled')->where('status', '!=', 'pending')->sum('amount')) }}</h6>
                                    <h6 class="font-weight-light mt-3" @if($setting['show_cash'] == 1)style="display: none;"@endif>₦ ---</h6>
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
                                    <h6 class="font-weight-light dashboard-cash-info mt-3" @if($setting['show_cash'] == 0)style="display: none;"@endif>{{ \App\Models\Investment::query()->where('status', 'active')->count() }}</h6>
                                    <h6 class="font-weight-light mt-3" @if($setting['show_cash'] == 1)style="display: none;"@endif>₦ ---</h6>
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
                                    <h6 class="font-weight-light dashboard-cash-info mt-3" @if($setting['show_cash'] == 0)style="display: none;"@endif>₦ {{ number_format(\App\Models\User::with('wallet')->get()->sum(function ($user) { return $user->wallet->balance;}), 2) }}</h6>
                                    <h6 class="font-weight-light mt-3" @if($setting['show_cash'] == 1)style="display: none;"@endif>₦ ---</h6>
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
        @if(\App\Models\Investment::query()->count() > 0)
            <div class="col-lg-5 col-xl-4 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-baseline mb-2">
                            <h6 class="card-title mb-0">Recent Investments</h6>
                        </div>
                        <table class="table">
                            @foreach(\App\Models\Investment::query()->latest()->take(6)->get() as $investment)
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
                        <a href="{{ route('admin.investments') }}" class="btn btn-primary btn-block">View Investments</a>
                    </div>
                </div>
            </div>
        @endif
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
            let autoHide = {{ $setting['show_cash'] }} != 1;
            let toggleCashDisplayButton = $('#toggleCashDisplayButton');
            toggleCashDisplayButton.on('click', function (){
                autoHide = !autoHide;
                showOrHideCashDetails();
            })
            function showOrHideCashDetails()
            {
                $('.dashboard-cash-info').each(function () {
                    if (autoHide){
                        $(this).hide();
                        $(this).parent().children().last().show();
                    }else {
                        $(this).show();
                        $(this).parent().children().last().hide();
                    }
                });
                toggleCashDisplayButton.text(toggleCashDisplayButton.text().trim() === 'Show' ? 'Hide' : 'Show');
            }
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
    </script>
@endsection
