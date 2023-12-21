@extends('layouts.admin')

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users') }}">Users</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.show', 1) }}">Details</a></li>
            <li class="breadcrumb-item active" aria-current="page">Invest</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">Invest</h6>
                    <form class="forms-sample" action="{{ route('admin.users.invest.store') }}" id="formToProcess" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="package"></label>
                            <select id="package" name="package" style="height: 50px; font-size: 14px" class="text-dark">
                                <option value="">Select Package</option>
                                @foreach($packages as $package)
                                    <option @if((old('package') == $package['name']) || (request('package') == $package['name'])) selected @endif value="{{ $package['name'] }}" data-price="{{ $package['price'] }}" data-roi="{{ $package['roi'] }}" data-duration="{{ $package['duration'] }}">{{ $package['name'] }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="price">
                            <input type="hidden" id="roi">
                            <input type="hidden" id="duration">
                            <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                            @error('package')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slots" class="d-flex justify-content-between"><span>No of slots</span><span id="slotInfo"></span></label>
                            <input id="slots" type="number" value="{{ old('slots') }}" name="slots" class="form-control" style="height: 50px; font-size: 14px" placeholder="Slots">
                            @error('slots')
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
                                <option value="deposit">Deposit</option>
                            </select>
                            @error('payment')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                            @enderror
                        </div>
                        <button type="button" disabled onclick="confirmFormSubmit('formToProcess')" id="submitButton" class="btn btn-block btn-primary mr-2" style="height: 50px; font-size: 14px">Invest</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function (){
            let packageName = $('#package');
            let slots = $('#slots');
            let slotInfo = $('#slotInfo');
            let price = $('#price');
            let roi = $('#roi');
            let duration = $('#duration');
            let amount = $('#amount');
            let returns = $('#returns');
            let returnInfo = $('#returnInfo');
            let payment = $('#payment');
            let submitButton = $('#submitButton');
            packageName.on('change', setFieldsForInvestment);
            function setFieldsForInvestment()
            {
                $("#package option").each(function(){
                    if($(this).val() === packageName.val()){
                        price.val($(this).attr('data-price'));
                        roi.val($(this).attr('data-roi'));
                        duration.val($(this).attr('data-duration'));
                    }
                });
                computeAmount();
            }
            payment.on('change', function (){
                checkIfFormCanSubmit();
            });
            setFieldsForInvestment();
            slots.on('input', computeAmount);
            function computeAmount(){
                if (packageName.val()){
                    returnInfo.html('after <b>'+ duration.val() +' month(s)</b>');
                    slotInfo.text('₦ ' + price.val() + '/slot' );
                }else{
                    returnInfo.html('');
                    slotInfo.text('');
                }
                if (packageName.val() && slots.val() && (slots.val() > 0)){
                    amount.val('₦ ' + numberFormat((slots.val() * price.val()).toFixed(2)));
                    returns.val('₦ ' + numberFormat((slots.val() * price.val() * ((parseInt(roi.val()) + 100) / 100)).toFixed(2)));
                }
                checkIfFormCanSubmit();
            }
            function checkIfFormCanSubmit(){
                if (packageName.val() && slots.val() && (slots.val() > 0) && payment.val()){
                    submitButton.removeAttr('disabled');
                }else{
                    submitButton.prop('disabled', true);
                }
            }
        });
    </script>
@endsection
