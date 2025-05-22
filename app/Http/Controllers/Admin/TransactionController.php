<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Ledger;
use App\Models\Saving;
use App\Models\Transaction;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Models\WalletTransaction;
use App\Models\WalletsTransactions;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\NotificationService as AdminNotificationService;
use App\Services\Admin\TransactionService;
use App\Http\Controllers\NotificationController;

class TransactionController extends Controller
{
    public function __construct(
        public TransactionService $transactionService,
        public AdminNotificationService $adminNotificationService
        ) {}

    public function index()
    {
        return $this->transactionService->index();
    }

    public function deposit(Request $request)
    {
        return $this->transactionService->deposit($request);
    }

    public function withdraw(Request $request)
    {
        return $this->transactionService->withdraw($request);
    }

    public function approve(Transaction $transaction)
    {
        return $this->transactionService->approve($transaction);
    }

    public function decline(Transaction $transaction)
    {
        return $this->transactionService->decline($transaction);
    }   
    
    public function fetchTransactionsWithAjax(Request $request, $type)
    {
        return $this->transactionService->fetchTransactionsWithAjax($request,$type);
    }

}
