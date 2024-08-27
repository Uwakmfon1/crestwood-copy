@extends('layouts.user.index')

@section('content')

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
                            <li class="breadcrumb-item active" aria-current="page">Investment Create</li>
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
                    <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12">
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
                                                    <option @if((old('package') == $package['name']) || (request('package') == $package['name'])) selected @endif 
                                                            value="{{ $package['id'] }}" 
                                                            data-price="{{ $package['price'] }}" 
                                                            data-roi="{{ $package['roi'] }}" 
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
                                            <label for="slots" class="form-label">Slot</label>
                                            <input name="slots" type="text" class="form-control" id="slots" placeholder="Enter slot">
                                            @error('slots')
                                                <strong class="small text-danger">
                                                    {{ $message }}
                                                </strong>
                                            @enderror
                                        </div>
                                        <div class="col-xl-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <label for="amount" class="form-label">Amount to Invest</label>
                                                    <input name="amount" type="text" class="form-control" id="amount" value="&#36; 0.00" disabled>
                                                </div>
                                                <div class="col-6">
                                                    <label for="returns" class="form-label">Expected Return</label>
                                                    <input name="returns" type="text" class="form-control" id="returns" value="&#36; 0.00" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-10 mx-3 alert alert-primary" id="savings-summary" style="display: none;">
                                            The Investment will run for <strong id="summary-duration"></strong> at an ROI of <strong id="summary-roi"></strong>.
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    @if($setting['invest'] == 1)
                                        <div class="btn-list text-start">
                                            <button type="submit" class="btn btn-primary">Start Investment</button>
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
                </div>
                <!--End::row-1 -->

            </div>
        </div>
        <!-- End::app-content -->

@endsection

@section('scripts')

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