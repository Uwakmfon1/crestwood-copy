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
        return view('user.investment.index', ['title' => 'Investments', 'investments' => $investments->get()]);
    }

    public function show(Investment $investment)
    {
        return view('user.investment.show', ['title' => 'Investment', 'investment' => $investment, 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function invest()
    {
        return view('user.investment.add', ['title' => 'Invest', 'setting' => Setting::all()->first(), 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1', 'integer'],
            'payment' => ['required']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Check if investment is allowed
        if (Setting::all()->first()['invest'] == 0){
            return back()->with('error', 'Investment in packages is currently unavailable, check back later');
        }
//        Find package and check if investment is enabled
        $package = Package::all()->where('name', $request['package'])->first();
        if (!($package && $package->canRunInvestment())){
            return back()->with('error', 'Can\'t process investment, package not found or disabled');
        }
//        Process investment based on payment method
        switch ($request['payment']){
            case 'wallet':
                if (!auth()->user()->hasSufficientBalanceForTransaction($request['slots'] * $package['price'])){
                    return back()->withInput()->with('error', 'Insufficient wallet balance');
                }
                auth()->user()->nairaWallet()->decrement('balance', $request['slots'] * $package['price']);
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
            'package_id'=>$package['id'], 'slots' => $request['slots'], 'amount' => $request['slots'] * $package['price'],
            'total_return' => $request['slots'] * $package['price'] * (( 100 + $package['roi'] ) / 100 ),
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => $status
        ]);
        if ($investment) {
            TransactionController::storeInvestmentTransaction($investment, $request['payment']);
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
