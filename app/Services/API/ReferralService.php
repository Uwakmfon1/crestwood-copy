<?php 
namespace App\Services\API;

use illuminate\Http\JsonResponse;
use App\Http\Resources\ReferralResource;


class ReferralService {


     public function index(): JsonResponse
    {
        return response()->json(['data' => ReferralResource::collection(auth()->user()->referrals()->latest()->get())]);
    }
}