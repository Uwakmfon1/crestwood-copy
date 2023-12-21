@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('notifications') }}">Notifications</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row inbox-wrapper">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 email-content">
                            <div class="email-head">
                                <div class="email-head-subject">
                                    <div class="title d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="card-title text-capitalize">{{ json_decode($notification->data)->title }}</span>
                                        </div>
                                        <div class="small date">{{ date('M d, Y \a\t h:i A', strtotime($notification->created_at)) }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="email-body">
                                {!! json_decode($notification->data)->body !!}
                            </div>
                        </div>
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
