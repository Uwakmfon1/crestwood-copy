<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Admin\ReferralService;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
   
    public function __construct(public ReferralService $referralService)  { }

    public function index(){ return $this->referralService->index();}
}
