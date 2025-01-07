@extends('layouts.user.index')

@section('content')

<style>
    .truncate-2-lines {
        display: -webkit-box;
        -webkit-line-clamp: 2; /* Limits to 2 lines */
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    /* Ensure all columns have the same height */
    .card {
        display: flex;
        flex-direction: column;
    }

    .card-body {
        flex-grow: 1; /* Makes the card body stretch */
    }

    /* Optional: Ensure the image keeps its aspect ratio and doesn't stretch */
    .img-box-2 img {
        object-fit: cover;
        max-height: 250px;
    }

    /* Ensure that footer sticks to the bottom */
    .card-footer {
        margin-top: auto;
    }

    .truncate {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden !important;
        text-overflow: ellipsis;
    }

    .image-box {
      width: 100%;
      height: 200px; /* Set your desired height */
      overflow: hidden; /* Ensures the image doesn't overflow the box */
    }
    .image-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Page Header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Select Plan</h1>
                <div class="">
                    <nav>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="javascript:void(0);">Investment</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Plans</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="d-flex gap-2">
                <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                    <i class="ri-filter-3-fill me-2"></i>Filter
                </button> -->
                <!-- <a href="{{ route('investments') }}" class="btn btn-primary btn-wave waves-effect waves-light">
                    <i class="ri-upload-2-line me-2"></i> My Investment
                </a> -->
            </div>  
        </div>
        <!-- Page Header Close -->

        <!-- Start:: row-1 -->
        <div class="row d-flex flex-wrap">
            @foreach($packages as $package)
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-lg-0 mb-4 d-flex">
                    <div class="card custom-card card-style-2 flex-grow-1"> 
                        <div class="card-body p-0"> 
                            <span class="ribbon-4 ribbon-primary top-left">
                                <span>{{ $package->roi }}%</span>
                            </span>
                            <div class="card-img-top"> 
                                <a href="product-details.html" class="stretched-link"></a> 
                                <div class="img-box-2 p-2 image-box"> 
                                    <img src="{{ $package->image }}" alt="img" class=" img-fluid w-100 rounded" style="max-height: 250px;"> 
                                </div> 
                            </div> 
                            <div class="px-3"> 
                                <div class="d-flex align-items-start justify-content-between"> 
                                    <div class="flex-grow-1"> 
                                        <div class="d-flex align-items-center justify-content-between mt-1 my-1"> 
                                            <div> 
                                                <sapn class="d-inline-block fw-bold text-primary fs-12 rounded"> 
                                                    <span class="text-muted">Duration: </span>{{ $package->milestone }} {{ $package->milestone == 1 ? rtrim($package->duration, 's') : $package->duration }}
                                                </span>
                                            </div> 
                                            <div class="d-flex align-items-baseline"> 
                                                <span class="fw-bold d-inline-block text-primary fs-12 rounded px-3 py-0">
                                                    <span class="text-muted">ROI: </span>{{ $package->roi }}%
                                                </span>
                                            </div> 
                                        </div> 
                                        <div class="d-flex align-items-center justify-content-between mt-1"> 
                                            <h6 class="truncate-2-lines mb-1 fw-semibold fs-16">
                                                <a href="/invest/{{ $package['name'] }}">{{ $package->name }}</a> 
                                            </h6>
                                        </div> 
                                        <div>
                                            <p class="text-muted truncate">{{ $package->description }}</p>
                                        </div>
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                        <div class="card-footer border-top-0 d-grid mt-0 pt-0"> 
                            <div class="d-flex align-items-center text-center justify-content-between py-2"> 
                                <span class="mt-">
                                    <span class="fs-20 fw-semibold text-primary">
                                        {{ number_format($package->min_amount, 2) }} <span class="fs-14 text-muted">USD</span> 
                                    </span>
                                    <span class="mx-1">-</span>
                                    <span class="fs-20 fw-semibold text-primary">
                                        {{ number_format($package->max_amount, 2) }} <span class="fs-14 text-muted">USD</span> 
                                    </span>
                                </span>
                            </div>
                            <a href="/invest/{{ $package['name'] }}" class="btn btn-primary-light">
                                Start Investment
                                <i class="fe fe-arrow-right me-2 align-middle d-inline-block"></i>
                            </a> 
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