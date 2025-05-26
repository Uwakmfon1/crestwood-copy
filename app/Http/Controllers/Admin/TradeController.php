<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Services\TransactionService;
use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Services\NotificationService;
use App\Services\Admin\TradeService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class TradeController extends Controller
{
    public function __construct(
        public TransactionService $transactionService,
        public NotificationService $notificationService,
        public TradeService $tradeService
        ){ }
    public function index()
    {
        return $this->tradeService->index();
    }
   
    public function buy(User $user)
    {
        return $this->tradeService->buy($user);        
    }

    public function sell(User $user)
    {
        return $this->tradeService->sell($user); 
    }

    public function buyStore(Request $request): RedirectResponse
    {
        return $this->tradeService->buyStore($request);       
    }

    public function sellStore(Request $request)
    {
        return $this->tradeService->sellStore($request);
    }

    public function fetchTradesWithAjax(Request $request, $type)
    {
        return $this->tradeService->fetchTradesWithAjax($request,$type);
    }
}