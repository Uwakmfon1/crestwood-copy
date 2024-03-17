<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function index()
    {
        $savings = auth()->user()->savings()->latest();
        switch (true){
            case \request()->offsetExists('active'):
                $savings = $savings->where('status', 'active');
                break;
            case \request()->offsetExists('pending'):
                $savings = $savings->where('status', 'pending');
                break;
            case \request()->offsetExists('cancelled'):
                $savings = $savings->where('status', 'cancelled');
                break;
            case \request()->offsetExists('settled'):
                $savings = $savings->where('status', 'settled');
                break;
        }

        return view('user.savings.index', ['title' => 'Savings', 'savings' => $savings->get()]);
    }
    public function packages()
    {
        return view('user.savings.packages.index', ['title' => 'Packages', 'packages' => SavingPackage::all()]);
    }

    public function create()
    {
        return view('user.savings.create', ['title' => 'Save', 'setting' => Setting::all()->first(), 'packages' => SavingPackage::all()]);
    }

    public function show(Saving $savings)
    {
        $paid = $savings->transaction()->where('status', 'approved')->count();

        return view('user.savings.show', ['title' => 'Savings', 'investment' => $savings, 'packages' => SavingPackage::all(), 'paid' => $paid]);
    }

    // Savings

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1', 'integer'],
            'milestone' => ['required', 'numeric', 'integer'],
            'payment' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        //        Check if investment is allowed
        if (Setting::all()->first()['save'] == 0){
            return back()->with('error', 'Investment in packages is currently unavailable, check back later');
        }
        //        Find package and check if investment is enabled
        $package = SavingPackage::all()->where('name', $request['package'])->first();
        // if (!($package && $package->canRunInvestment())){
        //     return back()->with('error', 'Can\'t process investment, package not found or disabled');
        // }
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

        if ($package['duration'] == 'monthly') {
            $returnDate = now()->addMonths($request['milestone'])->format('Y-m-d H:i:s');
        } elseif($package['duration'] == 'weekly') {
            $returnDate = now()->addWeeks($request['milestone'])->format('Y-m-d H:i:s');
        } else {
            $returnDate = now()->addDays($request['milestone'])->format('Y-m-d H:i:s');
        }

//        Create Investment
        $savings = auth()->user()->savings()->create([
            'savings_package_id'=>$package['id'], 
            'duration' => $package['duration'], 
            'amount' => $request['slots'] * $package['price'],
            'total_return' => $request['milestone'] * $package['price'] * (( 100 + $package['roi'] ) / 100 ),
            'savings_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => $returnDate, 
            'status' => $status
        ]);


        if ($savings) {
            TransactionController::storeSavingTransaction($savings, $request['payment'], 'savings');
            // if ($savings['status'] == 'active'){
            //     NotificationController::sendInvestmentCreatedNotification($savings);
            // }else{
            //     NotificationController::sendInvestmentQueuedNotification($savings);
            // }
            return redirect()->route('savings')->with('success', $msg);
        }
        return back()->withInput()->with('error', 'Error processing investment');
    }

    public function makePayment(Saving $savings) : \Illuminate\Http\RedirectResponse
    {
        if (!auth()->user()->hasSufficientBalanceForTransaction($savings['amount'])){
            return back()->withInput()->with('error', 'Insufficient wallet balance ❌');
        } else {
                TransactionController::storeSavingTransaction($savings, 'wallet', 'savings');

                auth()->user()->nairaWallet()->decrement('balance', $savings['amount']);

            return back()->withInput()->with('success', 'Savings Updated ✅');
        }
    }

    public function settlePayment(Saving $savings) 
    {
        $paid = $savings->transaction()->where('status', 'approved')->count();
        $package = $savings->package()->get();

        $milestone = $package[0]['milestone'];
        $roi = $package[0]['roi'];
        $total_amount = $savings['amount'] * $paid;
        $total_roi = (($savings['amount']) * ($roi/100)) * $paid;
        $amount_paid = $total_amount + $total_roi;

        if ($savings && $paid == $milestone)
        {
            TransactionController::storeSavingTransaction($savings, 'wallet', 'savings');

            auth()->user()->nairaWallet()->increment('balance', $amount_paid);

            auth()->user()->savings()->update(['status' => 'settled']);

            return back()->withInput()->with('success', 'Wallet Credited ✅');
            
        } else {

            return back()->withInput()->with('error', 'Incomplete Savings');

        }
    }
}
