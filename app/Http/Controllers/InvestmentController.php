<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Investment;
use Illuminate\Http\Request;
use InvalidArgumentException;
use App\Services\InvestmentService;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function __construct(public InvestmentService $investmentService){ }
    
    public function index()
    {
        return $this->investmentService->index();
    }
   
    public function show(Investment $investment)
    {
        return $this->investmentService->show($investment);
    }

    public function history(Request $request)
    {
        return $this->investmentService->history($request);
    }

    public function invest($packageName)
    {
        return $this->investmentService->invest($packageName);
    }  

    public function store(Request $request)
    {
        return $this->investmentService->store($request);
    }

    public function storeProfit(Investment $investment)
    {
        return $this->investmentService->storeProfit($investment);
    }
}
