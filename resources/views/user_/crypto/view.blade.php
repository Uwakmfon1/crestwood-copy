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
                                <p class="fw-medium text-muted mb-1">Lot Size: </p>
                                <p class="fs-15 mb-1 fw-bold">{{ number_format($quantity, 3) }}</p>
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
                                                <th class="fw-bold">Lots</th>
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
                                                    <td>
                                                        ${{ number_format(($stock->price * $data->quantity) - ($data->amount), 2) }}
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
                                                            <button type="button" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#sellModal-{{ $data->id }}">
                                                                Sell
                                                            </button>
                                                        @endif
                                                    </td>

                                                    <div class="modal fade" id="sellModal-{{ $data->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content" style="height: 100%; max-width: 650px !important;">
                                                                <div class="modal-body p-2" style="height: 100%;">
                                                                    <div class="">
                                                                        <div class="d-flex align-items-center flex-wrap gap-3">
                                                                            <div class="flex-grow-1 my-1">
                                                                                <div class="card custom-card overflow-hidden">
                                                                                    <div class="d-flex justify-content-between">
                                                                                        <div style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="px-3 py-4">
                                                                                                <div>
                                                                                                    <span class="d-block mb-1 fs-12 text-muted">Sale</span>
                                                                                                    <h5 class="fw-bold fs-24 mb-1">$<span id="sell-wallet-price-{{ $data->id }}">{{ $data->amount }}</span></h5>
                                                                                                    <span class="text-muted fs-12">
                                                                                                        Lots: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="sell-quantity-display-{{ $data->id }}">{{ $data->quantity }} Units</span>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div> 
                                                                                        </div>
                                                                                        <div class="text-end" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                                                                            <div class="px-3 py-4">
                                                                                                <span class="d-block mb-1 fs-12 text-muted">Stock Price</span>
                                                                                                <h5 class="fw-bold fs-24 mb-1">${{ number_format($stock->price, 2) }}</h5>
                                                                                                <span class="fs-12 text-muted">
                                                                                                    Today 
                                                                                                    <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-14 fw-bold ms-1 d-inline-block">
                                                                                                        <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                                                                        {{ number_format($stock->changes_percentage, 2) }}%
                                                                                                    </span>
                                                                                                </span>
                                                                                            </div> 
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- Form for Stock Sale -->
                                                                    <form action="{{ route('trade.crypto') }}" method="post">
                                                                        @csrf
                                                                        <div class="row">
                                                                            <div class="col-6 text-center">
                                                                                <label class="text-muted fs-12" for="sell-quantity-input-{{ $data->id }}">Lots</label>
                                                                                <div class="input-group my-1">
                                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                                                                    <input type="number" name="lots" class="form-control text-center sell-quantity-input" id="sell-quantity-input-{{ $data->id }}" placeholder="0.00" aria-label="Stock Quantity" data-key="{{ $data->id }}" data-price="{{ $stock->price }}" min="0.0001" max="{{ $data->quantity }}" value="{{ $data->quantity }}" step="0.0001" required >
                                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-increment-btn" style="border-radius: 0px 5px 5px 0px;">+</button>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-6 text-center">
                                                                                <label class="text-muted fs-12" for="sell-amount-input-{{ $data->id }}">Amount</label>
                                                                                <div class="input-group my-1">
                                                                                    <button type="button" class="input-group-text btn btn-primary-light btn-wave" style="border-radius: 5px 0px 0px 5px;">$</button>
                                                                                    <input type="number" name="amountX" class="form-control text-center sell-amount-input" id="sell-amount-input-{{ $data->id }}" placeholder="0.00" aria-label="Stock Amount" value="{{ $data->amount }}" data-key="{{ $data->id }}" data-price="{{ $stock->price }}" min="0.00" max="{{ $data->amount }}" step="0.0001" required>
                                                                                    <!-- Optional button for amount -->
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Hidden Inputs -->
                                                                        <div>
                                                                            <input type="hidden" name="crypto_id" value="{{ $stock->id }}">
                                                                            <input type="hidden" name="crypto_symbol" value="{{ $stock->symbol }}">
                                                                            <input type="hidden" name="amount" value="{{ $stock->price }}">
                                                                            <input type="hidden" name="trans_id" value="{{ $data->id }}">
                                                                            <input type="hidden" name="type" value="sell">
                                                                        </div>

                                                                        <!-- Submit Button -->
                                                                        <button class="my-1 btn btn-wave btn-md btn-danger waves-effect waves-light w-100" type="submit">
                                                                            SELL NOW <i class="ri-arrow-right-line align-middle"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
                            <a href="{{ route('crypto.assets') }}" class="btn btn-primary-transparent"> <i class="fe fe-arrow-left me-2 align-middle d-inline-block"></i> Back to Assets</a>
                        </div>
                        <div class="">
                            <form action="{{ route('asset.close.all', $trade->id) }}" method="post">
                                @csrf
                                <button type="submit" class="btn bg-danger-transparent text-danger btn-wave waves-effect waves-light">
                                    Sell All
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<div class="modal fade" id="exampleModalSell" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height: 100%; max-width: 650px !important;">
            <div class="modal-body p-2" style="height: 100%;">
                <div class="">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="flex-grow-1 my-1">
                            <div class="card custom-card overflow-hidden">
                                <div class="d-flex justify-content-between">
                                    <div style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                        <div class="px-3 py-4">
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Sale</span>
                                                <h5 class="fw-bold fs-24 mb-1">$<span id="sell-wallet-price-{{ $stock->id }}">0.00</span></h5>
                                                <span class="text-muted fs-12">
                                                    Quantity: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="sell-quantity-display-{{ $stock->id }}">0.00 Units</span>
                                                </span>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="text-end" style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                        <div class="px-3 py-4">
                                            <span class="d-block mb-1 fs-12 text-muted">Stock Price</span>
                                            <h5 class="fw-bold fs-24 mb-1">${{ number_format($stock->price, 2) }}</h5>
                                            <span class="fs-12 text-muted">
                                                Today 
                                                <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-14 fw-bold ms-1 d-inline-block">
                                                    <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                    {{ number_format($stock->changes_percentage, 2) }}%
                                                </span>
                                            </span>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form for Stock Sale -->
                <form action="{{ route('trade.crypto') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 text-center">
                            <label class="text-muted fs-12" for="sell-quantity-input-{{ $stock->id }}">Quantity</label>
                            <div class="input-group my-1">
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                <input type="number" name="quantity" class="form-control text-center sell-quantity-input" id="sell-quantity-input-{{ $stock->id }}" placeholder="0.00" aria-label="Stock Quantity" value="0.0000" data-key="{{ $stock->id }}" data-price="{{ $stock->price }}" min="0.0001" step="0.0001" required>
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave sell-increment-btn" style="border-radius: 0px 5px 5px 0px;">+</button>
                            </div>
                        </div>

                        <div class="col-6 text-center">
                            <label class="text-muted fs-12" for="sell-amount-input-{{ $stock->id }}">Amount</label>
                            <div class="input-group my-1">
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave" style="border-radius: 5px 0px 0px 5px;">$</button>
                                <input type="number" name="amountX" class="form-control text-center sell-amount-input" id="sell-amount-input-{{ $stock->id }}" placeholder="0.00" aria-label="Stock Amount" value="0.00" data-key="{{ $stock->id }}" data-price="{{ $stock->price }}" min="0.00" step="0.0001" required>
                                <!-- Optional button for amount -->
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Inputs -->
                    <div>
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                        <input type="hidden" name="amount" value="{{ $stock->price }}">
                        <input type="hidden" name="type" value="sell">
                    </div>

                    <!-- Submit Button -->
                    <button class="my-1 btn btn-wave btn-md btn-danger waves-effect waves-light w-100" type="submit">
                        SELL NOW <i class="ri-arrow-right-line align-middle"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End::app-content -->
@endsection

@section('scripts')

<script>
$(document).ready(function() {
    // Function to update wallet price and quantity display for sell trade
    function updateSellWalletPriceAndQuantity(key) {
        const $quantityInput = $('#sell-quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0; // Default to 0 if empty
        const totalPrice = pricePerUnit * quantity;

        $('#sell-wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }));
        $('#sell-quantity-display-' + key).text(`${parseFloat(quantity).toFixed(4)} Unit${quantity <= 1 ? 's' : ''}`);
    }

    function updateAmountInput(key) {
        const $quantityInput = $('#sell-quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0;
        const totalPrice = pricePerUnit * quantity;

        $('#sell-amount-input-' + key).val(parseFloat(totalPrice.toFixed(4)));
    }

    // Function to update quantity based on amount for sell trade
    function updateSellQuantityFromAmount(key) {
        const $amountInput = $('#sell-amount-input-' + key);
        const pricePerUnit = parseFloat($amountInput.data('price'));
        const amount = parseFloat($amountInput.val()) || 0; // Default to 0 if empty
        const quantity = amount / pricePerUnit;

        $('#sell-quantity-input-' + key).val(quantity.toFixed(4));
        updateSellWalletPriceAndQuantity(key);
    }

    // Handle input change for amount in sell trade
    $('.sell-amount-input').on('input', function() {
        const key = $(this).data('key');
        const maxAmount = parseFloat($(this).attr('max'));

        if (parseFloat($(this).val()) > maxAmount) {
            $(this).val(maxAmount.toFixed(4)); // Ensure the value doesn't exceed the max
        }
        updateSellQuantityFromAmount(key);
    });

    // Handle input change for quantity manually in sell trade
    $('.sell-quantity-input').on('input', function() {
        const key = $(this).data('key');
        const maxLots = parseFloat($(this).attr('max'));

        if (parseFloat($(this).val()) > maxLots) {
            $(this).val(maxLots.toFixed(4)); // Ensure the value doesn't exceed the max
        }
        updateSellWalletPriceAndQuantity(key);
        updateAmountInput(key);
    });

    // Handle increment button click for quantity in sell trade
    $('.sell-increment-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const maxLots = parseFloat($quantityInput.attr('max')); // Max lots
        const newValue = Math.min(currentValue + step, maxLots).toFixed(4); // Ensure the increment does not exceed max

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');

        updateSellWalletPriceAndQuantity(key);
        updateAmountInput(key);
    });

    // Handle decrement button click for quantity in sell trade
    $('.sell-decrement-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const minValue = parseFloat($quantityInput.attr('min')) || 0; // Minimum value is 0
        let newValue = Math.max(currentValue - step, minValue).toFixed(4); // Ensure the decrement does not go below min

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');
        updateSellWalletPriceAndQuantity(key);
        updateAmountInput(key);
    });
});


</script>
<script src="{{ asset('asset/libs/apexcharts/apexcharts.min.js') }}"></script>

@endsection