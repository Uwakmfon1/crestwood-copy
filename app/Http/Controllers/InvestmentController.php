<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Investment;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $investments = $user->investments()->latest();

        $balance = $user->wallet->invest;
        
        $active_savings = $investments->where('status', 'active')->count();
        $completed_savings = $investments->where('status', 'settled')->count();

        $total_amount = $user->investments()->sum('amount');
        $total_invest = $user->investments()->sum('total_return');

        $transactions = $user->transaction('invest')
        ->selectRaw('DATE(created_at) as date, SUM(amount) as total_amount')
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        $dates = $transactions->pluck('date')->toArray();  // Extract dates
        $totals = $transactions->pluck('total_amount')->toArray(); 

        $totalCredits = Investment::where('user_id', $user->id)
        ->with(['investmentTransaction' => function ($query) {
            $query->where('type', 'credit'); // Filter by type 'credit'
        }])
        ->get()
        ->pluck('investmentTransaction') // Get all related transactions
        ->flatten() // Flatten the collection of arrays into a single collection
        ->sum('amount'); // Sum the 'amount' field

        return view('user_.investment.index', [
            'title' => 'Investments', 
            'investments' => $user->investments()->latest()->get(), 
            'balance' => $balance, 
            'asv' => $active_savings, 
            'csv' => $completed_savings,
            'total_amount' => $total_amount,
            'total_invest' => $total_invest,
            'dates' => $dates,
            'totals' => $totals,
            'profit' => $totalCredits
        ]);
    }

    public function show(Investment $investment)
    {
        $transaction = $investment->investmentTransaction()->get();

        return view('user_.investment.show', [
            'title' => 'Investment', 
            'investment' => $investment, 
            'packages' => Package::where('investment', 'enabled')->get(),
            'transactions' => $transaction,
        ]);
    }

    public function history(Request $request)
    {
        $query = auth()->user()->investments();

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

    public function invest($packageName)
    {
        $package = Package::where('name', $packageName)->firstOrFail(); // Find the package by its name

        return view('user_.investment.create', [
            'title' => 'Invest', 
            'setting' => Setting::all()->first(), 
            'package' => $package,
            'packages' => Package::where('investment', 'enabled')->get()
        ]);
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'amount' => ['required', 'numeric', 'min:1', 'integer'],
            'roi_method' => ['required'],
            'roi_duration' => ['required'],
        ]);

        $user = auth()->user();

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

        if (!$user->wallet->sufficentAccountBalance($request->amount, 'invest')){
            return back()->with('error', 'Insufficient investment balance!');
        }

        // Create Investment
        $investment = $user->investments()->create([
            'package_id'=>$package['id'], 
            'amount' => $request->amount,
            'roi_duration' => $request->roi_method . '_' . $request->roi_duration,
            'total_return' => (($package['roi'] * $request->amount) / 100) + $request->amount ,
            'return_date' => now()->addMonths($request->roi_method)->format('Y-m-d H:i:s'), 
            'status' => 'active'
        ]);

        //Create Transaction
        $transaction = $user->transaction('invest')->create([
            'amount' => $request->amount,
            'data_id' => $investment->id,
            'status' => 'approved',
            'description' => 'Investment...',
            'method' => 'debit'
        ]);

        //Create Investment Transaction
        $transaction = $investment->investmentTransaction()->create([
            'amount' => $request->amount,
            'type' => 'debit',
            'status' => 'success',
        ]);

        // ::::: Store Ledger :::::: //
        try {
            Ledger::debit($user->wallet, $request->amount, 'invest', null, 'Investment in package');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }
        // ::::: Store Ledger :::::: //

        if($transaction) 
            NotificationController::sendInvestmentCreatedNotification($investment);
        
            return redirect()->route('investments')->with('success', 'Investment created successfully');

        return back()->withInput()->with('error', 'Error processing investment');
    }

    public function storeProfit(Investment $investment): \Illuminate\Http\RedirectResponse
    {
        $user = auth()->user();

        $package = Package::all()->where('id', $investment['package_id'])->first();
        $amount = (($package->roi / 100) * $investment->amount);

        //Create Transaction
        $transaction = $user->transaction('invest')->create([
            'amount' => $amount,
            'data_id' => $investment->id,
            'status' => 'approved',
            'description' => 'Investment profit on ' . $package->name,
            'method' => 'credit'
        ]);

        //Create Investment Transaction
        $transaction = $investment->investmentTransaction()->create([
            'amount' => $amount,
            'type' => 'credit',
            'status' => 'success',
        ]);

        // ::::: Store Ledger :::::: //
        try {
            Ledger::credit($user->wallet, $amount, 'invest', null, 'Investment profit on ' . $package->name);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }
        // ::::: Store Ledger :::::: //

        dd($transaction);

        // if($transaction) 
            // if ($investment['status'] == 'active'){
            //     NotificationController::sendInvestmentCreatedNotification($investment);
            // }else{
            //     NotificationController::sendInvestmentQueuedNotification($investment);
            // }
            // return redirect()->route('investments')->with('success', 'Investment created successfully');

        // return back()->withInput()->with('error', 'Error processing investment');
    }
}
