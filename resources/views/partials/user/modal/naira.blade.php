<div class="modal fade" id="nairaDepositModal" tabindex="-1" role="dialog" aria-labelledby="nairaDepositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('deposit') }}" id="depositForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="nairaDepositModalLabel">Deposit</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="amountDeposit">Amount</label>
                        <input type="number" value="{{ old('amount') }}" required style="height: 45px; font-size: 14px" step="any" class="form-control" name="amount" id="amountDeposit" placeholder="Amount">
                        @error('amount')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="paymentDeposit">Payment Method</label>
                        <select onchange="checkbutton()" name="payment" style="height: 45px; font-size: 14px" class="text-dark" required id="paymentDeposit">
                            <!-- <option value="card">Card</option> -->
                            <option value="deposit">Bank Transfer / Deposit</option>
                        </select>
                        @error('payment')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="type" value="deposit">
                        <label for="paymentDeposit">Account Type</label>
                        <select name="account_type" style="height: 45px; font-size: 14px" class="text-dark" required id="paymentDeposit">
                            <option value="savings">Savings</option>
                            <option value="investment">Investments</option>
                            <option value="trading">Trade</option>
                        </select>
                        @error('payment')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                        @enderror
                    </div>
                </div>
                <div id="securedByPaystackLogo" style="display: none" class="mx-auto text-center">
                    <img src="{{ asset('assets/images/paystack.png') }}" class="img-fluid mb-3" alt="Secured-by-paystack">
                </div>
                <div id="bankDetailsForDepositForm" class="alert mx-3 alert-fill-light">
                    <table>
                        <tr>
                            <td>Bank Name:</td>
                            <td><span class="ml-3">{{ \App\Models\Setting::all()->first()['bank_name'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Account Name:</td>
                            <td><span class="ml-3">{{ \App\Models\Setting::all()->first()['account_name'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Account Number:</td>
                            <td><span class="ml-3">{{ \App\Models\Setting::all()->first()['account_number'] }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="transfer" onclick="confirmFormSubmit('depositForm')" class="btn btn-primary" style="display: none;">Deposit</button>
                    <button type="submit" id="card"  class="btn btn-success">Deposit</button>
                    <!-- <button type="button" id="card" onclick="payWithMonnify()" class="btn btn-success">Deposit</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="nairaWithdrawalModal" tabindex="-1" role="dialog" aria-labelledby="nairaWithdrawalModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nairaWithdrawalModalLabel">Withdrawal</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('withdraw') }}" id="withdrawalForm">
                    @csrf
                    <div class="form-group">
                        <label for="amountWithdraw">Amount</label>
                        <input type="number" required value="{{ old('amount') }}" style="height: 45px; font-size: 14px" step="any" class="form-control" name="amount" id="amountWithdraw" placeholder="Amount">
                        @error('amount')
                        <strong class="small text-danger">
                            {{ $message }}
                        </strong>
                        @enderror
                    </div>
                </form>
                <div class="small text-info">Your withdrawal will be paid to the account details</div>
                <div class="alert alert-fill-light">
                    <table>
                        <tr>
                            <td>Bank Name:</td>
                            <td><span class="ml-3">{{ auth()->user()['bank_name'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Account Name:</td>
                            <td><span class="ml-3">{{ auth()->user()['account_name'] }}</span></td>
                        </tr>
                        <tr>
                            <td>Account Number:</td>
                            <td><span class="ml-3">{{ auth()->user()['account_number'] }}</span></td>
                        </tr>
                    </table>
                </div>
                <div class="small text-primary"><a href="{{ route('profile') }}"><b>Change Acconunt Details</b></a></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @if(\App\Models\Setting::all()->first()['withdrawal'] == 1)
                    <button type="button" onclick="confirmFormSubmit('withdrawalForm')" class="btn btn-primary">Process Withdrawal</button>
                @else
                    <button type="button" disabled class="btn btn-secondary">Unavailable</button>
                @endif
            </div>
        </div>
    </div>
</div>

@php
    $user = \App\Models\User::find(auth()->id());
@endphp

<script type="text/javascript" src="https://sdk.monnify.com/plugin/monnify.js"></script>
<script>
    <?php echo 'var userName = "' . $user->name . '";'; ?>
    <?php echo 'var userEmail = "' . $user->email . '";'; ?>

    function payWithMonnify() {
        var depositAmount = document.getElementById('amountDeposit').value

        MonnifySDK.initialize({
            amount: depositAmount,
            currency: "NGN",
            reference: new String((new Date()).getTime()),
            customerFullName: userName,
            customerEmail: userEmail,
            apiKey: "MK_TEST_FXMH1JTGXD",
            contractCode: "4401579811",
            paymentDescription: "deposit",
            onComplete: function(response) {
                //Implement what happens when the transaction is completed.
                window.location.href = '/transactions';
            },
            onClose: function(data) {
                //Implement what should happen when the modal is closed here
                window.location.href = '/wallet';
            }
        });
    }

    function checkbutton() {
        var deposittype = document.getElementById('paymentDeposit').value

        if (deposittype == 'card') {
            $('#transfer').hide();
            $('#card').show();
        } else {
            $('#transfer').show();
            $('#card').hide();
        }
    }
</script>