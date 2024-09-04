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

    public function history(Request $request)
    {
        $query = Investment::query();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('package', function ($q2) use ($searchTerm) {
                    $q2->where('name', 'like', '%' . $searchTerm . '%');
                })
                ->orWhere('amount', 'like', '%' . $searchTerm . '%')
                ->orWhere('total_return', 'like', '%' . $searchTerm . '%')
                ->orWhere('status', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter functionality
        if ($request->has('status')) {
            $status = $request->get('status');
            $query->where('status', $status);
        }

        $investments = $query->paginate(10);

        return view('user_.investment.history', ['title' => 'Investments History', 'investments' => $investments]);
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
            'amount' => ['required', 'numeric', 'min:1', 'integer'],
            'duration_type' => ['required'],
            'duration' => ['required'],
            'roi_method' => ['required'],
        ]);

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

        if (!auth()->user()->hasSufficientBalance($request->amount, 'investment')){
            return back()->withInput()->with('error', 'Insufficient investment balance!');
        }

        auth()->user()->investmentWallet->decrement('balance', $request->amount);

        $status = 'active';
        $msg = 'Investment created successfully';

        // Create Investment
        $investment = auth()->user()->investments()->create([
            'package_id'=>$package['id'], 
            'amount' => $request->amount,
            'duration_type' => $request->duration_type,
            'duration' => $request->duration,
            'roi_method' => $request->roi_method,
            'total_return' => $request->amount * $package['daily_roi'],
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 
            'status' => $status
        ]);

        $investment->investmentTransactions()->create(
            [
                'user_id' => auth()->user()->id,
                'amount' => $request->amount, 
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
