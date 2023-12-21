<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Unicodeveloper\Paystack\Facades\Paystack;
use KingFlamez\Rave\Facades\Rave as Flutterwave;

class PaymentController extends Controller
{
    public static function initializeOnlineTransaction($amount, $data): \Illuminate\Http\RedirectResponse
    {
        return back()->withInput()->with('error', 'Payment with card is currently unavailable, please use other payment methods.');
        if ($amount > 500000)
            return redirect()->route('dashboard')->with('error', 'We can\'t process card payment above ₦500,000');
        $data['channel'] = 'web';
        $paymentData = [
            'amount' => $amount * 100,
            'reference' => Paystack::genTranxRef(),
            'email' => auth()->user()['email'],
            'currency' => 'NGN',
            'metadata' => json_encode($data),
        ];
        auth()->user()->payments()->create([
            'reference' => $paymentData['reference'],
            'amount' => $amount,
            'type' => $data['type'],
            'gateway' => 'paystack',
            'meta' => json_encode($data)
        ]);
        \request()->merge($paymentData);
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return back()->with('error', 'The paystack token has expired. Please refresh the page and try again.');
        }
    }

    public function handlePaymentCallback()
    {
        $paymentDetails = Paystack::getPaymentData();
        $res = $paymentDetails['data'];
        $payment = Payment::query()->where('reference', $res['reference'])->first();
        if (isset($paymentDetails['status'])) {
            if (isset($res)) {
                $type = json_decode($payment['meta'], true)['type'];
                if ($res["status"] == 'success') {
                    return view('user.payment.success', compact('type', 'payment'));
                } else {
                    if ($payment['status'] == 'pending')
                        $payment->update(['status' => 'failed']);
                    return view('user.payment.error', compact('type', 'payment'));
                }
            }
        }
        return redirect()->route('dashboard')->with('error', 'Something went wrong');
    }

    public function handleMonnifyCallback(Request $request)
    {
        // Assuming Monnify sends the callback data as JSON
        $paymentDetails = json_decode($request->getContent(), true);

        // Extract relevant information from the Monnify callback
        $reference = $paymentDetails['reference'];
        $status = $paymentDetails['status'];

        // Retrieve the payment record from the database
        $payment = Payment::where('reference', $reference)->first();

        if ($payment) {
            // Update the payment status based on Monnify callback
            if ($status === 'successful') {
                $payment->update(['status' => 'success']);
                $type = json_decode($payment->meta, true)['type'];
                return view('user.payment.success', compact('type', 'payment'));
            } else {
                if ($payment->status === 'pending') {
                    $payment->update(['status' => 'failed']);
                }
                $type = json_decode($payment->meta, true)['type'];
                return view('user.payment.error', compact('type', 'payment'));
            }
        }

        return redirect()->route('dashboard')->with('error', 'Something went wrong');
    }

    public function handlePaymentWebhook(Request $request, $gateway)
    {
        logger('Pinged');
        $res = $request['data'];
        if ($gateway == 'paystack') {
            logger('Paystack payment');
            if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST') || !array_key_exists('HTTP_X_PAYSTACK_SIGNATURE', $_SERVER)) {
                http_response_code(401);
                exit();
            }
            logger('Paystack signature present');
            //This verifies the webhook is sent from paystack
            $payload = @file_get_contents("php://input");
            if($_SERVER['HTTP_X_PAYSTACK_SIGNATURE'] !== hash_hmac('sha512', $payload, env('PAYSTACK_SECRET_KEY'))) {
                http_response_code(401);
                exit();
            }
            logger('Paystack signature verified');
            // if it is a charge event, verify and confirm it is a successful transaction
            if ($request['event'] == 'charge.success' && $res['status'] == 'success') {
                $payment = Payment::query()->where('reference', $res['reference'])->first();
                if ($payment && $payment['status'] == 'pending') {
                    $meta = $res['metadata'];
                    self::processTransaction($payment, $meta);
                    logger('Payment processed and settled');
                    http_response_code(200);
                }
            }
        } elseif ($gateway == 'flutterwave') {
            //This verifies the webhook is sent from Flutterwave
            $verified = Flutterwave::verifyWebhook();
            // if it is a charge event, verify and confirm it is a successful transaction
            if ($verified && $request['event'] == 'charge.completed' && $res['status'] == 'successful') {
                $payment = Payment::query()->where('reference', $res['tx_ref'])->first();
                if ($payment && $payment['status'] == 'pending') {
                    $meta = json_decode($payment['meta'], true);
                    self::processTransaction($payment, $meta);
                    http_response_code(200);
                }
            }
        }
        http_response_code(400);
    }

    public static function processTransaction($payment, $meta) {
        $type = $meta['type'] ?? $meta['event_type'];
        switch ($type){
            case 'deposit':
                $payment->user->nairaWallet()->increment('balance', $payment['amount']);
                $transaction = $payment->user->transactions()->create([
                    'type' => 'deposit', 'amount' => $payment['amount'],
                    'description' => 'Deposit', 'channel' => $meta['channel'] ?? 'mobile',
                    'method' => 'card' ,'status' => 'approved'
                ]);
                if ($transaction)
                    try {
                        NotificationController::sendDepositSuccessfulNotification($transaction);
                    } catch (\Exception $e) { $emailError = true; }
                break;
            case 'investment':
                $package = Package::find($meta['package']['id']);
                $investment = $payment->user->investments()->create([
                    'package_id'=>$package['id'], 'slots' => $meta['slots'],
                    'amount' => $meta['slots'] * $package['price'],
                    'total_return' => $meta['slots'] * $package['price'] * (( 100 + $package['roi']) / 100 ),
                    'investment_date' => now()->format('Y-m-d H:i:s'),
                    'return_date' => now()->addMonths($package['duration'])->format('Y-m-d H:i:s'), 'status' => 'active'
                ]);
                if ($investment) {
                    try {
                        TransactionController::storeInvestmentTransaction($investment, 'card', false, $meta['channel'] ?? 'mobile');
                        NotificationController::sendInvestmentCreatedNotification($investment);
                    } catch (\Exception $e) { $emailError = true; }
                }
                break;
            case 'trade':
                if($meta['product'] == 'gold'){
                    $payment->user->goldWallet()->increment('balance', $meta['grams']);
                }elseif($meta['product'] == 'silver'){
                    $payment->user->silverWallet()->increment('balance', $meta['grams']);
                }
                $trade = $payment->user->trades()->create([
                    'grams' => $meta['grams'], 'amount' => $payment['amount'], 'product' => $meta['product'], 'type' => 'buy', 'status' => 'success'
                ]);
                if ($trade) {
                    try {
                        TransactionController::storeTradeTransaction($trade, 'card', false, $meta['channel'] ?? 'mobile');
                        NotificationController::sendTradeSuccessfulNotification($trade);
                    } catch (\Exception $e) { $emailError = true; }
                }
                break;
        }
        return $payment->update(['status' => 'success']);
    }
}
