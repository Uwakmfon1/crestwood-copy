@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.admins') }}">Admins</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create Admin</h6>
                    <form action="{{ route('admin.admins.store') }}" class="forms-sample" id="formToProcess" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control" style="height: 50px; font-size: 14px" placeholder="Name">
                            @error('name')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input id="email" type="email" value="{{ old('email') }}" name="email" class="form-control" style="height: 50px; font-size: 14px" placeholder="Email">
                            @error('email')
                                <strong class="small text-danger">
                                    {{ $message }}
                                </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" id="role" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="">Select Role</option>
                                @foreach(\Spatie\Permission\Models\Role::all()->where('name', '!=', 'Super Admin') as $role)
                                    <option @if(old('role') == $role['id']) selected @endif value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                @endforeach
                            </select>
                            @error('role')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <button type="button" onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Create Admin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
