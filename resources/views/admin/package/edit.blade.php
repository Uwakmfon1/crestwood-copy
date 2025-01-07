@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Savings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Plan</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Plan</h6>
                    <form class="forms-sample" action="{{ route('admin.packages.update', $package->id) }}" id="editPackageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $package->name) }}" id="name" placeholder="Name">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roi">ROI (%)</label>
                            <input type="number" name="roi" class="form-control" value="{{ old('roi', $package->roi) }}" id="roi" placeholder="ROI">
                            @error('roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description', $package->description) }}</textarea>
                            @error('description')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <!-- <div class="form-group">
                            <label for="img">Image URL</label>
                            <input type="text" name="img" class="form-control" value="{{ old('img', $package->img) }}" id="img" placeholder="Image URL...">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div> -->
                        <button type="button" onclick="confirmFormSubmit('editPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2">Update Plan</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
