@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('withdrawal'))
                <li class="breadcrumb-item"><a href="{{ route('admin.transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
            @elseif(request()->offsetExists('pending'))
                <li class="breadcrumb-item"><a href="{{ route('admin.transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending</li>
            @elseif(request()->offsetExists('deposit'))
                <li class="breadcrumb-item"><a href="{{ route('admin.transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Deposits</li>
            @elseif(request()->offsetExists('others'))
                <li class="breadcrumb-item"><a href="{{ route('admin.transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Others</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Transactions</li>
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
                        <h6 class="card-title my-2">@if(request()->offsetExists('deposit')) Deposit @elseif(request()->offsetExists('withdrawal')) Withdrawal @elseif(request()->offsetExists('pending')) Pending @elseif(request()->offsetExists('others')) Other @endif Transactions</h6>
                        <div class="d-flex my-2">
                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc;">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                            <form action="@if(request()->offsetExists('deposit')) {{ route('admin.transactions.export', 'deposit') }} @elseif(request()->offsetExists('withdrawal')) {{ route('admin.transactions.export', 'withdrawal') }} @elseif(request()->offsetExists('pending')) {{ route('admin.transactions.export', 'pending') }} @elseif(request()->offsetExists('others')) {{ route('admin.transactions.export', 'others') }} @else {{ route('admin.transactions.export', 'all') }} @endif">
                                <label><input type="date" name="from" id="export-date-from" hidden></label>
                                <label><input type="date" name="to" id="export-date-to" hidden></label>
                                <button type="submit" class="btn px-3 pb-2 btn-primary">
                                    <i class="icon-sm" data-feather="download"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="transactionTable" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Details</th>
                                <th>Method</th>
                                <!-- <th>Channel</th> -->
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

@section('modals')
    @include('partials.admin.modal.transaction-detail')
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        function populateTransactionDetails(accountName, accountNumber, bankName) {
            $('#accountName').text(accountName);
            $('#accountNumber').text(accountNumber);
            $('#bankName').text(bankName);
        }
        $(document).ready(function () {
            $('#transactionTable').DataTable({
                "processing": true,
                "serverSide": true,
                "searching": true,
                "ajax":{
                    "url": "{{ route('admin.transactions.ajax', $type) }}",
                    "dataType": "json",
                    "type": "POST",
                    "data":{ _token: "{{csrf_token()}}"}
                },
                "columns": [
                    { "data": "sn" },
                    { "data": "name" },
                    { "data": "amount" },
                    { "data": "description" },
                    { "data": "date" },
                    { "data": "details" },
                    { "data": "method" },
                    // { "data": "channel" },
                    { "data": "status" },
                    { "data": "action" }
                ],
                "lengthMenu": [50, 100, 200, 500]
            });
        });
    </script>
@endsection
