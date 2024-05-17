<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Saving;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Referral;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomNotificationByEmail;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\NotificationController as Notifications;
use App\Notifications\CustomNotificationWithoutGreeting;
use App\Notifications\CustomNotificationByEmailWithoutGreeting;

class CommandController extends Controller
{
    public static function generateSettings()
    {
        if (Setting::all()->count() == 0){
            Setting::create([
                'bank_name' => 'xxxxxxxxxx',
                'account_number' => 'xxxxxxxxxx',
                'account_name' => 'xxxxxxxxxx'
            ]);
        }
    }

    public static function notifyMaturity()
    {
        $investments = Investment::query()
                                    ->with('user')
                                    ->where('status', 'active')
                                    ->get();
        foreach ($investments as $investment){
            if (now()->diffInDays(date('Y-m-d', strtotime($investment['return_date']))) == 30){
                \App\Http\Controllers\NotificationController::sendInvestmentAlmostMaturedNotification($investment->user);
            }
        }
    }

    public static function updateExchangeRate()
    {
        $settings = Setting::all()->first();
        try {
            $rate = HomeController::fetchExchangeRates();
            $settings->update($rate);
        }catch (\Exception $exception){
            if ($settings['exchange_rate_error_mail'] == 1){
                $dateTime = date('Y-m-d H:i:s', strtotime($settings['last_exchange_rate_notification'].' + '.$settings['error_mail_interval']));
                if (now()->gte($dateTime)){
                    NotificationController::dispatchExchangeRateErrorNotification();
                    $settings->update(['last_exchange_rate_notification' => now()]);
                }
            }
        }
    }

    public static function transactionNotify()
    {
        $transactions = Transaction::query()->where('status', 'pending')->count();
        if ($transactions > 0){
            $settings = Setting::all()->first();
            if ($settings['pending_transaction_mail'] == 1){
                $dateTime = date('Y-m-d H:i:s', strtotime($settings['last_pending_transaction_notification'].' + '.$settings['pending_transaction_mail_interval']));
                if (now()->gte($dateTime)){
                    NotificationController::sendPendingTransactionNotificationOnScheduleToAdmin($transactions);
                    $settings->update(['last_pending_transaction_notification' => now()]);
                }
            }
        }
    }

    public static function deleteUsers()
    {
        $setting = Setting::all()->first();
        if ($setting['auto_delete_unverified_users'] == 1){
            $users = User::query()->whereNull('email_verified_at')
                ->get();
            foreach ($users as $user){
                if ($user->canBeDeleted($setting['auto_delete_unverified_users_after'])){
                    Referral::query()->where('referred_id', $user['id'])
                        ->delete();
                    $user->goldWallet()->delete();
                    $user->nairaWallet()->delete();
                    $user->delete();
                }
            }
        }
    }

    public static function markEmailsAsFailed()
    {
        $emails = Email::query()->where('status', 'sending')->get();
        foreach ($emails as $email){
            if ($email->canMarkAsFailed()){
                $email->update(['status' => 'failed']);
            }
        }
    }

    public static function sendEmails()
    {
        $emails = Email::query()->where('status', 'queued')->get();
        foreach ($emails as $email){
            $email->update(['status' => 'sending']);
//            Get email recipients
            $recipient = $recipients = null;
            if ($email['type'] == 'single'){
                $recipient = User::query()->where('email', $email['to'])->first();
            }else{
                switch ($email['to']){
                    case 'All verified users':
                        $recipients = User::query()->whereNotNull('email_verified_at')->get()->pluck('email')->toArray();
                        break;
                    case 'Specified Recipients':
                        $recipients = explode(',', $email['recipients']);
                        break;
                    default:
                        $recipients = [];
                }
            }
            $cc = $email['cc'] ? explode(',', $email['cc']) : null;
//            Send email
            switch ($email['type']){
                case 'single':
                    if ($recipient){
                        self::sendSingleEmail($recipient, $email, $cc);
                    }else{
                        if ($email['platform'] != 'notification') {
                            try {
                                Notification::route('mail', $email['to'])->notify(new CustomNotificationByEmailWithoutGreeting($email['subject'], $email['body'], $cc));
                            }catch (\Exception) {
                                logger('There was an error sending the email');
                            }
                        }
                    }
                    break;
                default:
                    foreach ($recipients as $recipient){
                        $user = User::query()->where('email', $recipient)->first();
                        if ($user){
                            self::sendSingleEmail($user, $email, $cc);
                        }else{
                            if ($email['platform'] != 'notification') {
                                try {
                                    Notification::route('mail', $recipient)->notify(new CustomNotificationByEmailWithoutGreeting($email['subject'], $email['body'], $cc));
                                }catch (\Exception) {
                                    logger('There was an error sending the email');
                                }
                            }
                        }
                    }
            }
            $email->update(['status' => 'success']);
        }
    }

    public static function settlePayments()
    {
        $payments = Payment::query()->where('status', 'pending')->get();
        foreach ($payments as $payment){
        //            if ($payment->canRetryVerification()){
                $paymentDetails = Http::withHeaders([
                    'Authorization' => 'Bearer '.env('PAYSTACK_SECRET_KEY')
                ])->get('https://api.paystack.co/transaction/verify/'.$payment['reference']);
                try {
                    if (isset($paymentDetails['status'])) {
                        $res = $paymentDetails['data'];
                        if (isset($res)) {
                            if ($res["status"] == 'success') {
                                PaymentController::processTransaction($payment, $res['metadata']);
                                $payment->update(['status' => 'success']);
                            } else {
                                $payment->update(['status' => 'failed']);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    $payment->update(['status' => 'failed']);
                }
        //            }
        }
    }

    public static function settleSavings()
    {
        $savings = Saving::query()->where('status', 'active')->get();

        foreach ($savings as $saving){
            $user = $saving->user;

            $paid = $saving->transaction()->where('status', 'approved')->count();

            for ($i = 1; $i <= $saving->package['milestone']; $i++)
            {
                if($paid >= $i){
                    //nothing
                } else {
                    if ($saving->package['duration'] == 'daily') {
                        if (\Carbon\Carbon::now() > \Carbon\Carbon::make($saving->savings_date)->addDays($i - 1)) {
                            if ($user->hasSufficientBalanceForTransaction($saving->amount)){
                                $desc = "Auto Saved to ". $saving->package['name'];
                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);
                                $user->nairaWallet()->decrement('balance', $saving->amount);

                                Notifications::sendSavingsNotification($saving);
                                
                                logger('Auto Save Successfully ✅ (daily)');
                            } elseif($user->auth_key){
                                $desc = "Bank Auto Saved to ". $saving->package['name'];

                                PaymentController::charge($saving->amount);

                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);

                                Notifications::sendSavingsNotification($saving);

                                logger('Bank Auto Save Successfully ✅ (daily)');
                            } else {
                                logger('Insufficient wallet balance ❌ (daily)'. $i);
                            }
                        }
                    } elseif($saving->package['duration'] == 'weekly') {
                        if (\Carbon\Carbon::now() > \Carbon\Carbon::make($saving->savings_date)->addWeeks($i - 1)) {
                            if ($user->hasSufficientBalanceForTransaction($saving->amount)){
                                $desc = "Auto Saved to ". $saving->package['name'];
                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);
                                $user->nairaWallet()->decrement('balance', $saving->amount);

                                Notifications::sendSavingsNotification($saving);
                                
                                logger('Auto Save Successfully ✅ (weekly)');
                            } elseif($user->auth_key){
                                $desc = "Bank Auto Saved to ". $saving->package['name'];

                                PaymentController::charge($saving->amount);

                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);

                                Notifications::sendSavingsNotification($saving);

                                logger('Bank Auto Save Successfully ✅ (weekly)');
                            } else {
                                logger('Insufficient wallet balance ❌ (weekly)'. $i);
                            }
                        }
                    } elseif($saving->package['duration'] == 'monthly') {
                        if (\Carbon\Carbon::now() > \Carbon\Carbon::make($saving->savings_date)->addWeeks($i - 1)) {
                            if ($user->hasSufficientBalanceForTransaction($saving->amount)){
                                $desc = "Auto Saved to ". $saving->package['name'];
                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);
                                $user->nairaWallet()->decrement('balance', $saving->amount);

                                Notifications::sendSavingsNotification($saving);
                                
                                logger('Auto Save Successfully ✅ (monthly)');
                            } elseif($user->auth_key){
                                $desc = "Bank Auto Saved to ". $saving->package['name'];

                                PaymentController::charge($saving->amount);

                                TransactionController::storeSavingTransaction($saving, $saving->amount, 'wallet', 'savings', $desc, $saving['id']);

                                Notifications::sendSavingsNotification($saving);

                                logger('Bank Auto Save Successfully ✅ (monthly)');
                            } else {
                                logger('Insufficient wallet balance ❌ (monthly)'. $i);
                            }
                        }
                    }
                }
            }
        }
    }

    public static function settleInvestments()
    {
        $investments = Investment::query()->where('status', 'active')->get();
        foreach ($investments as $investment){
//            Check if investment can be settled
            if ($investment->canSettle()){
//                Check if investment has rollover
                $user = $investment->user;
                if ($investment->rollover){
                    $rollover = $investment->rollover;
//                    Check if returns can purchase slot
                    if (!($investment['total_return'] < ($rollover['slots'] * $rollover->package['price']))){
                        $slots = $rollover['slots'];
                    }else{
                        $slots = floor($investment['total_return'] / $rollover->package['price']);
                    }
                    $amount = $slots * $rollover->package['price'];
                    $balance = $investment['total_return'] - $amount;
//                    Check if slots can create investment
                    if ($slots > 0){
//                        Create investment from rollover
                        $newInvestment = Investment::create([
                            'user_id' => $investment->user['id'], 'package_id'=> $rollover->package['id'], 'slots' => $slots,
                            'amount' => $amount, 'total_return' => $amount * (( 100 + $rollover->package['roi'] ) / 100 ),
                            'investment_date' => now()->format('Y-m-d H:i:s'),
                            'return_date' => now()->addMonths($rollover->package['duration'])->format('Y-m-d H:i:s'), 'status' => 'active'
                        ]);
                        if ($newInvestment){
                            TransactionController::storeInvestmentTransaction($newInvestment, 'wallet');
                            Notifications::sendRolloverInvestmentCreatedNotification($newInvestment);
                        }
//                        Check if user has balance and refund
                        if ($balance > 0){
                            $user->nairaWallet()->increment('balance', $balance);
                        }
                    }else{
                        $user->nairaWallet()->increment('balance', $investment['total_return']);
                    }
                }else{
                    $user->nairaWallet()->increment('balance', $investment['total_return']);
                }
                $investment->update(['status' => 'settled']);
                \App\Http\Controllers\NotificationController::sendInvestmentSettledNotification($investment);
            }
        }
    }

    protected static function sendSingleEmail($user, $email, $cc)
    {
        if ($email['platform'] == 'notification') {
            try {
                $user->notify(new CustomNotificationWithoutGreeting('database', $email['subject'], $email['body'], $cc, 'New message from '.env('APP_NAME')));
            }catch (\Exception) {
                logger('There was an error sending the email');
            }
        } else {
            if ($email['platform'] == 'both') {
                try {
                    $user->notify(new CustomNotificationWithoutGreeting('default', $email['subject'], $email['body'], $cc, 'New message from '.env('APP_NAME')));
                }catch (\Exception) {
                    logger('There was an error sending the email');
                }
            } elseif ($email['platform'] == 'email') {
                try {
                    $user->notify(new CustomNotificationByEmailWithoutGreeting($email['subject'], $email['body'], $cc));
                }catch (\Exception) {
                    logger('There was an error sending the email');
                }
            }
        }
    }

    public static function handleSavings() 
    {
        
    }
}
