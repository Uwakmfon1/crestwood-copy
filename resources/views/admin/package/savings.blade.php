@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Packages</li>
            <li class="breadcrumb-item active" aria-current="page">Savings</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('Create Packages')
                    <div class="d-flex mb-3 align-items-center justify-content-between">
                        <div class="card-title">Savings Plan</div>
                    </div>
                    @endcan
                    <div class="row">
                        @if(count($packages) > 0)
                            @foreach($packages as $package)
                                <div class="col-md-4 grid-margin mb-4 grid-margin-md-0">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="text-center text-uppercase mt-3 mb-4">{{ $package['name'] }}</h5>
                                            <div class="my-3 text-center">
                                                <img src="{{ $package['img'] }}" class="mx-auto text-center" style="width: 80px; height: 80px; border-radius: 5px" alt="{{ $package['name'] }}">
                                            </div>
                                            <h3 class="text-center font-weight-light">{{ $package['roi'] }}%</h3>
                                            <p class="text-muted text-center mb-4 font-weight-light">return on savings</p>
                                            <div class="d-flex px-auto text-center mb-2 mx-auto">
                                                <i data-feather="layers" class="icon-md text-secondary mr-2"></i>
                                                @if($package)
                                                    <p class="badge badge-success">Active</p>
                                                @else
                                                    <p class="badge badge-danger">Inactive</p>
                                                @endif
                                            </div>
                                            <div class="d-flex align-items-center mb-2">
                                                <p class="text-muted">{{ $package['description'] }}</p>
                                            </div>
                                            <div class="d-flex justify-content-center">
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Action <i class="icon-lg" data-feather="chevron-down"></i>
                                                    </button>
                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                        @can('Edit Packages')
                                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.saving.package.edit', $package['id']) }}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                        @endcan
                                                        @can('View Investments')
                                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.savings') }}"><i data-feather="layers" class="icon-sm mr-2"></i> <span class="">View Savings</span></a>
                                                        @endcan
                                                    </div>
                                                </div>
                                            </div>
                                            <form action="{{ route('admin.saving.package.destroy', $package['id']) }}" id="deletePackage{{ $package['id'] }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
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
@endsection
