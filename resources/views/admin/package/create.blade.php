@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Package</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create Package</h6>
                    <form class="forms-sample" action="{{ route('admin.packages.store') }}" id="createPackageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name"  class="form-control" value="{{ old('name') }}" id="name" placeholder="Name">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price per slot</label>
                            <input type="number" name="price"  class="form-control" value="{{ old('price') }}" id="price" placeholder="Price">
                            @error('price')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="min_duration">Minimum Duration (3_days, 5_months, 1_year)</label>
                            <input type="text" name="min_duration"  class="form-control" value="{{ old('min_duration') }}" id="min_duration" placeholder="Enter minimum day...">
                            @error('min_duration')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="daily_roi">Daily ROI (%)</label>
                            <input type="number" name="daily_roi"  class="form-control" value="{{ old('daily_roi') }}" id="daily_roi" placeholder="Daily ROI">
                            @error('daily_roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="weekly_roi">Weekly ROI (%)</label>
                            <input type="number" name="weekly_roi"  class="form-control" value="{{ old('weekly_roi') }}" id="weekly_roi" placeholder="Weekly ROI">
                            @error('weekly_roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="yearly_roi">Yearly ROI (%)</label>
                            <input type="number" name="yearly_roi"  class="form-control" value="{{ old('yearly_roi') }}" id="yearly_roi" placeholder="Yearly ROI">
                            @error('yearly_roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" id="description" class="form-control" placeholder="Description" rows="5">{{ old('description') }}</textarea>
                            @error('description')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image"  class="form-control-file" id="image">
                            @error('image')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div>
                                <label>Investment in package</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" checked class="form-check-input" name="investment" id="enabled" value="enabled">
                                    Enable
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="investment" id="disabled" value="disabled">
                                    Disable
                                </label>
                            </div>
                            @error('investment')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('createPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" >Create Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
