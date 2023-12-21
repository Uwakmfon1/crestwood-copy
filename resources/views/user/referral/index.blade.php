@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Referrals</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Referrals</h6>
                        <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <a class="dropdown-item d-flex align-items-center" href="#"><i data-feather="download" class="icon-sm mr-2"></i> <span class="">Download</span></a>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTableExample" class="table">
                            <thead>
                            <tr>
                                <th><i class="fas fa-list-ul"></i></th>
                                <th>Name</th>
                                <th>Email</th>
{{--                                <th>Earning</th>--}}
                                <th>Date</th>
{{--                                <th>Status</th>--}}
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($referrals as $key=>$referral)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $referral['referred']['name'] }}</td>
                                    <td>{{ $referral['referred']['email'] }}</td>
{{--                                    <td>₦ @if($referral['amount']) {{ number_format($referral['amount']) }} @else ---- @endif</td>--}}
                                    <td>{{ $referral['created_at']->format('M d, Y') }}</td>
{{--                                    <td>--}}
{{--                                        @if($referral['paid'] <> 1)--}}
{{--                                            <span class="badge badge-pill px-2 badge-warning">Pending</span>--}}
{{--                                        @else--}}
{{--                                            <span class="badge badge-pill px-2 badge-success">Paid</span>--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
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
