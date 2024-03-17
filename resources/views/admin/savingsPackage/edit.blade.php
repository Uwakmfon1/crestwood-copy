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
                    <form class="forms-sample" action="{{ route('admin.saving.package.update', $package['id']) }}" id="editPackageForm" method="POST" enctype="multipart/form-data">
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
                            <label for="duration">Duration</label>
                            <select name="duration" id="duration" style="height: 50px; font-size: 14px" class="form-control">
                                <option value="#" {{ old('duration') == '#' ? 'selected' : '' }}>Select Duration</option>
                                <option value="daily" {{ old('duration') == 'daily' ? 'selected' : ($package['duration'] == 'daily' ? 'selected' : '') }}>Daily</option>
                                <option value="weekly" {{ old('duration') == 'weekly' ? 'selected' : ($package['duration'] == 'weekly' ? 'selected' : '') }}>Weekly</option>
                                <option value="monthly" {{ old('duration') == 'monthly' ? 'selected' : ($package['duration'] == 'monthly' ? 'selected' : '') }}>Monthly</option>
                            </select>

                            @error('duration')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="milestone">Milestone</label>
                            <input type="number" name="milestone" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('milestone') ?? $package['milestone'] }}" id="milestone" placeholder="Milestone">
                            @error('milestone')
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
                            <input type="file" name="image" style="height: 50px; font-size: 14px" class="form-control-file" id="image" accept="image/*">
                            @error('image')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <img src="{{ asset($package['image']) }}" class="mx-auto my-3 text-center" style="width: 80px; border-radius: 5px" alt="Basic">
                        
                        <button type="button" onclick="confirmFormSubmit('editPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Update Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
