@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('withdrawal'))
                <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Withdrawals</li>
            @elseif(request()->offsetExists('deposit'))
                <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Deposits</li>
            @elseif(request()->offsetExists('others'))
                <li class="breadcrumb-item"><a href="{{ route('transactions') }}">Transactions</a></li>
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
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">@if(request()->offsetExists('deposit')) Deposit @elseif(request()->offsetExists('withdrawal')) Withdrawal @elseif(request()->offsetExists('others')) Other @endif Transactions</h6>
                        <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="@if(request()->offsetExists('deposit')) {{ route('transactions.export', 'deposit') }} @elseif(request()->offsetExists('withdrawal')) {{ route('transactions.export', 'withdrawal') }} @elseif(request()->offsetExists('others')) {{ route('transactions.export', 'others') }} @else {{ route('transactions.export', 'all') }} @endif"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download CSV</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Amount</th>
                                <th>Type</th>
                                <th>Account</th>
                                <th>Description</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($transactions as $key=>$transaction)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>₦ {{ number_format($transaction['amount']) }}</td>
                                        <td>{{ $transaction['type'] }}</td>
                                        <td>{{ $transaction['account_type'] }}</td>
                                        <td>{{ $transaction['description'] }}</td>
                                        <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                        <td>
                                            @if($transaction['status'] == 'approved')
                                                <span class="badge badge-pill badge-success">Approved</span>
                                            @elseif($transaction['status'] == 'pending')
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            @elseif($transaction['status'] == 'declined')
                                                <span class="badge badge-pill badge-danger">Declined</span>
                                            @endif
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
