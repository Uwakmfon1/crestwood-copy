@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Email</li>
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
                            <div class="email-inbox-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="email-title mb-2 mb-md-0">Sent Emails</div>
                                    @can('Send Emails')
                                        <a href="{{ route('admin.email.create') }}" class="btn btn-primary">New Email</a>
                                    @endcan
                                </div>
                            </div>
                            <hr>
                            <div class="email-list">
                                @if(count($emails) > 0)
                                @foreach($emails as $email)
                                    <div class="email-list-item">
                                        <a href="{{ route('admin.email.show', $email['id']) }}" class="email-list-detail">
                                    <div>
                                        <span class="from">{{ $email['subject'] }}</span>
                                    </div>
                                    <div class="mt-md-0 mt-3">
                                        <span class="d-block date"><span class="icon"><i data-feather="mail"></i></span>{{ $email['to'] }}</span>
                                        <span class="date mt-1 text-md-right text-left d-block">
                                            <span class="icon"><i data-feather="calendar"></i></span>
                                            {{ $email['created_at']->format('d M, Y') }}
                                        </span>
                                        <div class="text-md-right text-left">
                                            @if($email['status'] == 'failed')
                                                <span class="badge badge-danger">failed</span>
                                            @elseif($email['status'] == 'success')
                                                <span class="badge badge-success">success</span>
                                            @elseif($email['status'] == 'sending')
                                                <span class="badge badge-warning">sending</span>
                                            @elseif($email['status'] == 'queued')
                                                <span class="badge badge-warning">queued</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                    </div>
                                @endforeach
                                @else
                                    <div class="email-list-item disabled">
                                        <p class="email-list-detail disabled">
                                            No email(s)
                                        </p>
                                    </div>
                                @endif
                                    <div class="mt-3">
                                        {{ $emails->links() }}
                                    </div>
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
