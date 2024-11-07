@extends('layouts.user.index')

@section('content')

<!-- Start::app-content -->
<div class="main-content app-content">
            <div class="container-fluid">

                <!-- Start::page-header -->
                <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h1 class="page-title fw-medium fs-18 mb-2">Savings</h1>
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item">
                                <a href="javascript:void(0);">
                                    Pages
                                </a>
                            </li>
                            <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Savings</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Savings Create</li>
                        </ol>
                    </div>
                    <!-- <div class="d-flex gap-2">
                        <button class="btn btn-white btn-wave border-0 me-0 fw-normal waves-effect waves-light">
                            <i class="ri-filter-3-fill me-2"></i>Filter
                        </button>
                        <button type="button" class="btn btn-primary btn-wave waves-effect waves-light"> 
                            <i class="ri-upload-2-line me-2"></i> Export report
                        </button> 
                    </div> -->
                </div>
                <!-- End::page-header -->
                <!-- @if ($errors->any())
                    <div class="row">
                        <div class="col-6 my-1">
                            <div class="alert alert-danger" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>
                                        <i data-feather="alert-circle" class="mr-2"></i>
                                        <strong style="font-size: 13px" class="small">{{ $error }}</strong>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif -->

                <!-- Start::row-1 -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card custom-card overflow-hidden">
                                    <img src="https://images.rawpixel.com/image_800/cHJpdmF0ZS9sci9pbWFnZXMvd2Vic2l0ZS8yMDIyLTA1L3JtMjE4LWV5ZS0wNy5qcGc.jpg" class="card-img-top" style="height: 200px;" alt="...">
                                    <div class="card-img-overlay-profile">
                                        <div class="d-flex align-items-start text-fixed-white">
                                            <div class="flex-grow-1 text-center">
                                                <div class="mt-1 align-items-center justify-conent-between fs-22 mb-1">
                                                    <span>Expected Returns</span>
                                                    <span class="min-w-fit-content fs-10 ms-1 "></span>
                                                </div>
                                                <div class="d-flex align-items-center justify-conent-between">
                                                    <span class="flex-grow-1 fs-30 fw-semibold sale-font counter">$0.00<span>
                                                        </span></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-center mt-3 px-3">
                                            <div class="d-flex align-items-start">
                                                <span class="avatar avatar-sm rounded-circle me-3 bg-white-transparent mt-2 d-sm-flex d-none">
                                                    <i class="bx bx-up-arrow-alt fs-20 text-fixed-white"></i>
                                                </span>
                                                <div class="flex-grow-1 text-fixed-white">
                                                    <div class="d-flex align-items-center justify-conent-between fs-20 fw-medium">
                                                        <span id="initial">$0.00</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-conent-between">
                                                        <span class="flex-grow-1 fs-13 fw-semibold">Initial</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex ms-5">
                                                <span class="avatar avatar-sm rounded-circle me-3 bg-white-transparent mt-2 d-sm-flex d-none">
                                                    <i class="bx bx-down-arrow-alt fs-20 text-fixed-white"></i>
                                                </span>
                                                <div class="flex-grow-1 text-fixed-white">
                                                    <div class="d-flex align-items-center justify-conent-between fs-20 fw-medium">
                                                        <span id="contributions">$0.00</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-conent-between">
                                                        <span class="flex-grow-1 fs-13 fw-semibold">Contribution</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <ul class="list-group list-group-flush">
                                            <li class="list-group-item p-3">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div>
                                                        <span class="avatar avatar-rounded bg-primary-transparent text-primary"><i class="ti ti-clock  fs-22"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <span class="mb-0 fw-medium d-block">Period</span>
                                                        <span class="text-muted fs-12">Period of which the savings will run</span>

                                                    </div>
                                                    <div class="text-end">
                                                        <span class="flex-grow-1 fs-15 fw-semibold sale-font counter text-dark">--</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-3">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div>
                                                        <span class="avatar avatar-rounded bg-secondary-transparent text-secondary"><i class="ti ti-bolt fs-22"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <span class="mb-0 fw-medium d-block">Total-Profit</span>
                                                        <span class="text-muted fs-12">Profit after the whole savings period</span>
                                                    </div>
                                                    <div class="text-end">
                                                        <span class="flex-grow-1 fs-15 fw-semibold sale-font counter text-dark">$0.00</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="list-group-item p-3">
                                                <div class="d-flex align-items-start gap-3">
                                                    <div>
                                                        <span class="avatar avatar-rounded bg-success-transparent"><i class="ti ti-percentage fs-22"></i></span>
                                                    </div>
                                                    <div class="flex-fill">
                                                        <span class="mb-0 fw-medium d-block">ROI</span>
                                                        <span class="text-muted fs-12">Rate of Investment</span>

                                                    </div>
                                                    <div class="text-end">
                                                        <span class="lex-grow-1 fs-15 fw-semibold sale-font counter text-dark">0%</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
                        <form action="{{ route('savings.store') }}" method="post">
                            @csrf
                            <div class="card custom-card">
                                <div class="card-header">
                                    <div class="card-title">New Savings</div>
                                </div>
                                <div class="card-body">
                                    <div class="row gy-3">
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="deposit" class="form-label">Initial Deposit</label>
                                                    <input name="deposit" type="number" class="form-control" id="deposit" placeholder="Enter deposit">
                                                    @error('deposit')
                                                        <strong class="small text-danger">
                                                            {{ $message }}
                                                        </strong>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <label for="contribution" class="form-label">Periodical Contribution</label>
                                                    <input name="contribution" type="number" class="form-control" id="contribution" placeholder="Enter contribution">
                                                    @error('contribution')
                                                        <strong class="small text-danger">
                                                            {{ $message }}
                                                        </strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-12">
                                            <label for="roi" class="form-label">Risk Level</label>
                                            <select class="form-control" name="roi" id="roi">
                                                <option value="">Select Level</option>
                                                <option value="10">Basic</option>
                                                <option value="20">Mid-Risk</option>
                                                <option value="30">Premium</option>
                                            </select>
                                            @error('roi')
                                                <strong class="small text-danger">
                                                    {{ $message }}
                                                </strong>
                                            @enderror
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="timeframe" class="form-label">Contribution Timeframe</label>
                                                    <select class="form-control" name="timeframe" id="timeframe">
                                                        <option value="--">Select timeframe</option>
                                                        <option value="daily">Daily</option>
                                                        <option value="weekly">Weekly</option>
                                                        <option value="montly">Montly</option>
                                                        <option value="yearly">Yearly</option>
                                                    </select>
                                                    @error('timeframe')
                                                        <strong class="small text-danger">
                                                            {{ $message }}
                                                        </strong>
                                                    @enderror
                                                </div>
                                                <div class="col-6">
                                                    <label for="duration" class="form-label">Savings Duration</label>
                                                    <select class="form-control" name="duration" id="duration">
                                                        <option value="--">Select Duration</option>
                                                        <option value="2w">2 weeks</option>
                                                        <option value="4w">4 weeks</option>
                                                        <option value="1m">1 month</option>
                                                        <option value="1y">1 year</option>
                                                    </select>
                                                    @error('duration')
                                                        <strong class="small text-danger">
                                                            {{ $message }}
                                                        </strong>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                @if($setting['invest'] == 1)
                                    <div class="btn-list text-start">
                                        <button type="submit" class="btn btn-primary">Start Savings</button>
                                    </div>
                                @else
                                    <div class="btn-list text-end">
                                        <button type="button" class="btn btn-sm btn-primary" disabled>Start Savings</button>
                                    </div>
                                @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!--End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->

@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Get references to the form inputs and card elements
    const $depositInput = $('#deposit');
    const $contributionInput = $('#contribution');
    const $roiSelect = $('#roi');
    const $durationSelect = $('#duration');
    const $timeframeSelect = $('#timeframe');

    const $expectedReturnsElem = $('.card .sale-font.counter').eq(0);
    const $initialAmountElem = $('#initial');
    const $contributionAmountElem = $('#contributions');
    const $periodElem = $('.list-group-item:nth-child(1) .text-end span').eq(0);
    const $profitElem = $('.list-group-item:nth-child(2) .text-end span').eq(0);
    const $roiElem = $('.list-group-item:nth-child(3) .text-end span').eq(0);

    // Update card based on input
    function updateCard() {
        const depositValue = parseFloat($depositInput.val()) || 0;
        const contributionValue = parseFloat($contributionInput.val()) || 0;
        const roiValue = parseFloat($roiSelect.val()) || 0;
        const durationValue = $durationSelect.find('option:selected').text();
        const timeframeValue = $timeframeSelect.find('option:selected').text();

        // Calculate expected returns
        const totalContributions = contributionValue * (parseInt(durationValue) || 1);
        const expectedReturns = depositValue + totalContributions + (totalContributions + depositValue) * (roiValue / 100);

        // Update UI
        $expectedReturnsElem.text(`$${expectedReturns.toFixed(2)}`);
        $initialAmountElem.text(`$${depositValue.toFixed(2)}`);
        $contributionAmountElem.text(`$${totalContributions.toFixed(2)}`);
        $periodElem.text(`${durationValue} (${timeframeValue})`);
        $roiElem.text(`${roiValue}%`);
        $profitElem.text(`$${(expectedReturns - depositValue - totalContributions).toFixed(2)}`);
    }

    // Attach event listeners to update card on input change
    $depositInput.on('input', updateCard);
    $contributionInput.on('input', updateCard);
    $roiSelect.on('change', updateCard);
    $durationSelect.on('change', updateCard);
    $timeframeSelect.on('change', updateCard);

    // Initial card update with default values
    // updateCard();
});

</script>

<script>
    $(document).ready(function() {
        $('#savings-summary').hide();

        function updateSummary() {
            var selectedPackage = $('#package').find('option:selected');
            var roi = selectedPackage.attr('data-roi');
            var duration = $('#duration').val();
            var milestone = $('#milestone').val();

            if (duration && milestone) {
                var durationText = milestone + ' ';
                if (milestone > 1) {
                    durationText += duration === 'daily' ? ' days' : duration === 'weekly' ? ' weeks' : ' months';
                } else {
                    durationText += duration === 'daily' ? ' day' : duration === 'weekly' ? ' week' : ' month';
                }

                $('#summary-roi').text(roi + '%');
                $('#summary-duration').text(durationText);
                $('#savings-summary').show();
            } else { 
                $('#savings-summary').hide();
            }
        }

        $('#package').change(function() {
            var selectedPackage = $(this).find('option:selected');
            var price = selectedPackage.attr('data-price');
            var slot = parseFloat($('#slot').val());

            if (price && !isNaN(slot)) {
                price = parseFloat(price);
                $('#amount').val('₦ ' + (price * slot).toLocaleString());
            } else {
                $('#amount').val('₦ 0.00');
            }

            calculateReturns();
            updateSummary();
        });

        $('#slots, #milestone, #duration').on('input change', function() {
            calculateReturns();
            updateSummary();
        });

        function calculateReturns() {
            var selectedPackage = $('#package').find('option:selected');
            var price = parseFloat(selectedPackage.attr('data-price'));
            var roi = parseFloat(selectedPackage.attr('data-roi'));
            var slot = parseFloat($('#slots').val());
            var milestone = parseFloat($('#milestone').val());

            if (isNaN(price) || isNaN(roi) || isNaN(slot) || isNaN(milestone)) {
                $('#returns').val('₦ 0.00');
                return;
            }

            var amountToInvest = price * slot;
            var expectedReturn = amountToInvest * milestone * (1 + roi / 100);
            $('#amount').val('₦ ' + amountToInvest.toLocaleString());
            $('#returns').val('₦ ' + expectedReturn.toLocaleString());
        }
    });
</script>

@endsection