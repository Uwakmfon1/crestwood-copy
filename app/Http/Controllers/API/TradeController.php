<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Resources\InvestmentResource;
use App\Http\Resources\TradeResource;
use App\Http\Resources\TransactionResource;
use App\Models\Investment;
use App\Models\Setting;
use App\Models\Trade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TradeController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/trades",
     *   tags={"Trade"},
     *   summary="Get Trades",
     *   operationId="get trades",
     *
     *     @OA\Parameter(
     *      name="type",
     *      description="should be buy or sell",
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
        $trades = auth('api')->user()->trades();
        if (request()->get('type')){
            switch (request()->get('type')){
                case "buy":
                    $trades->where('type', 'buy');
                    break;
                case "sell":
                    $trades->where('type', 'sell');
                    break;
                default:
                    return response()->json(['message' => 'The type can only be buy or sell.'], 422);
            }
        }
        if (request()->get('paginate') == 'true'){
            $data = $trades->paginate(request()->get('limit') ?? 10);
            return response()->json(['data' => TradeResource::collection($data), 'pagination_links' => \App\Http\Controllers\API\HomeController::fetchPaginationLinks($data)]);
        }else{
            return response()->json(['data' => TradeResource::collection($trades->get())]);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/trades/{id}/show",
     *   tags={"Trade"},
     *   summary="Show Trade",
     *   operationId="show trade",
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
    public function show(Trade $trade): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => new TradeResource($trade)]);
    }

    /**
     * @OA\Post(
     ** path="/api/buy",
     *   tags={"Trade"},
     *   summary="Buy",
     *   operationId="buy",
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
     *   @OA\Parameter(
     *      name="currency",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="product",
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
    public function buy(Request $request): \Illuminate\Http\JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'gt:0'],
            'currency' => ['required', 'in:ngn,grams'],
            'payment' => ['required', 'in:wallet,deposit'],
            'product' => ['required', 'in:gold,silver']
        ],[
            'currency.in' => 'The currency field can only be ngn or grams',
            'product.in' => 'The product field can only be silver or gold'
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check if trading is allowed
        if (Setting::all()->first()['trade'] == 0){
            return response()->json(['message' => 'Buying is currently unavailable, check back later'], 400);
        }
//        Calculate grams of gold to buy
        if($request['product'] == 'gold'){
            $gramsToNgn = HomeController::fetchGoldBuyPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = HomeController::fetchSilverBuyPriceInNGN();
        }else{
            $gramsToNgn = 0;
        }
        if ($gramsToNgn == 0){
            return response()->json(['message' => 'There was an error fetching exchange rates, try again'], 400);
        }
        if ($request['currency'] == 'ngn'){
            $grams = round(($request['amount'] / $gramsToNgn), 6);
            $amount = round($request['amount'], 2);
        }else{
            $grams = round($request['amount'], 6);
            $amount = round($request['amount'] * $gramsToNgn, 2);
        }
//        Process trade based on payment method
        switch ($request['payment']){
            case 'wallet':
                if (!auth('api')->user()->hasSufficientBalanceForTransaction($amount)){
                    return response()->json(['message' => 'Insufficient wallet balance'], 400);
                }
                auth('api')->user()->nairaWallet()->decrement('balance', $amount);
                if($request['product'] == 'gold'){
                    auth('api')->user()->goldWallet()->increment('balance', $grams);
                }elseif($request['product'] == 'silver'){
                    auth('api')->user()->silverWallet()->increment('balance', $grams);
                }
                $status = 'success';
                $msg = 'Trade completed successfully';
                break;
            case 'deposit':
                $status = 'pending';
                $msg = 'Trade queued successfully';
                break;
            default:
                return response()->json(['message' => 'Invalid payment method'], 400);
        }
//        Create trade
        $trade = auth('api')->user()->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'type' => 'buy', 'product' => $request['product'], 'status' => $status
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, $request['payment'], false, 'mobile');
            if ($trade['status'] == 'success'){
                NotificationController::sendTradeSuccessfulNotification($trade);
            }else{
                NotificationController::sendTradeQueuedNotification($trade);
            }
            return response()->json(['message' => $msg, 'data' => new TradeResource($trade)]);
        }
        return response()->json(['message' => 'Error processing trade'], 400);
    }

    /**
     * @OA\Post(
     ** path="/api/sell",
     *   tags={"Trade"},
     *   summary="Sell",
     *   operationId="sell",
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
     *   @OA\Parameter(
     *      name="currency",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="product",
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
    public function sell(Request $request): \Illuminate\Http\JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric'],
            'currency' => ['required', 'in:ngn,grams'],
            'product' => ['required', 'in:gold,silver']
        ],[
            'currency.in' => 'The currency field can only be ngn or grams',
            'product.in' => 'The product field can only be silver or gold'
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check if trading is allowed
        if (Setting::all()->first()['trade'] == 0){
            return response()->json(['message' => 'Selling of gold is currently unavailable, check back later'], 400);
        }
//        Calculate grams of gold to sell
        if($request['product'] == 'gold'){
            $gramsToNgn = HomeController::fetchGoldSellPriceInNGN();
        }elseif($request['product'] == 'silver'){
            $gramsToNgn = HomeController::fetchSilverSellPriceInNGN();
        }else{
            $gramsToNgn = 0;
        }
        if ($gramsToNgn == 0){
            return response()->json(['message' => 'There was an error fetching exchange rates, reload page'], 400);
        }
        if ($request['currency'] == 'ngn'){
            $grams = round(($request['amount'] / $gramsToNgn), 6);
            $amount = round($request['amount'], 2);
        }else{
            $grams = round($request['amount'], 6);
            $amount = round($request['amount'] * $gramsToNgn, 2);
        }
//        Process trade
        if($request['product'] == 'gold'){
            if (!auth('api')->user()->hasSufficientGoldToTrade($grams)){
                return response()->json(['message' => 'Insufficient gold wallet balance'], 400);
            }
            auth('api')->user()->goldWallet()->decrement('balance', $grams);
        }elseif($request['product'] == 'silver'){
            if (!auth('api')->user()->hasSufficientSilverToTrade($grams)){
                return response()->json(['message' => 'Insufficient silver wallet balance'], 400);
            }
            auth('api')->user()->silverWallet()->decrement('balance', $grams);
        }
        auth('api')->user()->nairaWallet()->increment('balance', $amount);
//        Create trade
        $trade = auth('api')->user()->trades()->create([
            'grams' => $grams, 'amount' => $amount, 'product' => $request['product'], 'type' => 'sell', 'status' => 'success'
        ]);
        if ($trade) {
            TransactionController::storeTradeTransaction($trade, 'wallet', false, 'mobile');
            NotificationController::sendTradeSuccessfulNotification($trade);
            return response()->json(['message' => 'Trade completed successfully', 'data' => new TradeResource($trade)]);
        }
        return response()->json(['message' => 'Error processing trade'], 400);
    }
}
