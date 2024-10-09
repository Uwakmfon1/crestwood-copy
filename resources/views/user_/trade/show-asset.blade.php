@extends('layouts.user.index')

@section('styles')

<link rel="stylesheet" href="{{ asset('asset/libs/swiper/swiper-bundle.min.css') }}">

<style>
    /* Hide default number input arrows */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type=number] {
        -moz-appearance: textfield; /* For Firefox */
    }
</style>

@endsection

@section('content')
<!-- Start::app-content -->
<div class="main-content app-content">
    <div class="container-fluid">

        @include('partials.users.alert')

        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-xl-12 mt-3">
                <div class="card custom-card">
                    <div class="card-header d-flex d-block">
                        <div class="h5 mb-0 d-flex d-block align-items-center">
                            <div class="">
                                <img src="../assets/images/brand-logos/toggle-logo.png" alt="">
                            </div>
                            <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                                <div class="h6 fw-medium mb-0">
                                    <div class="d-flex align-items-center align-center gap-3">
                                        <span class="avatar avatar-lg p-1 avatar-rounded bg-light">
                                            <img src="{{ $stock->img }}" alt="" class="">
                                        </span>
                                        <div class="flex-fill">
                                            <a href="javascript:void(0);" class="d-block fs-18 fw-bold">{{ $stock->name }}</a>
                                            <span class="d-block fs-12 text-muted fw-md">{{ $stock->symbol }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ms-auto mt-md-0 mt-2">
                            <a href="javascript:void(0);" class="d-block fs-20 fw-bold">${{ $stock->price }}</a>
                            <span class="d-block fs-12 text-muted fw-md text-end">Price</span>
                        </div>
                    </div>
                    <div class="card-body mx-3">
                        <div class="row gy-3">
                            <div class="col-lg-3 col-6">
                                <p class="fw-medium text-muted mb-1">Amount: </p>
                                <p class="fs-15 mb-1 fw-bold">${{ number_format($amount, 2) }}</p>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="fw-medium text-muted mb-1">Quantity: </p>
                                <p class="fs-15 mb-1 fw-bold">{{ number_format($quantity, 3) }} Unit(s)</p>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="fw-medium text-muted mb-1">P/L: </p>
                                <p class="fs-15 mb-1 fw-bold {{ $overallProfitLoss < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $overallProfitLoss <= 0 ? '' : '+' }}{{ number_format($overallProfitLoss, 2) }}USD
                                    <span class="mx-2 badge {{ $percentageOverallProfitLoss <= 0 ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                        {{ $percentageOverallProfitLoss <= 0 ? '' : '+' }} {{ number_format($percentageOverallProfitLoss, 2) }}%
                                    </span>
                                </p>
                            </div>
                            <div class="col-lg-3 col-6">
                                <p class="fw-medium text-muted mb-1">Trades: </p>
                                <p class="fs-15 mb-1 fw-bold">{{ $asset->count() }}</p>
                            </div>
                            <div class="col-xl-12">
                                <div class="table-responsive" style="min-height: 300px;">
                                    <table class="table nowrap text-nowrap mt-4">
                                        <thead>
                                            <tr>
                                                <th class="fw-bold">Amount</th>
                                                <th class="fw-bold">Quantity</th>
                                                <th class="fw-bold">Price</th>
                                                <th class="fw-bold">Profit</th>
                                                <th class="fw-bold">Type</th>
                                                <th class="fw-bold">Date</th>
                                                <th class="fw-bold">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($asset as $data)
                                                <tr>
                                                    <td>
                                                        <div class="fw-medium">
                                                            ${{ number_format($data->amount, 2) }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">
                                                            {{ number_format($data->quantity, 4) }}
                                                        </div>
                                                    </td>
                                                    <td class="product-quantity-container">
                                                        ${{ number_format($data->purchase_amount, 2) }}
                                                    </td>
                                                    <td>
                                                        ${{ number_format(($stock->price * $data->quantity) - ($data->amount), 3) }}
                                                        @php
                                                            $totalCost = $data->amount;
                                                            $totalRevenue = $stock->price * $data->quantity;
                                                            $profit = $totalRevenue - $totalCost;
                                                            $percentageProfit = $totalCost > 0 ? ($profit / $totalCost) * 100 : 0; // Avoid division by zero
                                                        @endphp

                                                        <span class="mx-2 badge {{ $percentageProfit < 0 ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                                            {{ number_format($percentageProfit, 2) }}%
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="mx-2 badge {{ $data->type == 'sell' ? 'bg-danger-transparent' : 'bg-success-transparent' }}">
                                                            {{ $data->type }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-medium">
                                                            {{ $data['created_at']->format('M d, Y \a\t h:i A') }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($data->type == 'buy')
                                                            <form action="{{ route('trade.close', $data->id) }}" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light">
                                                                    Close
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                        <div class="">
                            <a href="{{ route('assets') }}" class="btn btn-primary-transparent"> <i class="fe fe-arrow-left me-2 align-middle d-inline-block"></i> Back to Holdings</a>
                        </div>
                        <div class="">
                            <form action="{{ route('trade.close.all', $trade->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light">
                                    Close All Position
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
<!-- End::app-content -->
@endsection

@section('scripts')

<script>
    $(document).ready(function() {
    // Function to update the wallet price
    function updateWalletPrice($input) {
        const key = $input.data('key'); // Get the key for the current stock
        const pricePerUnit = parseFloat($input.data('price')); // Get the price for the current stock
        const quantity = Math.max(0.001, parseFloat($input.val()) || 0.001); // Ensure quantity is at least 0.001
        const totalPrice = pricePerUnit * quantity;

        // Update the wallet price and quantity display
        $('#wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
        $('#quantity-display-' + key).text(`${quantity} Unit${quantity > 1 ? 's' : ''}`);
    }

    // Handle input change directly
    $('.quantity-input').on('input', function() {
        updateWalletPrice($(this));
    });

    // Handle increment
    $('.increment-btn').click(function() {
        let $input = $(this).siblings('.quantity-input');
        let step = parseFloat($input.attr('step')) || 1;
        let currentValue = parseFloat($input.val()) || 0.001;
        $input.val((currentValue + step).toFixed(3)); // Ensure 3 decimal places
        updateWalletPrice($input);
    });

    // Handle decrement
    $('.decrement-btn').click(function() {
        let $input = $(this).siblings('.quantity-input');
        let step = parseFloat($input.attr('step')) || 1;
        let currentValue = parseFloat($input.val()) || 0.001;
        let minValue = parseFloat($input.attr('min')) || 0.001;
        let newValue = (currentValue - step).toFixed(3);
            if (newValue >= minValue) {
                $input.val(newValue); // Ensure it doesn't go below the minimum value
                updateWalletPrice($input);
            }
        });
    });

</script>
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>

@endsection