@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row flex-md-row flex-column-reverse profile-body">
        <div class="col-md-8 mb-5 middle-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <h6 class="card-title">Personal Information</h6>
                    <form action="{{ route('admin.profile.update') }}" class="forms-sample row" id="profileForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-6">
                            <label for="exampleInputUsername1">Name</label>
                            <input type="text" style="height: 40px; font-size: 15px" class="form-control" value="{{ old('name') ?? auth()->user()['name'] }}" name="name" id="exampleInputUsername1" placeholder="Name">
                            @error('name')
                                <span class="text-danger small" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email address</label>
                            <input type="email" style="height: 40px; font-size: 15px" value="{{ auth()->user()['email'] }}" class="form-control" disabled name="email" id="email" placeholder="Email">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="role">Role</label>
                            <input type="text" style="height: 40px; font-size: 15px" value="Super Admin" class="form-control" disabled name="role" id="role" placeholder="Role">
                        </div>
                        <div class="col-12 mt-3">
                            <button type="button" onclick="confirmFormSubmit('profileForm')" class="btn btn-primary mr-2">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-5 left-wrapper">
            <div class="card rounded">
                <div class="card-body">
                    <h6 class="card-title">Change Password</h6>
                    <form class="forms-sample" action="{{ route('admin.password.custom.update') }}" id="changePasswordForm" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="old_password">Old Password</label>
                            <input type="password" style="height: 40px; font-size: 15px" name="old_password" class="form-control" id="old_password" autocomplete="off" placeholder="Old Password">
                            @error('old_password')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">Old Password</label>
                            <input type="password" style="height: 40px; font-size: 15px" name="new_password" class="form-control" id="new_password" autocomplete="off" placeholder="New Password">
                            @error('new_password')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="confirm_password">Confirm Password</label>
                            <input type="password" style="height: 40px; font-size: 15px" name="confirm_password" class="form-control" id="confirm_password" autocomplete="off" placeholder="Confirm Password">
                        </div>
                        <button type="button" onclick="confirmFormSubmit('changePasswordForm')" class="btn btn-primary mr-2">Change Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
