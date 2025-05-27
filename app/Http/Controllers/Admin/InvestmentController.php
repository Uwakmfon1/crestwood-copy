<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Package;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Services\NotificationService;
use App\Services\Admin\InvestmentService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;

class InvestmentController extends Controller
{
    public function __construct(
        public TransactionService $transactionService,
        public NotificationService $notificationService,
        public InvestmentService $investmentService,
    ){}

    public function index()
    {
        return view('admin.investment.index', ['type' => \request('type') ?? 'all']);
    }

    public function show(Investment $investment)
    {
        return view('admin.investment.show', ['investment' => $investment, 'packages' => Package::where('investment', 'enabled')->get()]);
    }

    public function invest(User $user)
    {
        return view('admin.user.investment.add', ['packages' => Package::where('investment', 'enabled')->get(), 'user' => $user]);
    }

    public function store(Request $request)
    {
        return $this->investmentService->store($request);
    }

    public function showUserInvestment(User $user, Investment $investment)
    {
        return $this->investmentService->showUserInvestment($user, $investment);
    }
    
    public function fetchInvestmentsWithAjax(Request $request, $type)
    {
            return $this->investmentService->fetchInvestmentsWithAjax($request,$type);
    }
}