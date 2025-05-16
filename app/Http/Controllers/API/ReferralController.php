<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Services\API\ReferralService;
use App\Http\Resources\ReferralResource;

class ReferralController extends Controller
{   
    public function __construct(public ReferralService $referralService) { }
    
    public function index()
    {
        return $this->referralService->index();
    }
}
