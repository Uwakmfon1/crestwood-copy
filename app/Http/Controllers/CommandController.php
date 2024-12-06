<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Stock;
use App\Models\Crypto;
use App\Models\Ledger;
use App\Models\Saving;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Referral;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomNotificationByEmail;
use App\Http\Controllers\Admin\NotificationController;
use App\Notifications\CustomNotificationWithoutGreeting;
use App\Notifications\CustomNotificationByEmailWithoutGreeting;
use App\Http\Controllers\NotificationController as Notifications;

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

    public static function updateStocks($command) 
    {
        $stockSymbols = DB::table('stocks')->pluck('symbol')->chunk(100); // Chunk to handle large data sets
        $command->info("Starting stock updates...");

        foreach ($stockSymbols as $chunk) {
            $symbolString = implode(',', $chunk->toArray());
            $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$symbolString}?apikey=U16Gq0PRKGgnTbltSa5423seAWtQNV0T";

            $response = Http::get($apiUrl);

            if ($response->successful()) {
                foreach ($response->json() as $data) {
                    DB::table('stocks')->updateOrInsert(
                        ['symbol' => $data['symbol']],
                        [
                            'price' => $data['price'],
                            'changes_percentage' => $data['changesPercentage'],
                            'change' => $data['change'],
                            'day_low' => $data['dayLow'],
                            'day_high' => $data['dayHigh'],
                            'year_low' => $data['yearLow'],
                            'year_high' => $data['yearHigh'],
                            'market_cap' => $data['marketCap'],
                            'price_avg_50' => $data['priceAvg50'],
                            'price_avg_200' => $data['priceAvg200'],
                            'volume' => $data['volume'],
                            'avg_volume' => $data['avgVolume'],
                            'open' => $data['open'],
                            'previous_close' => $data['previousClose'],
                            'eps' => $data['eps'],
                            'pe' => $data['pe'],
                        ]
                    );
                    $command->info("Updated stock: {$data['symbol']}");
                }
            } else {
                Log::error("Failed to fetch stock data. Status: " . $response->status());
                $command->error("Failed to fetch stock data for chunk: " . $symbolString);
            }
        }
        $command->info("Stock updates completed.");
    }

    public static function updateCrypto($command)
    {
        $stockSymbols = DB::table('cryptos')->pluck('symbol')->chunk(100); // Chunk to handle large data sets
        $command->info("Starting crypto updates...");

        foreach ($stockSymbols as $chunk) {
            $symbolString = implode(',', $chunk->toArray());
            $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$symbolString}?apikey=U16Gq0PRKGgnTbltSa5423seAWtQNV0T";

            $response = Http::get($apiUrl);

            if ($response->successful()) {
                foreach ($response->json() as $data) {
                    DB::table('cryptos')->updateOrInsert(
                        ['symbol' => $data['symbol']],
                        [
                            'price' => $data['price'] ?? 0,
                            'changes_percentage' => $data['changesPercentage'] ?? 0,
                            'change' => $data['change'] ?? 0,
                            'day_low' => $data['dayLow'] ?? 0,
                            'day_high' => $data['dayHigh'] ?? 0,
                            'year_low' => $data['yearLow'] ?? 0,
                            'year_high' => $data['yearHigh'] ?? 0,
                            'market_cap' => $data['marketCap'] ?? 0,
                            'price_avg_50' => $data['priceAvg50'] ?? 0,
                            'price_avg_200' => $data['priceAvg200'] ?? 0,
                            'volume' => $data['volume'] ?? 0,
                            'avg_volume' => $data['avgVolume'] ?? 0,
                            'open' => $data['open'] ?? 0,
                            'previous_close' => $data['previousClose'] ?? 0,
                            'eps' => $data['eps'] ?? 0, // Assuming 'eps' might be included in the response, if not it defaults to 0
                            'pe' => $data['pe'] ?? 0,   // Assuming 'pe' might be included in the response, if not it defaults to 0
                        ]
                    );
                    $command->info("Updated stock: {$data['symbol']}");
                }
            } else {
                Log::error("Failed to fetch stock data. Status: " . $response->status());
                $command->error("Failed to fetch stock data for chunk: " . $symbolString);
            }
        }

        // Update `account_coins` table for specific cryptos
        $command->info("Updating specific cryptocurrencies in account_coins...");

        // Define the mapping between database symbols and API symbols
        $cryptoMapping = [
            'BTC' => 'BTCUSD',
            'ETH' => 'ETHUSD',
            'USDT' => 'USDTUSD',
            'TRX' => 'TRXUSD',
        ];

        // Prepare the API query string
        $cryptoSymbols = array_values($cryptoMapping);
        $cryptoString = implode(',', $cryptoSymbols);
        $apiUrl = "https://financialmodelingprep.com/api/v3/quote/{$cryptoString}?apikey=U16Gq0PRKGgnTbltSa5423seAWtQNV0T";

        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $responseData = collect($response->json())->keyBy('symbol'); // Organize data by symbol

            foreach ($cryptoMapping as $dbSymbol => $apiSymbol) {
                if (isset($responseData[$apiSymbol])) {
                    $data = $responseData[$apiSymbol];
                    DB::table('account_coins')->where('symbol', $dbSymbol)->update([
                        'rate' => $data['price'] ?? 0,
                        'updated_at' => now(),
                    ]);
                    $command->info("Updated coin: {$dbSymbol} with rate from {$apiSymbol}");
                } else {
                    $command->error("Data for {$apiSymbol} not found in API response.");
                }
            }
        } else {
            Log::error("Failed to fetch crypto data for account_coins. Status: " . $response->status());
            $command->error("Failed to fetch crypto data for account_coins.");
        }

        $command->info("Crypto updates completed.");

    }

    public static function distributeProfit($command)
    {
        // Fetch active investments
        $investments = Investment::where('status', 'active')
            ->where('return_date', '>=', now())
            ->with('user') // Eager load the user relationship
            ->get();

        foreach ($investments as $investment) {
            // Get the total ROI and ROI duration
            $total_roi = $investment->package->roi;
            $total_profit = ($total_roi * $investment->amount) / 100;
            $roi_duration = $investment->roi_duration; // e.g., '2_days'
            $investment_duration = Carbon::parse($investment->created_at)->diffInDays($investment->return_date);
            $remaining_days = Carbon::now()->diffInDays($investment->return_date);

            if ($investment->user) {
                Log::info('Processing investment for user: ' . $investment->user->id);
            } else {
                Log::warning('Investment has no associated user: ' . $investment->id);
                continue; // Skip this investment if no user is associated
            }

            // Determine the profit percentage based on the remaining days
            $profit_percentage = self::getProfitPercentage($investment_duration, $remaining_days);

            // Calculate the profit to be credited today
            $profit_for_today = ($profit_percentage * $total_profit) / 100;

            if (self::shouldDistributeProfit($investment, $remaining_days)) {

                //Create Transaction
                $transaction = $investment->user->transaction('invest')->create([
                    'amount' => $profit_for_today,
                    'data_id' => $investment->id,
                    'status' => 'approved',
                    'description' =>  '$'. $profit_for_today . ' profit on ' . $investment->package->name,
                    'method' => 'credit'
                ]);

                //Create Investment Transaction
                $investment->investmentTransaction()->create([
                    'amount' => $profit_for_today,
                    'type' => 'credit',
                    'status' => 'success',
                ]);

                // ::::: Store Ledger :::::: //
                try {
                    Ledger::credit($investment->user->wallet, $profit_for_today, 'invest', null, '$'. $profit_for_today . ' profit on ' . $investment->package->name);
                } catch (InvalidArgumentException $e) {
                    return back()->with('error', 'Error debiting wallet: ' . $e->getMessage());
                }
                // ::::: Store Ledger :::::: //

                Log::info('Profit to distribute today: ' . $profit_for_today);
            }
        }

        $command->info('Investment profits distributed successfully.');
    }

    protected static function getProfitPercentage($investment_duration, $remaining_days)
    {
        if ($remaining_days == 0) {
            return 35; // Last day, 35% profit
        } elseif ($remaining_days <= $investment_duration / 2) {
            return 40; // Middle period, 40% profit
        } else {
            return 25; // First period, 25% profit
        }
    }

    /**
     * Check if we should distribute the profit based on the current ROI duration.
     */
    protected static function shouldDistributeProfit($investment, $remaining_days)
    {
        $next_distribution_date = Carbon::parse($investment->created_at)->addDays($investment->roi_duration);

        return Carbon::now()->gte($next_distribution_date);
    }
}
