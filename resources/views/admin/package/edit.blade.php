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
                            <label for="min_amount">Min Amount</label>
                            <input type="number" name="min_amount" class="form-control" value="{{ old('min_amount', $package->min_amount) }}" id="min_amount" placeholder="Min Amount">
                            @error('min_amount')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="max_amount">Max Amount</label>
                            <input type="number" name="max_amount" class="form-control" value="{{ old('max_amount', $package->max_amount) }}" id="max_amount" placeholder="Max Amount">
                            @error('max_amount')
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
                            <label for="milestone">Investment Method</label>
                            <input type="text" name="milestone" class="form-control" value="{{ old('milestone', $package->milestone) }}" id="milestone" placeholder="Enter minimum day...">
                            @error('milestone')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="duration">Investment Duration</label>
                            <select name="duration" id="duration" class="form-control">
                                <option value="days" {{ old('duration', $package->duration) == 'days' ? 'selected' : '' }}>Day(s)</option>
                                <option value="weeks" {{ old('duration', $package->duration) == 'weeks' ? 'selected' : '' }}>Week(s)</option>
                                <option value="months" {{ old('duration', $package->duration) == 'months' ? 'selected' : '' }}>Month(s)</option>
                                <option value="years" {{ old('duration', $package->duration) == 'years' ? 'selected' : '' }}>Year(s)</option>
                            </select>
                            @error('duration')
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
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control-file" id="image">
                            @if ($package->image)
                                <p>Current Image:</p>
                            @endif
                            @error('image')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <img src="{{ asset($package['image']) }}" class="mx-auto my-3 text-center" style="width: 80px; border-radius: 5px" alt="Package Image">

                        <div class="form-group">
                            <div>
                                <label>Investment in package</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="investment" id="enabled" value="enabled" {{ old('investment', $package->investment) == 'enabled' ? 'checked' : '' }}>
                                    Enable
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="investment" id="disabled" value="disabled" {{ old('investment', $package->investment) == 'disabled' ? 'checked' : '' }}>
                                    Disable
                                </label>
                            </div>
                            @error('investment')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('editPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2">Update Package</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
