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
                            <!-- <div class="d-flex justify-content-between">
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
                            </div> -->
                            <h2 class='text-warning'>---</h2>
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
                            <div class="col-lg-8 my-2">
                                <label class="col-form-label">Amount</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="${{ number_format($total, 2) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-8 my-2">
                                <label class="col-form-label">Date</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $investment->created_at->format('h:i A') }}" readonly>
                            </div>
                        </div>
                    </div>
                    @foreach($save->answers as $data)
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-lg-8 my-2">
                                <label class="col-form-label">{{ $data->question->text }}</label>
                            </div>
                            <div class="col-lg-8 my-1">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $data->answer->text }}" readonly>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row mx-2">
                    <div class="col-xl-12">
                        <h6 class="fw-bold fs-14 text-dark mb-2">Savings Milestone:</h6>
                        <div class="table-responsive">
                            <table class="table text-nowrap table-striped table-hover">
                                <thead>
                                <tr>
                                    <th class="text-muted fs-10 fw-medium">S/N</th>
                                    <th class="text-muted fs-10 fw-medium">Type</th>
                                    <th class="text-muted fs-10 fw-medium">Amount</th>
                                    <th class="text-muted fs-10 fw-medium">Status</th>
                                    <th class="text-muted fs-10 fw-medium">Date</th>
                                    <th class="text-muted fs-10 fw-medium">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($payment as $index => $save)
                                        <tr>
                                            <td><b>{{ $index + 1 }} </b></td>
                                            <td>
                                                @if($save->is_interest)
                                                    <b> Interest </b>
                                                @else
                                                    <b> Savings </b>
                                                @endif
                                            </td>
                                            <td>
                                                <b>${{ number_format($save->amount, 2) }}</b>
                                            </td>
                                            <td>
                                                @if($save->status == 'success')
                                                    @if(!$save->is_interest)
                                                        <span class="badge bg-success-transparent">
                                                            <b><i class="ri-check-fill align-middle me-1"></i> Paid </b>
                                                        </span>
                                                    @else
                                                        <span class="badge bg-info-transparent">
                                                            <b><i class="ri-check-fill align-middle me-1"></i> Received </b>
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge bg-dark-transparent">
                                                        <b><i class="ri-check-fill align-middle me-1"></i> Awaiting </b>
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <b>{{ $save->created_at->format('d M, Y') }}</b>
                                                <span class="badge bg-dark-transparent">
                                                    <b>{{ $save->created_at->format('h:i A') }} </b>
                                                </span>
                                            </td>
                                            <td>
                                                @if($save->status == 'success')
                                                    @if(!$save->is_interest)
                                                        <button type="button" class="btn btn-primary-light fs-12 fw-bold border-0" disabled>Cleared <i class="fe fe-arrow-right mx-1"></i></button>
                                                    @else
                                                        <form action="{{ route('interest.withdaw', $save->id) }}" method="post">
                                                            @csrf
                                                            <input type="hidden" name="amount" value="{{ $save->amount }}">
                                                            <button type="submit" class="btn btn-info-light fs-12 fw-bold border-0 withdrawInterestBtn">Withdraw <i class="fe fe-arrow-right mx-1"></i></button>
                                                        </form>
                                                    @endif
                                                @else
                                                    <form action="{{ route('savings.payment', $savings->id) }}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="amount" value="{{ $save->amount }}">
                                                        <button type="submit" class="btn btn-primary-light fs-12 fw-bold">Retry Payment <i class="fe fe-arrow-right mx-1"></i></button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive mt-3 pt-4">
                            <table class="table text-nowrap ">
                                <tbody>
                                    <tr>
                                        <td>Total</td>
                                        <td>
                                            <b>${{ number_format($total, 2) }}</b>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary-transparent" id="totalDate">
                                                <b><i class="ri-check-fill align-middle me-1"></i> In Progress </b>
                                            </span>
                                        </td>
                                        <td>
                                            <b>{{ $investment['created_at']->format('d M, Y') }}</b>
                                            <span class="badge bg-dark-transparent">
                                                <b>{{ $save->created_at->format('h:i A') }} </b>
                                            </span>
                                        </td>
                                        <td>
                                            <!-- <form action="{{ route('settle.payment', $investment['id']) }}" method="post">
                                                @csrf -->
                                                <button type="submit" class="btn btn-primary" id="withdrawBtn" disabled>Withdraw <i class="fe fe-card mx-1"></i></button>
                                            <!-- </form> -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
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
    <script>
        $(document).ready(function() {
            let targetDate = new Date("{{ $investment['created_at']->format('Y-m-d H:i:s') }}");
            let countdown = setInterval(function() {
                let now = new Date();
                let distance = targetDate - now;
                
                if (distance < 0) {
                    clearInterval(countdown);
                    $('#countdown').html("<h2 class='text-success'>Savings Active</h2>");
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
