@extends('layouts.admin')

@section('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
@endsection

@section('breadcrumbs')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.saving.package') }}">Savings</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body row">
                <h4 class="card-title col-12">Savings Countdown</h4>
                    <div id="countdown" class="col-md-5">
                        @if($savings['status'] == 'active')
                            <div class="d-flex justify-content-between" style="overflow-x: auto">
                                <div class="px-3 py-2 bg-light" style="border-radius: 5px">
                                    <div id="days" class="display-3 text-center">00</div>
                                    <span class="text-center">Days</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="hours" class="display-3 text-center">00</div>
                                    <span class="text-center">Hours</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="minutes" class="display-3 text-center">00</div>
                                    <span class="text-center">Minutes</span>
                                </div>
                                <div class="px-3 py-2 ml-2 bg-light" style="border-radius: 5px">
                                    <div id="seconds" class="display-3 text-center">00</div>
                                    <span class="text-center">Seconds</span>
                                </div>
                            </div>
                        @elseif($savings['status'] == 'pending')
                            <h2 class='text-warning'>Pending</h2>
                        @elseif($savings['status'] == 'cancelled')
                            <h2 class='text-danger'>Cancelled</h2>
                        @elseif($savings['status'] == 'settled')
                            <h2 class='text-secondary'>Settled</h2>
                        @endif
                    </div>
                    <h4 class="card-title mt-4 mb-1 col-12">Savings Details</h4>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Package</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $savings->package['name'] }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Saving Amount</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="₦ {{ number_format($savings['amount']) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Saving Duration</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control text-capitalize" type="text" value="{{ $savings->package['duration'] }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Total ROI</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="₦ {{ number_format($savings['amount'] / $savings->package['roi'] * $savings->package['milestone']) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">ROI</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $savings->package['roi'] }} %" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Current ROI</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="₦ {{ number_format($savings['amount'] / $savings->package['roi']) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Amount Saved</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="₦ {{ number_format($savings['amount'] * $paid) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Target Amount</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="₦ {{ number_format($savings['amount'] * $savings->package['milestone']) }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Total Milestone</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $savings->package['milestone'] }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Milestone Completed</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $paid }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Savings Date</label>
                            </div>
                            <div class="col-lg-8">
                            <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $savings['created_at']->format('M d, Y \a\t h:i A') }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group row">
                            <div class="col-lg-3">
                                <label class="col-form-label">Maturity Date</label>
                            </div>
                            <div class="col-lg-8">
                                <input style="height: 50px; font-size: 14px" class="form-control" type="text" value="{{ $savings['return_date']->format('M d, Y \a\t h:i A') }}" readonly>
                            </div>
                        </div>
                    </div>

                    <h4 class="card-title mt-4 mb-5 col-12">Milestone Record</h4>
                    <div class="table-responsive">
                        <table id="" class="table">
                            <thead>
                            <tr>
                                <th>Milestone</th>
                                <th>Amount</th>
                                <th>Date Range</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= $savings->package['milestone']; $i++)
                                    <tr>
                                        <td>Milestone {{ $i }}</td>
                                        <td>₦ {{ number_format($savings['amount']) }}</td>
                                        <td>
                                            @if($savings->package['duration'] == 'weekly')
                                                {{ \Carbon\Carbon::make($savings['savings_date'])->addWeeks($i - 1)->format('M d, Y H:m:s') }}
                                            @else
                                                {{ \Carbon\Carbon::make($savings['savings_date'])->addMonths($i - 1)->format('M d, Y H:m:s') }}
                                            @endif
                                        </td>
                                        <td>
                                            <!-- <span class="badge badge-pill badge-success">Active</span> -->
                                            @if ($paid >= $i)
                                                <span class="badge badge-pill badge-success py-1 px-3">Paid</span>
                                            @else
                                                @if($savings->package['duration'] == 'weekly')
                                                    @if(\Carbon\Carbon::now() > \Carbon\Carbon::make($savings['savings_date'])->addWeeks($i - 1))
                                                        <span class="badge badge-pill badge-dark py-1 px-3">Void</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning py-1 px-3">Pending</span>
                                                    @endif
                                                @else
                                                    @if(\Carbon\Carbon::now() > \Carbon\Carbon::make($savings['savings_date'])->addMonths($i - 1))
                                                        <span class="badge badge-pill badge-dark py-1 px-3">Void</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning py-1 px-3">Pending</span>
                                                    @endif
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @endfor
                            </tbody>
                            @if($paid >= $savings->package['milestone'])
                            <tr>
                                <td>Total</td>
                                <td><b>₦ {{ number_format($savings['amount'] * $paid + $savings['amount'] / $savings->package['roi'] * $savings->package['milestone']) }}</b></td>
                                <td class="text-success"><b>Completed 🥳</b></td>
                                
                                <td>
                                    <span class="badge badge-pill badge-info py-1 px-3">Credited✅</span>
                                </td>
                                <td>
                                    @if($paid == $savings->package['milestone'])
                                    <form action="{{ route('settle.payment', $savings['id']) }}" method="post">
                                        @csrf
                                        <!-- <button type="submit" class="btn btn-primary">Withdraw</button> -->
                                    </form> 
                                    @elseif($paid > $savings->package['milestone'])
                                        <!-- <button type="button" disabled class="btn btn-dark">Withdraw</button> -->
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/js/data-table.js') }}"></script>
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
            let rolloverBtn = $('#rolloverOption');
            let rolloverForm = $('#rolloverForm');
            let submitButton = $('#submitButton');
            let savingsReturns = parseFloat({{ $savings['total_return'] }});
            displayRolloverForm();
            packageName.on('change', function (){
                $("#package option").each(function(){
                    if($(this).val() === packageName.val()){
                        price.val($(this).attr('data-price'));
                        roi.val($(this).attr('data-roi'));
                        duration.val($(this).attr('data-duration'));
                    }
                });
                computeAmount();
            });
            rolloverBtn.on('change', displayRolloverForm);
            function displayRolloverForm(){
                if(rolloverBtn.prop('checked')){
                    rolloverForm.show(500);
                }else{
                    rolloverForm.hide(500);
                }
            }
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
                if (packageName.val() && slots.val() && (slots.val() > 0)){
                    if ((slots.val() * price.val()) <= savingsReturns ){
                        submitButton.removeAttr('disabled');
                        slots.css('borderColor', '#10B759');
                    }else{
                        submitButton.prop('disabled', true);
                        slots.css('borderColor', 'red');
                    }
                }else{
                    submitButton.prop('disabled', true);
                }
            }
        });
    </script>
    <script>
        @if($savings['status'] == 'active')
            // let countDownDate = new Date("May 1, 2021 15:37:25").getTime();
            let countDownDate = new Date("{{ $savings['return_date']->format('F d, Y H:i:s') }}").getTime();
            let countDown = document.getElementById('countdown');
            let x = setInterval(function() {
                let now = new Date().getTime();
                let distance = countDownDate - now;
                document.getElementById("days").textContent = formatText(Math.floor(distance / (1000 * 60 * 60 * 24)).toString());
                document.getElementById("hours").textContent = formatText(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString());
                document.getElementById("minutes").textContent = formatText(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)).toString());
                document.getElementById("seconds").textContent = formatText(Math.floor((distance % (1000 * 60)) / 1000).toString());
                if (distance < 0) {
                    clearInterval(x);
                    countDown.innerHTML = "<h2 class='text-success'>Completed</h2>";
                }
            }, 1000);
            function formatText(text){
                if (text.length === 1){
                    return "0" + text;
                }
                return text;
            }
        @endif
    </script>
@endsection
