<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Wallet;
use App\Models\Setting;
use App\Models\AccountCoin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        // Fetch transactions directly from the `ledgers` table
        $transactions = Ledger::where('ledgerable_type', 'App\Models\Wallet') // Adjust if needed
        ->where('ledgerable_id', $wallet->id)
        ->latest() // Apply latest() for ordering
        ->get();

        // Calculate total gains and losses
        $totalCredits = $transactions->where('type', 'credit')->sum('amount');
        $totalDebits = $transactions->where('type', 'debit')->sum('amount');
        $netGains = $totalCredits - $totalDebits;

        // Calculate performance percentage
        $initialBalance = $wallet->created_at_balance ?? 0; // Ensure `created_at_balance` exists
        $performancePercentage = $initialBalance > 0
        ? round(($netGains / $initialBalance) * 100, 2) // Rounded to 2 decimal places
        : null;


        // Overall available funds
        $savings = $wallet->save;
        $investment = $wallet->invest;
        $trading = $wallet->trade;
        $availableCash = $wallet->balance + $savings + $investment + $trading;

        // Locked funds (investments, savings, trading)
        $inv = $user->investments()->where('status', 'active')->sum('amount');
        $sav = $user->savings()
            ->with(['savingsTransactions' => function ($query) {
                $query->where('type', 'debit')->where('status', 'success');
            }])
            ->get()
            ->pluck('savingsTransactions')
            ->flatten()
            ->sum('amount') ?? 0;

        $trd = $user->trades('stocks')->sum('amount') + $user->trades('crypto')->sum('amount');
        $lockedFunds = $inv + $sav + $trd;

        // Group transactions by type and date
        $transact = $user->transaction()
            ->select(
                DB::raw('DATE(created_at) as date'),
                'type',
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('type', DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'), 'asc')
            ->get();

        $alignedSavings = $transact->where('type', 'save')->pluck('total_amount');
        $alignedInvestments = $transact->where('type', 'invest')->pluck('total_amount');
        $alignedTrading = $transact->where('type', 'trade')->pluck('total_amount');
        $dates = $transact->pluck('date')->unique()->values();

        $transaction = $user->transaction(); 

        // Pass data to the view
        return view('user_.wallet.index', [
            'title' => 'Wallets',
            'setting' => Setting::all()->first(),
            'transactions' => $transaction->latest()->paginate(10),
            'ledgerBalance' => $user->investments()->where('status', 'active')->sum('total_return'),
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
            'locked' => $lockedFunds,
            'wallet' => $availableCash,
            'cash' => $wallet->balance,
            'dates' => $dates,
            'alignedSavings' => $alignedSavings->values(),
            'alignedInvestments' => $alignedInvestments->values(),
            'alignedTrading' => $alignedTrading->values(),
            'lockedFunds' => $lockedFunds,
            'performance' => $netGains - $availableCash,
            'performancePer' => $performancePercentage,
        ]);
    }

    public function depo()
    {
        $setting = Setting::all()->first();

        $user = auth()->user();

        return view('user_.wallet.deposit', ['setting' => $setting, 'user' => $user]);
    }

    public function deposit(Request $request)
    {
        // dd($request->all());

        // Check logic
        if($request->logic !== 'deposit') {
            return back()->with('error', 'Wrong method initiated!');
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0', 'min:10'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $type = 'credit';
        $user = auth()->user();
        $status = 'pending';
        $amount = $request->amount;

        // Check method
        if($request->method && $request->method == 'coin') {
            //Crypto Variables
            $coin = AccountCoin::find($request->coin);
            if ($coin) {
                $method = $request->method;
                $currency = $coin->symbol ?? 'null';
                $proof = null;
                $swift = null;
                $delivering = null;
                $account = null;
                $time = null;
                $value = $request->coinvalue;
            } else {
                return back()->withErrors($validator)->withInput()->with('error', 'Invalid Coin or Network, Try again later');
            }
        } elseif($request->method && $request->method == 'bank') {
            $validator = Validator::make($request->all(), [
                'filepond' => 'required',
                'filepond.*' => 'file|mimes:jpeg,png,jpg,gif,svg|max:3072', // Max 3MB, adjust as needed
            ]);
            if ($validator->fails()){
                return back()->withErrors($validator)->withInput()->with('error', 'Upload a bank transfer proof!');
            }

            $proof = null;

            if ($request->filepond) {
                $fileData = $request->input('filepond'); // Retrieve the base64 data
                $fileInfo = json_decode($fileData, true);
                $imageData = $fileInfo['data']; // This contains the base64 image content
                $imageContent = base64_decode($imageData);

                $fileExtension = pathinfo($fileInfo['name'], PATHINFO_EXTENSION); // Extract extension
                $fileName = time() . '-' . date('YmdHis') . '.' . $fileExtension; // Generate unique name
                $path = 'uploads/' . $fileName;

                if (!File::exists(public_path('uploads'))) {
                    File::makeDirectory(public_path('uploads'), 0755, true);
                }

                file_put_contents(public_path($path), $imageContent);

                $proof = $path;
            }

            //Bank Variables
            $method = $request->method;
            $currency = 'USD';
            $swift = $request->swift;
            $delivering = $request->delivering;
            $account = $request->account;
            $time = $request->time;
            $value = 1;
        }

        // Create deposit
        $user->wallet->deposit()->create([
            'amount' => $amount,
            'type' => $type,
            'method' => $method,
            'currency' => $currency,
            'proof' => $proof,
            'swift' => $swift,
            'delivering' => $delivering,
            'account' => $account,
            'time' => $time,
            'value' => $value,
            'status' => $status,
        ]);

        //Create Transaction
        $transaction = $user->transaction('invest')->create([
            'amount' => $request->amount,
            'data_id' => 0,
            'type' => 'wallet',
            'status' => 'pending',
            'description' => 'User Deposit',
            'method' => 'credit'
        ]);

        if ($transaction) {
            NotificationController::sendDepositQueuedNotification($transaction);
            // return redirect()->route('wallet')->with('success', 'Deposit queued successfully');
            return redirect()->route('transactions.history')->with('success', 'Deposit queued successfully');
        }
        return redirect()->route('wallet')->with('error', 'Error processing deposit');
    }

    public function walletSwap(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        // Validate request with improved rules
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'from_account' => ['required', 'in:invest,save,trade,wallet'],
            'to_account' => ['required', 'in:invest,save,trade,wallet'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $amount = $request->input('amount');
        $fromAccount = $request->input('from_account');
        $toAccount = $request->input('to_account');

        // Ensure from_account and to_account are different
        if ($fromAccount === $toAccount) {
            return back()->withInput()->with('error', 'Source and destination accounts must be different');
        }

        // Calculate balance from the ledger for the appropriate account
        $fromWalletBalance = $user->wallet->getAccountBalance($user->wallet, $fromAccount);

        // Check if the user has enough balance in the source account
        if ($fromWalletBalance < $amount) {
            return back()->withInput()->with('error', 'Insufficient balance in the source account');
        }

        // Start transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Debit the source account via ledger
            Ledger::debit($user->wallet, $amount, $fromAccount, null, 'Transfer to ' . $toAccount);

            // Credit the destination account via ledger
            Ledger::credit($user->wallet, $amount, $toAccount, null, 'Transfer from ' . $fromAccount);

            $transaction = $user->transaction('wallet')->create([
                'amount' => $amount,
                'data_id' => 0,
                'type' => 'wallet',
                'status' => 'approved',
                'description' => "Transfer from $fromAccount to $toAccount",
                'method' => 'credit'
            ]);

            // Commit the transaction
            DB::commit();

            $accountNames = [
                'invest' => 'Investment',
                'save' => 'Savings',
                'trade' => 'Trading',
                'wallet' => 'Wallet',
            ];

            NotificationController::sendTransferSuccessfulNotification($transaction, $accountNames[$fromAccount], $accountNames[$toAccount]);

            return back()->with('success', 'Transfer was made successfully');

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Optionally log the error for debugging
            Log::error('Wallet transfer failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'An error occurred during the transfer');
        }
    }

    public function walletReset()
    {
        $user = auth()->user();
        $wallet = $user->wallet;

        // Helper function to calculate balance for a given account
        $calculateBalance = function ($account) use ($wallet) {
            $credits = $wallet->ledgerEntries()->where('account', $account)->where('type', 'credit')->sum('amount') ?? 0;
            $debits = $wallet->ledgerEntries()->where('account', $account)->where('type', 'debit')->sum('amount') ?? 0;
            return $credits - $debits;
        };

        // Calculate balances for each account
        $updateData = [
            'balance' => $calculateBalance('balance'),
            'invest'  => $calculateBalance('invest'),
            'save'    => $calculateBalance('save'),
            'trade'   => $calculateBalance('trade'),
        ];

        // Update the wallet
        $wallet->update($updateData);

        return response()->json(['wallet' => $wallet]);
    }






















    public function login()
    {
        $API_Key = env('MONNIFY_API_KEY');
        $Secret_Key = env('MONNIFY_SECRET_KEY');
        $ch = curl_init();
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic '. base64_encode($API_Key . ":" . $Secret_Key)
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, env('MONNIFY_BASE_URL') . "/api/v1/auth/login");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close($ch);
        $json = json_decode($output, true);

        $token = $json['responseBody']['accessToken'];

        return $token;
    }

    public function reserveAccount() 
    {
        $user = auth()->user();
        $accessToken = $this->login();
        $ref = str_replace([':', '-', ' '], '', now()->timezone('Africa/Lagos')->toDateTimeString());
        
        return Http::withHeaders(['Authorization' => "Bearer $accessToken", 'Content-Type' => 'application/json'])
            ->post(env('MONNIFY_BASE_URL').'/api/v2/bank-transfer/reserved-accounts', [
                'accountReference' => $ref,
                'accountName' => "{$user['name']} - monnify",
                'currencyCode' => 'NGN',
                'contractCode' => env('MONNIFY_CONTRACT_CODE'),
                'restrictPaymentSource' => false,
                'customerEmail' => $user['email'],
                'customerName' => "{$user['name']}",
                'getAllAvailableBanks' => true,
                'preferredBanks' => ['035'],
            ])
            ->json();
    }

    public function generateVirtualAccount()
    {
        $user = auth()->user();
        $account = $this->reserveAccount();
        if (! isset($account['requestSuccessful'])) {
            throw new BadRequestException($account['responseMessage'], 400);
        }
        if (! $account['requestSuccessful']) {
            throw new BadRequestException('Error generating account number. Please login again', 400);
        }
        $bankDetails = $account['responseBody']['accounts'][0];

        $virtualAccount = [
            'bank_name' => $bankDetails['bankName'],
            'account_name' => $bankDetails['accountName'],
            'account_number' => $bankDetails['accountNumber'],
            'bank_code' => $bankDetails['bankCode'],
            'account_reference' => $account['responseBody']['accountReference'],
            'customer_name' => $user['name'],
        ];

        $user->update(['virtual_account' => $virtualAccount]);

        return back()->with('success', 'Virtual Account created successfully');
    }

    

    public function getWalletBalance(Request $request)
    {
        $user = auth()->user();
        $account = $request->query('account');

        $balance = 0;
        if ($account === 'save') {
            $balance = $user->wallet->getAccountBalance($user->wallet, 'save');
        } elseif ($account === 'invest') {
            $balance = $user->wallet->getAccountBalance($user->wallet, 'invest');
        } elseif ($account === 'trade') {
            $balance = $user->wallet->getAccountBalance($user->wallet, 'trade');
        } elseif ($account === 'wallet') {
            $balance = $user->wallet->getAccountBalance($user->wallet, 'wallet');
        }

        // dd($balance);

        return response()->json(['balance' => $balance]);
    }


}
