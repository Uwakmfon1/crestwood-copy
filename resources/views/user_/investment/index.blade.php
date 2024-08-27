@extends('layouts.user.index')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div
            class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Investment</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Investment
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                </ol>
            </div>
            <div class="d-flex gap-2">
                <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button> -->
                <a class="btn btn-primary btn-wave waves-effect waves-light" href="{{ route('invest') }}">
                    <i class="ri-upload-2-line me-2"></i> New Investment
                </a>
            </div>
        </div>
        <!-- End::page-header -->

        <!-- Start:: row-1 -->
        <div class="row">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
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
                                        <span class="d-block mb-2 fw-medium">Investment Balance</span>
                                        <h4 class="mb-0 fw-semibold mb-1">${{ number_format($balance, 2) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
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
                                        <span class="d-block mb-2 fw-medium">Active Investment</span>
                                        <h4 class="mb-1 fw-semibold">{{ number_format($asv) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12">
                        <div class="card custom-card icon-overlay">
                            <span class="icon svg-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#000000" viewBox="0 0 256 256"><path d="M192,80v96H104a32,32,0,1,0-32-32H64V80Z" opacity="0.2"></path><path d="M216,40H40A16,16,0,0,0,24,56V200a16,16,0,0,0,16,16H53.39a8,8,0,0,0,7.23-4.57,48,48,0,0,1,86.76,0,8,8,0,0,0,7.23,4.57H216a16,16,0,0,0,16-16V56A16,16,0,0,0,216,40ZM80,144a24,24,0,1,1,24,24A24,24,0,0,1,80,144Zm136,56H159.43a64.39,64.39,0,0,0-28.83-26.16,40,40,0,1,0-53.2,0A64.39,64.39,0,0,0,48.57,200H40V56H216ZM56,96V80a8,8,0,0,1,8-8H192a8,8,0,0,1,8,8v96a8,8,0,0,1-8,8H176a8,8,0,0,1,0-16h8V88H72v8a8,8,0,0,1-16,0Z"></path></svg>
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
                                        <span class="d-block mb-2 fw-medium">Settled Investment</span>
                                        <h4 class="mb-1 fw-semibold">{{ number_format($csv) }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-1 -->

            <!-- Start:: row-2 -->
            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card">
                        <div class="card-header justify-content-between">
                            <div class="card-title">
                                Investment 
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
                                            <th>Package</th>
                                            <th>Slots</th>
                                            <th>Total Invested</th>
                                            <th>Expected returns</th>
                                            <th>Days Left</th>
                                            <th>Status</th>
                                            <th>Date Created</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($investments as $key=>$investment)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $investment->package['name'] }}</td>
                                                <td>{{ $investment['slots'] }}</td>
                                                <td>${{ number_format($investment['amount']) }}</td>
                                                <td>${{ number_format($investment['total_return']) }}</td>
                                                <td>
                                                    @if($investment['status'] == 'active')
                                                        {{ $investment['return_date']->diffInDays(now()) > 0 ? $investment['return_date']->diffInDays(now()) : '---' }}
                                                    @else
                                                        --
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($investment['status'] == 'active')
                                                        <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Active</span>
                                                    @elseif($investment['status'] == 'pending')
                                                        <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                    @elseif($investment['status'] == 'cancelled')
                                                        <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Cancelled</span>
                                                    @elseif($investment['status'] == 'settled')
                                                        <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Settled</span>
                                                    @endif
                                                </td>
                                                <td>{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                <td>
                                                    <a href="{{ route('investments.show', $investment['id']) }}" class="btn btn-sm btn-primary">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($investments->count() == 0)
                                    <tr>
                                        <p class="py-4 text-center">
                                            No Investment
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
</div>
<!-- End::app-content -->
@endsection