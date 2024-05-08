@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            @if(request()->offsetExists('active'))
                <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Active</li>
            @elseif(request()->offsetExists('pending'))
                <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pending</li>
            @elseif(request()->offsetExists('cancelled'))
                <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cancelled</li>
            @elseif(request()->offsetExists('settled'))
                <li class="breadcrumb-item"><a href="{{ route('savings') }}">Savings</a></li>
                <li class="breadcrumb-item active" aria-current="page">Settled</li>
            @else
                <li class="breadcrumb-item active" aria-current="page">Savings</li>
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
                        <h6 class="card-title mb-0">@if(request()->offsetExists('active')) Active @elseif(request()->offsetExists('pending')) Pending @elseif(request()->offsetExists('cancelled')) Cancelled @elseif(request()->offsetExists('settled')) Settled @endif Savings</h6>
                        <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="@if(request()->offsetExists('active')) {{ route('investments.export', 'active') }} @elseif(request()->offsetExists('pending')) {{ route('investments.export', 'pending') }} @elseif(request()->offsetExists('cancelled')) {{ route('investments.export', 'cancelled') }} @elseif(request()->offsetExists('settled')) {{ route('investments.export', 'settled') }} @else {{ route('investments.export', 'all') }} @endif"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download CSV</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Package</th>
                                <th>Duration</th>
                                <th>Amount Saved</th>
                                <th>Amount Remaining</th>
                                <th>Days Left</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($savings as $key=>$saving)
                                    @php 
                                        $paid = $saving->transaction()->where('status', 'approved')->count();
                                    @endphp
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $saving->package['name'] }}</td>
                                        <td class="text-capitalize">{{ $saving->package['duration'] }}</td>
                                        <td>₦ {{ number_format($saving['amount'] * $paid) }}</td>
                                        <td>₦ {{ number_format(($saving['amount'] * $saving->package['milestone']) - ($saving['amount'] * $paid)) }}</td>
                                        <td>
                                            @if($saving['status'] == 'active')
                                                {{ $saving['return_date']->diffInDays(now()) >= 1 ? $saving['return_date']->diffInDays(now()) : 0 }}
                                            @else
                                                Completed
                                            @endif
                                        </td>
                                        <td>
                                            @if($saving['status'] == 'active')
                                                @if($saving['return_date']->diffInDays(now()) >= 1)
                                                    <span class="badge badge-pill badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-pill badge-warning">Completed</span>
                                                @endif
                                            @elseif($saving['status'] == 'pending')
                                                <span class="badge badge-pill badge-warning">Pending</span>
                                            @elseif($saving['status'] == 'cancelled')
                                                <span class="badge badge-pill badge-danger">Cancelled</span>
                                            @elseif($saving['status'] == 'settled')
                                                <span class="badge badge-pill badge-secondary">Settled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('savings.show', $saving['id']) }}" class="btn btn-sm btn-primary">View</a> 
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
