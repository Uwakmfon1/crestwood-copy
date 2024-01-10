@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Savings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Packages</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center mb-3 mt-4">Choose a package</h4>
                    <div class="container">
                        <div class="row">
                            @if(count($packages) > 0)
                                @foreach($packages as $package)
                                    <div class="col-md-4 mb-4 grid-margin grid-margin-md-0">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="text-center text-uppercase mt-3 mb-4">{{ $package['name'] }}</h5>
                                                <div class="my-3 text-center">
                                                    <img src="{{ asset($package['image']) }}" class="mx-auto text-center" style="width: 80px; height: 80px;border-radius: 5px" alt="Basic">
                                                </div>
                                                <h3 class="text-center font-weight-light">{{ $package['roi'] }}%</h3>
                                                <p class="text-muted text-center mb-4 font-weight-light">return on investment</p>
                                                <h4 class="text-muted text-center mb-4 font-weight-600">₦ {{ number_format($package['price']) }}</h4>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i data-feather="clock" class="icon-md text-secondary mr-2"></i>
                                                    <p class="text-capitalize">{{ $package['duration'] }}</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <i data-feather="layers" class="icon-md text-secondary mr-2"></i>
                                                        <p class="badge badge-success">Active</p>
                                                </div>
                                                <div class="d-flex align-items-center mb-2">
                                                    <p class="text-muted">{{ $package['description'] }}</p>
                                                </div>
                                                    <a href="/savings/create?package={{ $package['name'] }}" style="padding: 12px 0" class="btn btn-primary btn-block d-block mx-auto mt-3">Save</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-12 text-center">
                                    No package(s) yet
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
