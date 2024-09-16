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
                                    <span class="mx-4 alert alert-primary fw-medium w-auto" style="font-weight: 700;"> 
                                        &#36;{{ number_format($investment['amount']) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto mt-md-0 mt-2">
                            <!-- <button class="btn btn-sm btn-primary-light me-1" onclick="javascript:window.print();">Print<i class="ri-printer-line ms-1 align-middle d-inline-block"></i></button> -->
                            <!-- <a class="btn btn-sm btn-primary">Back to investment<i class="ri-file-pdf-line ms-1 align-middle d-inline-block"></i></a> -->
                        </div>
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
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Price:</p>
                                <p class="fs-15 mb-1">${{ number_format($investment['amount']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Duration :</p>
                                <p class="fs-15 mb-1">{{ $investment->package['milestone'] }} {{ $investment->package['duration'] }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">ROI Duration :</p>
                                <p class="fs-15 mb-1">{{ $investment['roi_duration'] }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">ROI</p>
                                <p class="fs-15 mb-1">{{ $investment->package['roi'] }} %</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">ROI Amount :</p>
                                <p class="fs-15 mb-1">$ {{ number_format(($investment->package['roi'] * $investment->amount) / 100, 2) }} </p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Amount Invested :</p>
                                <p class="fs-15 mb-1">$ {{ number_format($investment['amount']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Expected Returns :</p>
                                <p class="fs-15 mb-1">$ {{ number_format($investment['total_return']) }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Investment Date :</p>
                                <p class="fs-15 mb-1">{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            <div class="col-xl-4 col-6 my-2">
                                <p class="fw-medium text-muted mb-1">Return Date :</p>
                                <p class="fs-15 mb-1">{{ \Carbon\Carbon::parse($investment['created_at'])->add($investment->package['milestone'], $investment->package['duration'])->format('M d, Y \a\t h:i A') }}</p>
                            </div>
                            @php
                                $balance = $investment['amount']; // Initialize balance with the investment amount
                            @endphp

                            <div class="col-xl-12 my-5">
                                <h6 class="fw-medium text-muted my-3">Profit:</h6>
                                <div class="table-responsive">
                                <table class="table text-nowrap table-striped table-hover">
                                    <thead>
                                    <tr>
                                        <th>Amount</th>
                                        <th>Balance</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>${{ number_format(0, 2) }}</td>
                                            <td>${{ number_format($investment['amount'], 2) }}</td>
                                            <td>
                                                <span class="badge bg-danger-transparent">Deposit</span>
                                            </td>
                                            <td>{{ $investment['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                            <td>
                                                <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Paid</span>
                                            </td>
                                        </tr>
                                        @foreach($transactions as $transaction)
                                            @php
                                                $balance += $transaction->amount; // Add the transaction amount to the balance
                                            @endphp
                                            <tr>
                                                <td>${{ number_format($transaction->amount, 2) }}</td>
                                                <td>${{ number_format($balance, 2) }}</td> <!-- Display updated balance -->
                                                <td>
                                                    <span class="badge bg-success-transparent">Profit</span>
                                                </td>
                                                <td>{{ $transaction['created_at']->format('M d, Y \a\t h:i A') }}</td>
                                                <td>
                                                    <span class="badge bg-success-transparent"><i class="ri-check-fill align-middle me-1"></i>Paid</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>


                                </div>
                            </div>
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
                                <div>
                                    <img src="/{{ $investment->package['image'] }}" class="w-100 my-1 rounded" alt="" height="180">
                                </div>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Name :</span> {{ $investment->package['name'] }}
                                </p>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Description :</span> {{ $investment->package['description'] }}
                                </p>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Amount :</span> <span class="text-primary fw-medium fs-14">{{ number_format($investment->package['min_amount']) }} <span class="text-muted fs-11">USD</span> - {{ number_format($investment->package['max_amount']) }} <span class="text-muted fs-11">USD</span></span>
                                </p>
                                <p>
                                    <span class="fw-medium text-muted fs-12">Duration :</span> {{ $investment->package['milestone'] }} {{ $investment->package['duration'] }} - 
                                    <span class="text-danger fs-12 fw-medium">
                                        {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($investment['created_at'])->add($investment->package['milestone'], $investment->package['duration'])) }} days due
                                    </span>
                                </p>
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
            let countDownDate = new Date("{{ \Carbon\Carbon::parse($investment['created_at'])->add($investment->package['milestone'], $investment->package['duration'])->format('F d, Y H:i:s') }}").getTime();
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

@section('trash')


{{--
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
                                                <b>$ {{ number_format($investment['amount'] * $paid + $investment['amount'] / $investment->package['roi'] * $paid) }}</b>
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

<tbody>
                                        @php
                                            // Convert roi_duration string to Carbon interval
                                            $roiParts = explode('_', $investment['roi_duration']);
                                            $roiValue = (int) $roiParts[0]; // Get the number (e.g., 2)
                                            $roiUnit = $roiParts[1]; // Get the time unit (e.g., days, weeks, months)

                                            // Convert package duration to Carbon-compatible format
                                            $packageDurationParts = explode('_', $investment->package['milestone'] . '_' . $investment->package['duration']);
                                            $milestoneValue = (int) $packageDurationParts[0]; // e.g., 3
                                            $milestoneUnit = $packageDurationParts[1]; // e.g., weeks, months

                                            // Calculate the end date of the investment based on the package duration
                                            $investmentEndDate = \Carbon\Carbon::make($investment['created_at'])->add($milestoneValue, $milestoneUnit);

                                            // Calculate the total number of milestones
                                            $milestoneCount = 0;
                                            $milestoneDate = \Carbon\Carbon::make($investment['created_at']);
                                            while ($milestoneDate->lt($investmentEndDate)) {
                                                $milestoneCount++;
                                                $milestoneDate->add($roiValue, $roiUnit);
                                            }

                                            // Calculate the amount per milestone
                                            $amountPerMilestone = $milestoneCount > 0 ? $investment['amount'] / $milestoneCount : 0;
                                        @endphp

                                        @php
                                            // Reset the milestone date for the loop
                                            $milestoneDate = \Carbon\Carbon::make($investment['created_at']);
                                        @endphp

                                        @for ($i = 1; $milestoneDate->lt($investmentEndDate); $i++)
                                            @php
                                                // Add roi_duration to the milestone date for each iteration
                                                $milestoneDate = \Carbon\Carbon::make($investment['created_at'])->add($roiValue * $i, $roiUnit);

                                                // Check if the milestone date falls within the package duration
                                                if ($milestoneDate->gt($investmentEndDate)) {
                                                    break; // Stop if the next milestone is beyond the package duration
                                                }

                                                // Check if the transaction is paid
                                                $isPaid = $investment->transaction()
                                                    ->where('status', 'approved')
                                                    ->whereDate('created_at', $milestoneDate->toDateString())
                                                    ->exists();
                                            @endphp
                                            <tr>
                                                <td>Milestone {{ $i }}</td>
                                                @if ($milestoneCount > 0)
                                                    <td>${{ number_format((($investment->package['roi'] * $investment->amount) / 100) / ($milestoneCount), 2) }}</td>
                                                @endif
                                                <td>{{ $milestoneDate->format('M d, Y \a\t h:i A') }}</td>
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

                                        <!-- Display the total number of milestones -->
                                        @if ($milestoneCount > 0)
                                            <tr>
                                                <td colspan="4"><b>Total Amount:</b></td>
                                                <td><b>${{  number_format(($investment->package['roi'] * $investment->amount) / 100, 2) }}</b></td>
                                            </tr>
                                        @endif
                                    </tbody> --}}
@endsection