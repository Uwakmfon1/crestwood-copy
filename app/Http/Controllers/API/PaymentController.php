<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

use Illuminate\Support\Facades\Validator;
use Unicodeveloper\Paystack\Facades\Paystack;
use App\Http\Controllers\NotificationController;
use HenryEjemuta\LaravelMonnify\Facades\Monnify;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethod;
use HenryEjemuta\LaravelMonnify\Classes\MonnifyPaymentMethods;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

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

            $payment = $user->payments()->create([
                'reference' => $paymentData['reference'],
                'amount' => $amountPaid,
                'type' =>  $eventData['paymentDescription'],
                'gateway' => 'monnify',
                'meta' => json_encode($data)
            ]);

            $payment->user->nairaWallet()->increment('balance', $payment['amount']);
            $transaction = $payment->user->transactions()->create([
                'type' => 'deposit', 'amount' => $payment['amount'],
                'description' => 'Deposit', 'channel' => $meta['channel'] ?? 'mobile',
                'method' => strtolower($paymentMethod) ,'status' => 'approved'
            ]);

            try 
            {
                NotificationController::sendDepositSuccessfulNotification($transaction);
            } catch (\Exception $e) 
            { 
                $emailError = true; 
            }
                    
            return response([], 200);
        } else {
            logger(json_encode($event));

            return response([], 400);
        }
    }

    public function handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        if ($paymentDetails['status'] && isset($paymentDetails['data']['authorization']['authorization_code'])) {
            // Encode the authorization code
            $encodedAuthCode = encrypt($paymentDetails['data']['authorization']['authorization_code']);
    
            // Find the user by email and update their auth_key
            $user = User::where('email', $paymentDetails['data']['customer']['email'])->first();
            if ($user) {
                $user->update(['auth_key' => $encodedAuthCode]);
                $meta = [
                    'type' => 'deposit',
                    'channel' => 'web',
                    'comment' => 'Bank Deposit'
                ];
                $amount = $paymentDetails['data']['amount'] / 100;
                $payment = $user->payments()->create([
                    'reference' => $paymentDetails['data']['reference'],
                    'amount' => $amount,
                    'type' =>  'deposit',
                    'gateway' => 'paystack',
                    'meta' => json_encode($meta)
                ]);
                $type = json_decode($payment['meta'], true)['type'];
    
                $user->nairaWallet()->increment('balance', $amount);
                $transaction = $payment->user->transactions()->create([
                    'type' => 'deposit', 
                    'amount' => $amount,
                    'description' => 'Deposit', 
                    'channel' => $meta['channel'] ?? 'mobile',
                    'method' => 'wallet',
                    'status' => 'approved'
                ]);

                return view('user.payment.success', compact('type', 'payment'));
            } else {
                return back()->withInput()->with('error', 'Error processing user data');
            }
        } else {
            return back()->withInput()->with('error', 'Error processing bank deposit');
        }
    }
}
