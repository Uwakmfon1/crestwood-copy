<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * @OA\Post(
     ** path="/api/payment/initialize",
     *   tags={"Transaction"},
     *   summary="Initialize Payment",
     *   operationId="Initialize Payment",
     *
     *     @OA\Parameter(
     *      name="reference",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
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
     *      name="type",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="meta",
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
     *    @OA\Response(
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
    public function initialize(Request $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'message' => "Card payment method is currently unavailable, try again later"
        ], 422);
        //        Validate request
        $validator = Validator::make($request->all(), [
            'reference' => ['required'],
            'amount' => ['required'],
            'type' => ['required', 'in:deposit,trade,investment'],
            // 'meta' => ['required', 'string']
        ],[
            'type.in' => 'The type field must be deposit, trade or investment'
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
        if ($request['amount'] > 500000)
            return response()->json(['message' => 'We can\'t process card payment above ₦500,000'], 400);
        //        Create Payment
        if (auth('api')->user()->payments()->create([
            'reference' => $request['reference'],
            'amount' => $request['amount'],
            'type' => $request['type'],
            'gateway' => 'paystack',
            'meta' => $request['meta']
        ])) return response()->json(['message' => 'Payment initialized successfully']);
        return response()->json(['message' => 'Error initialized payment'], 400);
    }

    public function handleWebhook(Request $request)
    {
        $event = $request->all();

        if ($event['eventType'] == 'SUCCESSFUL_TRANSACTION') {
            $eventData = $event['eventData'];
            $amountPaid = $eventData['amountPaid'];
            $transactionReference = $eventData['transactionReference'];
            $paymentMethod = $eventData['paymentMethod'];
            $settlementAmount = $eventData['settlementAmount'];
            $paidOn = $eventData['paidOn'];
            $customerEmail = $eventData['customer']['email'];

            $meta = [
                'payment_method' => $paymentMethod,
                'settlement_amount' => $settlementAmount,
                'customer_email' => $customerEmail,
                'paid_on' => $paidOn,
                'event_type' => $event['eventType'],
            ];

            $data['channel'] = 'web';
            $user = User::where('email', $customerEmail)->first();

            $paymentData = [
                'amount' => $amountPaid,
                'reference' => $transactionReference,
                'email' => $user['email'],
                'currency' => 'NGN',
                'metadata' => json_encode($data),
            ];
            $user->payments()->create([
                'reference' => $paymentData['reference'],
                'amount' => $amountPaid,
                'type' =>  $event['eventType'],
                'gateway' => 'monnify',
                'meta' => json_encode($data)
            ]);
            \request()->merge($paymentData);
            try{
                return redirect($event['data']['payment_url']);
            }catch(\Exception $e) {
                return back()->with('error', 'The paystack token has expired. Please refresh the page and try again.');
            }

            return response([], 200);
        } else {
            logger(json_encode($event));

            return response([], 400);
        }
    }
}
