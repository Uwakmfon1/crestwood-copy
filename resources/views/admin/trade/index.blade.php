@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('buy'))
                <li class="breadcrumb-item"><a href="{{ route('admin.trades') }}">Trades</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buy</li>
            @elseif(request()->offsetExists('sell'))
                <li class="breadcrumb-item"><a href="{{ route('admin.trades') }}">Trades</a></li>
                <li class="breadcrumb-item active" aria-current="page">Sell</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Trades</li>
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
                        <h6 class="card-title my-2">@if(request()->offsetExists('buy')) Buy @elseif(request()->offsetExists('sell')) Sell @endif Trades</h6>
                        <div class="d-flex my-2">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <form action="@if(request()->offsetExists('buy')) {{ route('admin.trades.export', 'buy') }} @elseif(request()->offsetExists('sell')) {{ route('admin.trades.export', 'sell') }} @else {{ route('admin.trades.export', 'all') }} @endif">
                                <label><input type="date" name="from" id="export-date-from" hidden></label>
                                <label><input type="date" name="to" id="export-date-to" hidden></label>
                                <button type="submit" class="btn px-3 pb-2 btn-primary">
                                    <i class="icon-sm" data-feather="download"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="tradeTable" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Symbol</th>
                                <th>Amount</th>
                                <th>Asset</th>
                                <th>Type</th>
                                <th>Date</th>
                                <!-- <th>Status</th> -->
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
            $('#tradeTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.trades.ajax', $type) }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "grams" },
                    { "data": "amount" },
                    { "data": "product" },
                    { "data": "type" },
                    { "data": "date" },
                    // { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
