@extends('layouts.user.index')

@section('content')
<style>
    .skeleton-loader {
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .skeleton-img {
        width: 100px;
        height: 100px;
        background: #f0f0f0;
        border-radius: 50%;
        margin-bottom: 20px;
    }
    .skeleton-text {
        width: 80%;
        height: 20px;
        background: #f0f0f0;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .skeleton-btn {
        width: 100px;
        height: 30px;
        background: #f0f0f0;
        border-radius: 4px;
    }

    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
</style>

<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        <!-- Start::page-header -->
        <div class="my-4 page-header-breadcrumb d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div>
                <h1 class="page-title fw-medium fs-18 mb-2">Investment</h1>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="javascript:void(0);">
                            Pages
                        </a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page"><a href="javascript:void(0);">Investment</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Create</li>
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
        @if (session('error'))
            <div class="row">
                <div class="col-6 my-1">
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                </div>
            </div>
        @endif

        <!-- Start::row-1 -->
        <div class="row">
            <div class="col-xl-7">
                <div class="card custom-card border-0 bg-primary-transparent podcast-card">
                    <div class="card-body p-4">
                        <div class="row justify-content-between">
                            <div class="col-xxl-4 col-xl-5 col-lg-7 col-md-7 col-sm-7 text-end my-auto">
                                <img src="/{{ $package['image'] }}" alt="" class="img-fluid my-1">
                            </div>
                            <div class="col-xxl-8 col-xl-7 col-lg-5 col-md-5 col-sm-5">
                                <h4 class="mb-2 fw-semibold">{{$package['name']}}</h4>
                                <p class="mb-2">{{$package['description']}}</p>
                                <span class="fw-medium rounded">
                                    <i class="fe fe-check-circle text-primary me-1"></i> 
                                    <span class="text-primary">
                                        {{ number_format($package['roi']) }}%
                                    </span>
                                    <span class="ms-2 text-default fs-12 op-8 text-primary"><i class="fe fe-calendar fs-13 me-1 text-primary"></i>2 months</span>
                                        <div class="d-flex align-items-center gap-2 mt-3">
                                            <!-- <button class="btn btn-primary btn-wave waves-effect waves-light">Listen Now</button>
                                            <button class="btn btn-outline-primary btn-wave waves-effect waves-light">Add To
                                                Favorite</button> -->
                                                <div class="d-flex align-items-center justify-content-between"> 
                                                <p class="mb-1">
                                                    <span class="fs-22 fw-semibold">
                                                        ${{ number_format($package['min_amount'], 2) }}
                                                    </span>
                                                    <span class="mx-1">-</span>
                                                    <span class="fs-22 fw-semibold">
                                                        ${{ number_format($package['max_amount'], 2) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </span>
                                </span>
                                <div class="d-flex align-items-center gap-2 mt-3">
                                    <button class="btn btn-primary btn-wave waves-effect waves-light">View Plan</button>
                                    <!-- <button class="btn btn-outline-primary btn-wave waves-effect waves-light"></button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-xl-7 col-lg-8 col-md-12 col-sm-12">
            <form action="{{ route('invest.store') }}" method="post">
                @csrf
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">New Investment</div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-xl-12">
                                <input type="hidden" id="price">
                                <input type="hidden" id="roi">
                                <input type="hidden" id="duration">
                                <label for="package" class="form-label">Investment Package</label>
                                <select class="form-control" name="package" id="package">
                                    <option value="">Select Package</option>
                                    @foreach($packages as $package)
                                        <option 
                                            @if((old('package') == $package['name']) || (request('package') == $package['name'])) selected @endif 
                                            value="{{ $package['id'] }}" 
                                            data-image="{{ $package['image'] }}"
                                            data-name="{{ $package['name'] }}" 
                                            data-description="{{ $package['description'] }}" 
                                            data-price="{{ $package['price'] }}" 
                                            data-roi="{{ $package['daily_roi'] }}" 
                                            data-duration="{{ $package['duration'] }}">
                                            {{ $package['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('package')
                                    <strong class="small text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>
                            <div class="col-xl-12">
                                <label for="amount" class="form-label">Amount</label>
                                <input name="amount" type="number" class="form-control" id="amount" placeholder="Enter amount">
                                @error('amount')
                                    <strong class="small text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>
                            <!-- <div class="col-xl-12">
                                <label class="form-label" for="duration-type">ROI Preiod</label>
                                <div class="input-group">
                                    <input type="text" aria-label="First name" class="form-control">
                                    <select name="duration_type" id="duration-type" class="form-control">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
                            </div> -->
                            <div class="col-xl-12">
                                <label class="form-label" for="duration-type">ROI Method</label>
                                <div class="input-group my-1">
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave decrement-btn-buy">-</button>
                                    <input type="number" name="roi_method" step="1" class="form-control text-center quantity-input-buy" id="quantity-input-buy" placeholder="Enter Method..." aria-label="Stock Quantity" value="1" min="1" required>
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy">+</button>
                                </div>
                                <strong class="fs-10 text-muted">
                                    Specify the frequency you want you ROI
                                </strong>
                            </div>
                            <div class="col-xl-12">
                                <label class="form-label" for="duration-type">ROI Duration</label>
                                <div class="input-group">
                                    <select name="roi_duration" id="duration-type" class="form-control">
                                        <option value="days">Daily</option>
                                        <option value="weeks">Weekly</option>
                                        <option value="months">Monthly</option>
                                        <option value="years">Yearly</option>
                                    </select>
                                </div>
                                <strong class="fs-10 text-muted">
                                    Specify the frequency duration you want you ROI
                                </strong>
                            </div>
                            <div class="col-xl-12">
                                <div class="fs-12 alert alert-primary w-100" id="savings-summaryX" style="">
                                    Your investment of {amount} into <strong>{{ $package->name }}</strong> will run for <strong>{duration}</strong>.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        @if($setting['invest'] == 1)
                            <div class="btn-list text-start">
                                <button type="submit" class="btn btn-success">Start Investment</button>
                            </div>
                        @else
                            <div class="btn-list text-end">
                                <button type="button" class="btn btn-sm btn-primary" disabled>Start Investment</button>
                            </div>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        {{-- <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
            <div class="card custom-card team-member" id="package-details-card">
                <div class="card-body text-center p-5">
                    <!-- Skeleton Loader -->
                    <div class="skeleton-loader" id="skeleton-loader">
                        <div class="skeleton-img"></div>
                        <div class="skeleton-text"></div>
                        <div class="skeleton-text"></div>
                        <div class="skeleton-btn"></div>
                    </div>
                    
                    <!-- Package Details -->
                    <div class="package-info d-none" id="package-info">
                        <div class="mb-4 lh-1">
                            <span class="avatar avatar-xxl avatar-rounded p-2 bg-light">
                                <img src="" id="package-image" class="card-img bg-primary" alt="...">
                            </span>
                        </div>
                        <div class="text-center">
                            <h6 class="mb-0 fw-semibold" id="package-name"></h6>
                            <p class="mb-0 text-muted" id="package-description"></p>
                            <div class="d-flex justify-content-around mt-4">
                                <div>
                                    <span class="text-primary w-100 py-2 rounded fw-bold fs-20" id="package-price"></span>
                                    <p class="mb-0 text-muted" id="">Amount</p>
                                </div>
                                <div>
                                    <span class=" w-100 py-2 rounded fw-bold fs-20 text-success" id="invest-button" href="#"></span>
                                    <p class="mb-0 text-muted" id="">ROI</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-lg-4 col-md-12 col-sm-12">
            <div class="card custom-card overflow-hidden">
                <div class="card-header">
                    <div class="card-title">
                        <div class="card custom-card" style="width: 100%; border: 0px; padding: 0px; margin: 0px;">
                            <div class="row g-0 w-100">
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <h3 class="card-title fs-24">{{$package['name']}}</h3>
                                    </div>
                                    <div class="card-body" style="border: 0px;">
                                        <p class="card-text"><small class="text-muted">{{$package['description']}}</small></p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <img src="{{$package['image']}}" class="img-fluid rounded-end h-80 w-100" alt="...">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <h4 class="fw-semibold mb-0">${{ number_format($package['price'], 2) }}</h4>
                        <div class="ms-2">
                            <span class="badge bg-success-transparent">+{{$package['daily_roi']}}%</span>
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
                                        <p class="mb-0 text-muted fs-10 d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-primary me-2"></i>
                                            Amount</p>
                                        <!-- <h6 class="fw-medium fs-12 bg-primary-transparent px-3 py-1 rounded ">$20</h6> -->
                                        <div class="d-flex align-items-center mb-2">
                                            <h4 class="fw-semibold mb-0 fs-15">${{ number_format($package['price'], 2) }}</h4>
                                            <div class="ms-2">
                                                <span class="badge bg-primary-transparent">+$400.23</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item success">
                            <div class="d-flex align-items-center">
                                <div class="flex-fill align-items-center pt-1">
                                    <div class="d-flex align-items-top justify-content-between">
                                        <p class="mb-0 text-muted fs-10  d-flex align-items-center"><i class="ti ti-point-filled fs-20 text-success me-2"></i>
                                            Investment Period</p>
                                        <h6 class="fw-medium fs-11 bg-success-transparent px-3 py-1 rounded">3 Months</h6>
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
                                        <h6 class="fw-medium fs-11 bg-info-transparent px-3 py-1 rounded">2nd, Nov. 2024</h6>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        </div> --}}
        <!--End::row-1 -->

    </div>
</div>
<!-- End::app-content -->

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Function to update the wallet price based on the quantity
    function updateWalletPrice(modalType) {
        const pricePerUnit = parseFloat($(`#quantity-input-${modalType}`).data('price'));
        const quantity = Math.max(0.001, parseFloat($(`#quantity-input-${modalType}`).val()) || 0.001);
        const totalPrice = pricePerUnit * quantity;

        $(`#wallet-price-${modalType}`).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $(`#quantity-display-${modalType}`).text(`${quantity} Unit${quantity > 1 ? 's' : ''}`);
    }

    // Handle quantity input change
    $('.quantity-input-buy, .quantity-input-sell').on('input', function() {
        const modalType = $(this).hasClass('quantity-input-buy') ? 'buy' : 'sell';
        updateWalletPrice(modalType);
    });

    // Handle increment button click
    $('.increment-btn-buy, .increment-btn-sell').click(function() {
        const modalType = $(this).hasClass('increment-btn-buy') ? 'buy' : 'sell';
        let $input = $(`#quantity-input-${modalType}`);
        let step = parseFloat($input.attr('step')) || 0.001;
        let currentValue = parseFloat($input.val()) || 0.001;
        $input.val((currentValue + step));
        updateWalletPrice(modalType);
    });

    // Handle decrement button click
    $('.decrement-btn-buy, .decrement-btn-sell').click(function() {
        const modalType = $(this).hasClass('decrement-btn-buy') ? 'buy' : 'sell';
        let $input = $(`#quantity-input-${modalType}`);
        let step = parseFloat($input.attr('step')) || 0.001;
        let currentValue = parseFloat($input.val()) || 0.001;
        let minValue = parseFloat($input.attr('min')) || 0.001;
        let newValue = (currentValue - step);
        if (newValue >= minValue) {
            $input.val(newValue);
            updateWalletPrice(modalType);
        }
    });
});

</script>
<script>
    function updatePackageDetails(selectedOption) {
        if (selectedOption.value) {
            // Hide Skeleton Loader
            document.getElementById('skeleton-loader').classList.add('d-none');
            // Show Package Info
            document.getElementById('package-info').classList.remove('d-none');

            // Update Package Info
            document.getElementById('package-image').src = selectedOption.getAttribute('data-image');
            document.getElementById('package-name').textContent = selectedOption.getAttribute('data-name');
            document.getElementById('package-description').textContent = selectedOption.getAttribute('data-description');
            document.getElementById('package-price').textContent = '$' + parseFloat(selectedOption.getAttribute('data-price')).toFixed(2);
            document.getElementById('invest-button').textContent = parseFloat(selectedOption.getAttribute('data-roi')) + '%';
            
            // Update Invest Button URL
            // document.getElementById('invest-button').setAttribute('href', '/invest?package=' + selectedOption.getAttribute('data-name'));
        } else {
            // Show Skeleton Loader
            document.getElementById('skeleton-loader').classList.remove('d-none');
            // Hide Package Info
            document.getElementById('package-info').classList.add('d-none');
        }
    }

    document.getElementById('package').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        updatePackageDetails(selectedOption);
    });

    // Check for a pre-selected package on page load
    window.addEventListener('DOMContentLoaded', function () {
        const packageSelect = document.getElementById('package');
        const selectedOption = packageSelect.options[packageSelect.selectedIndex];

        if (selectedOption.value) {
            updatePackageDetails(selectedOption);
        }
    });
</script>
<script>
$(document).ready(function() {
    $('#savings-summary').hide();

    function updateSummary() {
        var selectedPackage = $('#package').find('option:selected');
        var roi = selectedPackage.attr('data-roi');
        var duration = selectedPackage.attr('data-duration');

        if (duration) {
            var durationText = '1 ' + (duration === 'daily' ? 'day' : duration === 'weekly' ? 'week' : 'month');

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
        var slot = parseFloat($('#slots').val());

        if (price && !isNaN(slot)) {
            price = parseFloat(price);
            var amountToInvest = price * slot;
            $('#amount').val('$ ' + amountToInvest.toLocaleString());
        } else {
            $('#amount').val('$ 0.00');
        }

        calculateReturns();
        updateSummary();
    });

    $('#slots').on('input change', function() {
        calculateReturns();
        updateSummary();
    });

    function calculateReturns() {
        var selectedPackage = $('#package').find('option:selected');
        var price = parseFloat(selectedPackage.attr('data-price'));
        var roi = parseFloat(selectedPackage.attr('data-roi'));
        var slot = parseFloat($('#slots').val());

        if (isNaN(price) || isNaN(roi) || isNaN(slot)) {
            $('#returns').val('$ 0.00');
            return;
        }

        var amountToInvest = price * slot;
        var expectedReturn = amountToInvest * (1 + roi / 100);
        $('#amount').val('$ ' + amountToInvest.toLocaleString());
        $('#returns').val('$ ' + expectedReturn.toLocaleString());
    }
});
</script>

@endsection