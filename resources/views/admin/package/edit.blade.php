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
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Price -->
                            <div class="form-group">
                                <label for="price">Price per slot</label>
                                <input type="number" name="price" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('price') ?? $package['price'] }}" id="price" placeholder="Price">
                                @error('price')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Minimum Duration -->
                            <div class="form-group">
                                <label for="min_duration">Minimum Duration (months)</label>
                                <input type="text" name="min_duration" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('min_duration') ?? $package['min_duration'] }}" id="min_duration" placeholder="3_days, 5_months, 1_year...">
                                @error('min_duration')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Daily ROI -->
                            <div class="form-group">
                                <label for="daily_roi">Daily ROI (%)</label>
                                <input type="number" name="daily_roi" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('daily_roi') ?? $package['daily_roi'] }}" id="daily_roi" placeholder="Daily ROI">
                                @error('daily_roi')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Weekly ROI -->
                            <div class="form-group">
                                <label for="weekly_roi">Weekly ROI (%)</label>
                                <input type="number" name="weekly_roi" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('weekly_roi') ?? $package['weekly_roi'] }}" id="weekly_roi" placeholder="Weekly ROI">
                                @error('weekly_roi')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Yearly ROI -->
                            <div class="form-group">
                                <label for="yearly_roi">Yearly ROI (%)</label>
                                <input type="number" name="yearly_roi" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('yearly_roi') ?? $package['yearly_roi'] }}" id="yearly_roi" placeholder="Yearly ROI">
                                @error('yearly_roi')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description') ?? $package['description'] }}</textarea>
                                @error('description')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>

                            <!-- Image Upload -->
                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" style="height: 50px; font-size: 14px" class="form-control-file" id="image">
                                @error('image')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                @enderror
                            </div>
                            <img src="{{ asset($package['image']) }}" class="mx-auto my-3 text-center" style="width: 80px; border-radius: 5px" alt="Package Image">
                            <!-- Investment Options -->
                            <div class="form-group">
                                <label>Investment in package</label>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="investment" value="enabled" {{ $package['investment'] === 'enabled' ? 'checked' : '' }}>
                                        Enable
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="investment" value="disabled" {{ $package['investment'] === 'disabled' ? 'checked' : '' }}>
                                        Disable
                                    </label>
                                </div>
                                @error('investment')
                                    <div class="small text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="button" onclick="confirmFormSubmit('editPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Update Package</button>
                        </form>
                </div>
            </div>
        </div>
    </div>
@endsection
