@extends('layouts.user.index')

@section('styles')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
            <div class="container-fluid">
            @include('partials.users.alert')
                <!-- Start::row-1 -->
                <div class="row my-3">
                    <div class="col-xl-8">
                        <div class="card custom-card">
                            <div class="card-header d-md-flex d-block">
                                <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                                    <div class="">
                                        <img src="../assets/images/brand-logos/toggle-logo.png" alt="">
                                    </div>
                                    <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                        <div class="d-flex align-middle fw-medium mb-0">
                                            <h4 class="fw-medium">{{$savings->plan->name}}</h4>
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
                                <div class="row mt-4">
                                    @foreach($save->answers as $data)
                                        <div class="col-xl-4 col-6 my-2 quests">
                                            <p class="fw-medium text-muted mb-1 fs-12" id="savingsQuestion">{{ $data->question->text }}</p>
                                            <p class="fs-15 mb-1 fw-bold" id="savingsAnswer">{{ $data->answer->text }}</p>
                                        </div>
                                    @endforeach
                                    <div class="chart-container mb-4" style="position: relative; height:100%; width:100%">
                                        <canvas id="savingsProgressChart"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4">
                        <div class="card custom-card overflow-hidden">
                            <div class="card-header">
                                <div class="card-title">
                                    Savings Info
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <h4 class="fw-semibold mb-0">${{ number_format($total, 2) }}</h4>
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
                                                    <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-primary me-2"></i>Today Savings</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format($total, 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-info me-2"></i>
                                                        Interest Amount</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">${{ number_format(0, 2) }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item success">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-fill align-items-center pt-1">
                                                <div class="d-flex align-items-top justify-content-between">
                                                    <p class="mb-0 text-muted fs-10  d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-dark me-2"></i>
                                                        Interest Rate</p>
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">25%</h6>
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
                                                    <h6 class="mb-0 lh-1 fw-medium fs-12">{{ $savings['created_at']->format('d M, Y') }}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card custom-card card-bg-white">
                            <div class="card-body p-4">
                                <div class="row justify-content-between">
                                    <form action="{{ route('savings.payment', $savings->id) }}" method="post">
                                        @csrf
                                        <div class="col-12">
                                            <p class="text-fixed-dark op-10 mb-1 fw-bold">Initiate Savings</p>
                                            <p class="text-fixed-dark op-5 mb-3 fs-12">Make your next savings deposit with your desired amount</p>
                                            <div class="input-group mx-auto"> 
                                                <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                                <input type="number" value="" style="font-size: 14px; font-weight: 800;" step="any" class="form-control" name="amount" id="saveAmount" placeholder="Amount">
                                                <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">.00</button>
                                            </div>
                                            <div class="fs-12 alert alert-info w-100 mt-3">
                                                <div class="fs-11 fw-medium" id="savings-summary">
                                                    Start your savings for this month with <strong>$--</strong>
                                                </div>
                                            </div>
                                            <div class="mx-auto">
                                                <button type="submit" class="btn btn-primary-light btn-wave fs-12 fw-bold" style="width: 100%;" id="payBtn">Make Payment <i class="fe fe-arrow-right mx-1"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-xxl-4 col-xl-7 col-lg-7 col-md-7 col-sm-7 d-sm-block d-none text-end my-auto">
                                        <!-- <img src="../assets/images/media/media-77.png" class="exam-img"> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card custom-card card-bg-primary school-card">
                            <div class="card-body p-4">
                                <div class="row justify-content-between">
                                    <div class="col-12">
                                        <p class="text-fixed-white op-8 mb-2">Next Contribution</p>
                                        <p class="mb-2 h5 text-fixed-white fw-bold" id="nextContribution">{{ $save->created_at->format('M d, Y') }}</p>
                                        <span class="text-fixed-white op-7">Next contribution</span>
                                        <div class="d-flex gap-2 mt-2 align-items-center">
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                                00
                                            </div>
                                            <div>:</div>
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                                00
                                            </div>
                                            <div>:</div>
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                                00 
                                            </div>
                                            <div>:</div>
                                            <div class="bg-white-transparent fw-semibold py-1 px-2 rounded">
                                                00  
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-12">
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
                                                <b>{{ $savings['created_at']->format('d M, Y') }}</b>
                                                <span class="badge bg-dark-transparent">
                                                    <b>{{ $save->created_at->format('h:i A') }} </b>
                                                </span>
                                            </td>
                                            <td>
                                                <!-- <form action="{{ route('settle.payment', $savings['id']) }}" method="post">
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
                <!--End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->

        <!-- Modal HTML Structure -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Initiate Savings</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div> -->
                    <div class="modal-body">
                        <form action="{{ route('savings.payment', $savings->id) }}" method="post">
                            @csrf
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <div class="">
                                        <p class="text-fixed-dark op-10 mb-1 fw-bold">Initiate Savings</p>
                                    </div>
                                    <div class="">
                                        <a href="{{ route('wallet') }}" class="text-primary fw-bold fs-12">Top Up</a>
                                    </div>
                                </div>
                                <p class="text-fixed-dark op-5 mb-3 fs-12">Start your first savings with your desired amount</p>
                                <div class="input-group mx-auto"> 
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                    <input type="number" value="10" style="font-size: 14px; font-weight: 800;" step="any" class="form-control" name="amount" id="saveAmount" placeholder="Amount">
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">.00</button>
                                </div>
                                <div class="fs-12 alert alert-info w-100 mt-3">
                                    <div class="fs-11 fw-medium" id="savings-summary" style="">
                                        Start your savings for this month with <strong>$---</strong>
                                    </div>
                                </div>
                                <div class="mx-auto">
                                    <button type="submit" class="btn btn-primary-light btn-wave fs-12 fw-bold" style="width: 100%;" id="payBtn">Make Payment <i class="fe fe-arrow-right mx-1"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('scripts')
<script>
    let countDownDate = new Date("December 1, 2025 15:37:25").getTime();
    // let countDownDate = new Date("{{ $savings['created_at']->format('F d, Y H:i:s') }}").getTime();
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
                labels: [], // Dates array for the X-axis
                datasets: [{
                    label: 'Savings Progress',
                    data: [], // Amounts array for the Y-axis
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

@php
    $payDate = $payment->max('created_at'); // Find the most recent payment date using Laravel's max method
@endphp


<!-- <script>
    $(document).ready(function () {
        const backendModalId = "{{ $savings->plan->modalId }}";
        const plans = [
            {
                id: 1,
                name: 'High-Yield Savings Account (HYSA)',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/54nn41qg/propel-savings_500x500.png',
                btnText: 'Start Savings',
                modalId: 'modalHYSA', // Unique modal ID for each card
                questions: [
                    {
                        question: 'What is your primary goal for this savings account?',
                        answers: [
                            'Build an emergency fund',
                            'Earn higher interest on savings',
                            'Save for future large purchases (e.g., home, car)',
                        ]
                    },
                    {
                        question: 'What is your expected contribution amount?',
                        answers: [
                            'Less than $500/month',
                            '$500 – $1,000/month',
                            'Over $1,000/month',
                        ]
                    },
                    {
                        question: 'How long do you plan to keep your savings in this account?',
                        answers: [
                            'Less than 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    },
                    {
                        question: 'Do you need frequent access to the funds, or can they remain untouched?',
                        answers: [
                            'Frequent access needed',
                            'No access required for now',
                        ]
                    },
                    {
                        question: 'Would you like to reinvest interest into the account or withdraw it periodically?',
                        answers: [
                            'Reinvest interest',
                            'Withdraw interest periodically',
                        ]
                    }
                ]
            },
            {
                id: 2,
                name: 'Cash Interest Account',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/zpfjqqui/no-fees_500x500.webp',
                btnText: 'Start Savings',
                modalId: 'modalCashInterest',
                questions: [
                    {
                        question: 'What is the purpose of this cash account?',
                        answers: [
                            'Maintain liquidity with interest growth',
                            'Short-term cash management for upcoming expenses',
                            'Long-term capital preservation with flexible access',
                        ]
                    },
                    {
                        question: 'How often do you plan to deposit funds into this account?',
                        answers: [
                            'Weekly',
                            'Monthly',
                            'Irregularly',
                        ]
                    },
                    {
                        question: 'Do you need frequent access to these funds?',
                        answers: [
                            'Yes, I’ll need regular access',
                            'No, I can leave the funds untouched',
                        ]
                    },
                    {
                        question: 'Would you like a portion of this account to be allocated to higher interest products?',
                        answers: [
                            'Yes, maximize growth on a portion of funds',
                            'No, keep everything liquid',
                        ]
                    }
                ]
            },
            {
                id: 3,
                name: 'Tax-Free Savings Account',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/a0jeky3a/cash_2024_500x500.webp',
                btnText: 'Start Savings',
                modalId: 'modalTaxFree',
                questions: [
                    {
                        question: 'What is your primary goal for this tax-free savings account?',
                        answers: [
                            'Save for education or long-term projects',
                            'Maximize tax-free growth',
                            'Build long-term savings for retirement or specific milestones',
                        ]
                    },
                    {
                        question: 'How much do you plan to contribute each year?',
                        answers: [
                            'Less than $5,000',
                            '$5,000 – $10,000',
                            'Over $10,000',
                        ]
                    },
                    {
                        question: 'What is your expected time horizon for this account?',
                        answers: [
                            'Less than 5 years',
                            '5–10 years',
                            'Over 10 years',
                        ]
                    },
                    {
                        question: 'Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?',
                        answers: [
                            'Reinvest all earnings',
                            'Withdraw earnings periodically',
                        ]
                    }
                ]
            },
            {
                id: 4,
                name: 'First Home Savings Account',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/3junkeko/transfer-money-500x500.webp',
                btnText: 'Start Savings',
                modalId: 'modalFirstHome',
                questions: [
                    {
                        question: 'When do you plan to purchase your first home?',
                        answers: [
                            'Within 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    },
                    {
                        question: 'How much do you plan to save for a home down payment?',
                        answers: [
                            'Less than $50,000',
                            '$50,000 – $100,000',
                            'Over $100,000',
                        ]
                    },
                    {
                        question: 'How much do you plan to contribute monthly toward this goal?',
                        answers: [
                            'Less than $500',
                            '$500 – $1,000',
                            'Over $1,000',
                        ]
                    },
                    {
                        question: 'Do you need to access these funds before reaching your savings goal?',
                        answers: [
                            'Yes, I may need access',
                            'No, I plan to leave the funds untouched',
                        ]
                    },
                    {
                        question: 'Would you like financial advice on home-buying incentives and tax benefits?',
                        answers: [
                            'Yes',
                            'No',
                        ]
                    }
                ]
            },
            {
                id: 5,
                name: 'Corporate Accounts',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/0axfwoe2/lock-security-500x500.webp',
                btnText: 'Start Savings',
                modalId: 'modalCorporate',
                questions: [
                    {
                        question: 'What is the primary purpose of this corporate account?',
                        answers: [
                            'Cash flow management for operations',
                            'Capital preservation for business investments',
                            'Employee benefit funding (e.g., 401(k) or pensions)',
                        ]
                    },
                    {
                        question: 'How much do you plan to deposit into this account monthly?',
                        answers: [
                            'Less than $10,000',
                            '$10,000 – $50,000',
                            'Over $50,000',
                        ]
                    },
                    {
                        question: 'Do you require frequent access to corporate funds?',
                        answers: [
                            'Yes, for daily operations',
                            'No, funds can remain untouched',
                        ]
                    },
                    {
                        question: 'Would you like a portion of corporate funds to be invested for long-term growth?',
                        answers: [
                            'Yes, allocate a portion to investments',
                            'No, keep all funds in cash reserves',
                        ]
                    }
                ]
            },
            {
                id: 6,
                name: 'Retirement Accounts (Roth IRA, SEP IRA, Traditional IRA)',
                sub_name: 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                img: 'https://www.oneazcu.com/media/xf5p3zer/click_desktop_500x500.webp',
                btnText: 'Start Savings',
                modalId: 'modalRetirement',
                questions: [
                    {
                        question: 'What is your goal with this Roth IRA?',
                        answers: [
                            'Tax-free growth for retirement',
                            'Maximize savings for long-term retirement needs',
                        ]
                    },
                    {
                        question: 'How much do you plan to contribute each year?',
                        answers: [
                            'Less than $6,500',
                            '$6,500 – $15,000 (catch-up contributions for age 50+)',
                        ]
                    },
                    {
                        question: 'When do you expect to start withdrawing from the account?',
                        answers: [
                            'Before age 59 ½',
                            'After age 59 ½',
                        ]
                    },
                    {
                        question: 'Would you prefer automatic monthly or annual contributions?',
                        answers: [
                            'Monthly',
                            'Annually',
                        ]
                    }
                ]
            }
        ];

        // Function to get the most recent transaction date
        const getMostRecentTransactionDate = () => {
            let lastTransactionDate = null;
            @foreach($payment as $index => $save)
                const currentTransactionDate = new Date("{{ $save->created_at }}");
                lastTransactionDate = lastTransactionDate && currentTransactionDate > lastTransactionDate
                    ? currentTransactionDate
                    : lastTransactionDate || currentTransactionDate;
            @endforeach
            return lastTransactionDate || null;  // Default to current date if no transaction
        };

        // Utility function to find plan by modalId
        const findPlanByModalId = (modalId) => plans.find(plan => plan.modalId === modalId);

        // Utility function to update the summary message
        const updateSummary = (min, max) => {
            const $summary = $('#savings-summary');
            $summary.html(max 
                ? `Start your savings for this month with an amount between <strong>$${min}</strong> and <strong>$${max}</strong>`
                : `Start your savings for this month with an amount of <strong>$${min}</strong> or more`
            );
        };

        // Utility function to set amount input range
        const setAmountRange = (min, max) => {
            const $amountInput = $('#saveAmount');
            $amountInput.attr('min', min);
            max ? $amountInput.attr('max', max) : $amountInput.removeAttr('max');
            $amountInput.val(min);  // Set default to min
            updateSummary(min, max);
        };

        if(backendModalId == 'modalHYSA') {

            // Handle plan selection and range setup
            const selectedPlan = findPlanByModalId(backendModalId);
            if (selectedPlan) {
                $('.quests').each(function () {
                    const question = $(this).find('#savingsQuestion').text().trim();
                    const answer = $(this).find('#savingsAnswer').text().trim();

                    // Switch for processing question and answer
                    switch (question) {
                        case "What is your expected contribution amount?":
                            const ranges = {
                                "Less than $500/month": [10, 500],
                                "$500 – $1,000/month": [500, 1000],
                                "Over $1,000/month": [1000, null]
                            };
                            if (ranges[answer]) setAmountRange(...ranges[answer]);
                            break;
                        case "What is your primary goal for this savings account?":

                        case "How often do you plan to deposit funds into this account?":
                            // Add specific conditions here if necessary
                            break;
                    }
                });

                // Event listener for input changes to keep within range
                $('#saveAmount').on('input', function () {
                    const min = parseFloat($(this).attr('min'));
                    const max = $(this).attr('max') ? parseFloat($(this).attr('max')) : null;
                    let currentValue = parseFloat($(this).val());

                    // Ensure the value is within the specified range
                    currentValue = Math.max(min, max ? Math.min(currentValue, max) : currentValue, min);

                    // Update the summary message with the selected amount
                    $('#savings-summary').html(`Start your savings for this month with <strong>$${currentValue}.00</strong>`);
                });
            } else {
                alert("ModalId does not match any plan.");
            }

            const lastTransactionDate = getMostRecentTransactionDate();
            let nextContributionDate = new Date(lastTransactionDate);
            nextContributionDate.setMonth(lastTransactionDate.getMonth() + 1);

            // Display the next contribution date
            $('.school-card .h5').text(nextContributionDate.toLocaleDateString('en-US', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }));

            // Countdown timer logic
            function updateCountdown() {
                const now = new Date().getTime();
                const countDownDate = nextContributionDate.getTime();
                const distance = countDownDate - now;

                // Calculate days, hours, minutes, seconds
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Update countdown display
                $('.school-card .d-flex .bg-white-transparent').eq(0).text(String(days).padStart(2, '0'));
                $('.school-card .d-flex .bg-white-transparent').eq(1).text(String(hours).padStart(2, '0'));
                $('.school-card .d-flex .bg-white-transparent').eq(2).text(String(minutes).padStart(2, '0'));
                $('.school-card .d-flex .bg-white-transparent').eq(3).text(String(seconds).padStart(2, '0'));

                // If the countdown is finished
                if (distance < 0) {
                    clearInterval(countdownInterval);
                    $('.school-card .d-flex .bg-white-transparent').text('00');
                }
            }

            // Set the countdown interval
            const countdownInterval = setInterval(updateCountdown, 1000);
            updateCountdown();

            // Check if user already made payment this month
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();

            if (lastTransactionDate.getMonth() === currentMonth && lastTransactionDate.getFullYear() === currentYear) {
                // Disable input and button for current month
                $('#saveAmount').prop('disabled', true);
                $('#payBtn').prop('disabled', true);
                $('#savings-summary').html('You have already made a payment this month. Please wait until next month to initiate a new savings payment.');
            }
        }
        
        if (backendModalId == 'modalCashInterest') {

            // Function to calculate the next contribution date based on the selected frequency
            function calculateNextContribution(dateString, frequency) {
                const currentDate = new Date(dateString);
                let nextContributionDate = new Date(currentDate); // Start with the current contribution date

                // Adjust the next contribution date based on the selected frequency
                switch (frequency) {
                    case 'Weekly':
                        nextContributionDate.setDate(currentDate.getDate() + 7); // Add 7 days
                        break;
                    case 'Monthly':
                        nextContributionDate.setMonth(currentDate.getMonth() + 1); // Add 1 month
                        break;
                    case 'Irregularly':
                        // Set a default time interval (e.g., 14 days for irregular contribution)
                        nextContributionDate.setDate(currentDate.getDate() + 14);
                        break;
                    default:
                        console.log('Frequency not recognized');
                }

                return nextContributionDate;
            }

            // Function to start the countdown timer
            function startCountdown(targetDate) {
                const countdownInterval = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = targetDate.getTime() - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        console.log('Next contribution date reached!');
                        return;
                    }

                    // Calculate days, hours, minutes, and seconds
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Update countdown display
                    $('.school-card .d-flex .bg-white-transparent').eq(0).text(String(days).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(1).text(String(hours).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(2).text(String(minutes).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(3).text(String(seconds).padStart(2, '0'));
                }, 1000);
            }

            // Check if user already made payment this month
            const currentWeek = new Date().getDay();
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();
            
           // Handle plan selection and range setup
           const selectedPlan = findPlanByModalId(backendModalId);
            if (selectedPlan) {
                $('.quests').each(function () {
                    const question = $(this).find('#savingsQuestion').text().trim();
                    const answer = $(this).find('#savingsAnswer').text().trim();

                    // Switch for processing question and answer
                    switch(question) {
                        case 'What is the purpose of this cash account?':
                            switch (answer) {
                                case 'Maintain liquidity with interest growth':
                                    console.log('Maintain liquidity with interest growth');
                                    // Render additional info or UI changes here
                                    break;
                                case 'Short-term cash management for upcoming expenses':
                                    console.log('Short-term cash management for upcoming expenses');
                                    // Render additional info or UI changes here
                                    break;
                                case 'Long-term capital preservation with flexible access':
                                    console.log('Long-term capital preservation with flexible access');
                                    // Render additional info or UI changes here
                                    break;
                            }
                            break;

                        case 'How often do you plan to deposit funds into this account?':
                            switch (answer) {
                                case 'Weekly':
                                     // Calculate the next contribution date
                                    const nextContributionDate = calculateNextContribution('{{ $payDate }}', 'Weekly');

                                    // Start the countdown to the next contribution
                                    startCountdown(nextContributionDate);

                                    $('.school-card .h5').text(nextContributionDate.toLocaleDateString('en-US', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    }));

                                    if (getMostRecentTransactionDate().getDay() === currentWeek && getMostRecentTransactionDate().getFullYear() === currentYear) {
                                        // Disable input and button for current month
                                        $('#saveAmount').prop('disabled', true);
                                        $('#payBtn').prop('disabled', true);
                                        $('#savings-summary').html('You have already made a payment this week. Please wait until next week to initiate a new savings payment.');
                                    }

                                    break;
                                case 'Monthly':
                                    startCountdown(calculateNextContribution('{{ $payDate }}', 'Monthly'));

                                    $('.school-card .h5').text(calculateNextContribution('{{ $payDate }}', 'Monthly').toLocaleDateString('en-US', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    }));

                                    const lastTransactionDate = getMostRecentTransactionDate();
                                    if (lastTransactionDate.getMonth() === currentMonth && lastTransactionDate.getFullYear() === currentYear) {
                                        // Disable input and button for current month
                                        $('#saveAmount').prop('disabled', true);
                                        $('#payBtn').prop('disabled', true);
                                        $('#savings-summary').html('You have already made a payment this month. Please wait until next month to initiate a new savings payment.');
                                    }

                                    break;
                                case 'Irregularly':
                                    startCountdown(calculateNextContribution('{{ $payDate }}', 'Irregularly'));

                                    $('.school-card .h5').text(calculateNextContribution('{{ $payDate }}', 'Irregularly').toLocaleDateString('en-US', {
                                        day: 'numeric',
                                        month: 'long',
                                        year: 'numeric'
                                    }));
                                    break;
                            }
                            break;

                        case 'Do you need frequent access to these funds?':
                            switch (answer) {
                                case 'Yes, I’ll need regular access':
                                    console.log('User selected: Yes, I’ll need regular access');
                                    // Render additional info or UI changes here
                                    break;
                                case 'No, I can leave the funds untouched':
                                    console.log('User selected: No, I can leave the funds untouched');
                                    // Render additional info or UI changes here
                                    break;
                            }
                            break;

                        case 'Would you like a portion of this account to be allocated to higher interest products?':
                            switch (answer) {
                                case 'Yes, maximize growth on a portion of funds':
                                    console.log('User selected: Yes, maximize growth on a portion of funds');
                                    // Render additional info or UI changes here
                                    break;
                                case 'No, keep everything liquid':
                                    console.log('User selected: No, keep everything liquid');
                                    // Render additional info or UI changes here
                                    break;
                            }
                            break;

                        default:
                            console.log('No conditions found for this question');
                            break;
                    }
                });
            } else {
                alert("ModalId does not match any plan.");
            }
        }

        if (backendModalId == 'modalTaxFree') {
            // Function to calculate the next contribution date based on the selected frequency
            function calculateNextContribution(dateString, frequency) {
                const currentDate = new Date(dateString);
                let nextContributionDate = new Date(currentDate); // Start with the current contribution date

                // Adjust the next contribution date based on the selected frequency
                switch (frequency) {
                    case 'Weekly':
                        nextContributionDate.setDate(currentDate.getDate() + 7); // Add 7 days
                        break;
                    case 'Monthly':
                        nextContributionDate.setMonth(currentDate.getMonth() + 1); // Add 1 month
                        break;
                    case 'Yearly':
                        nextContributionDate.setFullYear(currentDate.getFullYear() + 1); // Add 1 Year
                        break;
                    case 'Irregularly':
                        // Set a default time interval (e.g., 14 days for irregular contribution)
                        nextContributionDate.setDate(currentDate.getDate() + 14);
                        break;
                    default:
                        console.log('Frequency not recognized');
                }

                return nextContributionDate;
            }

            // Function to start the countdown timer
            function startCountdown(targetDate) {
                const countdownInterval = setInterval(function () {
                    const now = new Date().getTime();
                    const distance = targetDate.getTime() - now;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        console.log('Next contribution date reached!');
                        return;
                    }

                    // Calculate days, hours, minutes, and seconds
                    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    // Update countdown display
                    $('.school-card .d-flex .bg-white-transparent').eq(0).text(String(days).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(1).text(String(hours).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(2).text(String(minutes).padStart(2, '0'));
                    $('.school-card .d-flex .bg-white-transparent').eq(3).text(String(seconds).padStart(2, '0'));
                }, 1000);
            }

            // Check if user already made payment this month
            const currentWeek = new Date().getDay();
            const currentMonth = new Date().getMonth();
            const currentYear = new Date().getFullYear();

            // Handle plan selection and range setup
            const selectedPlan = findPlanByModalId(backendModalId);
            if (selectedPlan) {
                $('.quests').each(function () {
                    const question = $(this).find('#savingsQuestion').text().trim();
                    const answer = $(this).find('#savingsAnswer').text().trim();

                    // Switch for processing question and answer
                    switch(question) {
                        case 'What is your primary goal for this tax-free savings account?':
                            switch (answer) {
                                case 'Maximize tax-free growth':
                                    console.log('Maximize tax-free growth');
                                    // Render additional info or UI changes here
                                    break;
                                case 'Short-term cash management for upcoming expenses':
                                    console.log('Short-term cash management for upcoming expenses');
                                    // Render additional info or UI changes here
                                    break;
                                case 'Long-term capital preservation with flexible access':
                                    console.log('Long-term capital preservation with flexible access');
                                    // Render additional info or UI changes here
                                    break;
                            }
                            break;

                        case 'How much do you plan to contribute each year?':
                            const ranges = {
                                "Less than $5,000": [10, 5000],
                                "$5,000 – $10,000": [5000, 10000],
                                "Over $10,000": [10000, null]
                            };
                            if (ranges[answer]) setAmountRange(...ranges[answer]);
                            break;

                        case 'Would you like a portion of this account to be allocated to higher interest products?':
                            switch (answer) {
                                case 'Yes, maximize growth on a portion of funds':
                                    console.log('User selected: Yes, maximize growth on a portion of funds');
                                    // Render additional info or UI changes here
                                    break;
                                case 'No, keep everything liquid':
                                    console.log('User selected: No, keep everything liquid');
                                    // Render additional info or UI changes here
                                    break;
                            }
                            break;

                        default:
                            console.log('No conditions found for this question');
                            break;
                    }

                    startCountdown(calculateNextContribution('{{ $payDate }}', 'Yearly'));

                    $('.school-card .h5').text(calculateNextContribution('{{ $payDate }}', 'Yearly').toLocaleDateString('en-US', {
                        day: 'numeric',
                        month: 'long',
                        year: 'numeric'
                    }));

                    const lastTransactionDate = getMostRecentTransactionDate();

                    console.log("Hey: {{ $payDate }}");
                    

                    if (lastTransactionDate && lastTransactionDate.getFullYear() === currentYear) {
                        // Disable input and button for current month
                        $('#saveAmount').prop('disabled', true);
                        $('#payBtn').prop('disabled', true);
                        $('#savings-summary').html('You have already made a payment this year. Please wait until next year to initiate a new savings payment.');
                    }

                });
            } else {
                alert("ModalId does not match any plan.");
            }
        }

    });

    $(document).ready(function () {
        // Assuming you have a variable that holds the payment status
        // For example, if there is no payment, you would pass 'no_payment' from the backend.
        const isPaymentAttached = @json($payment->isEmpty() ? false : true); // Adjust based on your data structure

        // Modal element
        const modalElement = $('#paymentModal'); // Assuming you are using a modal with the ID "paymentModal"

        // If there is no payment attached, show the modal
        if (!isPaymentAttached) {
            // Show the modal
            modalElement.modal('show');
        }

        // Prevent closing the modal if the condition isn't met
        modalElement.on('hide.bs.modal', function (e) {
            if (!isPaymentAttached) {
                e.preventDefault();  // Prevent modal from closing
            }
        });

        // Ensure the form doesn't submit unless the user is ready to make a payment
        $('#payBtn').on('click', function (e) {
            // Optionally, you can add more validation or checks before submitting the form
            const amount = $('#saveAmount').val();
            if (amount <= 0) {
                // If the user hasn't selected an amount, you can prevent form submission
                e.preventDefault();
                alert('Please enter a valid amount to initiate savings.');
            }
        });
    });
</script> -->

<script>
$(document).ready(function () {
    const backendModalId = "{{ $savings->plan->modalId }}";
    const currentMonthTotal = "{{ $currentMonthTotal }}";
    const lastTransactionDate = "{{ $lastTransactionDate }}";
    const currentDate = new Date();
    // const nextContributionDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, currentDate.getDate());

    const lastContributionDate = lastTransactionDate;
    const frequency = 'monthly';
    const interval = 1;

    const disableInputBtn = () => {
        // Disable input and button for current month
        $('#saveAmount').prop('disabled', true);
        $('#payBtn').prop('disabled', true);
    }

    const updateSummary = (min, max) => {
        const $summary = $('#savings-summary');
        $summary.html(max 
            ? `Initiate your next savings for the month with an amount between <strong>$${min}</strong> and <strong>$${max}</strong>`
            : `Initiate your next savings for the month with an amount of <strong>$${min}</strong> or more`
        );
    };

    const setAmountRange = (min, max, val) => {
        const $amountInput = $('#saveAmount');
        $amountInput.attr('min', min);
        max ? $amountInput.attr('max', max) : $amountInput.removeAttr('max');
        $amountInput.val(val);  // Set default to min
        updateSummary(min, max);
    };

    const checkAmountAnswer = (answer) => {
        switch (answer) { 
            case "Less than $500/month":
                if(currentMonthTotal > 500) {
                    disableInputBtn();
                }
                setAmountRange(10, (500 - currentMonthTotal), (500 - currentMonthTotal));
                break;

            case "$500 – $1,000/month":
                if(currentMonthTotal >= 1000) {
                    disableInputBtn();
                }
                setAmountRange(500, (1000 - currentMonthTotal), (1000 - currentMonthTotal));
                break;

            case "Over $1,000/month":
                setAmountRange(1000, null, 1000);
                break;
        }
    };

    const chechWithdrawInterest = (answer) => {
        switch (answer) { 
            case "Reinvest interest":
                    $('.withdrawInterestBtn').prop('disabled', true);
                break;

            case "Withdraw interest periodically":
                    $('.withdrawInterestBtn').prop('disabled', true);
                break;
        }
    };

    const checkAmountDuration = (answer) => {
        switch (answer) { 
            case "Weekly":
                    dateTimeMethod('weekly');
                break;

            case "Monthly":
                    dateTimeMethod('monthly');
                break;

            case "Irregularly":
                    dateTimeMethod('daily');
                break;
        }
    };

    const checkFundsAccess = (answer) => {
        switch (answer) { 
            case "Yes, I’ll need regular access":
                    $('#withdrawBtn').prop('disabled', false);
                break;

            case "No, I can leave the funds untouched":
                    $('#withdrawBtn').prop('disabled', true);
                break;
        }
    }

    function calculateNextContributionDate(lastContributionDate, frequency, interval) {
        // Clone the date to avoid mutation
        const nextDate = new Date(lastContributionDate);

        // Calculate the next contribution date based on frequency and interval
        switch (frequency.toLowerCase()) {
            case 'daily':
                nextDate.setDate(nextDate.getDate() + interval); // Interval in days
                break;
            case 'weekly':
                nextDate.setDate(nextDate.getDate() + (interval * 7)); // Interval in weeks
                break;
            case 'monthly':
                nextDate.setMonth(nextDate.getMonth() + interval); // Interval in months
                break;
            case 'yearly':
                nextDate.setFullYear(nextDate.getFullYear() + interval); // Interval in years
                break;
            default:
                console.error('Invalid frequency specified');
                break;
        }

        return nextDate;
    }

    const dateTimeMethod = (frequency) => {
        const nextContributionDate = calculateNextContributionDate(lastContributionDate, frequency, interval);

        // Display the next contribution date
        $('#nextContribution').text(nextContributionDate.toLocaleDateString('en-US', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }));

        // Countdown setup
        const countdownInterval = setInterval(updateCountdown, 1000);
        updateCountdown();

        function updateCountdown() {
            const now = new Date().getTime();
            const countDownDate = nextContributionDate.getTime();
            const distance = countDownDate - now;

            // Calculate days, hours, minutes, seconds
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Update countdown display
            $('.school-card .d-flex .bg-white-transparent').eq(0).text(String(days).padStart(2, '0'));
            $('.school-card .d-flex .bg-white-transparent').eq(1).text(String(hours).padStart(2, '0'));
            $('.school-card .d-flex .bg-white-transparent').eq(2).text(String(minutes).padStart(2, '0'));
            $('.school-card .d-flex .bg-white-transparent').eq(3).text(String(seconds).padStart(2, '0'));

            // If the countdown is finished
            if (distance < 0) {
                clearInterval(countdownInterval);
                $('.school-card .d-flex .bg-white-transparent').text('00');
                alert('Next contribution date has arrived!');
            }
        }
    }

    const checkAmountContribute = (answer) => {
        switch (answer) { 
            case "Less than $5,000":
                setAmountRange(10, (5000 - currentMonthTotal), (5000 - currentMonthTotal));
                break;

            case "$5,000 – $10,000":
                if(currentMonthTotal >= 1000) {
                    disableInputBtn();
                }
                setAmountRange(10, (10000 - currentMonthTotal), (10000 - currentMonthTotal));
                break;

            case "Over $10,000":
                setAmountRange(10, null, 10000);
                break;
        }
    };

    const checkMontlyAmount = (answer) => {
        switch (answer) { 
            case "Less than $500":
                if(currentMonthTotal > 500) {
                    disableInputBtn();
                }
                setAmountRange(10, (500 - currentMonthTotal), (500 - currentMonthTotal));
                break;

            case "$500 – $1,000":
                if(currentMonthTotal >= 1000) {
                    disableInputBtn();
                }
                setAmountRange(500, (1000 - currentMonthTotal), (1000 - currentMonthTotal));
                break;

            case "Over $1,000":
                setAmountRange(1000, null, 1000);
                break;
        }
    }

    const checkDepositAmount = (answer) => {
        switch (answer) { 
            case "Less than $10,000":
                    if(currentMonthTotal > 10000) {
                        disableInputBtn();
                    }
                    setAmountRange(10, (10000 - currentMonthTotal), (10000 - currentMonthTotal));
                break;

            case "$10,000 – $50,000":
                    if(currentMonthTotal >= 50000) {
                        disableInputBtn();
                    }
                    setAmountRange(10, (50000 - currentMonthTotal), (50000 - currentMonthTotal));
                break;

            case "Over $50,000":
                    setAmountRange(500000, null, 500000);
                break;
        }
    }

    if(backendModalId == 'modalHYSA') {
        $('.withdrawInterestBtn').prop('disabled', true);

        dateTimeMethod('monthly');

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is your primary goal for this savings account?":
                    //blank for now
                    break;
                case "What is your expected contribution amount?":
                    checkAmountAnswer(answer);
                    break;
                case "How long do you plan to keep your savings in this account?":
                    // Add specific conditions here if necessary
                    break;
                    
                case "Do you need frequent access to the funds, or can they remain untouched?":
                    // Add specific conditions here if necessary
                    break;
                    
                case "Would you like to reinvest interest into the account or withdraw it periodically?":
                    // Add specific conditions here if necessary
                    chechWithdrawInterest(answer)
                    break;
            }
        });
    }

    if(backendModalId == 'modalCashInterest') {
        $('.withdrawInterestBtn').prop('disabled', true);

        setAmountRange(10, null, 10);

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is the purpose of this cash account?":
                    //blank for now
                    break;
                case "How often do you plan to deposit funds into this account?":
                    checkAmountDuration(answer);
                    break;
                case "Do you need frequent access to these funds?":
                    checkFundsAccess(answer);
                    break;
                case "Would you like a portion of this account to be allocated to higher interest products?":
                    // Add specific conditions here if necessary
                    break;
            }
        });
    }

    if(backendModalId == 'modalTaxFree') {
        $('.withdrawInterestBtn').prop('disabled', true);

        dateTimeMethod('yearly');

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is your primary goal for this tax-free savings account?":
                    //blank for now
                    break;
                case "How much do you plan to contribute each year?":
                    checkAmountContribute(answer);
                    break;
                case "What is your expected time horizon for this account?":
                    // checkFundsAccess(answer);
                    break;
                case "Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?":
                    switch (answer) { 
                        case "Reinvest all earnings":
                                $('#withdrawInterestBtn').prop('disabled', true);
                            break;

                        case "Withdraw earnings periodically":
                                $('#withdrawInterestBtn').prop('disabled', false);
                            break;
                    }
                    break;
            }
        });
    }

    if(backendModalId == 'modalFirstHome') {
        $('.withdrawInterestBtn').prop('disabled', true);

        dateTimeMethod('monthly');

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is your primary goal for this tax-free savings account?":
                    //blank for now
                    break;
                case "How much do you plan to contribute each year?":
                    // checkAmountContribute(answer);
                    break;
                case "How much do you plan to contribute monthly toward this goal?":
                        checkMontlyAmount(answer);
                    break;
                case "Do you need to access these funds before reaching your savings goal?":
                    switch (answer) { 
                        case "Yes, I may need access":
                                $('#withdrawBtn').prop('disabled', false);
                            break;

                        case "No, I plan to leave the funds untouched":
                                $('#withdrawBtn').prop('disabled', true);
                            break;
                    }
                    break;
            }
        });
    }

    if(backendModalId == 'modalCorporate') {
        $('.withdrawInterestBtn').prop('disabled', true);

        dateTimeMethod('monthly');

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is your primary goal for this tax-free savings account?":
                    //blank for now
                    break;
                case "How much do you plan to deposit into this account monthly?":
                    checkDepositAmount(answer);
                    break;
                case "Do you require frequent access to corporate funds?":
                    switch (answer) { 
                        case "Yes, for daily operations":
                                $('#withdrawBtn').prop('disabled', false);
                            break;

                        case "No, funds can remain untouched":
                                $('#withdrawBtn').prop('disabled', true);
                            break;
                    }
                    break;
                case "Would you like a portion of corporate funds to be invested for long-term growth?":
                        // checkMontlyAmount(answer);
                    break;
            }
        });
    }

    if(backendModalId == 'modalRetirement') {
        $('.withdrawInterestBtn').prop('disabled', true);

        dateTimeMethod('monthly');

        $('.quests').each(function () {
            const question = $(this).find('#savingsQuestion').text().trim();
            const answer = $(this).find('#savingsAnswer').text().trim();

            // Switch for processing question and answer
            switch (question) {
                case "What is your goal with this Roth IRA?":
                    //blank for now
                    break;
                case "How much do you plan to contribute each year?":
                    // checkDepositAmount(answer);
                    switch (answer) { 
                        case "Less than $6,500":
                                if(currentMonthTotal > 6500) {
                                    disableInputBtn();
                                }

                                setAmountRange(10, (6500 - currentMonthTotal), (6500 - currentMonthTotal));
                            break;

                        case "$6,500 – $15,000 (catch-up contributions for age 50+)":
                                if(currentMonthTotal > 15000) {
                                    disableInputBtn();
                                }

                                setAmountRange(10, (15000 - currentMonthTotal), (15000 - currentMonthTotal));
                            break;
                    }
                    break;
                case "When do you expect to start withdrawing from the account?":
                    switch (answer) { 
                        case "Yes, for daily operations":
                                $('#withdrawBtn').prop('disabled', false);
                            break;

                        case "No, funds can remain untouched":
                                $('#withdrawBtn').prop('disabled', true);
                            break;
                    }
                    break;
                case "How often do you plan to deposit funds into this account?":
                        // checkMontlyAmount(answer);
                    break;
            }
        });
    }
});
    

$(document).ready(function () {
    const isPaymentAttached = @json($payment->isEmpty() ? false : true);
    const modalElement = $('#paymentModal');

    if (!isPaymentAttached) {
        modalElement.modal('show');
    }

    modalElement.on('hide.bs.modal', function (e) {
        if (!isPaymentAttached) {
            e.preventDefault();
        }
    });
    
    $('#payBtn').on('click', function (e) {
        const amount = $('#saveAmount').val();
        if (amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount to initiate savings.');
        }
    });
});
</script>

@endsection