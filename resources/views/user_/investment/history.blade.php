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
                            Investments
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                        <form action="{{ route('investments.history') }}" method="GET" class="d-flex align-items-center gap-2">
                            <div class="input-group">
                                <!-- Search input -->
                                <input name="search" class="form-control form-control-sm" type="text" placeholder="Search Here" value="{{ request()->get('search') }}" aria-label="Search">
                                
                                <!-- Sort By dropdown -->
                                <button class="btn btn-primary-transparent btn-sm dropdown-toggle" type="button" id="sortByDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    Sort By 
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="sortByDropdown">
                                    <li><a class="dropdown-item" href="{{ route('investments.history', ['status' => 'active']) }}">Active</a></li>
                                    <li><a class="dropdown-item" href="{{ route('investments.history', ['status' => 'pending']) }}">Pending</a></li>
                                    <li><a class="dropdown-item" href="{{ route('investments.history', ['status' => 'cancelled']) }}">Cancelled</a></li>
                                    <li><a class="dropdown-item" href="{{ route('investments.history', ['status' => 'settled']) }}">Settled</a></li>
                                </ul>
                                
                                <!-- Search button -->
                                <button type="submit" class="btn btn-success btn-sm">Search</button>
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
                                        <th>Package</th>
                                        <th>Slots</th>
                                        <th>Total Invested</th>
                                        <th>Expected returns</th>
                                        <th>Days Left</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($investments as $key => $investment)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $investment->package['name'] ?? 'Deleted Package' }}</td>
                                            <td>{{ $investment['slots'] }}</td>
                                            <td>${{ number_format($investment['amount']) }}</td>
                                            <td>${{ number_format($investment['total_return']) }}</td>
                                            <td>
                                                @if($investment['status'] == 'active')
                                                    {{ $investment['return_date']->diffInDays(now()) > 0 ? $investment['return_date']->diffInDays(now()) : '---' }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td>
                                                @if($investment['status'] == 'active')
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Active</span>
                                                @elseif($investment['status'] == 'pending')
                                                    <span class="badge bg-warning-transparent"><i class="ri-info-fill align-middle me-1"></i>Pending</span>
                                                @elseif($investment['status'] == 'cancelled')
                                                    <span class="badge bg-danger-transparent"><i class="ri-close-fill align-middle me-1"></i>Cancelled</span>
                                                @elseif($investment['status'] == 'settled')
                                                    <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Settled</span>
                                                @endif
                                            </td>
                                            <td>{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                            <td>
                                                <a href="{{ route('investments.show', $investment['id']) }}" class="btn btn-sm btn-primary">View</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($investments->count() == 0)
                                <p class="my-5 text-center">No Investment</p>
                            @endif
                        </div>
                        <div class="card-footer border-top-0">
                            <div class="d-flex align-items-center">
                                <div> Showing {{ $investments->count() }} of {{ $investments->total() }} Entries <i class="bi bi-arrow-right ms-2 fw-semibold"></i> </div>
                                <div class="ms-auto">
                                    <nav aria-label="Page navigation" class="pagination-style-4">
                                        {{ $investments->links() }}
                                    </nav>
                                </div>
                            </div>
                        </div>
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