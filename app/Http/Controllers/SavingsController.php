<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Saving;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function index()
    {
        $savings = auth()->user()->savings()->latest();

        $active_savings = $savings->where('status', 'active')->count();
        $completed_savings = $savings->where('status', 'settled')->count();

        $balance = auth()->user()->savingsWalletBalance();

        return view('user_.savings.index', ['title' => 'Savings', 'savings' => auth()->user()->savings()->latest()->get(), 'balance' => $balance, 'asv' => $active_savings, 'csv' => $completed_savings]);
    }
    public function packages()
    {
        return view('user.savings.packages.index', ['title' => 'Packages', 'packages' => SavingPackage::all()]);
    }

    public function create()
    {
        return view('user_.savings.create', ['title' => 'Save', 'setting' => Setting::all()->first(), 'packages' => SavingPackage::all()]);
    }

    public function show(Saving $savings)
    {
        $paid = $savings->transaction()->where('status', 'approved')->count();

        // Generate dates for the progress report (for example, daily progress)
        $progressDates = [];
        $progressAmounts = [];

        $currentAmount = $savings->deposit;
        $contributionPerDay = $savings->contribution / 30; // assuming 30 days in a month for simplicity

        $startDate = \Carbon\Carbon::parse($savings->savings_date);
        $endDate = \Carbon\Carbon::parse($savings->return_date);

        while ($startDate <= $endDate) {
            $progressDates[] = $startDate->format('Y-m-d');
            $progressAmounts[] = $currentAmount;

            // Add the daily contribution to the current amount
            $currentAmount += $contributionPerDay;

            // Move to the next day
            $startDate->addDay();
        }

        return view('user_.savings.show', [
            'title' => 'Savings', 
            'savings' => $savings, 
            'packages' => SavingPackage::all(), 
            'paid' => $paid, 
            'progressDates' => $progressDates,
            'progressAmounts' => $progressAmounts,
        ]);
    }

    public function save(Request $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the request
        $validated = $request->validate([
            'timeframe' => 'required|in:weekly,monthly,daily,yearly',
            'duration' => 'required',
            'roi' => 'required|numeric',
            'deposit' => 'required|numeric|min:0',
            'contribution' => 'required|numeric|min:0',
        ]);

        // Extract and prepare data
        $user_id = Auth::id();
        $savings_date = Carbon::now();
        $durationInDays = $this->calculateDurationInDays($validated['duration']);
        $return_date = $savings_date->copy()->addDays($durationInDays);

        // Calculate total contributions based on the timeframe and duration
        $total_contributions = $this->calculateTotalContributions(
            $validated['timeframe'], 
            $validated['contribution'], 
            $durationInDays
        );

        // Calculate total return
        $total_return = ($validated['deposit'] + $total_contributions) * (1 + ($validated['roi'] / 100));

        // Create the savings record
        $savings = Saving::create([
            'user_id' => $user_id,
            'timeframe' => $validated['timeframe'],
            'duration' => $validated['duration'],
            'roi' => $validated['roi'],
            'deposit' => $validated['deposit'],
            'contribution' => $validated['contribution'],
            'total_return' => $total_return,
            'savings_date' => $savings_date,
            'return_date' => $return_date,
            'status' => 'active',
        ]);

        // Optionally schedule contributions (if needed)
        $this->scheduleContributions($savings);

        return redirect()->route('savings')->with('success', 'Savings plan created successfully.');
    }

    private function calculateDurationInDays(string $duration): int
    {
        switch ($duration) {
            case '1w':
                return 7;
            case '2w':
                return 14;
            case '4w':
                return 28;
            case '1m':
                return Carbon::now()->daysInMonth;
            case '1y':
                return 365;
            default:
                return 30; // Default to 1 month (30 days)
        }
    }

    private function calculateTotalContributions(string $timeframe, float $contribution, int $durationInDays): float
    {
        switch ($timeframe) {
            case 'daily':
                return $contribution * $durationInDays;
            case 'weekly':
                return $contribution * ($durationInDays / 7);
            case 'monthly':
                return $contribution * ($durationInDays / 30);
            case 'yearly':
                return $contribution * ($durationInDays / 365);
            default:
                return 0.0;
        }
    }


    private function scheduleContributions(Saving $savings)
    {
        // Implement scheduling logic if needed
    }

    //Create Savings
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'package' => ['required'],
            'slots' => ['required', 'numeric', 'min:1', 'integer'],
            'milestone' => ['required', 'numeric', 'integer'],
            'duration' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        
        $payment = 'wallet'; // $request['payment']

        if (Setting::all()->first()['save'] == 0){
            return back()->with('error', 'Savings in packages is currently unavailable, check back later');
        }

        $package = SavingPackage::all()->where('id', $request['package'])->first();

        $amount = $request['slots'] * $package['price'];
        
        switch ($payment){
            case 'wallet':
                if (!auth()->user()->hasSufficientBalance($amount, 'savings')){
                    return back()->withInput()->with('error', 'Insufficient savings balance');
                }
                auth()->user()->savingsWallet->decrement('balance', $amount);
                $status = 'active';
                $msg = 'Savings created successfully';
                break;
            case 'deposit':
                $status = 'pending';
                $msg = 'Savings queued successfully';
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

        $totalReturn = ($amount * $request['milestone']) + (($amount / $package['roi']) * $request['milestone']);

        $savings = auth()->user()->savings()->create([
            'savings_package_id'=>$package['id'], 
            'duration' => $request['duration'], 
            'milestone' => $request['milestone'], 
            'amount' => $amount,
            'slot' =>  $request['slots'],
            'total_return' => $totalReturn,
            'savings_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => $returnDate, 
            'status' => $status
        ]);

        $savings->savingsTransactions()->create(
            [
                'user_id' => auth()->user()->id,
                'amount' => $amount, 
                'type' => 'withdrawal',
                'account_type' => 'savings',
                'description' => 'Savings into ' . $package['name'],
                'method' => 'wallet',
                'status' => 'approved'
            ]
        );

        $desc = 'Saved to '. $package['name'];

        if ($savings) {
            TransactionController::storeSavingTransaction($savings, $savings['amount'], $request['payment'], 'savings', $desc, $savings['id']);
                NotificationController::sendSavingsCreatedNotification($savings);
            return redirect()->route('savings')->with('success', $msg);
        }
        return back()->withInput()->with('error', 'Error processing investment');
    }

    public function history(Request $request)
    {
        $query = auth()->user()->savings();

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

        return view('user_.savings.history', ['title' => 'Savings History', 'investments' => $investments]);
    }
}
