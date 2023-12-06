<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Resources\InvestmentResource;
use App\Http\Resources\TransactionResource;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/transactions",
     *   tags={"Transaction"},
     *   summary="Get Transactions",
     *   operationId="get transactions",
     *
     *     @OA\Parameter(
     *      name="type",
     *      description="should be withdrawal, deposit or others",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function index(): \Illuminate\Http\JsonResponse
    {
        $transactions = auth('api')->user()->transactions();
        if (request()->get('type')){
            switch (request()->get('type')){
                case "withdrawal":
                    $transactions->where('type', 'withdrawal');
                    break;
                case "deposit":
                    $transactions->where('type', 'deposit');
                    break;
                case "others":
                    $transactions->where('type', 'others');
                    break;
                default:
                    return response()->json(['message' => 'The type can only be withdrawal, deposit or others.'], 422);
            }
        }
        if (request()->get('paginate') == 'true'){
            $data = $transactions->paginate(request()->get('limit') ?? 10);
            return response()->json(['data' => TransactionResource::collection($data), 'pagination_links' => HomeController::fetchPaginationLinks($data)]);
        }else{
            return response()->json(['data' => TransactionResource::collection($transactions->get())]);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/transactions/{id}/show",
     *   tags={"Transaction"},
     *   summary="Show Transaction",
     *   operationId="show transaction",
     *
     *     @OA\Parameter(
     *      name="id",
     *      in="path",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
    public function show(Transaction $transaction): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => new TransactionResource($transaction)]);
    }

    /**
     * @OA\Post(
     ** path="/api/deposit",
     *   tags={"Transaction"},
     *   summary="Deposit",
     *   operationId="deposit",
     *
     *   @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *    @OA\Parameter(
     *      name="payment",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *      @OA\Response(
     *      response=400,
     *       description="Bad Request",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function deposit(Request $request): \Illuminate\Http\JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'payment' => ['required', 'in:deposit']
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check for deposit method and process
        $transaction = auth('api')->user()->transactions()->create([
            'type' => 'deposit', 'amount' => $request['amount'],
            'method' => $request['payment'], 'channel' => 'mobile',
            'description' => 'Deposit', 'status' => 'pending'
        ]);
        if ($transaction) {
            NotificationController::sendDepositQueuedNotification($transaction);
            return response()->json(['message' => 'Deposit queued successfully', 'data' => new TransactionResource($transaction)]);
        }
        return response()->json(['message' => 'Error processing deposit'], 400);
    }

    /**
     * @OA\Post(
     ** path="/api/withdraw",
     *   tags={"Transaction"},
     *   summary="Withdraw",
     *   operationId="withdraw",
     *
     *   @OA\Parameter(
     *      name="amount",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *      @OA\Response(
     *      response=400,
     *       description="Bad Request",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function withdraw(Request $request): \Illuminate\Http\JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check if withdrawal is allowed
        if (Setting::all()->first()['withdrawal'] == 0){
            return response()->json(['message' => 'Withdrawal from wallet is currently unavailable, check back later'], 400);
        }
//        Check if user has sufficient balance
        if (!auth('api')->user()->hasSufficientBalanceForTransaction($request['amount'])) return response()->json(['message' => 'Insufficient wallet balance'], 400);
//        Process withdrawal
        auth('api')->user()->nairaWallet()->decrement('balance', $request['amount']);
        $transaction = auth('api')->user()->transactions()->create([
            'type' => 'withdrawal', 'amount' => $request['amount'],
            'method' => 'wallet', 'channel' => 'mobile',
            'description' => 'Withdrawal', 'status' => 'pending'
        ]);
        if ($transaction) {
            NotificationController::sendWithdrawalQueuedNotification($transaction);
            return response()->json(['message' => 'Withdrawal queued successfully', 'data' => new TransactionResource($transaction)]);
        }
        return response()->json(['message' => 'Error processing withdrawal'], 400);
    }
}
