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
        <div class="tradingview-widget-container mb-4">
            <div class="tradingview-widget-container__widget"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-symbol-info.js" async>
            {
                "symbol": "{{ $stock->symbol }}",
                "width": "100%",
                "locale": "en",
                "colorTheme": "light",
                "isTransparent": true
            }
            </script>
        </div>
        <!-- TradingView Widget END -->

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

                    <!-- TradingView Financials Widget BEGIN -->
                    <div class="tradingview-widget-container mt-4">
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
    </div>
</div>
<!-- End::app-content -->

<div class="modal fade" id="exampleModalBuy" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="max-width: 600px; overflow-x: hidden;">
            <div class="modal-body p-2" style="height: 100%;">
                <!-- Modal Content -->
                <div class="">
                    <div class="btn-list float-end py-2">
                        <a href="javascript:void(0);" class="avatar avatar-rounded bg-light text-default avatar-sm" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add to Wishlist" data-bs-original-title="Add to Wishlist"><span><i class="bi bi-heart"></i></span></a>
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
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="flex-grow-1 my-1">
                            <div class="row">
                                <!-- Market Price Card -->
                                <div class="col-6">
                                    <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px; margin: 0px;">
                                        <div class="card-body p-3 d-flex gap-2">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary svg-white">
                                                    <i class="ti ti-school fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Market Price</span>
                                                <h5 class="fw-semibold mb-1">${{ number_format($stock->price, 2) }}</h5>
                                                <span class="fs-12">
                                                    Today 
                                                    <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                        <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                        {{ number_format($stock->changes_percentage, 2) }}%
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity Card -->
                                <div class="col-6">
                                    <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px; margin: 0px;">
                                        <div class="card-body p-3 d-flex gap-2">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary svg-white">
                                                    <i class="ti ti-school fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Quantity</span>
                                                <h5 class="fw-semibold mb-1">$<span id="wallet-price-buy">{{ number_format($stock->price * 0.001, 2) }}</span></h5>
                                                <span class="fs-12">
                                                    Quantity <span class="text-primary fs-10 fw-bold ms-1 d-inline-block" id="quantity-display-buy">0.001 Unit</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Buy Stock Form -->
                <form action="{{ route('trade.stock') }}" method="post">
                    @csrf
                    <div class="input-group my-1">
                        <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn-buy" style="border-radius: 20px 0px 0px 20px;">&lt;</button>
                        <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input-buy" id="quantity-input-buy" placeholder="Enter Quantity..." aria-label="Stock Quantity" value="0.001" min="0.001" data-price="{{ $stock->price }}" required>
                        <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn-buy" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                    </div>
                    <div>
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                        <input type="hidden" name="amount" value="{{ $stock->price }}">
                        <input type="hidden" name="type" value="buy">
                    </div>
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
        <div class="modal-content" style="max-width: 600px; overflow-x: hidden;">
            <div class="modal-body p-2" style="height: 100%;">
                <!-- Modal Content -->
                <div class="">
                    <div class="btn-list float-end py-2">
                        <a href="javascript:void(0);" class="avatar avatar-rounded bg-light text-default avatar-sm" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Add to Wishlist" data-bs-original-title="Add to Wishlist"><span><i class="bi bi-heart"></i></span></a>
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
                    <div class="d-flex align-items-center flex-wrap gap-3">
                        <div class="flex-grow-1 my-1">
                            <div class="row">
                                <!-- Market Price Card -->
                                <div class="col-6">
                                    <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px; margin: 0px;">
                                        <div class="card-body p-3 d-flex gap-2">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary svg-white">
                                                    <i class="ti ti-school fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Market Price</span>
                                                <h5 class="fw-semibold mb-1">${{ number_format($stock->price, 2) }}</h5>
                                                <span class="fs-12">
                                                    Today 
                                                    <span class="{{ $stock->changes_percentage < 0 ? 'text-danger' : 'text-success' }} fs-10 fw-medium ms-1 d-inline-block">
                                                        <i class="{{ $stock->changes_percentage < 0 ? 'ri-arrow-down-line' : 'ri-arrow-up-line' }} me-1"></i>
                                                        {{ number_format($stock->changes_percentage, 2) }}%
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Quantity Card -->
                                <div class="col-6">
                                    <div class="card custom-card overflow-hidden" style="border-radius: 10px; padding: 0px; margin: 0px;">
                                        <div class="card-body p-3 d-flex gap-2">
                                            <div>
                                                <span class="avatar avatar-sm bg-primary svg-white">
                                                    <i class="ti ti-school fs-18"></i>
                                                </span>
                                            </div>
                                            <div>
                                                <span class="d-block mb-1 fs-12 text-muted">Quantity</span>
                                                <h5 class="fw-semibold mb-1">$<span id="wallet-price-sell">{{ number_format($stock->price * 0.001, 2) }}</span></h5>
                                                <span class="fs-12">
                                                    Quantity <span class="text-primary fs-10 fw-bold ms-1 d-inline-block" id="quantity-display-sell">0.001 Unit</span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Sell Stock Form -->
                <form action="{{ route('trade.stock') }}" method="post">
                    @csrf
                    <div class="input-group my-1">
                        <button type="button" class="input-group-text btn btn-primary-light btn-wave decrement-btn-sell" style="border-radius: 20px 0px 0px 20px;">&lt;</button>
                        <input type="number" name="quantity" step="0.001" class="form-control text-center quantity-input-sell" id="quantity-input-sell" placeholder="Enter Quantity..." aria-label="Stock Quantity" value="0.001" min="0.001" data-price="{{ $stock->price }}" required>
                        <button type="button" class="input-group-text btn btn-primary-light btn-wave increment-btn-sell" style="border-radius: 0px 20px 20px 0px;">&gt;</button>
                    </div>
                    <div>
                        <input type="hidden" name="stock_id" value="{{ $stock->id }}">
                        <input type="hidden" name="stock_symbol" value="{{ $stock->symbol }}">
                        <input type="hidden" name="amount" value="{{ $stock->price }}">
                        <input type="hidden" name="type" value="sell">
                    </div>
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
<!-- Add custom scripts if necessary -->
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
        $input.val((currentValue + step).toFixed(3));
        updateWalletPrice(modalType);
    });

    // Handle decrement button click
    $('.decrement-btn-buy, .decrement-btn-sell').click(function() {
        const modalType = $(this).hasClass('decrement-btn-buy') ? 'buy' : 'sell';
        let $input = $(`#quantity-input-${modalType}`);
        let step = parseFloat($input.attr('step')) || 0.001;
        let currentValue = parseFloat($input.val()) || 0.001;
        let minValue = parseFloat($input.attr('min')) || 0.001;
        let newValue = (currentValue - step).toFixed(3);
        if (newValue >= minValue) {
            $input.val(newValue);
            updateWalletPrice(modalType);
        }
    });
});

</script>

@endsection
