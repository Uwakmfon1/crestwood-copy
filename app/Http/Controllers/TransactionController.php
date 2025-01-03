<?php

namespace App\Http\Controllers;

use App\Models\SavingTransaction;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;

use HenryEjemuta\LaravelMonnify\Facades\Monnify;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyTransaction;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethod;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethods;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyIncomeSplitConfig;
use HenryEjemuta\LaravelMonnify\Exceptions\MonnifyFailedRequestException;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $transactions = $user->walletsTransactions(); 

        $total = $user->walletBalance();

        $s_balance = auth()->user()->savingsWalletBalance();
        $t_balance = auth()->user()->tradingWalletBalance();
        $i_balance = auth()->user()->investmentWalletBalance();

    
        return view('user_.wallet.index', [
            'tittle' => 'Transactions',
            'transactions' => $transactions->latest()->paginate(10),
            'total' => $total,
            'savings' => $s_balance,
            'trading' => $t_balance,
            'investment' => $i_balance,
            'setting' => Setting::all()->first(), 
        ]);
    }

    public function history(Request $request)
    {
        $user = auth()->user();

        $query = $user->transaction()->orderBy('created_at', 'desc'); 


        $transaction = $query->paginate(40);

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');

            // Adjusting the query to search within fields
            $query->where(function ($q) use ($searchTerm) {
                $q->where('description', 'like', '%' . $searchTerm . '%')
                ->orWhere('amount', 'like', '%' . $searchTerm . '%');
            });

            $transaction = $query->paginate(10000);
        }

        // Filter functionality
        if ($request->has('status')) {
            $status = $request->get('status');
            $query->where('status', $status);

            $transaction = $query->paginate(10000);
        }

        // Filter Type
        if ($request->has('type')) {
            $type = $request->get('type');
            $query->where('type', $type);

            $transaction = $query->paginate(10000);
        }

        return view('user_.wallet.history', ['title' => 'Transaction History', 'transactions' => $transaction]);
    }

    public function deposit(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0', 'min:10'],
            'account_type' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $user = auth()->user();

        //        Check Account
        switch ($request['account_type']){
            case 'savings':
                $transaction = $user->savingsWallet->walletTransactions()->create(
                    [
                        'user_id' => $user->id,
                        'amount' => $request['amount'], 
                        'account_type' => $request['account_type'],
                        'type' => 'deposit',
                        'description' => 'Deposit into ' . $request['account_type'] . ' account',
                        'method' => 'wallet',
                        'status' => 'pending'
                    ]
                );
                break;
            case 'trading':
                $transaction = $user->tradingWallet->walletTransactions()->create(
                    [
                        'user_id' => $user->id,
                        'amount' => $request['amount'],  
                        'account_type' => $request['account_type'],
                        'type' => 'deposit',
                        'description' => 'Deposit into ' . $request['account_type'] . ' account',
                        'method' => 'wallet',
                        'status' => 'pending'
                    ]
                );
                break;
            case 'investment':
                $transaction = $user->investmentWallet->walletTransactions()->create(
                    [
                        'user_id' => $user->id,
                        'amount' => $request['amount'],  
                        'account_type' => $request['account_type'],
                        'type' => 'deposit',
                        'description' => 'Deposit into ' . $request['account_type'] . ' account',
                        'method' => 'wallet',
                        'status' => 'pending'
                    ]
                );
            case 'wallet':
                $transaction = $user->wallet->walletTransactions()->create(
                    [
                        'user_id' => $user->id,
                        'amount' => $request['amount'],  
                        'account_type' => $request['account_type'],
                        'type' => 'deposit',
                        'description' => 'Deposit into portfolio wallet',
                        'method' => 'wallet',
                        'status' => 'pending'
                    ]
                );
                break;
            default:
                return back()->withInput()->with('error', 'Invalid account method');
        }

        if ($transaction) {
            // NotificationController::sendDepositQueuedNotification($transaction);
            return redirect()->route('transactions.history')->with('success', 'Deposit queued successfully');
        }
        return redirect()->route('wallet')->with('error', 'Error processing deposit');
    }

    public function withdraw(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate request

        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0', 'min:10'],
            'account_type' => ['required'],
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Check if withdrawal is allowed
        if (Setting::first()['withdrawal'] == 0) {
            return back()->with('error', 'Withdrawal from wallet is currently unavailable, check back later');
        }

        $user = auth()->user();

        if (!$user->wallet->sufficentAccountBalance($request->amount, 'wallet')){
            return back()->with('error', 'Insufficient wallet balance!');
        }

        $desc = $request->account_type == 'coin' ? 'Withdrawal Request to crypto wallet' : 'Withdrawal Request to bank account';

        $transaction = $user->transaction('wallet')->create([
            'amount' => $request->amount,
            'data_id' => 0,
            'status' => 'pending',
            'description' => $desc,
            'method' => 'debit',
            'type' => 'wallet'
        ]);

        if ($transaction) {
            NotificationController::sendWithdrawalQueuedNotification($transaction);
            return redirect()->route('transactions.history')->with('success', 'Withdrawal queued successfully');
        }

        return back()->withInput()->with('error', 'Error processing withdrawal');
    }


    public static function storeInvestmentTransaction($investment, $method, $byCompany = false, $channel = 'web')
    {
        $desc = !$byCompany ? 'Investment' : 'Investment by '.env('APP_NAME');
        Transaction::create([
            'investment_id' => $investment['id'],
            'user_id' => $investment->user['id'], 'type' => 'Investment',
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

    public static function storeSavingTransaction($saving, $amount, $method, $type, $desc, $saving_id, $channel = 'web')
    {
        Transaction::create([
            'saving_id' => $saving_id,
            'user_id' => $saving->user['id'], 'type' => $type,
            'amount' => $amount,
            'description' => $desc,
            'method' => $method, 'channel' => $channel,
            'status' => $saving['status'] == 'active' ? 'approved' : 'pending'
        ]);
    }
}
