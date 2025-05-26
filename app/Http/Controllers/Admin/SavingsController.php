<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Saving;
use Illuminate\Http\Request;
use App\Models\SavingPackage;
use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Services\Admin\SavingsService;
use Illuminate\Support\Facades\Validator;

class SavingsController extends Controller
{
    public function __construct(public SavingsService $savingsService){}

    public function index()
    {
        return $this->savingsService->index();
    }

    public function all()
    {
        return $this->savingsService->all();
    }

    public function show(Saving $saving)
    {
        return $this->savingsService->show($saving);
    }

   public function create()
   {
    return $this->savingsService->create();
   }

   public function savings(SavingPackage $savings)
   {
    return $this->savingsService->savings($savings);
   }


    public function edit(Plan $plan)
    {
        return $this->savingsService->edit($plan);
    }

    public function showUserSavings(User $user, Saving $saving)
    {
        return $this->savingsService->showUserSavings($user, $saving);
    }  

    // Savings Package CRUD
    public function store(Request $request)
    {
        return $this->savingsService->store($request);
    }

    public function update(Request $request, SavingPackage $package)
    {
        return $this->savingsService->store($request);
    }

    public function destroy(SavingPackage $package)
    {
        return $this->savingService->destroy($package);
    }

    
    public function fetchSavingsWithAjax(Request $request,$type)
    {
        return $this->savingsService->fetchSavingsWithAjax($request, $type);
    }


}
