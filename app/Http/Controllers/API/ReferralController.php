<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReferralResource;
use Illuminate\Http\JsonResponse;

class ReferralController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/referrals",
     *   tags={"Referrals"},
     *   summary="Get User Referrals",
     *   operationId="get user referrals",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function index(): JsonResponse
    {
        return response()->json(['data' => ReferralResource::collection(auth()->user()->referrals()->latest()->get())]);
    }
}
