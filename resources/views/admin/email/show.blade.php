@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.email') }}">Email</a></li>
            <li class="breadcrumb-item active" aria-current="page">View</li>
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
                                    <div class="title d-sm-flex d-block align-items-center justify-content-between">
                                        <div>
                                            <span class="card-title">{{ $email['subject'] }}</span>
                                        </div>
                                        <div>
                                            <table>
                                                <tr>
                                                    <th class="small">Date:</th>
                                                    <td class="small text-right">{{ $email['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="small">To:</th>
                                                    <td class="small text-right">{{ $email['to'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="small">Cc:</th>
                                                    <td class="small text-right">{{ $email['cc'] }}</td>
                                                </tr>
                                                <tr>
                                                    <th class="small d-none d-sm-table-cell"></th>
                                                    <td class="small text-sm-right text-left">
                                                        @if($email['status'] == 'failed')
                                                            <span class="badge badge-danger">failed</span>
                                                        @elseif($email['status'] == 'success')
                                                            <span class="badge badge-success">success</span>
                                                        @elseif($email['status'] == 'sending')
                                                            <span class="badge badge-warning">sending</span>
                                                        @elseif($email['status'] == 'queued')
                                                            <span class="badge badge-warning">queued</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-sm-none"></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="email-body">
                                {!! $email['body'] !!}
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
