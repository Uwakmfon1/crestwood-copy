@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('verified'))
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Verified</li>
            @elseif(request()->offsetExists('unverified'))
                <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
                <li class="breadcrumb-item active" aria-current="page">Unverified</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            @endif
        </ol>
    </nav>
@endsection

@section('content')
<style>
    .truncate {
        max-width: 150px; /* Adjust as needed */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title my-2">@if(request()->offsetExists('verified')) Verified @elseif(request()->offsetExists('unverified')) Unverified @endif Users</h6>
                        <div class="d-flex my-2">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <form action="@if(request()->offsetExists('verified')) {{ route('admin.users.export', 'verified') }} @elseif(request()->offsetExists('unverified')) {{ route('admin.users.export', 'unverified') }} @else {{ route('admin.users.export', 'all') }} @endif">
                                <label><input type="date" name="from" id="export-date-from" hidden></label>
                                <label><input type="date" name="to" id="export-date-to" hidden></label>
                                <button type="submit" class="btn px-3 pb-2 btn-primary">
                                    <i class="icon-sm" data-feather="download"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="userTable" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Verification</th>
                                <th>Joined</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
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
    <script>
        $(document).ready(function () {
            $('#userTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.users.ajax', $type) }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name", "className": "truncate"},
                    { "data": "email" },
                    { "data": "phone" },
                    { "data": "verification" },
                    { "data": "joined" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
