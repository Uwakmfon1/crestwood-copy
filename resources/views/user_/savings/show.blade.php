@extends('layouts.user.index')

@section('styles')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                                            <h4>Savings Details</h4>
                                            <span class="mx-4 alert alert-primary fw-medium" style="font-weight: 700;"> 
                                                ${{ number_format($savings['deposit'], 2) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="ms-auto mt-md-0 mt-2">
                                    <!-- <button class="btn btn-sm btn-primary-light me-1" onclick="javascript:window.print();">Print<i class="ri-printer-line ms-1 align-middle d-inline-block"></i></button> -->
                                    <!-- <a class="btn btn-sm btn-primary">Back to Savings<i class="ri-file-pdf-line ms-1 align-middle d-inline-block"></i></a> -->
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="countdown">
                                    @if($savings['status'] == 'active')
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
                                    @elseif($savings['status'] == 'pending')
                                        <h2 class='text-warning py-3'>Pending</h2>
                                    @elseif($savings['status'] == 'cancelled')
                                        <h2 class='text-danger py-3'>Cancelled</h2>
                                    @elseif($savings['status'] == 'settled')
                                        <h2 class='text-secondary py-3'>Settled</h2>
                                    @endif
                                </div>
                                <div class="row gy-3">
                                    <div class="chart-container" style="position: relative; height:100%; width:100%">
                                        <canvas id="savingsProgressChart"></canvas>
                                    </div>
                                    {{-- <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Saving Amount :</p>
                                        <p class="fs-15 mb-1">₦ {{ number_format($savings['amount']) }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Saving Duration :</p>
                                        <p class="fs-15 mb-1">{{ $savings['duration'] }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Total ROI :</p>
                                        <p class="fs-15 mb-1">₦ {{ number_format($savings['amount'] / $savings->package['roi'] * $savings['milestone']) }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">ROI</p>
                                        <p class="fs-15 mb-1">{{ $savings->package['roi'] }} %</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Current ROI :</p>
                                        <p class="fs-15 mb-1">₦ {{ number_format($savings['amount'] / $savings->package['roi']) }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Amount Saved :</p>
                                        <p class="fs-15 mb-1">₦ {{ number_format($savings['amount'] * $paid) }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Target Amount :</p>
                                        <p class="fs-15 mb-1">₦ {{ number_format($savings['amount'] * $savings['milestone']) }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Total Milestone :</p>
                                        <p class="fs-15 mb-1">{{ $savings['milestone'] }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Milestone Completed :</p>
                                        <p class="fs-15 mb-1">{{ $paid }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Savings Date :</p>
                                        <p class="fs-15 mb-1">{{ $savings['created_at']->format('M d, Y \a\t h:i A') }}</p>
                                    </div>
                                    <div class="col-xl-4 col-6 my-2">
                                        <p class="fw-medium text-muted mb-1">Maturity Date :</p>
                                        <p class="fs-15 mb-1">{{ $savings['return_date']->format('M d, Y \a\t h:i A') }}</p>
                                    </div>

                                    <div class="col-xl-12 my-5">
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
                                                    @for ($i = 1; $i <= $savings['milestone']; $i++)
                                                        <tr>
                                                            <td>Milestone {{ $i }}</td>
                                                            <td>₦ {{ number_format($savings['amount']) }}</td>
                                                            <td>
                                                                @php
                                                                    // Determine the milestone date based on the package duration
                                                                    switch ($savings->package['duration']) {
                                                                        case 'weekly':
                                                                            $milestoneDate = \Carbon\Carbon::make($savings['savings_date'])->addWeeks($i - 1);
                                                                            break;
                                                                        case 'monthly':
                                                                            $milestoneDate = \Carbon\Carbon::make($savings['savings_date'])->addMonths($i - 1);
                                                                            break;
                                                                        default:
                                                                            $milestoneDate = \Carbon\Carbon::make($savings['savings_date'])->addDays($i - 1);
                                                                            break;
                                                                    }

                                                                    // Check if there is an approved transaction on the milestone date
                                                                    $isPaid = $savings->transaction()
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
                                                                    <form action="{{ route('make.payment', $savings['id']) }}" method="post">
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
                                                        $returnDate = \Carbon\Carbon::make($savings['return_date']);
                                                        $isReturnDateDue = $currentDate->startOfDay()->greaterThanOrEqualTo($returnDate->startOfDay()) 
                                                                        && $currentDate->format('H:i') >= $returnDate->format('H:i');
                                                    @endphp

                                                    @if ($isReturnDateDue)
                                                        <tr>
                                                            <td>Total</td>
                                                            <td>
                                                                <b>₦ {{ number_format($savings['amount'] * $paid + $savings['amount'] / $savings->package['roi'] * $paid) }}</b>
                                                            </td>
                                                            <td>
                                                                <b>{{ $returnDate->format('M d, Y \a\t h:i A') }}</b>
                                                            </td>
                                                            <td>
                                                                @if ($savings['status'] == 'settled')
                                                                    <span class="badge badge-pill badge-success py-1 px-3">Credited ✅</span>
                                                                @else
                                                                    <span class="text-success"><b>Completed 🥳</b></span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if ($savings['status'] != 'settled' && $isReturnDateDue)
                                                                    <form action="{{ route('settle.payment', $savings['id']) }}" method="post">
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
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header">
                                <div class="card-title">
                                    Savings Info
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="fw-semibold mb-0">${{ number_format($savings['contribution'] + ($savings['deposit'] * $paid), 2) }}</h4>
                                    <div class="ms-2">
                                        <span class="badge bg-success-transparent">+{{ number_format($savings['roi'], 0) }}%</span>
                                    </div>
                                </div>
                                <div class="progress-stacked progress-xs">
                                    <div class="progress-bar" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-secondary" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 23%" aria-valuenow="23" aria-valuemin="0" aria-valuemax="100"></div>
                                    <div class="progress-bar bg-info" role="progressbar" style="width: 27%" aria-valuenow="27" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-primary me-2"></i>Today
                                                        Deposit</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format($savings['deposit'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10  d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-secondary me-2"></i>
                                                        Contribution</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format($savings['contribution'], 2) }} ({{ $savings['timeframe'] }})</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item warning">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-success me-2"></i>
                                                        Start Date</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">{{ $savings['created_at']->format('M d, Y') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-info me-2"></i>
                                                        Return Date</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">{{ $savings['return_date']->format('M d, Y') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10  d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-dark me-2"></i>
                                                        Contribution done</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format($savings['contribution'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10  d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-dark me-2"></i>
                                                        Expected Return</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format($savings['total_return'], 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card custom-card card-bg-primary school-card">
                            <div class="card-body p-4">
                                <div class="row justify-content-between">
                                    <div class="col-xxl-8 col-xl-5 col-lg-5 col-md-5 col-sm-5">
                                        <p class="text-fixed-white op-8 mb-2">Contribution</p>
                                        <p class="mb-2 h5 text-fixed-white fw-medium">$200.00</p>
                                        <span class="text-fixed-white op-7">Next contribution</span>
                                        <div class="d-flex gap-2 mt-2 align-items-center">
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                                02
                                            </div>
                                            <div>:</div>
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                            00
                                            </div>
                                            <div>:</div>
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                            08  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-xl-7 col-lg-7 col-md-7 col-sm-7 d-sm-block d-none text-end my-auto">
                                        <!-- <img src="../assets/images/media/media-77.png" class="exam-img"> -->
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
    // let countDownDate = new Date("May 1, 2021 15:37:25").getTime();
    let countDownDate = new Date("{{ $savings['return_date']->format('F d, Y H:i:s') }}").getTime();
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

    var ctx = document.getElementById('savingsProgressChart').getContext('2d');
        var savingsProgressChart = new Chart(ctx, {
            type: 'line', // or 'bar', 'radar', etc.
            data: {
                labels: @json($progressDates), // Dates array for the X-axis
                datasets: [{
                    label: 'Savings Progress',
                    data: @json($progressAmounts), // Amounts array for the Y-axis
                    backgroundColor: 'rgba(130, 116, 255, 0.1)',
                    borderColor: 'rgb(130, 116, 255)',
                    fill: true,
                }]
            },
            options: {
                scales: {
                    // x: {
                    //     beginAtZero: true
                    // },
                    // y: {
                    //     beginAtZero: true
                    // }
                }
            }
        });
</script>

@endsection