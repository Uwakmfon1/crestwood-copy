<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/balance",
     *   tags={"Transaction"},
     *   summary="Get User Balance",
     *   operationId="get user balance",
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
    public function getBalance(): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => [
            'naira' => auth('api')->user()->nairaWallet()->first()['balance'],
            'gold' => round(auth('api')->user()->goldWallet()->first()['balance'], 6),
            'silver' => round(auth('api')->user()->silverWallet()->first()['balance'], 6),
        ]]);
    }
}
