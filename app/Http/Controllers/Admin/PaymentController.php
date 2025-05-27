<?php

namespace App\Http\Controllers\Admin;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Services\Admin\PaymentService;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{

    public function __construct(public PaymentService $paymentService) {}

    public function index(){return $this->paymentService->index();}
    
    public function fetchPaymentsWithAjax(Request $request)
    {
        return $this->paymentService->fetchPaymentsWithAjax($request);
    }
    public function resolve(Payment $payment)
    {
        return $this->paymentService->resolve($payment);
    }
}
