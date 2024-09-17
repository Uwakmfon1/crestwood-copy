<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class WalletController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $virtualAccount = json_decode($user['virtual_account'], true);

        $savings = auth()->user()->savingsWalletBalance();
        $investment = auth()->user()->investmentWalletBalance();
        $trading = auth()->user()->tradingWalletBalance();
        $wallet = auth()->user()->portfolioBalance();

        $ledgerBalance = $user->investments()->where('status', 'active')->sum('total_return');
        $transactions = $user->walletsTransactions(); 

        $availableCash = ($wallet + ($savings + $investment + $trading));

        return view('user_.wallet.index', [ 
            'title', 
            'Wallets', 
            'setting' => Setting::all()->first(), 
            'transactions' => $transactions->latest()->paginate(10),
            'virtualAccount' => $virtualAccount, 
            'ledgerBalance' => $ledgerBalance,
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
            'wallet' => $availableCash,
            'cash' => $wallet,
        ]);
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

    public function walletSwap(Request $request): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        // Validate request with improved rules
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'from_account' => ['required', 'in:investment,savings,trading,wallet'],
            'to_account' => ['required', 'in:investment,savings,trading'],
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

        // Get current balance from the appropriate method based on the from_account
        switch ($fromAccount) {
            case 'savings':
                $fromWalletBalance = $user->savingsWalletBalance();
                break;
            case 'investment':
                $fromWalletBalance = $user->investmentWalletBalance();
                break;
            case 'trading':
                $fromWalletBalance = $user->tradingWalletBalance();
                break;
            case 'wallet':
                $fromWalletBalance = $user->portfolioBalance();
                break;
            default:
                return back()->withInput()->with('error', 'Invalid source account');
        }

        // Check if the user has enough balance in the source account
        if ($fromWalletBalance < $amount) {
            return back()->withInput()->with('error', 'Insufficient balance in the source account');
        }

        // Start transaction to ensure atomicity
        DB::beginTransaction();
        try {
            // Increment the balance of the destination account
            switch ($toAccount) {
                case 'savings':
                    $user->savingsWallet->increment('balance', $amount);
                    break;
                case 'investment':
                    $user->investmentWallet->increment('balance', $amount);
                    break;
                case 'trading':
                    $user->tradingWallet->increment('balance', $amount);
                    break;
                default:
                    return back()->withInput()->with('error', 'Invalid destination account');
            }

            // Decrement the balance of the source account
            switch ($fromAccount) {
                case 'savings':
                    $user->savingsWallet->decrement('balance', $amount);
                    break;
                case 'investment':
                    $user->investmentWallet->decrement('balance', $amount);
                    break;
                case 'trading':
                    $user->tradingWallet->decrement('balance', $amount);
                    break;
                case 'wallet':
                    $user->wallet->decrement('balance', $amount);
                    break;
            }

            // Log the transaction
            $transaction = $user->wallet->walletTransactions()->create([
                'user_id' => $user->id,
                'amount' => $amount,
                'account_type' => $toAccount,
                'type' => 'deposit',
                'description' => 'Transferred from ' . ucfirst($fromAccount) .' to '. ucfirst($toAccount),
                'method' => 'wallet',
                'status' => 'approved',
            ]);

            // If everything is fine, commit the transaction
            DB::commit();

            return back()->with('success', 'Transfer was made successfully');

        } catch (\Exception $e) {
            // Rollback the transaction if something goes wrong
            DB::rollBack();

            // Optionally log the error for debugging
            Log::error('Wallet transfer failed: ' . $e->getMessage());

            return back()->withInput()->with('error', 'An error occurred during the transfer');
        }
    }

    public function getWalletBalance(Request $request)
    {
        $user = auth()->user();
        $account = $request->query('account');

        $balance = 0;
        if ($account === 'savings') {
            $balance = $user->savingsWalletBalance();
        } elseif ($account === 'investment') {
            $balance = $user->investmentWalletBalance();
        } elseif ($account === 'trading') {
            $balance = $user->tradingWalletBalance();
        } elseif ($account === 'wallet') {
            $balance = $user->portfolioBalance();
        }

        return response()->json(['balance' => $balance]);
    }


}
