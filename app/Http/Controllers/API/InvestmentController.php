<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Resources\InvestmentResource;
use App\Models\Investment;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvestmentController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/investments",
     *   tags={"Investment"},
     *   summary="Get Investments",
     *   operationId="get investments",
     *
     *     @OA\Parameter(
     *      name="status",
     *      description="should be active, pending, cancelled or settled",
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
        $investments = auth('api')->user()->investments();
        if (request()->get('status')){
            switch (request()->get('status')){
                case "pending":
                    $investments->where('status', 'pending');
                    break;
                case "active":
                    $investments->where('status', 'active');
                    break;
                case "cancelled":
                    $investments->where('status', 'cancelled');
                    break;
                case "settled":
                    $investments->where('status', 'settled');
                    break;
                default:
                    return response()->json(['message' => 'The status can only be active, pending, cancelled or settled.'], 422);
            }
        }
        if (request()->get('paginate') == 'true'){
            $data = $investments->paginate(request()->get('limit') ?? 10);
            return response()->json(['data' => InvestmentResource::collection($data), 'pagination_links' => HomeController::fetchPaginationLinks($data)]);
        }else{
            return response()->json(['data' => InvestmentResource::collection($investments->get())]);
        }
    }

    /**
     * @OA\Get(
     ** path="/api/investments/{id}/show",
     *   tags={"Investment"},
     *   summary="Show Investment",
     *   operationId="show investment",
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
    public function show(Investment $investment): \Illuminate\Http\JsonResponse
    {
        return response()->json(['data' => new InvestmentResource($investment)]);
    }

    /**
     * @OA\Post(
     ** path="/api/invest",
     *   tags={"Investment"},
     *   summary="Store Investment",
     *   operationId="store investment",
     *
     *     @OA\Parameter(
     *      name="package_id",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="slots",
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
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'package_id' => ['required'],
            'slots' => ['required', 'numeric', 'min:1'],
            'payment' => ['required', 'in:wallet,deposit']
        ],[
            'payment.in' => 'The payment should be wallet or deposit'
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check if investment is allowed
        if (Setting::all()->first()['invest'] == 0){
            return response()->json(['message' => 'Investment in packages is currently unavailable, check back later'], 400);
        }
//        Find package and check if investment is enabled
        $package = Package::all()->where('id', $request['package_id'])->first();
        if (!($package && $package->canRunInvestment())){
            return response()->json(['message' => 'Can\'t process investment, package not found or disabled'], 400);
        }
//        Process investment based on payment method
        switch ($request['payment']){
            case 'wallet':
                if (!auth('api')->user()->hasSufficientBalanceForTransaction($request['slots'] * $package['price'])){
                    return response()->json(['message' => 'Insufficient wallet balance'], 400);
                }
                auth('api')->user()->nairaWallet()->decrement('balance', $request['slots'] * $package['price']);
                $status = 'active';
                $msg = 'Investment created successfully';
                break;
            case 'deposit':
                $status = 'pending';
                $msg = 'Investment queued successfully';
                break;
            default:
                return response()->json(['message' => 'Invalid payment method'], 400);
        }
//        Create Investment
        $investment = auth('api')->user()->investments()->create([
            'package_id'=>$package['id'], 'slots' => $request['slots'], 'amount' => $request['slots'] * $package['price'],
            'total_return' => $request['slots'] * $package['price'] * (( 100 + $package['roi'] ) / 100 ),
            'investment_date' => now()->format('Y-m-d H:i:s'),
            'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => $status
        ]);
        if ($investment) {
            TransactionController::storeInvestmentTransaction($investment, $request['payment'], false, 'mobile');
            if ($investment['status'] == 'active'){
                NotificationController::sendInvestmentCreatedNotification($investment);
            }else{
                NotificationController::sendInvestmentQueuedNotification($investment);
            }
            return response()->json(['message' => $msg, 'data' => new InvestmentResource($investment)]);
        }
        return response()->json(['message' => 'Error processing investment'], 400);
    }
}
