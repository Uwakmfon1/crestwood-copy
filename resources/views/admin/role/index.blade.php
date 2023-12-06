@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Roles</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Roles</h6>
                        <div class="dropdown mb-2">
                            @can('Create Roles')
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">Create Role</a>
                            @endcan
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Users</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $key=>$role)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $role['name'] }}</td>
                                        <td>{{ \App\Models\Admin::role($role['name'])->count() }}</td>
                                        <td>{{ $role['created_at']->format('M d, Y') }}</td>
                                        <td>
                                            <div class="dropdown">
                                                <button @if(!auth()->user()->can('Edit Roles') && !auth()->user()->can('Delete Roles')) disabled @endif class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Action <i class="icon-lg" data-feather="chevron-down"></i>
                                                </button>
                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                                    @can('Edit Roles')
                                                        <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.roles.edit', $role['id']) }}"><i data-feather="edit-2" class="icon-sm mr-2"></i> <span class="">Edit</span></a>
                                                    @endcan
                                                    @can('Delete Roles')
                                                        <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit('roleDelete{{ $role['id'] }}')" href="{{ route('admin.roles.destroy', $role['id']) }}"><i data-feather="delete" class="icon-sm mr-2"></i> <span class="">Delete</span></a>
                                                    @endcan
                                                    <form id="roleDelete{{ $role['id'] }}" action="{{ route('admin.roles.destroy', $role['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
@endsection
