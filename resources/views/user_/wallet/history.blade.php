@extends('layouts.user.index')

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">
        <!-- Start:: row-2 -->
        <div class="row">
            <div class="col-xxl-12 col-xl-12">
                <div class="card custom-card my-4">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            Wallet Transaction
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('transactions.history') }}" method="GET" class="d-flex align-items-center gap-2">
                            <div class="input-group">
                                <!-- Search input -->
                                <input name="search" class="form-control form-control-sm" type="text" placeholder="Search Here" value="{{ request()->get('search') }}" aria-label="Search">
                                
                                <!-- Search button -->
                                <button type="submit" class="btn btn-success btn-sm">Search</button>

                                <!-- Sort By dropdown -->
                                <button class="btn btn-success-transparent btn-sm dropdown-toggle" type="button" id="sortByDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter Status 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortByDropdown">
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['status' => 'active']) }}">Active</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['status' => 'pending']) }}">Pending</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['status' => 'cancelled']) }}">Cancelled</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['status' => 'settled']) }}">Settled</a></li>
                                </ul>
                                <!-- Sort By dropdown -->
                                <button class="btn btn-success-transparent btn-sm dropdown-toggle" type="button" id="sortByDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filter Type 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortByDropdown">
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['type' => 'deposit']) }}">Credit</a></li>
                                    <li><a class="dropdown-item" href="{{ route('transactions.history', ['type' => 'withdrawal']) }}">Debit</a></li>
                                </ul>
                            </div>
                        </form>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="min-height: 65vh;">
                            <table class="table text-nowrap">
                                <thead>
                                    <tr>
                                        <th>S/N</th>
                                        <th>Amount</th>
                                        <th>Account</th>
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Date</th>  
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transactions as $key=>$transaction)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>${{ number_format($transaction['amount'], 2) }}</td>
                                            <td>
                                                @if($transaction['type'] == 'trade')
                                                    <span class="badge bg-pink-transparent">Trading</span>
                                                @elseif($transaction['type'] == 'save')
                                                    <span class="badge bg-info-transparent">Savings</span>
                                                @elseif($transaction['type'] == 'invest')
                                                    <span class="badge bg-primary-transparent">Investment</span>
                                                @elseif($transaction['type'] == 'wallet')
                                                    <span class="badge bg-dark-transparent">Wallet</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction['description'] }}</td>
                                            <td>
                                                @if($transaction['method'] == 'credit')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Credit</span>
                                                @elseif($transaction['method'] == 'debit')
                                                    <span class="badge bg-danger-transparent"><i class="ri-info-fill align-middle me-1"></i>Debit</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($transaction['status'] == 'approved')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Approved</span>
                                                @elseif($transaction['status'] == 'pending')
                                                    <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                @elseif($transaction['status'] == 'decline')
                                                    <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Decline</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                            @if($transactions->count() == 0)
                                <tr>
                                    <p class="py-4 text-center">
                                        No Transactions...
                                    </p>
                                </tr>
                            @endif
                        </div>
                        @if($transactions)
                        <div class="card-footer border-top-0">
                            <div class="d-flex align-items-center">
                                <div> Showing {{ $transactions->count() }} of {{ $transactions->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                <div class="ms-auto">
                                    <nav aria-label="Page navigation" class="pagination-style-4">
                                        {{ $transactions->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- End:: row-2 -->
    </div>
</div>
<!-- End::app-content -->

<!-- End::app-content -->

@endsection