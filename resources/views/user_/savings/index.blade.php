@extends('layouts.user.index')

@section('styles')

<link rel="stylesheet" href="{{ asset('asset/libs/apexcharts/apexcharts.css') }}">

@endsection

<style>
    ul.recent-transactions-list li:nth-child(1):before {
        background-color: #17171c !important;
    }
    ul.recent-transactions-list li:nth-child(2):before {
        background-color: #17171c !important;
    }
    ul.recent-transactions-list li:nth-child(3):before {
        background-color: #17171c !important;
    }
    ul.recent-transactions-list li:nth-child(4):before {
        background-color: #17171c !important;
    }
    ul.recent-transactions-list li:nth-child(5):before {
        background-color: #17171c !important;
    }
    ul.recent-transactions-list li:nth-child(6):before {
        background-color: #17171c !important;
    }
</style>

@section('content')
<!-- Start::app-content -->

<div class="main-content app-content">
    <div class="container-fluid">
    @include('partials.users.alert')
        <!-- Start::page-header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Savings</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Savings
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button> -->
                <a class="btn btn-primary btn-wave waves-effect waves-light" href="{{ route('savings.create') }}">
                    <i class="ri-upload-2-line me-2"></i> New Savings
                    <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Click to start a new savings plan" class="text-muted mt-2">
                        <i class="fe fe-info"></i>
                    </a>
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-sm-6">
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
                                            <h4 class="fw-semibold mb-1">&#36;{{ number_format($balance, 2) }} <!-- <span class="text-success ms-2 d-inline-block">0.45%<i class="ti ti-arrow-narrow-up"></i></span> --> </h4>
                                            <span class="text-muted fs-12 tooltip-container">Available Savings Balance
                                                <a href="javascript:void(0);" class="tooltip-trigger text-muted mx-1"  data-tooltip="Funds allocated to your savings accounts, ready for withdrawal or reinvestment." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </span>
                                            <div class="mt-2">
                                                <a href="javascript:void(0);" class="py-2 fs-11 text-muted fw-semibold" data-bs-toggle="modal" data-bs-target="#transferModal" id="openSWalletModal">Withdraw <i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-sm-6">
                            <div class="card custom-card">
                                <div class="card-body">
                                    <div class="">
                                        <div class="d-flex justify-content-between">
                                            <div class="avatar avatar-md bg-primary border border-primary border-opacity-10">
                                                <div class="avatar avatar-sm bg-white-transparent svg-white">
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
                                        </div>
                                        <div class="mt-3">
                                            <h4 class="fw-semibold mb-1">{{ number_format($asv) }} <!-- <span class="text-success ms-2 d-inline-block">+$20.80</span> --> </h4>
                                            <span class="text-muted fs-12 tooltip-container">Number of Active Savings Plans
                                                <a href="javascript:void(0);" class="tooltip-trigger text-muted mx-1"  data-tooltip="The total number of active savings plans you are currently enrolled in." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </span>
                                        </div>
                                        <div class="mt-2">
                                            <a href="javascript:void(0);" class="py-2 fs-11 text-white fw-semibold">.</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start:: row-2 -->
                    <div class="row">
                        <div class="col-xxl-12 col-xl-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        All Savings 
                                    </div>
                                    <div class="d-flex flex-wrap gap-2"> 
                                        <div> 
                                            <input class="form-control form-control-sm" type="text" placeholder="Search Here" aria-label=".form-control-sm example"> 
                                        </div> 
                                        <div class="dropdown"> 
                                            <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-wave waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false"> Sort By<i class="ri-arrow-down-s-line align-middle ms-1 d-inline-block"></i> 
                                            </a> 
                                            <ul class="dropdown-menu" role="menu"> 
                                                <li><a class="dropdown-item" href="{{ request()->offsetExists('pending') }}">New</a></li> 
                                                <li><a class="dropdown-item" href="javascript:void(0);">Popular</a></li> 
                                                <li><a class="dropdown-item" href="javascript:void(0);">Relevant</a></li> 
                                                @if(request()->offsetExists('active'))
                                                    <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                                                    <li class="breadcrumb-item active" aria-current="page">Active</li>
                                                @elseif(request()->offsetExists('pending'))
                                                    <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                                                    <li class="breadcrumb-item active" aria-current="page">Pending</li>
                                                @elseif(request()->offsetExists('cancelled'))
                                                    <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                                                    <li class="breadcrumb-item active" aria-current="page">Cancelled</li>
                                                @elseif(request()->offsetExists('settled'))
                                                    <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                                                    <li class="breadcrumb-item active" aria-current="page">Settled</li>
                                                @else
                                                    <li class="breadcrumb-item active" aria-current="page">Savings</li>
                                                @endif
                                            </ul> 
                                        </div> 
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table text-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>Plan</th>
                                                    <th>Date</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($savings as $key=>$saving)
                                                    <tr>
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $saving->plan->name }}</td>
                                                        <td>{{ $saving['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                        <td>
                                                            @if($saving['status'] == 'active')
                                                                <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Active</span>
                                                            @elseif($saving['status'] == 'pending')
                                                                <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                            @elseif($saving['status'] == 'cancelled')
                                                                <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Cancelled</span>
                                                            @elseif($saving['status'] == 'settled')
                                                                <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Settled</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('savings.show', $saving['id']) }}" class="btn btn-sm btn-primary">View</a> 
                                                        </td>
                                                    </tr>
                                                @endforeach 
                                            </tbody>
                                        </table>
                                                @if($savings->count() == 0)
                                                    <tr>
                                                        <p class="py-4 text-center">
                                                            No Savings
                                                        </p>
                                                    </tr>
                                                @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End:: row-2 -->
                </div>
                <div class="col-xl-3">
                    <div class="row">
                        <div class="col-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">
                                        Savings Overview
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="progress progress-xs mb-3">
                                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-secondary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 12%" aria-valuenow="12" aria-valuemin="0" aria-valuemax="100"></div>
                                        <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" role="progressbar" style="width: 16%" aria-valuenow="16" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <ul class="list-group list-unstyled aquisitionlist mb-0">
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="avatar avatar-sm bg-success-transparent avatar-rounded"><i class="ti ti-file-x fs-16"></i></span>
                                                <span class="d-block fw-medium">Active</span>
                                            </div>
                                            <div>
                                                <span class="badge d-inline-flex bg-success-transparent">{{ number_format($asv) }}</span>
                                            </div>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="avatar avatar-sm bg-secondary-transparent avatar-rounded"><i class="ti ti-file-check fs-16"></i></span>
                                                <span class="d-block fw-medium">Completed</span>
                                            </div>
                                            <div>
                                                <span class="badge d-inline-flex bg-secondary-transparent">{{ number_format($csv) }}</span>
                                            </div>
                                        </li>
                                        <li class="d-flex justify-content-between">
                                            <div class="d-flex gap-2 align-items-center">
                                                <span class="avatar avatar-sm bg-primary-transparent avatar-rounded"><i class="ti ti-file-import fs-16"></i></span>
                                                <span class="d-block fw-medium">Settled</span>
                                            </div>
                                            <div>
                                                <span class="badge d-inline-flex bg-primary-transparent">{{ number_format($ssv) }}</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="card custom-card">
                                <div class="card-header justify-content-between">
                                    <div class="card-title">
                                        Recent Profits
                                    </div>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled recent-transactions-list">
                                        @foreach($profit as $data)
                                        <li>
                                            <div class="d-flex align-items-start gap-3">
                                                <div class="flex-fill">
                                                    <span class="d-block fw-medium">Today</span>
                                                    <span class="text-muted fs-12">23, May 2024 - 12:24PM</span>
                                                </div>
                                                <div>
                                                    <span class="d-block fw-medium">+244.27</span>
                                                </div>
                                            </div>
                                        </li>
                                        @endforeach
                                        @if($profit == null)
                                            <p class="text-center my-5 py-4">No transactions</p>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->
        @include('partials.users.modal.topup')
    </div>
</div>
<!-- End::app-content -->
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
            height: 310,
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