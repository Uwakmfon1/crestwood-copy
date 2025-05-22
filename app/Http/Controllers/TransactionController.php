<?php

namespace App\Http\Controllers;

use App\Models\SavingTransaction;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;
use App\Services\TransactionService;

use HenryEjemuta\LaravelMonnify\Facades\Monnify;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyTransaction;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethod;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethods;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyIncomeSplitConfig;
use HenryEjemuta\LaravelMonnify\Exceptions\MonnifyFailedRequestException;


class TransactionController extends Controller
{
    public function __construct(public TransactionService $transactionService) {    }

    public function index(){return $this->transactionService->index();    }
   
    public function history(Request $request){ return $this->transactionService->history($request);}
   
    public function deposit(Request $request) { return $this->transactionService->deposit($request);} 

    public function withdraw(Request $request){ return $this->transactionService->withdraw($request);}
    
    public function storeInvestmentTransaction($investment, $method, $byCompany = false, $channel = 'web')
    {
        return $this->transactionService->storeInvestmentTransaction($investment, $method, $byCompany = false, $channel = 'web');
    }

    public function storeTradeTransaction($trade, $method, $byCompany = false, $channel = 'web')
    {
        return $this->transactionService->storeTradeTransaction($trade, $method, $byCompany = false, $channel = 'web');
    }
 
    public function storeSavingTransaction($saving, $amount, $method, $type, $desc, $saving_id, $channel = 'web')
    {
        return $this->transactionService->storeSavingTransaction($saving, $amount, $method, $type, $desc, $saving_id, $channel = 'web');
    }
}
