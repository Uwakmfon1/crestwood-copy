<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ledger;
use App\Models\Saving;
use App\Models\Transaction;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Models\WalletTransaction;
use App\Models\WalletsTransactions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationController;

class TransactionController extends Controller
{
    public function index()
    {
        switch (true){
            case \request()->offsetExists('pending'):
                $type = 'pending';
                break;
            case \request()->offsetExists('withdrawal'):
                $type = 'withdrawal';
                break;
            case \request()->offsetExists('deposit'):
                $type = 'deposit';
                break;
            case \request()->offsetExists('others'):
                $type = 'others';
                break;
            default:
                $type = 'all';
        }
        return view('admin.transaction.index', ['type' => $type]);
    }

    public function deposit(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'account' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Find user
        $user = User::find($request['user_id']);
        if (!$user) {
            return back()->with('error', 'Can\'t process investment, user not found');
        }

        // Check Account
        switch ($request['account']) {
            case 'savings':
                Ledger::credit($user->wallet, $request['amount'], 'save', null, 'Admin Deposit to Savings Account');
                $transaction = $user->transaction('save')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'save',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Savings Account',
                    'method' => 'credit'
                ]);
                break;
            case 'trading':
                Ledger::credit($user->wallet, $request['amount'], 'trade', null, 'Admin Deposit to Trading Account');
                $transaction = $user->transaction('trade')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'trade',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Trading Account',
                    'method' => 'credit'
                ]);
                break;
            case 'investment':
                Ledger::credit($user->wallet, $request['amount'], 'invest', null, 'Admin Deposit to Investment Account');
                $transaction = $user->transaction('invest')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'invest',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Investment Account',
                    'method' => 'credit'
                ]);
                break;
            case 'wallet':
                Ledger::credit($user->wallet, $request['amount'], 'wallet', null, 'Admin Deposit to Wallet Balance');
                $transaction = $user->transaction('wallet')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'wallet',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Wallet Balance',
                    'method' => 'credit'
                ]);
                break;
            default:
                return back()->withInput()->with('error', 'Invalid account method');
        }

        if ($transaction) {
            // NotificationController::sendDepositSuccessfulNotification($transaction);
            return redirect()->route('admin.users.show', $user['id'])->with('success', 'Deposit made successfully to '. $request['account']);
        }
        return redirect()->route('admin.users.show', $user['id'])->with('error', 'Error processing deposit');
    }


    public function withdraw(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'user_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'account' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Find user
        $user = User::find($request['user_id']);
        if (!$user) {
            return back()->with('error', 'Can\'t process transaction, user not found');
        }

        // Check Account
        switch ($request['account']) {
            case 'savings':
                Ledger::debit($user->wallet, $request['amount'], 'save', null, 'Admin Withdrawal from Savings Account');
                $transaction = $user->transaction('save')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'save',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Savings Account',
                    'method' => 'debit'
                ]);
                break;
            case 'trading':
                Ledger::debit($user->wallet, $request['amount'], 'trade', null, 'Admin Withdrawal from Trading Account');
                $transaction = $user->transaction('trade')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'trade',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Trading Account',
                    'method' => 'debit'
                ]);
                break;
            case 'investment':
                Ledger::debit($user->wallet, $request['amount'], 'invest', null, 'Admin Withdrawal from Investment Account');
                $transaction = $user->transaction('invest')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'invest',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Investment Account',
                    'method' => 'debit'
                ]);
                break;
            case 'wallet':
                Ledger::debit($user->wallet, $request['amount'], 'wallet', null, 'Admin Withdrawal from Wallet Balance');
                $transaction = $user->transaction('wallet')->create([
                    'amount' => $request['amount'],
                    'data_id' => 0,
                    'type' => 'wallet',
                    'status' => 'approved',
                    'description' => 'Admin Deposit to Wallet Balance',
                    'method' => 'debit'
                ]);
                break;
            default:
                return back()->withInput()->with('error', 'Invalid account method');
        }

        if ($transaction) {
            // NotificationController::sendWithdrawalSuccessfulNotification($transaction);
            return redirect()->route('admin.users.show', $user['id'])->with('success', 'Withdrawal made successfully on '. $request['account']);
        }
        return redirect()->route('admin.users.show', $user['id'])->with('error', 'Error processing deposit');
    }

    public function approve(Transaction $transaction): \Illuminate\Http\RedirectResponse
    {
        // Check if transaction is pending
        if (!$transaction['status'] == 'pending'){
            return back()->with('error', 'Transaction already processed');
        }

        // Process transaction based on type
        $user = $transaction['user'];

        try {
            if ($transaction['method'] == 'credit' && $transaction['status'] == 'pending'){
                Ledger::credit($user->wallet, $transaction->amount, 'wallet', null, 'Approved Deposit');
            } elseif ($transaction['method'] == 'debit' && $transaction['status'] == 'pending') {
                Ledger::debit($user->wallet, $transaction->amount, 'wallet', null, 'Approved Deposit');
            }
            //::: Error: assign the particular deposit ::://
            $user->wallet->deposit()->update([
                'status' => 'approved',
            ]);
            //::: Error: assign the particular deposit ::://
            
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }

        // Update transaction
        if ($transaction->update(['status' => 'approved'])){
            return back()->with('success', 'Transaction approved successfully');
        }
        return back()->with('error', 'Error approving transaction');
    }

    public function decline(Transaction $transaction): \Illuminate\Http\RedirectResponse
    {
        // Check if transaction is pending
        if (!$transaction['status'] == 'pending'){
            return back()->with('error', 'Transaction already processed');
        }

        // Process transaction based on type
        $user = $transaction['user'];

        try {
            //::: Error: assign the particular deposit ::://
            $user->wallet->deposit()->update([
                'status' => 'decline',
            ]);
            //::: Error: assign the particular deposit ::://
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }

        // Update transaction
        if ($transaction->update(['status' => 'declined'])){
            return back()->with('success', 'Transaction declined successfully');
        }
        return back()->with('error', 'Error declining transaction');
    }
    
    public function fetchTransactionsWithAjax(Request $request, $type)
    {
// Define all column names
        $columns = [
            'id', 'name', 'amount', 'description', 'date', 'id', 'method', 'channel', 'status', 'action'
        ];
//        Find data based on page
        switch ($type){
            case 'pending':
                $transactions = Transaction::query()->latest()->where('status', 'pending');
                break;
            case 'withdrawal':
                $transactions = Transaction::query()->latest()->where('method', 'debit')->where('type', 'wallet');
                break;
            case 'deposit':
                $transactions = Transaction::query()->latest()->where('method', 'credit')->where('type', 'wallet');
                break;
            case 'others':
                $transactions = Transaction::query()->latest()->where('type', 'others');
                break;
            default:
                $transactions = Transaction::query()->latest();
        }
//        Set helper variables from request and DB
        $totalData = $totalFiltered = $transactions->count();
        $limit = $request['length'];
        $start = $request['start'];
        $order = $columns[$request['order.0.column']];
        $dir = $request['order.0.dir'];
        $search = $request['search.value'];
//        Check if request wants to search or not and fetch data
        if(empty($search))
        {
            $transactions = $transactions->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $transactions = $transactions->where('description','LIKE',"%{$search}%")
                ->orWhereHas('user',function ($q) use ($search) { $q->where('name', 'LIKE',"%{$search}%"); })
                ->orWhere('type', 'LIKE',"%{$search}%")
                ->orWhere('amount', 'LIKE',"%{$search}%")
                ->orWhere('status', 'LIKE',"%{$search}%");
            $totalFiltered = $transactions->count();
            $transactions = $transactions->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
//        Loop through all data and mutate data
        $data = [];
        $i = $start + 1;
        foreach ($transactions as $transaction)
        {
            $status = $action = $disabled = $details = null;
            if($transaction['type'] == 'withdrawal' && $transaction->user){
                $bank_name = $transaction['user']['bank_name'];
                $account_name = $transaction['user']['account_name'];
                $account_number = $transaction['user']['account_number'];
                $details = '<button data-toggle="modal" onclick="populateTransactionDetails(\''.$account_name.'\', \''.$account_number.'\', \''.$bank_name.'\');" data-target="#transactionDetailModal" class="btn btn-sm btn-primary" type="button">
                                View
                            </button>';
            }else{
                $details = '---';
            }
            if($transaction['status'] == 'approved'){
                $status = '<span class="badge badge-pill badge-success">Approved</span>';
                $disabled = 'disabled';
            }elseif ($transaction['status'] == 'pending') {
                $status = '<span class="badge badge-pill badge-warning">Pending</span>';
                if (auth()->user()->can('Approve Transactions')){
                    $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionApprove' . $transaction['id'] . '\')" href="' . route('admin.transactions.approve', $transaction['id']) . '"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-check mr-2"></i> <span class="">Approve</span></a>
                           <form id="transactionApprove' . $transaction['id'] . '" action="' . route('admin.transactions.approve', $transaction['id']) . '" method="POST">
                               <input type="hidden" name="_token" value="' . csrf_token() . '">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                }
                if (auth()->user()->can('Decline Transactions')) {
                    $action .= '<a class="dropdown-item d-flex align-items-center" onclick="event.preventDefault(); confirmFormSubmit(\'transactionDecline' . $transaction['id'] . '\')" href="' . route('admin.transactions.decline', $transaction['id']) . '"><i style="font-size: 13px" class="icon-sm text-secondary fa fa-times mr-2"></i> <span class="">Decline</span></a>
                            <form id="transactionDecline' . $transaction['id'] . '" action="' . route('admin.transactions.decline', $transaction['id']) . '" method="POST">
                               <input type="hidden" name="_token" value="' . csrf_token() . '">
                               <input type="hidden" name="_method" value="PUT">
                           </form>';
                }
                if (!auth()->user()->can('Approve Transactions') && !auth()->user()->can('Decline Transactions')){
                    $disabled = 'disabled';
                }
            }elseif ($transaction['status'] == 'declined'){
                $status = '<span class="badge badge-pill badge-danger">Declined</span>';
                $disabled = 'disabled';
            }
            $datum['sn'] = $i;
            if (auth()->user()->can('View Users') && $transaction->user){
                $datum['name'] = '<a href="'.route('admin.users.show', $transaction->user['id']).'">'.ucwords($transaction->user['first_name']) . ' ' . ucwords($transaction->user['last_name']).'</a>';
            }else{
                $datum['name'] = "Deleted Account";
            }
            $datum['amount'] = '$'.number_format($transaction['amount'], 2);
            $datum['description'] = $transaction['description'];
            $datum['date'] = $transaction['created_at']->format('M d, Y \a\t h:i A');
            $datum['details'] = $details;
            $datum['method'] = $transaction['method'];
            $datum['channel'] = $transaction['channel'];
            $datum['status'] = $status;
            $datum['action'] = '<div class="dropdown">
                                        <button class="btn btn-sm btn-primary" '.$disabled.' type="button" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action <i class="icon-lg fa fa-angle-down"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                            '.$action.'
                                        </div>
                                    </div>';
            $data[] = $datum;
            $i++;
        }
//      Ready results for datatable
        $res = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );
        echo json_encode($res);
    }
}
