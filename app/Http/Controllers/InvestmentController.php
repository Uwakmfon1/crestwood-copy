<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function index()
    {
        $investments = auth()->user()->investments()->latest();
        switch (true){
            case \request()->offsetExists('active'):
                $investments = $investments->where('status', 'active');
                break;
            case \request()->offsetExists('pending'):
                $investments = $investments->where('status', 'pending');
                break;
            case \request()->offsetExists('cancelled'):
                $investments = $investments->where('status', 'cancelled');
                break;
            case \request()->offsetExists('settled'):
                $investments = $investments->where('status', 'settled');
                break;
        }

        $balance = auth()->user()->investmentWalletBalance();
        
        $active_savings = $investments->where('status', 'active')->count();
        $completed_savings = $investments->where('status', 'settled')->count();

        return view('user_.investment.index', ['title' => 'Investments', 'investments' => auth()->user()->investments()->latest()->get(), 'balance' => $balance, 'asv' => $active_savings, 'csv' => $completed_savings]);
    }

    public function show(Investment $investment)
    {
        return view('user_.investment.show', ['title' => 'Investment', 'investment' => $investment, 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function invest()
    {
        return view('user_.investment.create', ['title' => 'Invest', 'setting' => Setting::all()->first(), 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1', 'integer'],
        ]);
        $payment = 'wallet'; // $request['payment']

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        if (Setting::all()->first()['invest'] == 0){
            return back()->with('error', 'Investment in packages is currently unavailable, check back later');
        }
        $package = Package::all()->where('id', $request['package'])->first();

        if (!($package && $package->canRunInvestment())){
            return back()->with('error', 'Can\'t process investment, package not found or disabled');
        }

        $amount = $request['slots'] * $package['price'];

        switch ($payment){
            case 'wallet':
                if (!auth()->user()->hasSufficientBalance($amount, 'investment')){
                    return back()->withInput()->with('error', 'Insufficient investment balance');
                }
                auth()->user()->investmentWallet->decrement('balance', $amount);
                $status = 'active';
                $msg = 'Investment created successfully';
                break;
            case 'deposit':
                $status = 'pending';
                $msg = 'Investment queued successfully';
                break;
            case 'card':
                $data = ['type' => 'investment', 'package' => $package, 'slots' => $request['slots']];
                return PaymentController::initializeOnlineTransaction($request['slots'] * $package['price'], $data);
            default:
                return back()->withInput()->with('error', 'Invalid payment method');
        }
//        Create Investment
        $investment = auth()->user()->investments()->create([
            'package_id'=>$package['id'], 
            'slots' => $request['slots'], 
            'amount' => $amount,
            'total_return' => $amount * (( 100 + $package['roi'] ) / 100 ),
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => $status
        ]);

        $investment->investmentTransactions()->create(
            [
                'user_id' => auth()->user()->id,
                'amount' => $amount, 
                'type' => 'withdrawal',
                'account_type' => 'investment',
                'description' => 'Invested into ' . $package['name'],
                'method' => 'wallet',
                'status' => 'approved'
            ]
        );

        if ($investment) {
            TransactionController::storeInvestmentTransaction($investment, $request['payment'], 'investment');
            if ($investment['status'] == 'active'){
                NotificationController::sendInvestmentCreatedNotification($investment);
            }else{
                NotificationController::sendInvestmentQueuedNotification($investment);
            }
            return redirect()->route('investments')->with('success', $msg);
        }
        return back()->withInput()->with('error', 'Error processing investment');
    }
}
