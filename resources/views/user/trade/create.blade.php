@extends('layouts.user')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Trade</li>
        </ol>
    </nav>
@endsection

@section('content')
    @if($setting['invest'] == 0)
        <div class="alert alert-fill-warning" role="alert">
            <i data-feather="alert-circle" class="mr-2"></i>
            <strong style="font-size: 13px" class="small">Savings packages is currently unavailable, check back later</strong>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Trade</h6>
                    <form class="forms-sample" action="{{ route('trading.store') }}" id="formToProcess" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="stock_id"></label>
                            <select id="stock_id" name="stock_id" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="">Select Stock</option>
                                @foreach($stocks as $stock)
                                    <option @if((old('stock_id') == $stock['stock']) || (request('stock') == $stock['stock'])) selected @endif value="{{ $stock['id'] }}" data-price="{{ $stock['amount'] }}">{{ $stock['stock'] }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="amount">
                            <input type="hidden" id="roi">
                            <input type="hidden" id="duration">
                            @error('package')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slots" class="d-flex justify-content-between"><span>Duration</span><span id="slotInfo"></span></label>
                            <input id="slots" type="hidden" value="1" name="slots" class="form-control" style="height: 50px; font-size: 14px" placeholder="Slots">
                            <input id="milestone" type="hidden" name="milestone">
                            <input id="timeframe" type="text" name="timeframe" class="form-control text-capitalize" style="height: 50px; font-size: 14px" disabled>
                            @error('duration')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount to Invest</label>
                            <input type="text" class="form-control" id="amount" style="height: 50px; font-size: 14px" value="₦ 0.00" disabled>
                        </div>
                        <div class="form-group">
                            <label for="returns">Expected Return <span id="returnInfo"></span></label>
                            <input type="text" class="form-control" id="returns" style="height: 50px; font-size: 14px" value="₦ 0.00" disabled>
                        </div>
                        <div class="form-group">
                            <label for="payment">Pay Via</label>
                            <select name="payment" id="payment" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="wallet">Naira Wallet</option>
                                <!-- <option value="card">Card</option> -->
                                <option value="deposit">Deposit / Bank Transfer</option>
                            </select>
                            @error('payment')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
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
                        @if($setting['invest'] == 1)
                            <button type="button" disabled onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Invest</button>
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
            let packageName = $('#stock_id');
            let slots = $('#slots');
            let slotInfo = $('#slotInfo');
            let price = $('#price');
            let roi = $('#roi');
            let duration = $('#duration');
            let milestone = $('#milestone');
            let timeframe = $('#timeframe');
            let amount = $('#amount');
            let returns = $('#returns');
            let returnInfo = $('#returnInfo');
            let payment = $('#payment');
            let bankDetails = $('#bankDetails');
            let securedByPaystack = $('#securedByPaystack');
            let submitButton = $('#submitButton');
            let agreed = $('#agreed');
            let nairaWalletBalance = parseFloat({{ auth()->user()->tradingWalletBalance() }});
            agreed.on('change', checkIfFormCanSubmit);
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
            setFieldsForInvestment();
            packageName.on('change', setFieldsForInvestment);
            function setFieldsForInvestment()
            {
                $("#package option").each(function(){
                    if($(this).val() === packageName.val()){
                        price.val($(this).attr('data-price'));
                        roi.val($(this).attr('data-roi'));
                        duration.val($(this).attr('data-duration'));
                        milestone.val($(this).attr('data-milestone'));
                    }
                });
                computeAmount();
            }
            slots.on('input', computeAmount);
            function computeAmount(){
                if (packageName.val()){
                    if (duration.val() == 'weekly') {
                        durValue = 'Week'
                    } else if (duration.val() == 'monthly') {
                        durValue = 'Month'
                    } else {
                        durValue = 'Day'
                    }
                    
                    returnInfo.html('after <b>'+ milestone.val() +' '+ durValue +'(s)</b>');
                    slotInfo.text('₦ ' + price.val() + '/' + durValue );

                    timeframe.val(duration.val());
                }else{
                    returnInfo.html('');
                    slotInfo.text('');
                }
                if (packageName.val() && slots.val() && (slots.val() > 0)){
                    amount.val('₦ ' + numberFormat((slots.val() * price.val()).toFixed(2)));
                    returns.val('₦ ' + numberFormat((milestone.val() * price.val() * ((parseInt(roi.val()) + 100) / 100)).toFixed(2)));
                }
                checkIfFormCanSubmit();
            }
            function checkIfFormCanSubmit(){
                if (packageName.val() && slots.val() && (slots.val() > 0) && payment.val() && agreed.prop('checked')){
                    if (payment.val() === 'wallet'){
                        if ((slots.val() * price.val()) <= nairaWalletBalance ){
                            submitButton.removeAttr('disabled');
                            slots.css('borderColor', '#10B759');
                        }else{
                            submitButton.prop('disabled', true);
                            slots.css('borderColor', 'red');
                        }
                    }else{
                        submitButton.removeAttr('disabled');
                        slots.css('borderColor', '#10B759');
                    }
                }else{
                    submitButton.prop('disabled', true);
                }
            }
        });
    </script>
@endsection
