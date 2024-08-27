<div class="modal fade" id="nairaDepositModal" tabindex="-1" role="dialog" aria-labelledby="nairaDepositModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="nairaDepositModalLabel">Deposit</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.deposit') }}" id="depositForm">
                    @csrf
                    <div class="form-group">
                        <label for="amountDeposit">Amount</label>
                        <input type="number" value="{{ old('amount') }}" required style="height: 45px; font-size: 14px" step="any" class="form-control" name="amount" id="amountDeposit" placeholder="Amount">
                        <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                        @error('amount')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                        @enderror
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="type" value="deposit">
                        <label for="paymentDeposit">Account Type</label>
                        <select name="account" style="height: 45px; font-size: 14px" class="text-dark" required id="paymentDeposit">
                            <option value="savings">Savings</option>
                            <option value="investment">Investments</option>
                            <option value="trading">Trade</option>
                        </select>
                        @error('account')
                            <strong class="small text-danger">
                                {{ $message }}
                            </strong>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="confirmFormSubmit('depositForm')" class="btn btn-primary">Deposit</button>
            </div>
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
                <form action="{{ route('admin.withdraw') }}" method="POST" id="withdrawalForm">
                    @csrf
                    <div class="form-group">
                        <label for="amountWithdraw">Amount</label>
                        <input type="number" value="{{ old('amount') }}" required style="height: 45px; font-size: 14px" step="any" class="form-control" name="amount" id="amountWithdraw" placeholder="Amount">
                        <input type="hidden" name="user_id" value="{{ $user['id'] }}">
                        @error('amount')
                        <strong class="small text-danger">
                            {{ $message }}
                        </strong>
                        @enderror
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="confirmFormSubmit('withdrawalForm')" class="btn btn-primary">Withdrawal</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteUserModalLabel">Delete User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.users.delete', $user['id']) }}" method="POST" id="deleteUserForm">
                    @csrf
                    @method("DELETE")
                    <div class="form-group">
                        <label for="amountWithdraw" class="text-danger font-weight-bold">Type <strong>DELETE</strong> to confirm</label>
                        <input type="text" id="deleteInputVerify" required style="height: 45px; font-size: 14px" step="any" class="form-control" name="delete">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" disabled id="deleteUserButton" onclick="confirmFormSubmit('deleteUserForm')" class="btn btn-primary">Delete</button>
            </div>
        </div>
    </div>
</div>