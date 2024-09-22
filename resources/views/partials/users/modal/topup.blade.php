<!-- Modal Form (Place this in a shared file, e.g., modal.blade.php) -->

<!-- resources/views/components/transfer-modal.blade.php -->
<div class="modal fade" id="transferModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
<form method="POST" action="{{ route('swap.balance') }}" id="transferForm">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title" id="modalTitle">Transfer Funds</h5>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="amountDeposit" class="form-label fw-semibold">Amount</label>
            <input type="number" value="{{ old('amount') }}" required step="any" class="form-control" name="amount" id="amountDeposit" placeholder="Enter amount">
            @error('amount')
                <strong class="small text-danger">{{ $message }}</strong>
            @enderror
        </div>

        <!-- From Account Dropdown -->
        <div class="form-group my-4">
            <div class="d-flex justify-content-between">
                <label for="fromAccount" class="form-label fw-semibold">From Account</label>
                <span id="fromAccountBalance" class="text-end text-primary fw-semibold"></span>
            </div>
            <select name="from_account" class="form-control" required id="fromAccount">
                <option value="wallet" selected>Portfolio Wallet</option>
                <option value="savings">Savings Wallet</option>
                <option value="trading">Trading Wallet</option>
                <option value="investment">Investment Wallet</option>
            </select>
            @error('from_account')
                <strong class="small text-danger">{{ $message }}</strong>
            @enderror
        </div>

        <!-- To Account (Static, to be set dynamically by page) -->
        <div class="form-group my-4">
            <label for="toAccount" class="form-label fw-semibold">To Account</label>
            <input type="hidden" name="to_account" id="toAccountValue">
            <input type="text" disabled id="toAccountDisplay" class="form-control">
        </div>
    </div>

    <!-- Summary -->
    <div class="alert mx-3 alert-primary" id="summaryAlert">
        <p><strong>Note: </strong> <span id="summaryText">A sum of $100.98 will be transferred.</span></p>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" id="transferButton" class="btn btn-success">Transfer</button>
    </div>
</form>
        </div>
        </div>
        </div>



<script>
$(document).ready(function() {
    // Function to initialize the modal
    function initModal(toAccount, toAccountDisplayName) {
        // Set the "To Account" input values
        $('#toAccountValue').val(toAccount);
        $('#toAccountDisplay').val(toAccountDisplayName);

        // Set modal title dynamically
        $('#modalTitle').text('Top up ' + toAccountDisplayName);

        // Remove the selected option from the "From Account" dropdown
        $('#fromAccount option').each(function() {
            if ($(this).val() === toAccount) {
                $(this).hide(); // Hide the option so it can't be selected
            } else {
                $(this).show(); // Ensure other options are visible
            }
        });

        // Update the balance display for the current "From Account"
        updateFromAccountBalance();
    }

    // Function to update the fromAccountBalance span
    function updateFromAccountBalance() {
        const fromAccount = $('#fromAccount').val();

        if (fromAccount) {
            $.ajax({
                url: '{{ route("wallet.balance") }}',
                method: 'GET',
                data: { account: fromAccount },
                success: function(response) {
                    const formattedBalance = response.balance.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                    $('#fromAccountBalance').text('$' + formattedBalance);
                },
                error: function() {
                    $('#fromAccountBalance').text('Error fetching balance');
                }
            });
        } else {
            $('#fromAccountBalance').text('');
        }
    }

    // Example: Trigger modal for investment page
    $('#openInvestmentModal').on('click', function() {
        initModal('investment', 'Investment Wallet');
    });

    // Example: Trigger modal for savings page
    $('#openSavingsModal').on('click', function() {
        initModal('savings', 'Savings Wallet');
    });

    // Example: Trigger modal for trading page
    $('#openTradingModal').on('click', function() {
        initModal('trading', 'Trading Wallet');
    });

    // Function to update summary based on input
    function updateSummary() {
        let amount = parseFloat($('#amountDeposit').val());
        let fromAccount = $('#fromAccount option:selected').text();
        let toAccount = $('#toAccountDisplay').val();

        updateFromAccountBalance();

        if (!isNaN(amount) && amount > 0) {
            $('#summaryText').html(`A sum of <strong>$${amount.toFixed(2)}</strong> will be transferred from <strong>${fromAccount}</strong> to <strong>${toAccount}</strong>.`);
        } else {
            $('#summaryText').html('Please enter a valid amount.');
        }
    }

    // Update summary on amount change
    $('#amountDeposit').on('input', updateSummary);
    $('#fromAccount').on('change', updateSummary);

    // Initialize summary when modal opens
    updateSummary();
});
</script>