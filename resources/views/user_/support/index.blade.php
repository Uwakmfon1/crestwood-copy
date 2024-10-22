@extends('layouts.user.index')

@section('content')
    <!-- Start::app-content -->
    <div class="main-content app-content">
        <div class="container-fluid">

        @include('partials.users.alert') 

            <!-- Page Header -->
            <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                    <h1 class="page-title fw-medium fs-18 mb-2">Support Ticket</h1>
                    <div class="">
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="javascript:void(0);">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Support</li>
                                <li class="breadcrumb-item active" aria-current="page">Tickets</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <!-- <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                        <i class="ri-filter-3-fill me-2"></i>Filter
                    </button> -->
                    <a href="{{ route('support.create') }}" class="btn btn-primary btn-wave waves-effect waves-light"> 
                        <i class="fe fe-plus me-2"></i> Create Ticket
                    </a> 
                </div>
            </div>
            <!-- Page Header Close -->

            <!-- Start:: row-1 -->
            <div class="row">
                <div class="col-xxl-12 col-xl-12">
                    <div class="card custom-card overflow-hidden">
                        <div class="card-body p-0">
                            <div class="file-manager-folders">
                                <div class="p-3 file-folders-container">
                                    <div class="d-flex mb-3 align-items-center justify-content-between">
                                        <p class="mb-0 fw-medium fs-14">Tickets</p>
                                        <a href="javascript:void(0);" class="fs-12 text-muted fw-medium tag-link"> View All<i class="ti ti-arrow-narrow-right ms-1"></i> </a>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="table-responsive border border-bottom-0">
                                                <table class="table text-nowrap table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Code</th>
                                                            <th scope="col">Subject</th>
                                                            <th scope="col">Priority</th>
                                                            <th scope="col">Status</th>
                                                            <th scope="col">Date Created</th>
                                                            <th scope="col">Date Modified</th>
                                                            <th scope="col">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="files-list">
                                                        @foreach($tickets as $ticket)
                                                        <tr class="@if($ticket['status'] == 'closed') table-active @endif">
                                                            <td>#CW{{ $ticket->uuid }}</td>
                                                            <th scope="row">
                                                                <div class="d-flex align-items-center">
                                                                    <!-- <div class="me-0">
                                                                        <span class="avatar avatar-sm me-2 svg-primary text-primary">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 256"><rect width="256" height="256" fill="none"/><path d="M112,175.67V168a8,8,0,0,0-8-8H48a8,8,0,0,0-8,8v40a8,8,0,0,0,8,8h56a8,8,0,0,0,8-8v-8.82L144,216V160Z" opacity="0.2"/><polyline points="112 175.67 144 160 144 216 112 199.18" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><rect x="40" y="160" width="72" height="56" rx="8" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><polygon points="152 32 152 88 208 88 152 32" opacity="0.2"/><polyline points="152 32 152 88 208 88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/><path d="M176,224h24a8,8,0,0,0,8-8V88L152,32H56a8,8,0,0,0-8,8v88" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="16"/></svg>
                                                                        </span>
                                                                    </div> -->
                                                                    <div>
                                                                        <a href="javascript:void(0);" data-bs-toggle="offcanvas"
                                                                        data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">{{ $ticket->subject }}</a>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td>
                                                                @if($ticket['urgency'] == 'low')
                                                                    <span class="badge bg-dark-transparent">Low</span>
                                                                @elseif($ticket['urgency'] == 'medium')
                                                                    <span class="badge bg-info-transparent">Medium</span>
                                                                @elseif($ticket['urgency'] == 'high')
                                                                    <span class="badge bg-danger-transparent">High</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($ticket['status'] == 'pending')
                                                                    <span class="badge bg-warning-transparent">Pending</span>
                                                                @elseif($ticket['status'] == 'open')
                                                                    <span class="badge bg-success-transparent">Open</span>
                                                                @elseif($ticket['status'] == 'closed')
                                                                    <span class="badge bg-danger-transparent">Closed</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $ticket['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                            <td>{{ $ticket['updated_at']->format('M d, Y \a\t h:i A') }}</td>
                                                            <td>
                                                                <div class="hstack gap-2 fs-15">
                                                                    <a href="{{ route('support.show', $ticket->id) }}" class="btn btn-icon btn-sm btn-primary-light"><i class="ri-eye-line"></i></a>
                                                                    <form action="{{ route('support.destroy', $ticket->id) }}" method="POST">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger-light"><i class="ri-delete-bin-line"></i></button>
                                                                    </form>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                                    @if($tickets->count() < 1)
                                                        <div class="py-5">
                                                            <p class="text-center fw-bold">No Tickets</p>
                                                        </div>
                                                    @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End:: row-1 -->

        </div>
    </div>
    <!-- End::app-content -->
@endsection