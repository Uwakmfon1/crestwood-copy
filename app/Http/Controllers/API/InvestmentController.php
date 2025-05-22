<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Resources\InvestmentResource;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Setting;
use App\Services\API\InvestmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    public function __construct(public InvestmentService $investmentService) { }    
    
    public function index() { return $this->investmentService->index();   }

    public function show(Investment $investment)
    {
        return $this->investmentService->show($investment);
    }

    public function store(Request $request)
    {
    return $this->investmentService->store($request);
    }

}
