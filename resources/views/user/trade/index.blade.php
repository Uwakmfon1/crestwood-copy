@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('buy'))
                <li class="breadcrumb-item"><a href="{{ route('trades') }}">Trades</a></li>
                <li class="breadcrumb-item active" aria-current="page">Buy</li>
            @elseif(request()->offsetExists('sell'))
                <li class="breadcrumb-item"><a href="{{ route('trades') }}">Trades</a></li>
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
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">@if(request()->offsetExists('buy')) Buy @elseif(request()->offsetExists('sell')) Sell @endif Trades</h6>
                        <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="@if(request()->offsetExists('buy')) {{ route('trades.export', 'buy') }} @elseif(request()->offsetExists('sell')) {{ route('trades.export', 'sell') }} @else {{ route('trades.export', 'all') }} @endif"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download CSV</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Units</th>
                                <th>Amount</th>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($trades as $key=>$trade)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ round($trade['grams'], 6) }} grams</td>
                                        <td>₦ {{ number_format($trade['amount']) }}</td>
                                        <td>
                                            @if($trade['product'] == 'gold')
                                                <span class="badge badge-gold">Gold</span>
                                            @else
                                                <span class="badge badge-silver">Silver</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($trade['type'] == 'buy')
                                                <span class="badge badge-success">Buy</span>
                                            @else
                                                <span class="badge badge-danger">Sell</span>
                                            @endif
                                        </td>
                                        <td>{{ $trade['created_at']->format('M d, Y') }}</td>
                                        <td>
                                            @if($trade['status'] == 'success')
                                                <span class="badge badge-pill badge-success">Success</span>
                                            @elseif($trade['status'] == 'pending')
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            @elseif($trade['status'] == 'failed')
                                                <span class="badge badge-pill badge-danger">Failed</span>
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
