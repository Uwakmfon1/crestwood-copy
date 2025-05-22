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
use App\Services\SavingsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class SavingsController extends Controller
{
    public function __construct(public SavingsService $savingsService) {}

    public function index()
    {
        return $this->savingsService->index();
    }

    public function packages()
    {
        return $this->savingsService->packages();
    }
  

    public function create(){ return $this->savingsService->create();}
  
    public function show(Saving $savings){ return $this->savingsService->show($savings); }


    public function questionaire(){return  $this->savingsService->questionaire();}


    //Create Savings
    public function store(Request $request) { return $this->savingsService->store($request); }
   
    public function history(Request $request) {     return $this->savingsService->history($request); }
  
    public function fetchPlan()  { return $this->savingsService->fetchPlan(); }
    
    public function getPlanDetails($id) { return $this->savingsService->getPlanDetails($id); }
    
    public function savingsPayment(Saving $savings, Request $request)  
    {
          return $this->savingsService->savingsPayment($savings,$request);
    }
 
    public function savingsInterest(Saving $savings)
    {
        return $this->savingsService->savingsInterest($savings);
    }
   
    public function withdrawInterest(SaveTransaction $saveTransaction)
    {
        return $this->savingsService->withdrawInterest($saveTransaction);
    }
  
}
