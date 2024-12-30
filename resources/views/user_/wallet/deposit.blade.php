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

    .selectdepo {
        height: 200px;
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
                    <h5 class="modal-title text-center fw-bold" id="nairaDepositModalLabel">Deposit Funds</h5>
                    <p class="text-center text-muted fs-10" style="margin-top: 5px;">Select a deposit method to fund your account securely.</p>
                    <div class="d-none" id="back-arrow" style="position: absolute; top: 28px; left: 20px; cursor: pointer;">
                        <i class="fe fe-x text-dark me-2"></i>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row mx-auto my-auto" id="depoSelect" style="max-width: 600px;">
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo mx-auto pt-5" id="selectCrypto">
                                <div class="card-body align-items-center rounded">
                                    <span class="avatar avatar-md bg-primary me-2 shadow-avatar mb-3">
                                        <img class="p-1" src="https://cryptologos.cc/logos/centrifuge-cfg-logo.png" alt="">
                                    </span>
                                    <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                        Cryptocurrency
                                    </h5>
                                    <p class="text-center text-muted fs-10" style="margin-top: -5px;">Deposit funds using cryptocurrency.</p>
                                </div>
                            </div>
                        </div>
                        @if($user->is_approved == "pending" | $user->is_approved == "decline")
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo mx-auto pt-5" id="">
                                <div class="card-body align-items-center rounded">
                                    <span class="avatar avatar-md bg-primary me-2 shadow-avatar mb-3">
                                        <img class="p-1" src="https://pngimg.com/d/bank_PNG24.png" alt="">
                                    </span>
                                    <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                        Bank
                                    </h5>
                                    <p class="text-center text-muted fs-10" style="margin-top: -5px;">Deposit funds through a bank transfer.</p>
                                    <p class="text-center text-danger fs-11 fw-bold" style="margin-top: -5px;">Click <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#modalProof">here</a> to complete your verification.</p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-md-6 col-sm-12">
                            <div class="card text-center selectdepo mx-auto pt-5" id="selectBank">
                                <div class="card-body align-items-center rounded">
                                    <span class="avatar avatar-md bg-primary me-2 shadow-avatar mb-3">
                                        <img class="p-1" src="https://pngimg.com/d/bank_PNG24.png" alt="">
                                    </span>
                                    <h5 class="fw-bold fs-14 mt-2 mx-2"> 
                                        Bank
                                    </h5>
                                    <p class="text-center text-muted fs-10" style="margin-top: -5px;">Deposit funds through a bank transfer.</p>
                                </div>
                            </div>
                        </div>
                        @endif
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
                                <div class="input-group mx-auto"> 
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
                            <h4 class="text-center fs-13">You are about to make a deposit of <strong class="fw-bold text-primary amount-val">0 ---</strong></h4>
                            <p class="text-center text-muted fs-10">Exchange Rate: 1 <strong id="selected-coin-symbol"></strong>  - <span class="fw-bold" id="exchange-rate">0</span> USD</p>
                        </div>
                        <div class=" mx-auto" style="max-width: 600px;">
                            <div class="my-4">
                                <p class="text-center fs-12 fw-medium">To complete your deposit, scan the QR code or copy the wallet address below. Ensure the selected network matches your transaction to avoid errors or loss of funds.</p>
                                <div class="d-flex justify-content-center mx-auto my-2">
                                    <img width="130" height="130" src="https://upload.wikimedia.org/wikipedia/commons/5/5e/QR_Code_example.png" alt="...">
                                </div>
                                <p class="text-center fs-12 fw-medium">Use the QR code or wallet address below to send your selected cryptocurrency. Double-check all details before confirming the transaction on your wallet.</p>
                            </div>

                            <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                                <div class="col-xl-12">
                                    <div class="input-group">
                                        <button type="button" class="input-group-text btn btn-light-light btn-wave"><i class="ri-link me-2"></i></button>
                                        <input type="text" id="address-display" name="address-display" class="form-control text-center" placeholder="Enter Method..." aria-label="Stock Quantity" value="Select Coin" disabled>
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" name="account_type" value="wallet">

                            <div id="" class="alert mx-auto alert-primary mt-2" style="max-width: 6000px;">
                                <h4 class="text-danger fs-13">Note</h4>
                                <div class="">
                                    <!-- <p class="fs-12 text-muted">{{ $setting->crypto_note }}</p> -->
                                    <ul class="text-dark">
                                        <li>Ensure you select the correct cryptocurrency and blockchain network before making the deposit.</li>
                                        <li>Do not send unsupported cryptocurrencies or tokens to this address, as they will be permanently lost.</li>
                                        <li>Deposits will be credited to your account after the required number of network confirmations (e.g., Bitcoin: 3 confirmations, Ethereum: 12 confirmations).</li>
                                    </ul>
                                </div>
                            </div>
                            <!-- <p class="text-dark fs-13 text-center fw-medium">Already made payment of <span class="fw-bold text-primary amount-val">0 ---</span> to the wallet address above <br> Click the button below to confirm transaction.</p> -->
                             <p class="text-dark fs-13 text-center fw-medium">After sending your deposit to the address above, click the ‘Confirm Deposit’ button to notify our system for faster processing.</p>
                        </div>
                    </div>
                    <div id="bank" class="d-none">
                        <input type="hidden" id="bank-method" name="method" value="bank">
                        <div class="" id="screen-one">
                            <div class="row d-flex justify-content-center mx-auto" style="max-width: 600px;">
                                <div class="col-xl-12">
                                    <!-- <label for="bank-amount" class="form-label text-center">Deposit Amount</label> -->
                                    <div>
                                        <p class="small text-dark text-center fw-bold">Deposit Amount</p>
                                    </div>
                                    <div class="input-group mx-auto" style="max-width: 470px;"> 
                                        <input type="number" style="font-size: 14px; font-weight: 800;" step="any" class="form-control amountDeposit text-center" name="amount" id="bank-amount" placeholder="Enter the amount you wish to deposit.">
                                        <button type="button" class="input-group-text btn btn-dark-light btn-wave text-dark fs-12 fw-bold">USD</button>
                                    </div>
                                    <div>
                                        <p class="small text-danger text-center fw-bold" id="amount-error">Please enter deposit amount</p>
                                    </div>
                                    @error('amount')
                                        <strong class="small text-danger text-center">
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
                                    <p class="text-center text-dark fs-12 fw-medium">Transfer Funds to the Bank Account Below</p>
                                </div>
                                <div class="row d-flex justify-content-center mx-auto">
                                    <div class="col-xl-12" style="max-width: 500px;">
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Name</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->account_name }}" disabled>
                                            <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave increment-btn-buy text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Please use the exact name listed to avoid delays." class="text-muted input-group-text btn btn-dark-light btn-wave">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </div>
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Account Number</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->account_number }}" disabled>
                                            <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                        </div>
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Bank Name</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_name }}" disabled>
                                            <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                        </div>
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">SWIFT Code (International Transfers)</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->swift_code }}" disabled>
                                            <!-- <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button> -->
                                        </div>
                                        <div class="input-group my-1">
                                            <button type="button" class="input-group-text btn btn-light-light btn-wave fs-10">Reference</button>
                                            <input type="text" name="roi_method" class="form-control fw-bold" placeholder="Enter Method..." aria-label="Stock Quantity" value="{{ $setting->bank_reference }}" disabled>
                                            <button type="button" class="input-group-text btn btn-dark-light btn-wave copy-btn text-primary fs-13"><i class="ri-file-copy-fill text-primary me-2"></i> Copy</button>
                                            <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Include this reference in your bank transfer to ensure proper allocation" class="text-muted input-group-text btn btn-dark-light btn-wave">
                                                <i class="fe fe-info"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 my-3" style="max-width: 500px;">
                                        <div class="row">
                                            <div class="col-lg-8 col-6">
                                                <div class="">
                                                    <label for="" class="fs-10 text-dark">Bank Address:</label>
                                                    <p class="text-muted fw-bold fs-12">{{ $setting->bank_address }}, {{ $setting->bank_state }} {{ $setting->bank_country }} 
                                                        <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Contact this email for any deposit-related issues." class="text-muted mx-1">
                                                            <i class="fe fe-info"></i>
                                                        </a>
                                                    </p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-6">
                                                <!-- <div class="">
                                                    <label for="" class="fs-10 text-dark">Phone:</label>
                                                    <p class="text-muted fw-bold fs-12">{{ $setting->bank_phone }}</p>
                                                </div> -->
                                            </div>
                                            <!-- <div class="col-lg-4 col-6">
                                                <div class="">
                                                    <label for="" class="fs-10">Country:</label>
                                                    <p class="text-muted fw-bold fs-12">{{ $setting->bank_country }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-6">
                                                <div class="">
                                                    <label for="" class="fs-10">State:</label>
                                                    <p class="text-muted fw-bold fs-12">{{ $setting->bank_state }}</p>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-6">
                                                <div class="">
                                                    <label for="" class="fs-10">Address:</label>
                                                    <p class="text-muted fw-bold fs-12">{{ $setting->bank_address_address }}</p>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div style="max-width: 500px;">
                                        <div id="" class="alert mx-1 alert-primary mt-2">
                                            <h4 class="text-danger fs-12 fw-bold">Please Note</h4>
                                            <div class="">
                                                    <!-- <p class="fs-12 text-muted">{{ $setting->bank_note_initial }}</p> -->
                                                    <ul class="text-dark fs-12 text-muted">
                                                        <li>Ensure the deposit amount matches your entry above to avoid discrepancies.</li>
                                                        <li>Include the transaction reference in your transfer details for proper allocation.</li>
                                                        <li>International deposits may take up to 3-5 business days to reflect.</li>
                                                        <li>For questions, contact our support team.</li>
                                                    </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                        <button type="button" class="btn btn-grey text-muted px-4">Previous</button>
                                        <button type="button" class="btn btn-success-transparent px-4" id="nextScreenButtonOne">Confirm Deposit <i class="fe fe-arrow-right"></i></button>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="screen-two">
                            <div class="mx-auto" style="max-width: 500px;">
                                <div class="row d-flex justify-content-center mx-auto">
                                    <div class="col-xl-12">
                                        <div class="form-group my-2">
                                            <label for="delivering" class="fs-12 fw-medium my-2 text-muted">Delivering Bank 
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="The bank from which you initiated the transfer." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </label>
                                            <input type="text" name="delivering" class="form-control fw-bold fs-11" placeholder="Enter the name of your bank.”" id="delivering">
                                        </div>
                                        
                                        <div class="form-group my-2">
                                            <label for="swift" class="fs-12 fw-medium my-2 text-muted">Swift Code
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Required for international transfers." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </label>
                                            <input type="text" name="swift" class="form-control fw-bold fs-11" placeholder="Enter the SWIFT code of the delivering bank." id="swift">
                                        </div>
                                        
                                        <div class="form-group my-2">
                                            <label for="account" class="fs-12 fw-medium my-2 text-muted">Account Number
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="Your bank account number used for the transfer." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </label>
                                            <input type="text" name="account" class="form-control fw-bold fs-11" placeholder="Enter the sending account number." id="account">
                                        </div>
                                        
                                        <div class="form-group my-2">
                                            <label for="time" class="fs-12 fw-medium my-2 text-muted">Initiated Time
                                                <a href="javascript:void(0);" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-dark" title="The exact time the transfer was initiated." class="text-muted mx-1">
                                                    <i class="fe fe-info"></i>
                                                </a>
                                            </label>
                                            <input type="time" name="time" class="form-control fw-bold fs-11" id="time">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card custom-card my-2">
                                            <div class="card-header">
                                                <div class="card-title">
                                                Upload Proof
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <input type="file" id="imageUpload" class="multiple-filepond" name="filepond" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                                            </div>
                                        </div>
                                        <div id="error-message" style="display: none;" class="small text-danger text-center fw-bold">Please fill out all fields and upload an image.</div>
                                    </div>
                                    <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                        <button type="button" class="btn btn-info-transparent px-4"><i class="fe fe-arrow-left"></i> Previous </button>
                                        <button type="button" class="btn btn-success-transparent px-4" id="nextScreenButton">Next <i class="fe fe-arrow-right"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none" id="screen-three">
                            <div class="summary">
                                <div>
                                    <h3 class="fs-16 fw-bold text-center my-3">Summary</h3>
                                    <div>
                                        <h4 class="text-center fs-13">You are about to make a deposit of <strong class="fw-bold text-primary amount-val" id="amount-val-summary">0 USD</strong></h4>
                                        <div class="row d-flex justify-content-center mx-auto">
                                            <div class="col-xl-12" style="max-width: 500px;">
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
                                            <div class="mx-auto" style="max-width: 500px;">
                                                <div id="" class="alert alert-primary mt-2">
                                                    <h4 class="text-danger fs-12 fw-bold">Please Note</h4>
                                                    <div class="">
                                                            <!-- <p class="fs-11 text-muted">{{ $setting->bank_note_final }}</p> -->
                                                            <ul class="text-dark fs-12 text-muted">
                                                                <li>Ensure all information entered matches your bank transaction details to avoid delays..</li>
                                                                <li>Upload a clear and complete copy of your transfer receipt.</li>
                                                                <li>Once submitted, our team will verify your deposit within 1-3 business days.</li>
                                                                <li>For any issues, contact support.</li>
                                                            </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-between my-4 float-end" style="max-width: 500px;">
                                                <button type="button" class="btn btn-info-transparent px-4"><i class="fe fe-arrow-left"></i> Previous </button>
                                                <button type="submit" class="btn btn-primary-transparent px-4">Submit and Verify</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-none mx-auto" id="depositFooter" style="max-width: 600px;">
                    <button type="submit"  class="btn btn-primary-transparent px-6 mx-auto" >Confirm and Notify</button>
                </div>
            </form>

            <div class="d-none card-body">
                <form data-single="true" method="post" action="https://httpbin.org/post" class="dropzone"></form>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalProof" tabindex="-1" role="dialog" aria-labelledby="modalProofLabel" aria-hidden="true">
    <div class="modal-dialog" role="document" style="max-width: 700px;">
        <div class="modal-content">
            <div class="px-3 py-3">
                <div class="card-title d-flex justify-content-between align-items-center">
                    <h3 class="fw-bold fs-14">Proof of Address</h3>
                    <span class="badge @if($user->is_approved == 'pending') bg-warning @else($user->is_approved) bg-danger @endif ">
                    @if($user->is_approved == 'pending') Pending @else($user->is_approved) Declined @endif
                    </span>
                </div>
                <div id="" class="alert alert-warning mt-2">
                    <div class="">
                        <p class="fs-12 text-dark">Upload a valid proof of address document. This can be a utility bill, bank statement, or government-issued document dated within the last 3 months." "Accepted formats: JPG, PNG, PDF. Max size: 10 MB</p>
                    </div>
                </div>

                <div class="">
                    <form action="{{ route('profile.data') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="screen" value="proof">
                        <div class="my-3 py-2">
                            <p class="fs-14 fw-bold my-2">
                                Upload Proof
                            </p>
                            <div class="">
                                <input type="file" id="imageUpload" class="form-control" name="proof" multiple data-allow-reorder="true" data-max-file-size="3MB" data-max-files="6">
                            </div>
                        </div>
                        @if(auth()->user()['proof'])
                            <div class="mt-2 mx-2">
                                <img class="img-fluid" style="border-radius: 5px" src="{{ asset(auth()->user()['proof']) }}" alt="proof">
                            </div>
                        @endif
                        <div id="" class="alert alert-primary my-2">
                            <h4 class="text-danger fs-12 fw-bold">Compliance Disclaimer:</h4>
                            <div class="">
                                <p class="fs-12 text-muted">In compliance with applicable laws and Customer Identification Program (CIP) requirements, your information will be securely processed.</p>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-light border-1 w-100">Submit</button>
                    </form>

                </div>
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
            
            // Format the amount with commas and fixed to two decimal places
            const formattedAmount = usdAmount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            
            // Update the displayed value with the formatted amount
            $('.amount-val-bank').text(formattedAmount + ' USD');
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
                $('#exchange-rate').text(selectedCoinRate.toLocaleString()); // Display the rate with 5 decimal places
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
                // Format the coin amount with commas
                const formattedCoinAmount = coinAmount.toLocaleString(undefined, { minimumFractionDigits: 5, maximumFractionDigits: 5 });

                // Update displayed amount in selected coin
                $('.amount-val').text(formattedCoinAmount + ' ' + selectedCoinSymbol);

                $('#coin-value').prop('value', coinAmount);
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
        document.getElementById('depoSelect').classList.add('d-none');

        document.getElementById('back-arrow').classList.remove('d-none');
        document.getElementById('back-arrow').classList.add('d-block');
    });

    document.getElementById('selectBank').addEventListener('click', function() {
        // Show bank fields, hide crypto fields
        document.getElementById('crypto').classList.add('d-none');
        document.getElementById('bank').classList.remove('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.add('d-none');
        document.getElementById('depoSelect').classList.add('d-none');
        
        document.getElementById('back-arrow').classList.remove('d-none');
        document.getElementById('back-arrow').classList.add('d-block');
    });

    document.getElementById('back-arrow').addEventListener('click', function() {
        // Show bank fields, hide crypto fields
        document.getElementById('crypto').classList.add('d-none');
        document.getElementById('bank').classList.add('d-none');

        // Show the footer
        document.getElementById('depositFooter').classList.add('d-none');

        document.getElementById('depoSelect').classList.add('d-flex');
        document.getElementById('depoSelect').classList.remove('d-none');
        
        document.getElementById('back-arrow').classList.add('d-none');
        document.getElementById('back-arrow').classList.remove('d-block');
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
    });

    $(document).ready(function() {
        
        // Handle "Continue" button click on screen-one
        $('#screen-one .btn-success-transparent').click(function() {
            var amount = $('#bank-amount').val();
            
            // Format the amount with commas
            var formattedAmount = parseFloat(amount).toLocaleString();
            
            // Update the summary section with the formatted amount
            $('#amount-val-summary').text(formattedAmount + " USD");
        });
        
        // Handle "Continue" button click on screen-two
        $('#screen-two .btn-success-transparent').click(function() {
            var delivering = $('#delivering').val();
            var swift = $('#swift').val();

            $('#summary-bank').val(delivering);
            $('#summary-swift').val(swift);
        });
    });

    $(document).ready(function() {
        // Initialize by showing the first screen
        $('#screen-one').removeClass('d-none');
        $('#screen-two, #screen-three').addClass('d-none');

        // Handle 'Next' button on screen-one
        // $('#screen-one .btn-success-transparent').click(function() {
        //     $('#screen-one').addClass('d-none'); // Hide screen 1
        //     $('#screen-two').removeClass('d-none'); // Show screen 2
        // });

        // Handle 'Next' button on screen-two
        // $('#screen-two .btn-success-transparent').click(function() {
        //     $('#screen-two').addClass('d-none'); // Hide screen 2
        //     $('#screen-three').removeClass('d-none'); // Show screen 3
        // });

        // Handle 'Previous' button on screen-two (goes back to screen-one)
        $('#screen-two .btn-info-transparent').click(function() {
            $('#screen-two').addClass('d-none'); // Hide screen 2
            $('#screen-one').removeClass('d-none'); // Show screen 1
        });

        // Handle 'Previous' button on screen-three (goes back to screen-two)
        $('#screen-three .btn-info-transparent').click(function() {
            $('#screen-three').addClass('d-none'); // Hide screen 3
            $('#screen-two').removeClass('d-none'); // Show screen 2
        });

        // Initially leave 'Previous' buttons non-functional on screen-one
        // $('#screen-one .btn-info-transparent').prop('disabled', true);
    });

    $(document).ready(function() {
        $('#amount-error').hide();

        $('#bank-amount').on('input', function() {
            $('#amount-error').hide();
        });

        $('#nextScreenButtonOne').click(function() {
            var input1 = $('#bank-amount').val().trim();
            if (input1 === "") {
                $('#amount-error').show();
            } else {
                $('#screen-one').addClass('d-none'); // Hide screen 1
                $('#screen-two').removeClass('d-none'); // Show screen 2
            }
        });
        $('#nextScreenButton').click(function() {
            // Variables to track if all inputs are valid
            var input1 = $('#delivering').val().trim();
            var input2 = $('#swift').val().trim();
            var input3 = $('#account').val().trim();
            var input4 = $('#time').val().trim();
            var imageUpload = $('#imageUpload');

            // Check if all fields are filled and an image is uploaded
            if (input1 === "" || input2 === "" || input3 === "" || input4 === "" || imageUpload === "") {
                // If any field is empty, show error message
                $('#error-message').show();
                console.log(imageUpload);
                
            } else {
                // All fields are valid, hide error message and proceed to next screen
                $('#error-message').hide();

                $('#screen-two').addClass('d-none'); // Hide screen 2
                $('#screen-three').removeClass('d-none'); // Show screen 3
            }
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