@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @if($type == 'packages')
                <li class="breadcrumb-item"><a href="{{ route('admin.packages') }}">Packages</a></li>
            @endif
            @if(request()->offsetExists('active'))
                <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Active</li>
            @elseif(request()->offsetExists('pending'))
                <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending</li>
            @elseif(request()->offsetExists('cancelled'))
                <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cancelled</li>
            @elseif(request()->offsetExists('settled'))
                <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settled</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Investments</li>
            @endif
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title my-2">@if(request()->offsetExists('active')) Active @elseif(request()->offsetExists('pending')) Pending @elseif(request()->offsetExists('cancelled')) Cancelled @elseif(request()->offsetExists('settled')) Settled @endif Investments</h6>
                        <div class="d-flex my-2">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <form action="@if(request()->offsetExists('active')) {{ route('admin.investments.export', 'active') }} @elseif(request()->offsetExists('pending')) {{ route('admin.investments.export', 'pending') }} @elseif(request()->offsetExists('cancelled')) {{ route('admin.investments.export', 'cancelled') }} @elseif(request()->offsetExists('settled')) {{ route('admin.investments.export', 'settled') }} @else {{ route('admin.investments.export', 'all') }} @endif">
                                <label><input type="date" name="from" id="export-date-from" hidden></label>
                                <label><input type="date" name="to" id="export-date-to" hidden></label>
                                <button type="submit" class="btn px-3 pb-2 btn-primary">
                                    <i class="icon-sm" data-feather="download"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="investmentTable" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Package</th>
                                <th>Total Invested</th>
                                <th>Expected Returns</th>
                                <th>Return Date</th>
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
            $('#investmentTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.investments.ajax', $type) }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}", "package": {{ $id ?? 'null' }} }
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "package" },
                    { "data": "total_invested" },
                    { "data": "expected_returns" },
                    { "data": "return_date" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
