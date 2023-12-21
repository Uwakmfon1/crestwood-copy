@extends('layouts.user')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Notifications</li>
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
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="email-title mb-2 mb-md-0"><span class="icon"><i data-feather="bell"></i></span> Notifications
                                            @if(auth()->user()->unreadNotifications()->count() > 0)
                                                <span class="new-messages">({{ auth()->user()->unreadNotifications()->count() }} new)</span> </div>
                                            @endif
                                    </div>
                                </div>
                            </div>
                            <div class="email-filters d-flex align-items-center justify-content-between flex-wrap">
                                <div class="email-filters-left flex-wrap d-md-flex">
                                    <div class="btn-group mb-1 mb-md-0">
                                        <a href="{{ route('notifications.read') }}" class="btn btn-sm btn-outline-primary" type="button">Mark all as read</a>
                                    </div>
                                </div>
                            </div>
                            <div class="email-list">
                                @if(count($notifications) > 0)
                                @foreach ($notifications as $notification)
                                <div class="email-list-item @if(!$notification['read_at']) email-list-item--unread @endif">
                                    <div class="email-list-actions">
                                        <a class="favorite" href="{{ route('notifications.show', $notification['id']) }}">
                                            {!! $notification['data']['icon'] !!}
                                        </a>
                                    </div>
                                    <a href="{{ route('notifications.show', $notification['id']) }}" class="email-list-detail">
                                        <div>
                                            <span class="from">{{ $notification['data']['title'] }}</span>
                                            <p class="msg">{!! $notification['data']['description'] !!}</p>
                                        </div>
                                        <span class="date">
                                        <span class="icon"><i data-feather="calendar"></i> </span>
                                        {{ $notification['created_at']->format('d M, Y') }}
                                      </span>
                                    </a>
                                </div>
                                @endforeach
                                @else
                                    <div class="email-list-item disabled">
                                        <p class="email-list-detail disabled">
                                            No notifications(s)
                                        </p>
                                    </div>
                                @endif
                                <div class="mt-3">
                                    {{ $notifications->links() }}
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
