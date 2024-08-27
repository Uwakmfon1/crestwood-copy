@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Savings</a></li>
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
                    <h6 class="card-title">Create Savings Package</h6>
                    <form class="forms-sample" action="{{ route('admin.saving.package.store') }}" id="createPackageForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('name') }}" id="name" placeholder="Name">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="roi">ROI in %</label>
                            <input type="number" name="roi" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('roi') }}" id="roi" placeholder="ROI">
                            @error('roi')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" name="price" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('price') }}" id="price" placeholder="Price">
                            @error('price')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <!-- <div class="form-group">
                            <label for="duration">Duration</label>
                            <select name="duration" id="duration" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('duration') }}">
                                <option value="#">Select Duration</option>
                                <option value="daily">Daily</option>
                                <option value="weekly">Weekly</option>
                                <option value="monthly">Monthly</option>
                            </select>
                            @error('duration')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div> -->
                        <!-- <div class="form-group">
                            <label for="milestone">Milestone</label>
                            <input type="number" name="milestone" style="height: 50px; font-size: 14px" class="form-control" value="{{ old('milestone') }}" id="milestone" placeholder="Milestone">
                            @error('milestone')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div> -->
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
                            <input type="file" name="image" style="height: 50px; font-size: 14px" class="form-control-file" id="image">
                            @error('image')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('createPackageForm')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Create Package</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
