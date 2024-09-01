@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.savings') }}">Savings</a></li>
            @if(request()->has('active'))
                <li class="breadcrumb-item active" aria-current="page">Active</li>
            @elseif(request()->has('pending'))
                <li class="breadcrumb-item active" aria-current="page">Pending</li>
            @elseif(request()->has('cancelled'))
                <li class="breadcrumb-item active" aria-current="page">Cancelled</li>
            @elseif(request()->has('settled'))
                <li class="breadcrumb-item active" aria-current="page">Settled</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">All</li>
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
                        <h6 class="card-title my-2">
                            @if(request()->has('active')) 
                                Active 
                            @elseif(request()->has('pending')) 
                                Pending 
                            @elseif(request()->has('cancelled')) 
                                Cancelled 
                            @elseif(request()->has('settled')) 
                                Settled 
                            @else
                                All 
                            @endif Savings
                        </h6>
                        <div class="d-flex my-2">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            {{--  <form action="{{ route('admin.savings.export', request()->segment(2)) }}" method="GET">
                                <input type="hidden" name="from" id="export-date-from">
                                <input type="hidden" name="to" id="export-date-to">
                                <button type="submit" class="btn px-3 pb-2 btn-primary">
                                    <i class="icon-sm" data-feather="download"></i>
                                </button>
                            </form> --}}
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="savingsTable" class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Timeframe</th>
                                    <th>Deposit</th>
                                    <th>Contribution</th>
                                    <th>Total Return</th>
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
            $('#savingsTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.savings.ajax', request()->segment(2)) }}",
                    "type": "POST",
                    "data": { 
                        _token: "{{ csrf_token() }}", 
                    }
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "timeframe" },
                    { "data": "deposit" },
                    { "data": "contribution" },
                    { "data": "total_return" },
                    { "data": "return_date" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
