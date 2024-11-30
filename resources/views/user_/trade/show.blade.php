@extends('layouts.user.index')

@section('styles')
<!-- Add custom styles if necessary -->
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

        <!-- TradingView Widget BEGIN -->
        <div class="tradingview-widget-container mb-2 mt-2">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-info.js" async>
            {
                "symbol": "{{ $stock->symbol }}",
                "width": "100%",
                "locale": "en",
                "colorTheme": "light",
                "isTransparent": false
            }
            </script>
        </div>
        <!-- TradingView Widget END -->

        <div class="card custom-card p-3">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <p class="fw-medium text-muted mb-1">Amount: </p>
                    <p class="fs-15 mb-1 fw-bold">${{ number_format($amount, 2) }}</p>
                </div>
                <div class="col-lg-3 col-6">
                    <p class="fw-medium text-muted mb-1">Quantity: </p>
                    <p class="fs-15 mb-1 fw-bold">${{ number_format($quantity, 3) }}</p>
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
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-12 mb-4">
                <!-- TradingView Widget BEGIN -->
                <div class="tradingview-widget-container">
                    <div class="tradingview-widget-container__widget"></div>
                    <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-overview.js" async>
                        {
                            "symbols": [
                                ["{{ $stock->name }}", "{{ $stock->symbol }}|1M"]
                            ],
                            "chartOnly": true,
                            "width": "100%",
                            "height": "500",
                            "locale": "en",
                            "colorTheme": "light",
                            "autosize": false,
                            "showVolume": false,
                            "showMA": false,
                            "hideDateRanges": false,
                            "hideMarketStatus": false,
                            "hideSymbolLogo": false,
                            "scalePosition": "right",
                            "scaleMode": "Normal",
                            "fontFamily": "-apple-system, BlinkMacSystemFont, Trebuchet MS, Roboto, Ubuntu, sans-serif",
                            "fontSize": "10",
                            "noTimeScale": false,
                            "valuesTracking": "2",
                            "changeMode": "price-and-percent",
                            "chartType": "area",
                            "maLineColor": "#2962FF",
                            "maLineWidth": 1,
                            "maLength": 9,
                            "headerFontSize": "medium",
                            "lineWidth": 2,
                            "lineType": 0,
                            "dateRanges": ["1d|1", "1m|30", "3m|60", "12m|1D", "60m|1W", "all|1M"]
                        }
                    </script>
                </div>
                <!-- TradingView Widget END -->
            </div>

            <div class="col-lg-4 col-md-12">
                <div>
                    <div class="card custom-card px-4 py-2">
                        <div class="row">
                            {{-- <div class="input-group mb-3">
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 20px 0 0 20px;">&lt;</button>
                                <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input" id="quantity-input" placeholder="Enter Quantity..." aria-label="Stock Quantity" value="0.001" min="0.001" data-price="{{ $stock->price }}" required>
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0 20px 20px 0;">&gt;</button>
                            </div> --}}
                            <div class="col-6">
                                <button class="btn btn-wave btn-md btn-success w-100" data-bs-toggle="modal" data-bs-target="#exampleModalBuy" type="submit">
                                    BUY <i class="ri-arrow-right-line align-middle"></i>
                                </button>
                            </div>
                            <div class="col-6">
                                <button class="btn btn-wave btn-md btn-danger w-100" data-bs-toggle="modal" data-bs-target="#exampleModalSell" type="submit">
                                    SELL <i class="ri-arrow-right-line align-middle"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- TradingView Financials Widget BEGIN -->
                    <div class="tradingview-widget-container">
                        <div class="tradingview-widget-container__widget"></div>
                        <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-financials.js" async>
                        {
                            "symbol": "{{ $stock->symbol }}",
                            "width": "100%",
                            "height": "400",
                            "colorTheme": "light",
                            "locale": "en"
                        }
                        </script>
                    </div>
                    <!-- TradingView Financials Widget END -->

                </div>
            </div>
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
                                    ${{ number_format($data->price, 2) }}
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
                        @if($asset->count() <=0)
                            <div class="bg-white p-4">
                                <p class="text-center">No Trade</p>
                            </td>
                        @endif
            </div>
        </div>
    </div>
</div>
<!-- End::app-content -->

<div class="modal fade" id="exampleModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height: 100%; max-width: 650px !important;">
            <div class="modal-body p-2" style="height: 100%;">
                    <!-- <div class="btn-list float-end py-2">
                        <a href="javascript:void(0);" class="avatar avatar-rounded bg-light text-default avatar-sm" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add to Wishlist" data-bs-original-title="Add to Wishlist"><span><i class="bi bi-heart"></i></span></a>
                    </div> -->
                    <div class="btn-list float-end py-2">
                        <a href="javascript:void(0);"
                        class="avatar avatar-rounded bg-primary text-white avatar-sm watchlist-toggle"
                        data-type="stocks"
                        data-id="{{$stock->id}}"
                        aria-label="Add to Wishlist"
                        data-bs-toggle="tooltip"
                        data-bs-placement="top">
                            <span><i class="bi bi-heart"></i></span>
                        </a>
                    </div>

                    <div class="d-flex align-items-center flex-wrap gap-2">
                        <span class="avatar avatar-lg bg-white  border p-2 avatar-rounded">
                            <img src="{{ $stock->img }}" alt="">
                        </span>
                        <div class="ms-2">
                            <h5 class="fw-medium mb-2 d-flex align-items-center"><a href="javascript:void(0);">{{ $stock->name }}  <i class="bi bi-check-circle-fill text-success fs-16" data-bs-toggle="tooltip" aria-label="Verified company" data-bs-original-title="Verified company"></i></a></h5>
                            <div class="d-flex gap-2 mb-1">
                                <p class="mb-0 text-muted">{{ $stock->symbol }} </p>
                            </div>
                        </div>
                    </div>
                <!-- <div id="tradingview-widget-{{ $stock->id }}" style="height: 55%;"></div> -->
                <div class="">
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="flex-grow-1 my-1">
                            <div class="card custom-card overflow-hidden">
                                <div class="d-flex justify-content-between">
                                    <div style="border-radius: 10px; padding: 0px !important; margin: 0px !important;">
                                        <div class="px-3 py-4">
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Purchase</span>
                                                <h5 class="fw-bold fs-24 mb-1">$<span id="wallet-price-{{ $stock->id }}">0.00</span></h5>
                                                <span class="text-muted fs-12">
                                                    Quantity: <span class="text-primary fs-15 fw-bold ms-1 d-inline-block" id="quantity-display-{{ $stock->id }}">0.00 Units</span>
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

                <!-- Form for Stock Purchase -->
                <form action="{{ route('trade.stock') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-6 text-center">
                            <label class="text-muted fs-12" for="quantity-input-{{ $stock->id }}">Quantity</label>
                            <div class="input-group my-1">
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn" style="border-radius: 5px 0px 0px 5px;">-</button>
                                <input type="number" name="quantity" class="form-control text-center quantity-input" id="quantity-input-{{ $stock->id }}" placeholder="0.00" aria-label="Stock Quantity" value="0.0000" data-key="{{ $stock->id }}" data-price="{{ $stock->price }}" min="0.0001" step="0.0001" required>
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn" style="border-radius: 0px 5px 5px 0px;">+</button>
                            </div>
                        </div>

                        <div class="col-6 text-center">
                            <label class="text-muted fs-12" for="amount-input-{{ $stock->id }}">Amount</label>
                            <div class="input-group my-1">
                                <button type="button" class="input-group-text btn btn-primary-light btn-wave" style="border-radius: 5px 0px 0px 5px;">$</button>
                                <input type="number" name="amountX" class="form-control text-center amount-input" id="amount-input-{{ $stock->id }}" placeholder="0.0000" aria-label="Stock Amount" value="0.00" data-key="{{ $stock->id }}" data-price="{{ $stock->price }}" min="0.0000" step="0.0001" required>
                                <!-- Optional button for amount -->
                            </div>
                        </div>
                    </div>

                    <!-- Hidden Inputs -->
                    <div>
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                        <input type="hidden" name="amount" value="{{ $stock->price }}">
                        <input type="hidden" name="type" value="buy">
                    </div>

                    <!-- Submit Button -->
                    <button class="my-1 btn btn-wave btn-md btn-success waves-effect waves-light w-100" type="submit">
                        BUY NOW <i class="ri-arrow-right-line align-middle"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="exampleModalSell" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="height: 100%; max-width: 650px !important;">
            <div class="modal-body p-2" style="height: 100%;">
                <!-- <div class="btn-list float-end py-2">
                    <a href="javascript:void(0);" class="avatar avatar-rounded bg-light text-default avatar-sm" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add to Wishlist" data-bs-original-title="Add to Wishlist"><span><i class="bi bi-heart"></i></span></a>
                </div> -->
                <div class="btn-list float-end py-2">
                    <a href="javascript:void(0);"
                    class="avatar avatar-rounded bg-primary text-white avatar-sm watchlist-toggle"
                    data-type="stocks"
                    data-id="{{$stock->id}}"
                    aria-label="Add to Wishlist"
                    data-bs-toggle="tooltip"
                    data-bs-placement="top">
                        <span><i class="bi bi-heart"></i></span>
                    </a>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-2">
                    <span class="avatar avatar-lg bg-white  border p-2 avatar-rounded">
                        <img src="{{ $stock->img }}" alt="">
                    </span>
                    <div class="ms-2">
                        <h5 class="fw-medium mb-2 d-flex align-items-center"><a href="javascript:void(0);">{{ $stock->name }}  <i class="bi bi-check-circle-fill text-success fs-16" data-bs-toggle="tooltip" aria-label="Verified company" data-bs-original-title="Verified company"></i></a></h5>
                        <div class="d-flex gap-2 mb-1">
                            <p class="mb-0 text-muted">{{ $stock->symbol }} </p>
                        </div>
                    </div>
                </div>
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
                <form action="{{ route('trade.stock') }}" method="post">
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

@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('.watchlist-toggle').on('click', function() {
        var icon = $(this); // Store the icon element
        var type = icon.data('type'); // Get the type (crypto or stocks)
        var dataId = icon.data('id'); // Get the data ID (e.g., 123)
        
        // Send AJAX request to store the watchlist
        $.ajax({
            url: '/watchlist', // Replace with your actual route URL
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // CSRF token for security
                type: type,
                data_id: dataId
            },
            success: function(response) {
                // Handle the response based on status
                if (response.status === 'added') {
                    icon.addClass('bg-success'); // Change icon to indicate it's added
                    icon.find('i').removeClass('bi-heart').addClass('bi-heart-fill'); // Change icon to filled heart
                } else if (response.status === 'removed') {
                    icon.removeClass('bg-success'); // Remove the added state
                    icon.find('i').removeClass('bi-heart-fill').addClass('bi-heart'); // Change icon to empty heart
                }
                alert(response.message); // Show message
            },
            error: function(xhr, status, error) {
                alert('Something went wrong, please try again.');
            }
        });
    });
});
</script>

<!-- Add custom scripts if necessary -->
<script>
$(document).ready(function() {
    // Function to update wallet price and quantity display
    function updateWalletPriceAndQuantity(key) {
        const $quantityInput = $('#quantity-input-' + key);
        const pricePerUnit = parseFloat($quantityInput.data('price'));
        const quantity = parseFloat($quantityInput.val()) || 0; // Default to 0 if empty
        const totalPrice = pricePerUnit * quantity;

        $('#wallet-price-' + key).text(totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 4 }));
        $('#quantity-display-' + key).text(`${parseFloat(quantity).toFixed(4)} Unit${quantity <= 1 ? 's' : ''}`);
    }

    // Function to update quantity based on amount
    function updateQuantityFromAmount(key) {
        const $amountInput = $('#amount-input-' + key);
        const pricePerUnit = parseFloat($amountInput.data('price'));
        const amount = parseFloat($amountInput.val()) || 0; // Default to 0 if empty
        const quantity = amount / pricePerUnit;

        $('#quantity-input-' + key).val(quantity.toFixed(4));
        updateWalletPriceAndQuantity(key);
    }

    // Handle input change for amount
    $('.amount-input').on('input', function() {
        const key = $(this).data('key');
        updateQuantityFromAmount(key);
    });

    // Handle input change for quantity manually
    $('.quantity-input').on('input', function() {
        const key = $(this).data('key');
        updateWalletPriceAndQuantity(key);
    });

    // Handle increment button click for quantity
    $('.increment-btn').click(function() {
        const $quantityInput = $(this).siblings('.quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const newValue = (currentValue + step).toFixed(4); // Ensure 4 decimal places

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');
        updateWalletPriceAndQuantity(key);
        // Also update the amount field based on the new quantity
        updateWalletPriceAndQuantity(key); // Update amount
    });

    // Handle decrement button click for quantity
    $('.decrement-btn').click(function() {
        const $quantityInput = $(this).siblings('.quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const minValue = parseFloat($quantityInput.attr('min')) || 0; // Minimum value is 0
        let newValue = (currentValue - step).toFixed(4);

        if (newValue >= minValue) {
            $quantityInput.val(newValue);
            const key = $quantityInput.data('key');
            updateWalletPriceAndQuantity(key);
            // Also update the amount field based on the new quantity
            updateWalletPriceAndQuantity(key); // Update amount
        }
    });
});

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
        updateSellQuantityFromAmount(key);
    });

    // Handle input change for quantity manually in sell trade
    $('.sell-quantity-input').on('input', function() {
        const key = $(this).data('key');
        updateSellWalletPriceAndQuantity(key);
    });

    // Handle increment button click for quantity in sell trade
    $('.sell-increment-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const newValue = (currentValue + step).toFixed(4); // Ensure 4 decimal places

        $quantityInput.val(newValue);
        const key = $quantityInput.data('key');
        updateSellWalletPriceAndQuantity(key);
        // Also update the amount field based on the new quantity
        updateSellWalletPriceAndQuantity(key); // Update amount
    });

    // Handle decrement button click for quantity in sell trade
    $('.sell-decrement-btn').click(function() {
        const $quantityInput = $(this).siblings('.sell-quantity-input');
        const step = parseFloat($quantityInput.attr('step')) || 0.0001; // Default step is 0.0001 for more precision
        const currentValue = parseFloat($quantityInput.val()) || 0;
        const minValue = parseFloat($quantityInput.attr('min')) || 0; // Minimum value is 0
        let newValue = (currentValue - step).toFixed(4);

        if (newValue >= minValue) {
            $quantityInput.val(newValue);
            const key = $quantityInput.data('key');
            updateSellWalletPriceAndQuantity(key);
            // Also update the amount field based on the new quantity
            updateSellWalletPriceAndQuantity(key); // Update amount
        }
    });
});

</script>

@endsection
