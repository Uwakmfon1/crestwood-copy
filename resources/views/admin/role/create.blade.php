@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.roles') }}">Roles</a></li>
            <li class="breadcrumb-item active" aria-current="page">Create</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Create Role</h6>
                    <form action="{{ route('admin.roles.store') }}" class="forms-sample" id="formToProcess" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name" >Name</label>
                            <input id="name" type="text" value="{{ old('name') }}" name="name" class="form-control" style="height: 50px; font-size: 14px" placeholder="Name">
                            @error('name')
                            <div class="small text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group row">
                            <div class="col-12 d-flex justify-content-between">
                                <label>Permissions</label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input id="selectAll" type="checkbox" class="form-check-input">
                                        Select All
                                    </label>
                                </div>
                            </div>
                            @foreach(\Spatie\Permission\Models\Permission::query()->whereNotIn('name', ['View Trading Dashboard', 'View Trades', 'View Market / Statistics'])->get() as $permission)
                            <div class="col-md-6">
                                <div class="form-check">
                                    <label style="white-space: normal" class="form-check-label">
                                        <input @if($permission['name'] == 'View Quick Overview') checked disabled @endif value="{{ $permission['name'] }}" name="permissions[]" type="checkbox" class="form-check-input permission-check-box">
                                        {{ $permission['name'] }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                            <div class="col-12">
                                @error('permissions')
                                <div class="small text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <button type="button" onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Create Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            let selectAll = $('#selectAll');
            let permissionCheckBoxes = $('.permission-check-box');
            selectAll.on('change', toggleAllPermissions);
            function toggleAllPermissions(){
                if (selectAll.prop('checked')){
                    permissionCheckBoxes.each(function (){
                        $(this).prop('checked', true);
                    });
                }else {
                    permissionCheckBoxes.each(function (){
                        if (!$(this).prop('disabled')) {
                            $(this).prop('checked', false);
                        }
                    });
                }
            }
        });
    </script>
@endsection
