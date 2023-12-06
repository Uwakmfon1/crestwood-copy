@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Sell</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if($setting['trade'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="alert-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">Selling is currently unavailable, check back later</strong>
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
                    <h6 class="card-title">Sell</h6>
                    <form class="forms-sample" action="{{ route('sell.store') }}" id="formToProcess" method="POST">
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
                            <label id="tradeTitle">Grams to sell</label>
                            <div class="row">
                                <div class="col-9 pr-0">
                                    <input type="number" step="any" value="{{ old('amount') }}" name="amount" id="amount" class="form-control" style="height: 50px; font-size: 14px" placeholder="0.00">
                                </div>
                                <div class="col-3 pl-0">
                                    <select name="currency" id="currency" style="height: 50px; font-size: 14px" class="text-dark">
                                        <option value="grams">Grams</option>
                                        <option value="ngn">₦</option>
                                    </select>
                                </div>
                                @error('amount')
                                    <div class="small text-danger">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label id="receiveTitle" for="receive">Amount you'll receive</label>
                            <input type="text" class="form-control" id="receive" style="height: 50px; font-size: 14px" value="₦ 0.00" disabled>
                        </div>
                        <div class="form-check mt-3 form-check-flat form-check-primary">
                            <label class="form-check-label">
                                I hereby agree to the <a href="https://raregems.ng/terms-and-conditions.html" target="_blank">terms and conditions</a>
                                <input required type="checkbox" id="agreed" class="form-check-input">
                            </label>
                        </div>
                        @if($setting['trade'] == 1)
                            <button type="button" disabled onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-danger mr-2" style="height: 50px; font-size: 14px">Sell</button>
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
            let product = $('#product');
            let receive = $('#receive');
            let submitButton = $('#submitButton');
            let agreed = $('#agreed');
            let goldWalletBalance = parseFloat({{ round(auth()->user()->goldWallet()->first()['balance'], 6) }});
            let silverWalletBalance = parseFloat({{ round(auth()->user()->silverWallet()->first()['balance'], 6) }});
            let balance = 0;
            agreed.on('change', checkIfFormCanSubmit);
            fetchGramsToNgn();
            currency.on('change', function (e){
                switch (e.target.value){
                    case 'grams' :
                        title.text('Grams to sell');
                        receiveTitle.text('Amount you\'ll receive');
                        break;
                    case 'ngn' :
                        title.text('Amount to sell');
                        receiveTitle.text('Grams you\'ll sell');
                        break;
                }
                processData();
            });
            product.on('change', fetchGramsToNgn);
            amount.on('input', processData);
            function fetchGramsToNgn(){
                if (product.val() === 'gold'){
                    gramsToNgn = goldToNgn;
                    balance = goldWalletBalance;
                }else if(product.val() === 'silver'){
                    gramsToNgn = silverToNgn;
                    balance = silverWalletBalance;
                }else{
                    gramsToNgn = 0;
                    balance = 0;
                }
                processData();
            }
            function processData(){
                if (product.val() && amount.val() && amount.val() > 0){
                    receive.val(currency.val() === 'grams' ? '₦ '+numberFormat((gramsToNgn * amount.val()).toFixed(2)) : numberFormat((amount.val() / gramsToNgn).toFixed(6)) + ' Grams');
                }else {
                    receive.val(currency.val() === 'grams' ? '₦ 0.00' : '0.00 Grams')
                }
                checkIfFormCanSubmit();
            }
            function checkIfFormCanSubmit(){
                if (product.val() && amount.val() && (amount.val() > 0) && receive.val()){
                    switch (currency.val()){
                        case "grams":
                            if (amount.val() <= balance){
                                enableSubmit();
                            }else{
                                disableSubmit();
                            }
                            break;
                        case 'ngn':
                            if ((amount.val() / gramsToNgn ) <= balance){
                                enableSubmit();
                            }else{
                                disableSubmit();
                            }
                            break;
                        default:
                            disableSubmit();
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
