<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Trade;
use Illuminate\Http\Request;
use App\Services\TradeService;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    public function __construct(public TradeService $tradeService){  }

    public function index(){ return $this->tradeService->index();}
    
    public function showBuyForm() {return $this->tradeService->showBuyForm(); }

    public function showSellForm(){ return $this->tradeService->showSellForm();}

    public function buy(Request $request){ return $this->tradeService->buy($request);}

    public function sell(Request $request) { return $this->tradeService->sell($request);}
}
