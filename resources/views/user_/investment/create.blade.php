@extends('layouts.user.index')

@section('title', 'New Investment')

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
                <h1 class="page-title fw-medium fs-18 mb-2">Create New Investment</h1>
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
        </div>
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
            <div class="col-xl-5 col-lg-8 col-md-12 col-sm-12">
                <form action="{{ route('invest.store') }}" method="post" id="investment-form">
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

                                    <label for="package" class="form-label">
                                        Investment Package 
                                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Select Package Investment" class="text-primary mx-1">
                                            <i class="fe fe-info"></i>
                                        </a>
                                    </label>

                                    <select class="form-control py-2" name="package" id="package">
                                        <option value="">Select Package</option>
                                        @foreach($packages as $package)
                                        <option 
                                            @if((old('package') == $package->name) || (request('package') == $package->name)) selected @endif 
                                            value="{{ $package->id }}" 
                                            data-image="{{ $package->image }}"
                                            data-name="{{ $package->name }}" 
                                            data-description="{{ $package->description }}" 
                                            data-min="{{ $package->min_amount }}" 
                                            data-max="{{ $package->max_amount }}" 
                                            data-roi="{{ $package->roi }}" 
                                            data-duration="{{ $package->milestone }} {{ $package->milestone == 1 ? rtrim($package->duration, 's') : $package->duration }}">
                                            {{ $package->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('package')
                                    <strong class="small text-danger">{{ $message }}</strong>
                                    @enderror

                                    <div class="d-flex justify-content-between my-2 mx-1">
                                        <strong class="small text-muted">Duration: <span class="text-primary duration">{{ $package->milestone }} {{ $package->duration }}</span></strong>
                                        <strong class="small text-muted">ROI: <span class="text-primary roi">{{ $package->roi }}%</span></strong>
                                    </div>

                                    <div class="d-flex justify-content-between my-2 mx-1">
                                        <strong class="small text-muted">Min Amount: <span class="text-primary" id="min-amount">${{ $package->min_amount }}</span></strong>
                                        <strong class="small text-muted">Max Amount: <span class="text-primary" id="max-amount">${{ $package->max_amount }}</span></strong>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <label for="amount" class="form-label">
                                        Amount 
                                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Specify the amount for your investment" class="text-primary mx-1">
                                            <i class="fe fe-info"></i>
                                        </a>
                                    </label>
                                    <input name="amount" type="number" class="form-control py-2" id="amount" placeholder="Enter amount" value="">
                                    <strong id="amount-error" class="small text-danger my-1" style="display:none;"></strong>
                                    @error('amount')
                                        <strong class="small text-danger">{{ $message }}</strong>
                                    @enderror
                                </div>
                                <div class="col-xl-6">
                                    <label class="form-label" for="duration-type">ROI Method <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Specify the frequency you want you ROI" class="text-primary mx-1"><i class="fe fe-info"></i></a></label>
                                    <div class="input-group">
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave decrement-btn-buy">-</button>
                                        <input type="number" name="roi_method" step="1" class="form-control text-center quantity-input-buy" id="quantity-input-buy" placeholder="Enter Method..." aria-label="Stock Quantity" value="1" min="1" required>
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy">+</button>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <label class="form-label" for="duration-type">ROI Duration <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-primary" title="Specify the frequency duration you want you ROI" class="text-primary mx-1"><i class="fe fe-info"></i></a></label>
                                    <div class="input-group"> 
                                        <select name="roi_duration" id="duration-type" class="form-control py-2">
                                            <option value="days">Day(s)</option>
                                            <option value="weeks">Week(s)</option>
                                            <option value="months">Month(s)</option>
                                            <option value="years">Year(s)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <strong id="roi-error" class="small text-danger my-1" style="display:none;"></strong>
                                </div>
                                <div class="col-xl-12">
                                    <div class="fs-12 alert alert-primary w-100">
                                        <div class="my-1" id="savings-summaryX" style="">
                                            
                                        </div>
                                        <div class="" id="roi-summaryX" style="">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @if($setting['invest'] == 1)
                                <div class="btn-list text-start w-100">
                                    <button type="submit" class="btn btn-primary w-100" id="submit-button">Start Investment</button>
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
            {{-- <div class="col-xl-7">
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
            </div> --}}

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

    function formatDuration(roiMethod, roiDuration) {
        return roiMethod === 1 
            ? roiDuration.slice(0, -1)  // Remove the "s" if roiMethod is 1
            : roiDuration;  // Keep the plural otherwise
    }

    // Convert duration to days
    function convertToDays(value, unit) {
        switch (unit) {
            case 'days': return value;
            case 'weeks': return value * 7;
            case 'months': return value * 30; // Approximation
            case 'years': return value * 365; // Approximation
            default: return value;
        }
    }

    // Parse duration string into value and unit
    function parseDuration(durationString) {
        const [value, unit] = durationString.split(' ');
        return { value: parseInt(value), unit };
    }

    // Update the savings summary
    function updateSavingsSummary() {
        const selectedPackage = $('#package option:selected');
        const amount = $('#amount').val() || selectedPackage.data('min');
        const packageName = selectedPackage.data('name');
        const packageDurationString = selectedPackage.data('duration');
        const parsedPackageDuration = parseDuration(packageDurationString);
        const packageDurationValue = parsedPackageDuration.value;
        const packageDurationUnit = parsedPackageDuration.unit;
        const roiMethod = parseInt($('#quantity-input-buy').val());
        const roiDuration = $('#duration-type').val();

        const roiInDays = convertToDays(roiMethod, roiDuration);
        const packageInDays = convertToDays(packageDurationValue, packageDurationUnit);

        const summary = `Your investment of $${amount} into <strong>${packageName}</strong> will run for <strong>${packageDurationString}</strong>.`;
        const summaryRoi = `Your ROI will be paid every <strong>${roiMethod} ${formatDuration(roiMethod, roiDuration)}</strong>.`;

        $('#savings-summaryX').html(summary);
        $('#roi-summaryX').html(summaryRoi);

        // Validation
        if (roiInDays > packageInDays) {
            $('#roi-error').text(`ROI duration exceeds the package limit of ${packageDurationString}.`).show();
            $('#submit-button').prop('disabled', true);
        } else {
            $('#roi-error').hide();
            $('#submit-button').prop('disabled', false);
        }
    }

    // Update the amount limits based on the selected package
    function updateAmountLimits() {
        const selectedPackage = $('#package option:selected');
        const minAmount = parseFloat(selectedPackage.data('min'));
        const maxAmount = parseFloat(selectedPackage.data('max'));

        $('#amount').on('input', function() {
            const amount = parseFloat($(this).val());
            if (amount < minAmount || amount > maxAmount) {
                $('#amount-error').text(`Amount must be between $${minAmount.toFixed(2)} and $${maxAmount.toFixed(2)}.`).show();
                $('#submit-button').prop('disabled', true);
            } else {
                $('#amount-error').hide();
                $('#submit-button').prop('disabled', false);
            }
            updateSavingsSummary();
        });
    }

    // Update package details and UI elements
    function updatePackageDetails() {
        const selectedPackage = $('#package option:selected');
        const packageName = selectedPackage.data('name');
        const packagePrice = parseFloat(selectedPackage.data('price')).toFixed(2);
        const packageDescription = selectedPackage.data('description');
        const packageImage = selectedPackage.data('image');
        const roi = selectedPackage.data('roi');
        const duration = selectedPackage.data('duration');
        const amount = $('#amount').val();

        $('#package-info').removeClass('d-none').find('#package-image').attr('src', packageImage);
        $('#package-name').text(packageName);
        $('#package-description').text(packageDescription);
        $('#package-price').text(`$${packagePrice}`);
        $('#invest-button').text(`${roi}%`);

        $('#savings-summary').show();
        $('.text-primary.duration').text(duration);
        $('.text-primary.roi').text(`${roi}%`);
        $('#min-amount').text(`$${parseFloat(selectedPackage.data('min')).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);
        $('#max-amount').text(`$${parseFloat(selectedPackage.data('max')).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`);

        $('#amount').val(parseFloat(selectedPackage.data('min')));
    }

    // Handle package change event
    $('#package').on('change', function() {
        updatePackageDetails();
        updateAmountLimits();
        updateSavingsSummary();
    });

    // Handle quantity and ROI input changes
    $('#quantity-input-buy, #duration-type').on('input change', function() {
        updateSavingsSummary();
    });

    // Handle amount input changes
    $('#amount').on('input', function() {
        updateSavingsSummary();
    });

    // Handle quantity changes with increment and decrement buttons
    function updateWalletPrice(modalType) {
        const pricePerUnit = parseFloat($(`#quantity-input-${modalType}`).data('price'));
        const quantity = Math.max(0.001, parseFloat($(`#quantity-input-${modalType}`).val()) || 0.001);
        const totalPrice = pricePerUnit * quantity;
        $(`#wallet-price-${modalType}`).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $(`#quantity-display-${modalType}`).text(`${quantity} Unit${quantity > 1 ? 's' : ''}`);
    }

    $('.quantity-input-buy, .quantity-input-sell').on('input', function() {
        const modalType = $(this).hasClass('quantity-input-buy') ? 'buy' : 'sell';
        updateWalletPrice(modalType);
    });

    $('.increment-btn-buy, .increment-btn-sell').click(function() {
        const modalType = $(this).hasClass('increment-btn-buy') ? 'buy' : 'sell';
        let $input = $(`#quantity-input-${modalType}`);
        let step = parseFloat($input.attr('step')) || 1;
        let currentValue = parseFloat($input.val()) || 1;
        $input.val(currentValue + step);
        updateWalletPrice(modalType);
        updateSavingsSummary();
    });

    $('.decrement-btn-buy, .decrement-btn-sell').click(function() {
        const modalType = $(this).hasClass('decrement-btn-buy') ? 'buy' : 'sell';
        let $input = $(`#quantity-input-${modalType}`);
        let step = parseFloat($input.attr('step')) || 0.001;
        let currentValue = parseFloat($input.val()) || 0.001;
        let minValue = parseFloat($input.attr('min')) || 0.001;
        if (currentValue - step >= minValue) {
            $input.val(currentValue - step);
            updateWalletPrice(modalType);
        }
        updateSavingsSummary();
    });

    // Initialize on page load
    $('#package').trigger('change');
});
</script>


@endsection