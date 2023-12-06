@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Maturity</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-sm-flex d-block justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title my-2">Investments Maturity</h6>
                        <div class="d-flex my-2">
                            <form action="">
                                <label>
                                    <select id="filterMonth" class="text-dark" name="month">
                                        @foreach($months as $key=>$month)
                                            <option @if(request()->get('month') == $key + 1) selected @elseif(!request()->get('month') && (int)date('m') == $key + 1) selected @endif value="{{ $key + 1 }}">{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </label>
                                <label>
                                    <select id="filterYear" class="text-dark" name="year">
                                        @for($year=2021; $year <= (date('Y') + 1); $year++)
                                            <option @if(request()->get('year') == $year) selected @elseif(!request()->get('year') && date('Y') == $year) selected @endif value="{{ $year }}">{{ $year }}</option>
                                        @endfor
                                    </select>
                                </label>
                                <button type="submit" id="filterButton" class="btn px-3 pb-2 btn-primary">
                                    Filter
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
                                <th>Slots</th>
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
                    "url": "{{ route('admin.investments.maturity.ajax') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}", "month" : $('#filterMonth').val(), "year": $('#filterYear').val() }
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "package" },
                    { "data": "slots" },
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
