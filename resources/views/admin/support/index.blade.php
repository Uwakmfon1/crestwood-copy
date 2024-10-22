@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Supports</li>
            <li class="breadcrumb-item active" aria-current="page">Tickets</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Tickets</h6>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Priority</th>
                                <th>Team</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tickets as $key=>$ticket)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $ticket->user->first_name }} {{ $ticket->user->last_name }}</td>
                                <td>{{ $ticket->subject }}</td>
                                <td>
                                    @if($ticket['urgency'] == 'low')
                                        <span class="badge badge-pill badge-dark">Low</span>
                                    @elseif($ticket['urgency'] == 'medium')
                                        <span class="badge badge-pill badge-info">Medium</span>
                                    @elseif($ticket['urgency'] == 'high')
                                        <span class="badge badge-pill badge-danger">High</span>
                                    @endif
                                </td>
                                <td>{{ $ticket['department'] }}</td>
                                <td>
                                    @if($ticket['status'] == 'pending')
                                        <span class="badge badge-pill badge-warning">Pending</span>
                                    @elseif($ticket['status'] == 'open')
                                        <span class="badge badge-pill badge-">Open</span>
                                    @elseif($ticket['status'] == 'closed')
                                        <span class="badge badge-pill badge-danger">Closed</span>
                                    @endif
                                </td>
                                <td>{{ $ticket['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg" data-feather="chevron-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="changeRoleModalLabel">
                                            <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.support.view', $ticket->id) }}">
                                                <i data-feather="user-x" class="icon-sm mr-2"></i> 
                                                <span class="">View</span>
                                            </a>
                                            <form action="{{ route('support.destroy', $ticket->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item btn"> <i data-feather="user-x" class="icon-sm mr-2"></i> Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                    {{-- @if($admin->roles()->first()['name'] <> 'Super Admin')
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-primary" type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Action <i class="icon-lg" data-feather="chevron-down"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="changeRoleModalLabel">
                                                @can('Change Admins Role')
                                                <button data-toggle="modal" onclick="setParametersForChangingRole('{{ $admin->roles()->first()['id'] }}', {{ $admin['id'] }})" data-target="#changeRoleModal" class="dropdown-item d-flex align-items-center">
                                                    <i data-feather="settings" class="icon-sm mr-2"></i> <span class="">Change Role</span>
                                                </button>
                                                @endcan
                                                @if($admin['active'] == 1)
                                                    @can('Block Admins')
                                                    <a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit('adminBlock{{ $admin['id'] }}')" href="{{ route('admin.admins.block', $admin['id']) }}"><i data-feather="user-x" class="icon-sm mr-2"></i> <span class="">Block</span></a>
                                                    <form id="adminBlock{{ $admin['id'] }}" action="{{ route('admin.admins.block', $admin['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    @endcan
                                                @else
                                                    @can('Unblock Admins')
                                                    <a class="dropdown-item d-flex align-items-center" href="{{ route('admin.admins.unblock', $admin['id']) }}" onclick="event.preventDefault(); confirmFormSubmit('adminUnblock{{ $admin['id'] }}')"><i data-feather="user-check" class="icon-sm mr-2"></i> <span class="">Unblock</span></a>
                                                    <form id="adminUnblock{{ $admin['id'] }}" action="{{ route('admin.admins.unblock', $admin['id']) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                    </form>
                                                    @endcan
                                                @endif
                                            </div>
                                        </div>
                                    @endif --}}
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

@section('modals')
    @include('partials.admin.modal.change-role')
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        function setParametersForChangingRole(role, user){
            document.getElementById('oldAdminRole').value = role;
            document.getElementById('adminToChangeRoleID').value = user;
        }
    </script>
@endsection
