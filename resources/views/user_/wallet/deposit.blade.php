@extends('layouts.user.index')

@section('styles')

<!-- Prism CSS -->
<link rel="stylesheet" href="{{ asset('asset/libs/prismjs/themes/prism-coy.min.css') }}">

<link rel="stylesheet" href="{{ asset('asset/libs/filepond/filepond.min.css') }}">

<link rel="stylesheet" href="{{ asset('asset/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/libs/dropzone/dropzone.css') }}">

@endsection

@section('content')

<style>
    select {
        appearance: auto !important;
        -webkit-appearance: auto;
        -moz-appearance: auto;
    }
    select:focus {
        appearance: none;
    }

    .selectdepo:hover {
        border: 1px solid rgb(130, 116, 255);
        cursor: pointer;
    }

    .selectdepo .active {
        border: 1px solid rgb(130, 116, 255);
    }
</style>

<div class="main-content app-content">
    <div class="container-fluid">

    @include('partials.users.alert')

        <div class="card mt-4 mx-auto" style="max-width: 800px;">
            <form method="POST" action="{{ route('deposit') }}" id="depositForm">
                @csrf
                <input type="hidden" name="logic" value="deposit">
                <div class="my-4">
                    <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Make a Deposit</h5>
                </div>
                <div class="modal-body">
                    <div class="row mx-auto" id="depoSelect" style="max-width: 600px;">
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo" id="selectCrypto">
                                <div class="card-body d-flex align-items-center rounded">
                                    <span class="avatar avatar-sm bg-primary me-2 shadow-avatar">
                                        <img class="p-1" src="https://cryptologos.cc/logos/centrifuge-cfg-logo.png" alt="">
                                    </span>
                                    <h5 class="fw-medium fs-13 mt-2 mx-2"> 
                                        Cryptocurrency
                                    </h5>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo" id="selectBank">
                                <div class="card-body d-flex align-items-center rounded">
                                    <span class="avatar avatar-sm bg-primary me-2 shadow-avatar">
                                        <img class="p-1" src="https://pngimg.com/d/bank_PNG24.png" alt="">
                                    </span>
                                    <h5 class="fw-medium fs-13 mt-2 mx-2"> 
                                        Bank
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="crypto" class="d-none">
                        <input type="hidden" id="crypto-method" name="method" value="coin">
                        <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                            <div class="col-xl-6">
                                <label class="form-label" for="coin-select">Select Coin</label>
                                <div class="input-group"> 
                                    <button type="button" class="input-group-text btn btn-white btn-wave text-dark fs-12 fw-bold" style="border-right: 0px;">
                                        <img id="coin-img" width="23" class="rounded-circle" style="border-left: 0px; opacity: .3;" src="https://cdn4.iconfinder.com/data/icons/cryptocoins/227/USDT-alt-512.png" alt="USDT">
                                    </button>
                                    <select name="coin" id="coin-select" class="form-control py-2">
                                        <option value="usdt">USDT</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <label class="form-label" for="network-select">Choose Network</label>
                                <div class="input-group"> 
                                    <select name="network" id="network-select" class="form-control py-2">
                                        <option value="">Select Network</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xl-12 my-2">
                                <div class="input-group"> 
                                    <input type="number" value="{{ old('amount') }}" style="font-size: 14px; font-weight: 800;" step="any" class="form-control text-center amountDeposit" name="amount" id="crypto-amount" placeholder="Amount">
                                    <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                    <input type="hidden" name="coinvalue" id="coin-value">
                                </div>
                                @error('amount')
                                    <strong class="small text-danger">
                                        {{ $message }}
                                    </strong>
                                @enderror
                            </div>
                        </div>

                        <div class="my-1">
                            <h4 class="text-center fs-13">You are about to make a deposit of <strong class="fw-bold text-primary amount-val">0 BTC</strong></h4>
                            <p class="text-center text-muted fs-10">Exchange Rate: 1 <strong id="selected-coin-symbol"></strong>  - <span id="exchange-rate">0</span> USD</p>
                        </div>
                        <div>
                            <div class="my-4">
                                <p class="text-center fs-12 fw-medium">Carefully follow the procedures below for successful investment.</p>
                                <div class="d-flex justify-content-center mx-auto my-2">
                                    <img width="130" height="130" src="https://upload.wikimedia.org/wikipedia/commons/5/5e/QR_Code_example.png" alt="...">
                                </div>
                                <p class="text-center fs-12 fw-medium">Scan the QR code above or copy and pay to this <span class="text-primary fw-bold">CRESTWOOD</span> address below:</p>
                            </div>

                            <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                                <div class="col-xl-12">
                                    <div class="input-group">
                                        <button type="button" class="input-group-text btn btn-light-light btn-wave"><i class="ri-link me-2"></i></button>
                                        <input type="text" id="address-display" name="address-display" class="form-control text-center" placeholder="Enter Method..." aria-label="Stock Quantity" value="-------" disabled>
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="account_type" value="wallet">

                            <div id="" class="alert mx-auto alert-primary mt-2" style="max-width: 600px;">
                                <h4 class="text-danger fs-13">Note</h4>
                                <div class="">
                                    <p class="fs-12 text-muted">{{ $setting->crypto_note }}</p>
                                </div>
                            </div>
                            <p class="text-dark fs-13 text-center fw-medium">Already made payment of <span class="fw-bold text-primary amount-val">100USD</span> to the wallet address above® <br> Click the button below to confirm transaction.</p>
                        </div>
                    </div>
                    <div id="bank" class="d-none">
                        <input type="hidden" id="bank-method" name="method" value="bank">
                        <div class="" id="screen-one">
                            <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                                <div class="col-xl-12">
                                    <!-- <label for="amountDeposit" class="form-label">Deposit Amount</label> -->
                                    <div class="input-group"> 
                                        <input type="number" style="font-size: 14px; font-weight: 800;" step="any" class="form-control amountDeposit text-center" name="amount" id="bank-amount" placeholder="Amount">
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                    </div>
                                    @error('amount')
                                        <strong class="small text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="my-4">
                                <h4 class="text-center fs-13">You are about to make a deposit of <strong class="fw-bold text-primary amount-val-bank">0 USD</strong></h4>
                                <p class="text-center text-muted fs-10">Exchange Rate: 1 USD - 1.00 USD</strong></p>
                            </div>
                            <div class="">
                                <div class="my-2">
                                    <p class="text-center fs-12 fw-medium">You are making a deposit into the following account detail</p>
                                </div>
                                <div class="row d-flex justify-content-center mx-auto">
                                    <div class="col-xl-12" style="max-width: 500px;">
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Bank Adddress</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_address }}" disabled>
                                            <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Phone Number</button>
                                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_phone }}" disabled>
                                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Country</button>
                                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_country }}" disabled>
                                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">State</button>
                                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_state }}" disabled>
                                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Address</button>
                                                    <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_address_address }}" disabled>
                                                    <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Reference</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_reference }}" disabled>
                                            <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                        </div>
                                    </div>
                                    <div style="max-width: 550px;">
                                        <div id="" class="alert mx-3 alert-primary mt-2">
                                            <h4 class="text-danger fs-12 fw-bold">Please Note</h4>
                                            <div class="">
                                                    <p class="fs-12 text-muted">{{ $setting->bank_note_initial }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-auto my-4" style="max-width: 400px;">
                                        <button type="button"  class="btn btn-success-transparent" style="width: 100%;" >Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="screen-two">
                            <div class="mx-auto" style="max-width: 600px;">
                                <div class="col-xl-12">
                                    <div class="card custom-card">
                                        <div class="card-header">
                                            <div class="card-title">
                                               Upload Proof
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <input type="file" class="multiple-filepond" name="filepond" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                                        </div>
                                    </div>
                                </div>
                                <div class="row d-flex justify-content-center mx-auto">
                                    <div class="col-xl-12" style="max-width: 600px;">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Delivering Bank</button>
                                                    <input type="text" name="delivering" class="form-control fw-bold fs-11" placeholder="..." id="delivering">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Swift Code</button>
                                                    <input type="text" name="swift" class="form-control fw-bold fs-11" placeholder="..." id="swift">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button id="" type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Account Number</button>
                                                    <input type="text" name="account" class="form-control fw-bold fs-11" placeholder="..." id="account">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-group my-1">
                                                    <button type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Initiated time</button>
                                                    <input type="time" name="time" class="form-control fw-bold fs-11" placeholder="...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-auto my-4" style="max-width: 400px;">
                                        <button type="button"  class="btn btn-success-transparent" style="width: 100%;" >Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="screen-three">
                            <div class="summary">
                                <div>
                                    <h3 class="fs-16 fw-bold text-center my-3">Summary</h3>
                                    <div>
                                        <h4 class="text-center fs-13">You have made a deposit of <strong class="fw-bold text-primary amount-val" id="amount-val-summary">0 USD</strong></h4>
                                        <div class="row d-flex justify-content-center mx-auto">
                                            <div class="col-xl-12" style="max-width: 400px;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group my-1">
                                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Delivering Bank</button>
                                                            <input type="text" name="testr" class="form-control fw-bold fs-11" id="summary-bank" disabled>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="input-group my-1">
                                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-11">Swift Code</button>
                                                            <input type="text" name="test" class="form-control fw-bold fs-11" id="summary-swift" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mx-auto" style="max-width: 400px;">
                                        <div id="" class="alert mx-3 alert-primary mt-2">
                                            <h4 class="text-danger fs-12 fw-bold">Please Note</h4>
                                            <div class="">
                                                    <p class="fs-11 text-muted">{{ $setting->bank_note_final }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mx-auto my-4" style="max-width: 400px;">
                                        <button type="submit"  class="btn btn-primary-transparent" style="width: 100%;" >Confirm Deposit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none" id="depositFooter">
                    <button type="submit"  class="btn btn-primary-transparent" style="width: 100%;" >Confirm Deposit</button>
                </div>
            </form>

            <div class="d-none card-body">
                <form data-single="true" method="post" action="https://httpbin.org/post" class="dropzone"></form>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function () {
        // Fetch coins on page load
        fetchCoins();

        // Variables to hold selected coin rate and symbol
        let selectedCoinRate = 0;
        let selectedCoinSymbol = '';

        // Trigger display update on input change for amount
        $('.amountDeposit').on('input', function () {
            updateDisplay();
        });

        $('#bank-amount').on('input', function () {
            const usdAmount = parseFloat($('#bank-amount').val()) || 0;

            $('.amount-val-bank').text(usdAmount.toFixed(2) + ' USD');
        });

        const coinImages = {
            ETH: 'https://images.seeklogo.com/logo-png/52/1/ethereum-logo-png_seeklogo-527153.png',
            BTC: 'https://cryptologos.cc/logos/bitcoin-btc-logo.png',
            TRX: 'https://cdn-icons-png.flaticon.com/512/12114/12114250.png',
            USDT: 'https://seeklogo.com/images/T/tether-usdt-logo-FA55C7F397-seeklogo.com.png'
        };

        // Fetch networks and update display based on coin selection
        $('#coin-select').on('change', function () {
            const coinId = $(this).val();
            if (coinId) {
                fetchNetworks(coinId);

                // Retrieve selected coin data from response
                const coin = coins.find(c => c.id == coinId);
                selectedCoinRate = parseFloat(coin.rate); // Make sure rate is correctly parsed
                selectedCoinSymbol = coin.symbol;

                // Update the exchange rate and symbol display
                $('#exchange-rate').text(selectedCoinRate.toFixed(5)); // Display the rate with 5 decimal places
                $('#selected-coin-symbol').text(selectedCoinSymbol); // Display selected coin symbol
                updateDisplay();
                
                const selectedImg = coinImages[selectedCoinSymbol] || ''; // Get the image for the selected coin
                $('#coin-img').attr('src', selectedImg); // Update the image source
                $('#coin-img').attr('style', 'opacity: 1;'); // Update the image source
            } else {
                // Reset if no coin is selected
                $('#network-select').html('<option value="">Select Network</option>').prop('disabled', true);
                $('#address-display').val('Select network first').prop('disabled', true);
                resetDisplay();
            }
        });

        // Fetch address based on network selection
        $('#network-select').on('change', function () {
            const networkId = $(this).val();
            if (networkId) {
                fetchAddress(networkId);
            } else {
                $('#address-display').val('Select network first').prop('disabled', true);
            }
        });

        // Function to update the display with calculated coin amount
        function updateDisplay() {
            const usdAmount = parseFloat($('.amountDeposit').val()) || 0; // Get entered USD amount
            const coinAmount = usdAmount / selectedCoinRate; // Calculate equivalent coin amount

            if (!isNaN(coinAmount) && selectedCoinRate > 0) {
                // Update displayed amount in selected coin
                $('.amount-val').text(coinAmount.toFixed(5) + ' ' + selectedCoinSymbol);

                $('#coin-value').prop('value', coinAmount.toFixed(5));
            } else {
                // Reset display if invalid input or no coin selected
                $('.amount-val').text('0 ' + selectedCoinSymbol);
            }
        }

        // Function to reset the display if no coin is selected
        function resetDisplay() {
            selectedCoinRate = 0;
            selectedCoinSymbol = '';
            $('#exchange-rate').text(0);
            $('#selected-coin-symbol').text('');
            $('.amount-val').text('0');
        }

        // Function to fetch coins (no change here)
        function fetchCoins() {
            $.ajax({
                url: '/api/deposit/coin',
                type: 'GET',
                success: function (response) {
                    coins = response.data;
                    let options = '<option value="">Select Coin</option>';
                    response.data.forEach(function (coin) {
                        options += `<option value="${coin.id}">${coin.name} (${coin.symbol})</option>`;
                    });
                    $('#coin-select').html(options);
                }
            });
        }

        // Function to fetch networks (no change here)
        function fetchNetworks(coinId) {
            $.ajax({
                url: `/api/deposit/networks/${coinId}`,
                type: 'GET',
                success: function (response) {
                    let options = '<option value="">Select Network</option>';
                    response.data.forEach(function (network) {
                        options += `<option value="${network.id}">${network.name} </option>`;
                    });
                    $('#network-select').html(options).prop('disabled', false);
                    $('#address-display').val('Select network first').prop('disabled', true);
                }
            });
        }

        // Function to fetch address (no change here)
        function fetchAddress(networkId) {
            $.ajax({
                url: `/api/deposit/address/${networkId}`,
                type: 'GET',
                success: function (response) {
                    if(response.data && response.data.address) {
                        $('#address-display').val(response.data.address).prop('disabled', true);
                    } else {
                        $('#address-display').val('Address not available').prop('disabled', true);
                    }
                }
            });
        }
    });

    document.getElementById('selectCrypto').addEventListener('click', function() {
        // Show crypto fields, hide bank fields
        document.getElementById('crypto').classList.remove('d-none');
        document.getElementById('bank').classList.add('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.remove('d-none');
    });

    document.getElementById('selectBank').addEventListener('click', function() {
        // Show bank fields, hide crypto fields
        document.getElementById('crypto').classList.add('d-none');
        document.getElementById('bank').classList.remove('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.add('d-none');
    });

    $(document).ready(function() {
        // Hide both the crypto and bank sections initially
        $('#crypto').hide();
        $('#bank').hide();

        // Handle click event for selecting cryptocurrency
        $('#selectCrypto').click(function() {
            // Show the crypto section and hide the bank section
            $('#crypto').show();
            $('#bank').hide();

            // Enable all input fields inside #crypto
            // $('#crypto').find('input, select').prop('disabled', false);
            $('#crypto-amount').prop('disabled', false);
            $('#crypto-method').prop('disabled', false);

            $('#bank-amount').prop('disabled', true);
            $('#bank-method').prop('disabled', true);

            // Disable all input fields inside #bank
            // $('#bank').find('input, select').prop('disabled', true);

            // Add active state to the selected option
            $('#selectCrypto').addClass('active');
            $('#selectBank').removeClass('active');
        });

        // Handle click event for selecting bank
        $('#selectBank').click(function() {
            // Show the bank section and hide the crypto section
            $('#bank').show();
            $('#crypto').hide();

            $('#crypto-amount').prop('disabled', true);
            $('#crypto-method').prop('disabled', true);

            $('#bank-amount').prop('disabled', false);
            $('#bank-method').prop('disabled', false);

            // Add active state to the selected option
            $('#selectBank').addClass('active');
            $('#selectCrypto').removeClass('active');
        });

        // Function to handle copy to clipboard
        function copyToClipboard(text, button) {
            // Use the modern clipboard API to copy text
            if (navigator.clipboard) {
                navigator.clipboard.writeText(text).then(function() {
                    // Change button text on successful copy
                    $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');

                    // Revert button text after 3 seconds
                    setTimeout(function() {
                        $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
                    }, 3000);
                }).catch(function(error) {
                    console.error('Failed to copy text: ', error);
                });
            } else {
                // Fallback to older execCommand method (for older browsers)
                var tempInput = $("<input>");
                $("body").append(tempInput);
                tempInput.val(text).select();
                document.execCommand("copy");
                tempInput.remove();

                // Change button text on successful copy
                $(button).html('<i class="ri-check-fill text-success me-2"></i> Copied');

                // Revert button text after 3 seconds
                setTimeout(function() {
                    $(button).html('<i class="ri-file-copy-fill text-primary me-2"></i> Copy');
                }, 3000);
            }
        }

        // Attach click event for copy buttons
        $('.copy-btn').on('click', function() {
            // Find the input field next to the button and get its value
            var textToCopy = $(this).closest('.input-group').find('input').val();
            copyToClipboard(textToCopy, this);
        });

        // Initially disable all input fields (just in case)
        // $('#crypto').find('input, select').prop('disabled', true);
        // $('#bank').find('input, select').prop('disabled', true);
    });

    $(document).ready(function() {
        // Default show screen-one, hide others
        $('#screen-one').removeClass('d-none').addClass('d-block');
        $('#screen-two, #screen-three').removeClass('d-block').addClass('d-none');
        
        // Handle "Continue" button click on screen-one
        $('#screen-one .btn-success-transparent').click(function() {
            $('#screen-one').removeClass('d-block').addClass('d-none');
            $('#screen-two').removeClass('d-none').addClass('d-block');
            var amount = $('#bank-amount').val();

             // Update the summary section with the form values
            $('#amount-val-summary').text(amount + " USD");
        });
        
        // Handle "Continue" button click on screen-two
        $('#screen-two .btn-success-transparent').click(function() {
            $('#screen-two').removeClass('d-block').addClass('d-none');
            $('#screen-three').removeClass('d-none').addClass('d-block');

            var delivering = $('#delivering').val();
            var swift = $('#swift').val();

            $('#summary-bank').val(delivering);
            $('#summary-swift').val(swift);
        });

        // Handle "Continue" button click on screen-three to submit the form
        $('#screen-three .btn-primary-transparent').click(function() {
            $('form').submit(); // Assuming you have a form wrapping the content
        });
    });

</script>
@endsection

@section('scripts')

<!-- Prism JS -->
<script src="{{ asset('asset/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('asset/js/prism-custom.js') }}"></script>

<!-- Filepond JS -->
<script src="{{ asset('asset/libs/filepond/filepond.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-preview/filepond-plugin-image-preview.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-exif-orientation/filepond-plugin-image-exif-orientation.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-validate-size/filepond-plugin-file-validate-size.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-encode/filepond-plugin-file-encode.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-edit/filepond-plugin-image-edit.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-file-validate-type/filepond-plugin-file-validate-type.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-crop/filepond-plugin-image-crop.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-resize/filepond-plugin-image-resize.min.js') }}"></script>
<script src="{{ asset('asset/libs/filepond-plugin-image-transform/filepond-plugin-image-transform.min.js') }}"></script>

<!-- Dropzone JS -->
<script src="{{ asset('asset/libs/dropzone/dropzone-min.js') }}"></script>

<!-- Fileupload JS -->
<script src="{{ asset('asset/js/fileupload.js') }}"></script>


@endsection