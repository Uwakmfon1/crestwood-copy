@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Package</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Edit Package</h6>
                    <form class="forms-sample" action="{{ route('admin.packages.update', $package['id']) }}" id="editPackageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('name') ?? $package['name'] }}" id="name" placeholder="Name">
                            @error('name')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roi">ROI in %</label>
                            <input type="number" name="roi" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('roi') ?? $package['roi'] }}" id="roi" placeholder="ROI">
                            @error('roi')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price per slot</label>
                            <input type="number" name="price" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('price') ?? $package['price'] }}" id="price" placeholder="Price">
                            @error('price')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">Duration in months</label>
                            <input type="number" name="duration" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('duration') ?? $package['duration'] }}" id="duration" placeholder="Duration">
                            @error('duration')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description') ?? $package['description'] }}</textarea>
                            @error('description')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" style="height: 50px; font-size: 14px" class="form-control-file" id="image">
                            @error('image')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <img src="{{ asset($package['image']) }}" class="mx-auto my-3 text-center" style="width: 80px; border-radius: 5px" alt="Basic">
                        <div class="form-group">
                            <div>
                                <label>Investment in package</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" @if($package['investment'] == "enabled") checked @endif class="form-check-input" name="investment" id="optionsRadios5" value="enabled">
                                    Enable
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" @if($package['investment'] == "disabled") checked @endif class="form-check-input" name="investment" id="optionsRadios6" value="disabled">
                                    Disable
                                </label>
                            </div>
                            @error('investment')
                            <div class="small text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('editPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Update Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
