<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\Validator;

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

        // Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'from_account' => ['required'],
            'to_account' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        if($request['to_account'] == 'investment') {

            $user->investmentWallet->increment('balance', $request['amount']);

        } elseif($request['to_account'] == 'savings') {

            $user->savingsWallet->increment('balance', $request['amount']);
            
        } elseif($request['to_account'] == 'trading') {

            $user->tradingWallet->increment('balance', $request['amount']);

        } else {
            return back()->withInput()->with('error', 'Invalid account method');
        }

        if($request['from_account'] == 'investment') {

            $user->investmentWallet->decrement('balance', $request['amount']);

        } elseif($request['from_account'] == 'savings') {

            $user->savingsWallet->decrement('balance', $request['amount']);
            
        } elseif($request['from_account'] == 'trading') {

            $user->tradingWallet->decrement('balance', $request['amount']);

        } elseif($request['from_account'] == 'wallet') {

            $user->wallet->decrement('balance', $request['amount']);

        } else {
            return back()->withInput()->with('error', 'Invalid account method');
        }

        $transaction = $user->wallet->walletTransactions()->create([
            'user_id' => $user->id,
            'amount' => $request['amount'],
            'account_type' => 'wallet',
            'type' => 'deposit',
            'description' => 'Credit transaction from ' . $request['from_account'] .' to '. $request['to_account'],
            'method' => 'wallet',
            'status' => 'approved'
        ]);

        if ($transaction) {
            // NotificationController::sendDepositSuccessfulNotification($transaction);
            // return redirect()->route('admin.users.show', $user['id'])->with('success', 'Top up was made successfully');
            return back()->with('success', 'Transfer was made successfully');
        }
        return redirect()->route('admin.users.show', $user['id'])->with('error', 'Error processing deposit');
    }
}
