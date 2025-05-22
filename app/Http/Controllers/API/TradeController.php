<?php

namespace App\Http\Controllers\API;


use App\Models\Trade;
use App\Models\Setting;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Services\API\TradeService;
use App\Http\Controllers\Controller;
use App\Http\Resources\TradeResource;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\InvestmentResource;
use App\Http\Controllers\PaymentController;
use App\Http\Resources\TransactionResource;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;


class TradeController extends Controller
{
    public function __construct(public TradeService $tradeService){ }

    public function index() { return $this->tradeService->index(); }

    public function show(Trade $trade): JsonResponse
    {
        return $this->tradeService->show($trade);
    }

    public function buy(Request $request) { return $this->tradeService->buy($request);  }

    public function sell(Request $request) { return $this->tradeService->sell($request); }
}
