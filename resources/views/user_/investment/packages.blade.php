@extends('layouts.user.index')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Packages</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Investment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Packages</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button> -->
                <a href="{{ route('investments') }}" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-upload-2-line me-2"></i> My Investment
                </a>
            </div>  
        </div>
        <!-- Page Header Close -->

        <!-- Start:: row-1 -->
        <div class="row">
            @foreach($packages as $package)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4">
                    <div class="card custom-card team-member">
                        <div class=""></div>
                        <div class="card-body text-center p-5">
                            <div class="mb-4 lh-1">
                                <span class="avatar avatar-xxl avatar-rounded p-2 bg-light">
                                    <img src="{{ $package->image }}" class="card-img bg-primary" alt="...">
                                </span>
                            </div>
                            <div class="text-center">
                                <h6 class="mb-0 fw-semibold">{{ $package->name }}</h6>
                                <p class="mb-0 text-muted">{{ $package->description }}</p>
                                <div class="d-flex justify-content-center mt-3">
                                    <span class="text-primary w-100 py-2 rounded fw-bold fs-20">${{ number_format($package->price, 2) }}</span>
                                </div>
                                <div class="mt-4">
                                    @if($package->canRunInvestment())
                                        <a class="btn btn-primary w-100" href="/invest?package={{ $package['name'] }}">Invest</a>
                                    @else
                                        <button class="btn btn-dark-transparent w-100 text-dark" disabled>Invest</button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            @if($packages->count() < 1)
                <div>
                    <p class="fs-15 text-center py-4 my-4"> No available packages... </p>
                </div>
            @endif
        </div>
        <!-- End:: row-1 -->

    </div>
</div>
<!-- End::app-content -->

@endsection