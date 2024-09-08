@extends('layouts.user.index')

@section('style')

<style>
    
</style>

@endsection

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::row-1 -->
        <div class="row my-3">
            <div class="col-xl-9">
                <div class="card custom-card">
                    <div class="card-header d-md-flex d-block">
                        <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                            <div class="">
                                <img src="../assets/images/brand-logos/toggle-logo.png" alt="">
                            </div>
                            <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                <div class="d-flex align-middle fw-medium mb-0">
                                    <h4>{{ $investment->package['name'] }}</h4>
                                    <span class="mx-4 alert alert-primary fw-medium" style="font-weight: 700;"> 
                                        &#36; {{ number_format($investment['amount']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto mt-md-0 mt-2">
                            <!-- <button class="btn btn-sm btn-primary-light me-1" onclick="javascript:window.print();">Print<i class="ri-printer-line ms-1 align-middle d-inline-block"></i></button> -->
                            <!-- <a class="btn btn-sm btn-primary">Back to investment<i class="ri-file-pdf-line ms-1 align-middle d-inline-block"></i></a> -->
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Price:</p>
                                <p class="fs-15 mb-1">₦ {{ number_format($investment['amount'] / 1) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Duration :</p>
                                <p class="fs-15 mb-1">{{ $investment['return_date']->diff($investment['investment_date'])->m }} months</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Slots Purchased :</p>
                                <p class="fs-15 mb-1">1</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">ROI</p>
                                <p class="fs-15 mb-1">{{ (($investment['total_return'] - $investment['amount']) / $investment['amount'] ) * 100 }} %</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">ROI Amount :</p>
                                <p class="fs-15 mb-1">₦ {{ number_format($investment['total_return'] - $investment['amount']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Amount Invested :</p>
                                <p class="fs-15 mb-1">₦ {{ number_format($investment['amount']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Expected Returns :</p>
                                <p class="fs-15 mb-1">₦ {{ number_format($investment['total_return']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Investment Date :</p>
                                <p class="fs-15 mb-1">{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Return Date :</p>
                                <p class="fs-15 mb-1">{{ $investment['return_date']->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <!-- <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">investment Date :</p>
                                <p class="fs-15 mb-1">{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Maturity Date :</p>
                                <p class="fs-15 mb-1">{{ $investment['return_date']->format('M d, Y \a\t h:i A') }}</p>
                            </div> -->

                            {{-- <div class="col-xl-12 my-5">
                                <h6 class="fw-medium text-muted my-3">Milestone:</h6>
                                <div class="table-responsive">
                                    <table class="table text-nowrap table-striped table-hover">
                                        <thead>
                                        <tr>
                                            <th>Milestone</th>
                                            <th>Amount</th>
                                            <th>Date Range</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @for ($i = 1; $i <= $investment['milestone']; $i++)
                                                <tr>
                                                    <td>Milestone {{ $i }}</td>
                                                    <td>₦ {{ number_format($investment['amount']) }}</td>
                                                    <td>
                                                        @php
                                                            // Determine the milestone date based on the package duration
                                                            switch ($investment->package['duration']) {
                                                                case 'weekly':
                                                                    $milestoneDate = \Carbon\Carbon::make($investment['investment_date'])->addWeeks($i - 1);
                                                                    break;
                                                                case 'monthly':
                                                                    $milestoneDate = \Carbon\Carbon::make($investment['investment_date'])->addMonths($i - 1);
                                                                    break;
                                                                default:
                                                                    $milestoneDate = \Carbon\Carbon::make($investment['investment_date'])->addDays($i - 1);
                                                                    break;
                                                            }

                                                            // Check if there is an approved transaction on the milestone date
                                                            $isPaid = $investment->transaction()
                                                                ->where('status', 'approved')
                                                                ->whereDate('created_at', $milestoneDate->toDateString())
                                                                ->exists();
                                                        @endphp
                                                        {{ $milestoneDate->format('M d, Y \a\t h:i A') }}
                                                    </td>
                                                    <td>
                                                        @if ($isPaid)
                                                            <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Paid</span>
                                                        @else
                                                            @if (\Carbon\Carbon::now()->greaterThan($milestoneDate))
                                                            <span class="badge bg-light text-dark"><i class="ri-reply-line align-middle me-1"></i>Void</span>
                                                            @else
                                                                <span class="badge bg-warning-transparent"><i class="ri-delete-fill align-middle me-1"></i>Pending</span>
                                                            @endif
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (!$isPaid && \Carbon\Carbon::now()->isSameDay($milestoneDate) && \Carbon\Carbon::now()->format('H:i') >= $milestoneDate->format('H:i'))
                                                            <form action="{{ route('make.payment', $investment['id']) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">Retry Payment</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endfor

                                        </tbody>
                                            @php
                                                $currentDate = \Carbon\Carbon::now();
                                                $returnDate = \Carbon\Carbon::make($investment['return_date']);
                                                $isReturnDateDue = $currentDate->startOfDay()->greaterThanOrEqualTo($returnDate->startOfDay()) 
                                                                && $currentDate->format('H:i') >= $returnDate->format('H:i');
                                            @endphp

                                            @if ($isReturnDateDue)
                                                <tr>
                                                    <td>Total</td>
                                                    <td>
                                                        <b>₦ {{ number_format($investment['amount'] * $paid + $investment['amount'] / $investment->package['roi'] * $paid) }}</b>
                                                    </td>
                                                    <td>
                                                        <b>{{ $returnDate->format('M d, Y \a\t h:i A') }}</b>
                                                    </td>
                                                    <td>
                                                        @if ($investment['status'] == 'settled')
                                                            <span class="badge badge-pill badge-success py-1 px-3">Credited ✅</span>
                                                        @else
                                                            <span class="text-success"><b>Completed 🥳</b></span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($investment['status'] != 'settled' && $isReturnDateDue)
                                                            <form action="{{ route('settle.payment', $investment['id']) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn btn-primary">Withdraw</button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                    </table>
                                </div>
                            </div> --}}
                        </div>
                        <div id="countdown">
                            @if($investment['status'] == 'active')
                            <div class="d-flex justify-content-between my-4">
                                <div class="mx-2 alert alert-primary px-2" style="width: 80%;">
                                    <div id="days" class="display-3 text-center">00</div>
                                    <span class="text-center">Days</span>
                                </div>
                                <div class="mx-2 alert alert-primary px-2" style="width: 80%;">
                                    <div id="hours" class="display-3 text-center">00</div>
                                    <span class="text-center">Hours</span>
                                </div>
                                <div class="mx-2 alert alert-primary px-2" style="width: 80%;">
                                    <div id="minutes" class="display-3 text-center">00</div>
                                    <span class="text-center">Minutes</span>
                                </div>
                                <div class="mx-2 alert alert-primary px-2" style="width: 80%;">
                                    <div id="seconds" class="display-3 text-center">00</div>
                                    <span class="text-center">Seconds</span>
                                </div>
                                <div class="alert alert-primary" style="display: none; margin: 0px !important; padding: 0px !important;">
                                    
                                </div>
                            </div>
                            @elseif($investment['status'] == 'pending')
                                <h2 class='text-warning py-3 my-4'>Pending</h2>
                            @elseif($investment['status'] == 'cancelled')
                                <h2 class='text-danger py-3 my-4'>Cancelled</h2>
                            @elseif($investment['status'] == 'settled')
                                <h2 class='text-secondary py-3 my-4'>Settled</h2>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            Package
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <p>
                                    <span class="fw-medium text-muted fs-12">Name :</span> {{ $investment->package['name'] }}
                                </p>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Description :</span> {{ $investment->package['description'] }}
                                </p>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Amount :</span> <span class="text-primary fw-medium fs-14">&#36; {{ number_format($investment->package['price']) }}</span>
                                </p>
                                <!-- <p>
                                    <span class="fw-medium text-muted fs-12">Duration :</span> {{ $investment->package['description'] }} - <span class="text-danger fs-12 fw-medium">30 days due</span>
                                </p> -->
                                <p>
                                    <span class="fw-medium text-muted fs-12">ROI : <span class="badge bg-primary-transparent">{{ $investment->package['roi'] }}%</span></span>
                                </p>
                                <!-- <div class="alert alert-primary" role="alert">
                                    Please Make sure to pay the invoice bill within 30 days.
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--End::row-1 -->

    </div>
</div>
<!-- End::app-content -->

@endsection

@section('scripts')
<script>
    @if($investment['status'] == 'active')
            // let countDownDate = new Date("May 1, 2021 15:37:25").getTime();
            let countDownDate = new Date("{{ $investment['return_date']->format('F d, Y H:i:s') }}").getTime();
            let countDown = document.getElementById('countdown');
            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;
                document.getElementById("days").textContent = formatText(Math.floor(distance / (1000 * 60 * 60 * 24)).toString());
                document.getElementById("hours").textContent = formatText(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString());
                document.getElementById("minutes").textContent = formatText(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString());
                document.getElementById("seconds").textContent = formatText(Math.floor((distance % (1000 * 60)) / 1000).toString());
                if (distance < 0) {
                    clearInterval(x);
                    countDown.innerHTML = "<h2 class='text-success'>Completed</h2>";
                }
            }, 1000);
            function formatText(text){
                if (text.length === 1){
                    return "0" + text;
                }
                return text;
            }
        @endif
</script>
@endsection