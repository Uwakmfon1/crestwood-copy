<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = auth()->user()->transactions()->latest();
        switch (true){
            case \request()->offsetExists('all'):
                $transactions = $transactions->where('type', 'all');
                break;
            case \request()->offsetExists('withdrawal'):
                $transactions = $transactions->where('type', 'withdrawal');
                break;
            case \request()->offsetExists('deposit'):
                $transactions = $transactions->where('type', 'deposit');
                break;
            case \request()->offsetExists('others'):
                $transactions = $transactions->where('type', 'others');
                break;
        }
        return view('user.transaction.index', ['tittle' => 'Transactions', 'transactions' => $transactions->get()]);
    }

    public function deposit(Request $request)
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment' => ['required']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

//        Check for deposit method and process
        if ($request['payment'] == 'card') {
            $data = ['type' => 'deposit'];
            return PaymentController::initializeOnlineTransaction($request['amount'], $data);
        }
        $transaction = auth()->user()->transactions()->create([
            'type' => 'deposit', 'amount' => $request['amount'],
            'method' => $request['payment'],
            'description' => 'Deposit', 'status' => 'pending'
        ]);
        if ($transaction) {
            NotificationController::sendDepositQueuedNotification($transaction);
            return redirect()->route('wallet')->with('success', 'Deposit queued successfully');
        }
        return redirect()->route('wallet')->with('error', 'Error processing deposit');
    }

    public function withdraw(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Check if withdrawal is allowed
        if (Setting::all()->first()['withdrawal'] == 0){
            return back()->with('error', 'Withdrawal from wallet is currently unavailable, check back later');
        }
//        Check if user has sufficient balance
        if (!auth()->user()->hasSufficientBalanceForTransaction($request['amount'])) return back()->withInput()->with('error', 'Insufficient wallet balance');
//        Process withdrawal
        auth()->user()->nairaWallet()->decrement('balance', $request['amount']);
        $transaction = auth()->user()->transactions()->create([
            'type' => 'withdrawal', 'amount' => $request['amount'],
            'method' => 'wallet',
            'description' => 'Withdrawal', 'status' => 'pending'
        ]);
        if ($transaction) {
            NotificationController::sendWithdrawalQueuedNotification($transaction);
            return redirect()->route('wallet')->with('success', 'Withdrawal queued successfully');
        }
        return redirect()->route('wallet')->with('error', 'Error processing withdrawal');
    }

    public static function storeInvestmentTransaction($investment, $method, $byCompany = false, $channel = 'web')
    {
        $desc = !$byCompany ? 'Investment' : 'Investment by '.env('APP_NAME');
        Transaction::create([
            'investment_id' => $investment['id'],
            'user_id' => $investment->user['id'], 'type' => 'others',
            'amount' => $investment['amount'], 'description' => $desc,
            'method' => $method, 'channel' => $channel,
            'status' => $investment['status'] == 'active' ? 'approved' : 'pending'
        ]);
    }

    public static function storeTradeTransaction($trade, $method, $byCompany = false, $channel = 'web')
    {
        $desc = $trade['type'] == 'buy' ? 'Buy Trade' : 'Sell Trade';
        $desc = !$byCompany ? $desc : $desc.' by '.env('APP_NAME');
        Transaction::create([
            'trade_id' => $trade['id'],
            'user_id' => $trade->user['id'], 'type' => 'others',
            'amount' => $trade['amount'], 'description' => $desc,
            'method' => $method, 'channel' => $channel,
            'status' => $trade['status'] == 'success' ? 'approved' : 'pending'
        ]);
    }
}
