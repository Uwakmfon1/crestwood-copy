@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.investments') }}">Investments</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body row">
                    <h4 class="card-title col-12">Investment Countdown</h4>
                    <div id="countdown" class="col-md-5">
                        @if($investment && $investment['status'] == 'active')
                            <div class="d-flex justify-content-between">
                                <div class="px-3 py-2 bg-light" style="border-radius: 5px">
                                    <div id="days" class="display-3 text-center">00</div>
                                    <span class="text-center">Days</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="hours" class="display-3 text-center">00</div>
                                    <span class="text-center">Hours</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="minutes" class="display-3 text-center">00</div>
                                    <span class="text-center">Minutes</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="seconds" class="display-3 text-center">00</div>
                                    <span class="text-center">Seconds</span>
                                </div>
                            </div>
                        @elseif($investment && $investment['status'] == 'pending')
                            <h2 class='text-warning'>Pending</h2>
                        @elseif($investment && $investment['status'] == 'cancelled')
                            <h2 class='text-danger'>Cancelled</h2>
                        @elseif($investment && $investment['status'] == 'settled')
                            <h2 class='text-secondary'>Settled</h2>
                        @endif
                    </div>
                    <h4 class="card-title mt-4 mb-1 col-12">Savings Details</h4>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">User</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $investment->user->name ?? 'N/A' }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Total Value</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($investment['contribution'] + ($investment['deposit'] * 1), 2) }}" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">ROI</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ number_format($investment['roi'], 0) }}%" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Deposit</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($investment['deposit'], 2) }}" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Contribution</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($investment['contribution'], 2) }} ({{ $investment['timeframe'] }})" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Start Date</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $investment['created_at']->format('M d, Y') }}" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Return Date</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $investment['return_date']->format('M d, Y') }}" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Contribution Done</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($investment['contribution'], 2) }}" readonly>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group row">
        <div class="col-lg-3">
            <label class="col-form-label">Expected Return</label>
        </div>
        <div class="col-lg-8">
            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($investment['total_return'], 2) }}" readonly>
        </div>
    </div>
</div>

                    {{-- <div class="col-12">
                        <form action="{{ route('admin.investments.rollover') }}" id="rolloverForm" style="display: none" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="package"></label>
                                <select id="package" @if($investment->rollover) disabled @endif class="form-control" name="package_id">
                                    @foreach($packages as $package)
                                        <option value="{{ $package->id }}" {{ old('package_id') == $package->id ? 'selected' : '' }}>
                                            {{ $package->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" name="investment_id" value="{{ $investment->id }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Rollover</button>
                            </div>
                        </form>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
    <script>
        $(document).ready(function() {
            let targetDate = new Date("{{ $investment['return_date']->format('Y-m-d H:i:s') }}");
            let countdown = setInterval(function() {
                let now = new Date();
                let distance = targetDate - now;
                
                if (distance < 0) {
                    clearInterval(countdown);
                    $('#countdown').html("<h2 class='text-success'>Investment Complete</h2>");
                    return;
                }
                
                let days = Math.floor(distance / (1000 * 60 * 60 * 24));
                let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                let seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                $('#days').text(days);
                $('#hours').text(hours);
                $('#minutes').text(minutes);
                $('#seconds').text(seconds);
            }, 1000);
        });
    </script>
@endsection
