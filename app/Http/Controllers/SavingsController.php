<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Answer;
use App\Models\Ledger;
use App\Models\Saving;
use App\Models\Setting;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use App\Models\SavingsAnswer;
use InvalidArgumentException;
use App\Models\SaveTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function index()
    {
        $plan = [
            [
                'id' => 1,
                'name' => 'High-Yield Savings Account (HYSA)',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/54nn41qg/propel-savings_500x500.png',
                'btnText' => 'Start Savings',
                'modalId' => 'modalHYSA',
                'questions' => [
                    [
                        'question' => 'What is your primary goal for this savings account?',
                        'answers' => [
                            'Build an emergency fund',
                            'Earn higher interest on savings',
                            'Save for future large purchases (e.g., home, car)',
                        ]
                    ],
                    [
                        'question' => 'What is your expected contribution amount?',
                        'answers' => [
                            'Less than $500/month',
                            '$500 – $1,000/month',
                            'Over $1,000/month',
                        ]
                    ],
                    [
                        'question' => 'How long do you plan to keep your savings in this account?',
                        'answers' => [
                            'Less than 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    ],
                    [
                        'question' => 'Do you need frequent access to the funds, or can they remain untouched?',
                        'answers' => [
                            'Frequent access needed',
                            'No access required for now',
                        ]
                    ],
                    [
                        'question' => 'Would you like to reinvest interest into the account or withdraw it periodically?',
                        'answers' => [
                            'Reinvest interest',
                            'Withdraw interest periodically',
                        ]
                    ]
                ]
            ],
            [
                'id' => 2,
                'name' => 'Cash Interest Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/zpfjqqui/no-fees_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalCashInterest',
                'questions' => [
                    [
                        'question' => 'What is the purpose of this cash account?',
                        'answers' => [
                            'Maintain liquidity with interest growth',
                            'Short-term cash management for upcoming expenses',
                            'Long-term capital preservation with flexible access',
                        ]
                    ],
                    [
                        'question' => 'How often do you plan to deposit funds into this account?',
                        'answers' => [
                            'Weekly',
                            'Monthly',
                            'Irregularly',
                        ]
                    ],
                    [
                        'question' => 'Do you need frequent access to these funds?',
                        'answers' => [
                            'Yes, I’ll need regular access',
                            'No, I can leave the funds untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like a portion of this account to be allocated to higher interest products?',
                        'answers' => [
                            'Yes, maximize growth on a portion of funds',
                            'No, keep everything liquid',
                        ]
                    ]
                ]
            ],
            [
                'id' => 3,
                'name' => 'Tax-Free Savings Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/a0jeky3a/cash_2024_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalTaxFree',
                'questions' => [
                    [
                        'question' => 'What is your primary goal for this tax-free savings account?',
                        'answers' => [
                            'Save for education or long-term projects',
                            'Maximize tax-free growth',
                            'Build long-term savings for retirement or specific milestones',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute each year?',
                        'answers' => [
                            'Less than $5,000',
                            '$5,000 – $10,000',
                            'Over $10,000',
                        ]
                    ],
                    [
                        'question' => 'What is your expected time horizon for this account?',
                        'answers' => [
                            'Less than 5 years',
                            '5–10 years',
                            'Over 10 years',
                        ]
                    ],
                    [
                        'question' => 'Do you prefer to reinvest all earnings into the account or withdraw them as they accumulate?',
                        'answers' => [
                            'Reinvest all earnings',
                            'Withdraw earnings periodically',
                        ]
                    ]
                ]
            ],
            [
                'id' => 4,
                'name' => 'First Home Savings Account',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/3junkeko/transfer-money-500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalFirstHome',
                'questions' => [
                    [
                        'question' => 'When do you plan to purchase your first home?',
                        'answers' => [
                            'Within 1 year',
                            '1–3 years',
                            'Over 3 years',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to save for a home down payment?',
                        'answers' => [
                            'Less than $50,000',
                            '$50,000 – $100,000',
                            'Over $100,000',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute monthly toward this goal?',
                        'answers' => [
                            'Less than $500',
                            '$500 – $1,000',
                            'Over $1,000',
                        ]
                    ],
                    [
                        'question' => 'Do you need to access these funds before reaching your savings goal?',
                        'answers' => [
                            'Yes, I may need access',
                            'No, I plan to leave the funds untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like financial advice on home-buying incentives and tax benefits?',
                        'answers' => [
                            'Yes',
                            'No',
                        ]
                    ]
                ]
            ],
            [
                'id' => 5,
                'name' => 'Corporate Accounts',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/0axfwoe2/lock-security-500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalCorporate',
                'questions' => [
                    [
                        'question' => 'What is the primary purpose of this corporate account?',
                        'answers' => [
                            'Cash flow management for operations',
                            'Capital preservation for business investments',
                            'Employee benefit funding (e.g., 401(k) or pensions)',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to deposit into this account monthly?',
                        'answers' => [
                            'Less than $10,000',
                            '$10,000 – $50,000',
                            'Over $50,000',
                        ]
                    ],
                    [
                        'question' => 'Do you require frequent access to corporate funds?',
                        'answers' => [
                            'Yes, for daily operations',
                            'No, funds can remain untouched',
                        ]
                    ],
                    [
                        'question' => 'Would you like a portion of corporate funds to be invested for long-term growth?',
                        'answers' => [
                            'Yes, allocate a portion to investments',
                            'No, keep all funds in cash reserves',
                        ]
                    ]
                ]
            ],
            [
                'id' => 6,
                'name' => 'Retirement Accounts (Roth IRA, SEP IRA, Traditional IRA)',
                'sub_name' => 'Lorem ipsum dolor sit amet consectetur, adipisicing.',
                'img' => 'https://www.oneazcu.com/media/xf5p3zer/click_desktop_500x500.webp',
                'btnText' => 'Start Savings',
                'modalId' => 'modalRetirement',
                'questions' => [
                    [
                        'question' => 'What is your goal with this Roth IRA?',
                        'answers' => [
                            'Tax-free growth for retirement',
                            'Maximize savings for long-term retirement needs',
                        ]
                    ],
                    [
                        'question' => 'How much do you plan to contribute each year?',
                        'answers' => [
                            'Less than $6,500',
                            '$6,500 – $15,000 (catch-up contributions for age 50+)',
                        ]
                    ],
                    [
                        'question' => 'When do you expect to start withdrawing from the account?',
                        'answers' => [
                            'Before age 59 ½',
                            'After age 59 ½',
                        ]
                    ],
                    [
                        'question' => 'Would you prefer automatic monthly or annual contributions?',
                        'answers' => [
                            'Monthly',
                            'Annually',
                        ]
                    ]
                ]
            ]
        ];

        $savings = auth()->user()->savings()->latest();

        $active_savings = $savings->where('status', 'active')->count();
        $completed_savings = $savings->where('status', 'settled')->count();
        $settled_savings = $savings->where('status', 'settled')->count();

        // $transactions = $savings->savingsTransactions('status', 'settled')->count();

        // $watchlistData = $user->savings()->where('type', 'crypto')->pluck('data_id');
        // $watchlist = SaveTransaction::whereIn('id', $watchlistData)->get();

        $user = auth()->user();
        $balance = $user->savings()
            ->with(['savingsTransactions' => function($query) {
                $query->where('type', 'debit')->where('status', 'success');
            }])
            ->get()
            ->pluck('savingsTransactions')
            ->flatten()
            ->sum('amount') ?? 0;

        return view('user_.savings.index', [
            'title' => 'Savings', 
            'savings' => auth()->user()->savings()->latest()->get(),
            'balance' => $balance, 
            'asv' => $active_savings, 
            'csv' => $completed_savings,
            'ssv' => $settled_savings,
            'plan' => $plan,
            'profit' => [],
        ]);
    }
    public function packages()
    {
        return view('user.savings.packages.index', ['title' => 'Packages', 'packages' => SavingPackage::all()]);
    }

    public function create()
    {
        return view('user_.savings.create', ['title' => 'Save', 'setting' => Setting::all()->first(),]);
    }

    public function show(Saving $savings)
    {
        $savingsQA = Saving::with(['plan', 'answers.question', 'answers.answer'])
            ->where('user_id', auth()->id())
            ->where('id', $savings->id)
            ->first();

        $savingPayment = $savings->savingsTransactions()->get();
        
        $total = $savings->savingsTransactions()
        // ->where('type', 'debit')
        ->where('status', 'success')
        ->sum('amount');

        $currentMonthTotal = $savings->savingsTransactions()
            ->where('type', 'debit')
            ->where('status', 'success')
            ->whereMonth('created_at', now()->month) // Filter by current month
            ->whereYear('created_at', now()->year)  // Filter by current year
            ->sum('amount');

        $lastTransactionDate = $savings->savingsTransactions()
            ->where('status', 'success') // Consider only successful transactions
            ->latest('created_at')       // Get the most recent transaction
            ->value('created_at');

        return view('user_.savings.show', [
            'title' => 'Savings', 
            'savings' => $savings, 
            'save' => $savingsQA, 
            'packages' => [], 
            'payment' => $savingPayment, 
            'total' => $total,
            'currentMonthTotal' => $currentMonthTotal,
            'lastTransactionDate' => $lastTransactionDate,
        ]);
    }

    public function questionaire ()
    {
        return view('user_.savings.start');
    }

    //Create Savings
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'answers' => 'required',
        ]);

        if ($validator->fails()) {
            // Retrieve all error messages
            $errors = $validator->errors()->all();
            
            $errorMessage = implode(', ', $errors);
            return back()->with('error', $errorMessage);
        }        
        
        $answersJson = $request->input('answers');
        $answersData = json_decode($answersJson, true);
        
        if (!$answersData) {
            return back()->withInput()->with('error', 'Invalid Data format.');
        }

        // Create Savings
        $savings = Saving::create([
            'user_id' => auth()->id(),
            'plan_id' => $request->plan_id,
            'plan_info' => $request->answers,
            'status' => 'active'
        ]);

        $savingsId = $savings->id;
        if (!$savingsId) {
            return back()->withInput()->with('error', 'Savings is required.');
        }

        // Iterate over the answers data
        foreach ($answersData as $key => $data) {
            // Get the answer_id text from the provided data
            $answerText = $data['answer_id'] ?? null;
            
            if ($answerText) {
                // Find the Answer by its text in the database
                $answer = Answer::where('text', $answerText)->first();

                if ($answer) {
                    // Create a new entry in the savings_answers table
                    SavingsAnswer::create([
                        'saving_id'  => $savingsId,
                        'question_id' => $answer->question_id,
                        'answer_id'   => $answer->id,
                    ]);
                } else {
                    // Handle the case where the answer was not found (optional)
                    return back()->withInput()->with('error', "Answer with text '{$answerText}' not found.");
                }
            }
        }

        $savingsQA = Saving::with(['plan', 'answers.question', 'answers.answer'])
            ->where('user_id', auth()->id())
            ->where('id', $savings->id)
            ->first();

        $msg = 'Savings was created successfully';

        if ($savings) {
            return redirect()->route('savings.show', $savings->id)->with('success', $msg);
        }
        return back()->withInput()->with('error', 'Error processing Savings');
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
    
    public function fetchPlan()
    {
        try {
            // Retrieve all plans from the database
            $plans = Plan::all();

            // Return response as JSON
            return response()->json([
                'status' => 'success',
                'data' => $plans
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function getPlanDetails($id)
    {
        try {
            // Fetch the plan by ID
            $plan = Plan::with('questions.answers') // Assuming there's a 'questions' relationship, and questions have 'answers'
                        ->findOrFail($id); // Fetch the plan or throw an exception if not found

            // Return the response
            return response()->json([
                'id' => $plan->id,
                'name' => $plan->name,
                'description' => $plan->description,
                'img' => $plan->img, // Assuming the plan has an 'img' attribute
                'btnText' => 'Start Savings', // Static button text, or you can modify this as needed
                'modalId' => $plan->modalId, // Dynamically generate the modal ID
                'questions' => $plan->questions->map(function ($question) {
                    return [
                        'question' => $question->text,
                        'answers' => $question->answers->pluck('text')->toArray(), // Assuming answers have an 'answer' column
                    ];
                })
            ], 200);
        } catch (\Exception $e) {
            // Handle any errors (plan not found, or any DB-related errors)
            return response()->json([
                'error' => 'Plan not found or an error occurred',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function savingsPayment(Saving $savings, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:1', 'integer'],
        ]);

        if ($validator->fails()) {
            // Retrieve all error messages
            $errors = $validator->errors()->all();
            
            $errorMessage = implode(', ', $errors);
            return back()->with('error', $errorMessage);
        }  

        $user = auth()->user();

        // ::::: Store Ledger :::::: //
        try {
            Ledger::debit($user->wallet, $request->amount, 'wallet', null, 'Savings Account');

            $user->transaction('wallet')->create([
                'amount' => $request->amount,
                'data_id' => $savings->id,
                'type' => 'wallet',
                'status' => 'approved',
                'description' => "Transfer from wallet to savings",
                'method' => 'credit'
            ]);
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }
        // ::::: Store Ledger :::::: //

        $payment = $savings->savingsTransactions()->create([
            'amount' => $request->amount,
            'type' => 'debit',
            'status' => 'success'
        ]);

        if($payment)
            return back()->with('success', "Payment of $" . $request->amount . " was made successfully");

        return back()->with('error', 'Error processing Payment');
    }

    public function savingsInterest(Saving $savings)
    {
        $user = auth()->user();

        $total = $savings->savingsTransactions()
        ->where('type', 'debit')
        ->where('status', 'success')
        ->sum('amount');

        $interest = $total * 0.08; // 8% interest

        $payment = $savings->savingsTransactions()->create([
            'amount' => $interest,
            'type' => 'credit',
            'status' => 'success',
            'is_interest' => 1,
        ]);

        return back()->with('success', 'Interest Paid!');
    }

    public function withdrawInterest(SaveTransaction $saveTransaction)
    {
        $user = auth()->user();

        // ::::: Store Ledger :::::: //
        try {
            Ledger::credit($user->wallet, $saveTransaction->amount, 'wallet', null, 'Interest Credit');
        } catch (InvalidArgumentException $e) {
            return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
        }
        // ::::: Store Ledger :::::: //

        $saveTransaction->delete();

        return back()->with('success', 'Interest Withdrawn!');
    }
}
