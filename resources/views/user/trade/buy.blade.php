@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Buy</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if($setting['trade'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="alert-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">Buying is currently unavailable, check back later</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @if($rate['gold'] == 0 || $rate['silver'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="check-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">There was an error fetching exchange rates, reload page</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Buy</h6>
                    <form action="{{ route('buy.store') }}" class="forms-sample" id="formToProcess" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="product">Product</label>
                            <select name="product" id="product" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="">Select Product</option>
                                <option @if(request()->offsetExists('silver')) selected @endif  value="silver">Silver</option>
                                <option @if(request()->offsetExists('gold'))  selected @endif value="gold">Gold</option>
                            </select>
                            @error('product')
                            <div class="small text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label id="tradeTitle">Grams to buy</label>
                            <div class="row">
                                <div class="col-9 pr-0">
                                    <input id="amount" type="number" step="any" value="{{ old('amount') }}" name="amount" class="form-control" style="height: 50px; font-size: 14px" placeholder="0.00">
                                </div>
                                <div class="col-3 pl-0">
                                    <select id="currency" name="currency" style="height: 50px; font-size: 14px" class="text-dark">
                                        <option value="grams">Grams</option>
                                        <option value="ngn">₦</option>
                                    </select>
                                </div>
                                @error('amount')
                                    <div class="small col-12 text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="receiveTitle" for="receive">Amount you'll pay</label>
                            <input type="text" class="form-control" id="receive" style="height: 50px; font-size: 14px" value="₦ 0.00" disabled>
                        </div>
                        <div class="form-group">
                            <label for="payment">Pay Via</label>
                            <select name="payment" id="payment" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="wallet">Naira Wallet</option>
                                <option value="card">Card</option>
                                <option value="deposit">Deposit / Bank Transfer</option>
                            </select>
                            @error('payment')
                            <div class="small text-danger">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div id="securedByPaystack" style="display: none" class="mx-auto text-center">
                            <img src="{{ asset('assets/images/paystack.png') }}" class="img-fluid mb-3" alt="Secured-by-paystack">
                        </div>
                        <div id="bankDetails" style="display: none" class="alert alert-fill-light">
                            <table>
                                <tr>
                                    <td>Bank Name:</td>
                                    <td><span class="ml-3">{{ $setting['bank_name'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Account Name:</td>
                                    <td><span class="ml-3">{{ $setting['account_name'] }}</span></td>
                                </tr>
                                <tr>
                                    <td>Account Number:</td>
                                    <td><span class="ml-3">{{ $setting['account_number'] }}</span></td>
                                </tr>
                            </table>
                        </div>
                        <div class="form-check mt-3 form-check-flat form-check-primary">
                            <label class="form-check-label">
                                I hereby agree to the <a href="https://raregems.ng/terms-and-conditions.html" target="_blank">terms and conditions</a>
                                <input required type="checkbox" id="agreed" class="form-check-input">
                            </label>
                        </div>
                        @if($setting['trade'] == 1)
                            <button type="button" disabled onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-success mr-2" style="height: 50px; font-size: 14px">Buy</button>
                        @else
                            <button type="button" disabled class="btn btn-secondary btn-block mr-2" style="height: 50px; font-size: 14px">Unavailable</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            let goldToNgn = {{ $rate['gold'] }};
            let silverToNgn = {{ $rate['silver'] }};
            let gramsToNgn = 0;
            let title = $('#tradeTitle');
            let receiveTitle = $('#receiveTitle');
            let currency = $('#currency');
            let amount = $('#amount');
            let receive = $('#receive');
            let product = $('#product');
            let payment = $('#payment');
            let bankDetails = $('#bankDetails');
            let securedByPaystack = $('#securedByPaystack');
            let submitButton = $('#submitButton');
            let agreed = $('#agreed');
            let nairaWalletBalance = parseFloat({{ auth()->user()['nairaWallet']['balance'] }});
            agreed.on('change', checkIfFormCanSubmit);
            fetchGramsToNgn();
            currency.on('change', function (e){
                switch (e.target.value){
                    case 'grams' :
                        title.text('Grams to buy');
                        receiveTitle.text('Amount you\'ll pay');
                        break;
                    case 'ngn' :
                        title.text('Amount to buy');
                        receiveTitle.text('Grams you\'ll get');
                        break;
                }
                processData();
            });
            product.on('change', fetchGramsToNgn);
            amount.on('input', processData);
            payment.on('change', function (){
                if (payment.val() === 'deposit') {
                    bankDetails.show(500);
                    securedByPaystack.hide(500);
                }else if(payment.val() === 'card'){
                    bankDetails.hide(500);
                    securedByPaystack.show(500);
                }else {
                    bankDetails.hide(500);
                    securedByPaystack.hide(500);
                }
                checkIfFormCanSubmit();
            });
            function fetchGramsToNgn(){
                if (product.val() === 'gold'){
                    gramsToNgn = goldToNgn;
                }else if(product.val() === 'silver'){
                    gramsToNgn = silverToNgn
                }else{
                    gramsToNgn = 0;
                }
                processData();
            }
            function processData(){
                if (product.val() && amount.val() && amount.val() > 0){
                    receive.val(currency.val() === 'grams' ? '₦ '+ numberFormat((gramsToNgn * amount.val()).toFixed(2)) : numberFormat((amount.val() / gramsToNgn).toFixed(6)) + ' Grams');
                }else {
                    receive.val(currency.val() === 'grams' ? '₦ 0.00' : '0.00 Grams')
                }
                checkIfFormCanSubmit();
            }
            function checkIfFormCanSubmit(){
                if (product.val() && amount.val() && (amount.val() > 0) && receive.val() && payment.val()){
                    if (payment.val() === 'wallet'){
                        switch (currency.val()){
                            case "grams":
                                if ((gramsToNgn * amount.val()) <= nairaWalletBalance){
                                    enableSubmit();
                                }else{
                                    disableSubmit();
                                }
                                break;
                            case 'ngn':
                                if (amount.val() <= nairaWalletBalance){
                                    enableSubmit();
                                }else{
                                    disableSubmit();
                                }
                                break;
                            default:
                                disableSubmit();
                        }
                    }else{
                        enableSubmit();
                    }
                }else{
                    disableSubmit();
                }
            }
            function disableSubmit(){
                submitButton.prop('disabled', true);
                amount.css('borderColor', 'red');
            }
            function enableSubmit(){
                if (agreed.prop('checked')) {
                    submitButton.removeAttr('disabled');
                }else{
                    submitButton.prop('disabled', true);
                }
                amount.css('borderColor', '#10B759');
            }
        });
    </script>
@endsection
