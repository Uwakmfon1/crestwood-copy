<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Email;
use App\Models\Stock;
use App\Models\Crypto;
use App\Models\Saving;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Referral;
use App\Models\Investment;
use App\Models\Transaction;
use Illuminate\Http\Request;
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
        // Fetch stock data from an external API (replace with actual API)
        $apiUrl = 'https://financialmodelingprep.com/api/v3/quote/AAPL,GOOGL,AMZN,MSFT,TSLA,FB,JPM,V,A,PG,JNJ,MA,NVDA,UNH,BRK.B,HD,DIS,INTC,VZ,PYPL,CMCSA,PFE,ADBE,CRM,XOM,CSCO,IBM,ABT,ACN,BAC,ORCL,COST,TMO,ABBV,NFLX,T,XEL,MDT,NKE,AMGN,CVS,TMUS,DHR,LMT,NEE,HON,BMY,COP?apikey=BxRzCvi46ZOnN32A2sIGuhGEsH9Mksw7'; // Replace with your real API
        $response = Http::get($apiUrl);

        // Check if API request was successful
        if ($response->successful()) {
            $stocksData = $response->json(); // Assuming this returns a list of stocks data

            // Iterate through the stocks returned from the API
            foreach ($stocksData as $stockData) {
                try {
                    // Attempt to find the stock by symbol in the database
                    $stock = Stock::where('symbol', $stockData['symbol'])->first();

                    // Only update if the stock exists in the database
                    if ($stock) {
                        // Update only the price and related fields
                        $stock->update([
                            'price' => $stockData['price'],
                            'changes_percentage' => $stockData['changesPercentage'], // Changed key to match API
                            'change' => $stockData['change'],
                            'day_low' => $stockData['dayLow'], // Changed key to match API
                            'day_high' => $stockData['dayHigh'], // Changed key to match API
                            'year_low' => $stockData['yearLow'], // Changed key to match API
                            'year_high' => $stockData['yearHigh'], // Changed key to match API
                            'market_cap' => $stockData['marketCap'], // Changed key to match API
                            'price_avg_50' => $stockData['priceAvg50'], // Changed key to match API
                            'price_avg_200' => $stockData['priceAvg200'], // Changed key to match API
                            'volume' => $stockData['volume'],
                            'avg_volume' => $stockData['avgVolume'], // Changed key to match API
                            'open' => $stockData['open'],
                            'previous_close' => $stockData['previousClose'], // Changed key to match API
                            'eps' => $stockData['eps'],
                            'pe' => $stockData['pe'],
                        ]);
                        $command->info("Updated stock: {$stock->symbol}");
                    } else {
                        $command->warn("Stock with symbol {$stockData['symbol']} not found.");
                    }
                } catch (\Exception $e) {
                    // Log any errors encountered while processing a stock
                    Log::error("Error updating stock {$stockData['symbol']}: " . $e->getMessage());
                }
            }
        } else {
            // Log if the API request fails
            Log::error("Failed to fetch stock data. Status: " . $response->status());
            $command->error('Failed to fetch stock data.');
        }

        $cryptos = [
            ['symbol' => 'BTCUSD', 'name' => 'Bitcoin', 'img' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/4/46/Bitcoin.svg/1200px-Bitcoin.svg.png'],
            ['symbol' => 'ETHUSD', 'name' => 'Ethereum', 'img' => 'https://upload.wikimedia.org/wikipedia/commons/0/05/Ethereum_logo_2014.svg'],
            ['symbol' => 'USDTUSD', 'name' => 'Tether (USDT)', 'img' => 'https://cryptologos.cc/logos/tether-usdt-logo.png'],
            ['symbol' => 'BNBUSD', 'name' => 'Binance Coin', 'img' => 'https://cryptologos.cc/logos/binance-coin-bnb-logo.png'],
            ['symbol' => 'XRPUSD', 'name' => 'XRP (Ripple)', 'img' => 'https://cryptologos.cc/logos/xrp-xrp-logo.png'],
            ['symbol' => 'ADAUSD', 'name' => 'Cardano', 'img' => 'https://cryptologos.cc/logos/cardano-ada-logo.png'],
            ['symbol' => 'SOLUSD', 'name' => 'Solana', 'img' => 'https://cryptologos.cc/logos/solana-sol-logo.png'],
            ['symbol' => 'DOTUSD', 'name' => 'Polkadot', 'img' => 'https://cryptologos.cc/logos/polkadot-new-dot-logo.png'],
            ['symbol' => 'LTCUSD', 'name' => 'Litecoin', 'img' => 'https://cryptologos.cc/logos/litecoin-ltc-logo.png'],
            ['symbol' => 'DOGEUSD', 'name' => 'Dogecoin', 'img' => 'https://cryptologos.cc/logos/dogecoin-doge-logo.png'],
            ['symbol' => 'AVAXUSD', 'name' => 'Avalanche', 'img' => 'https://cryptologos.cc/logos/avalanche-avax-logo.png'],
            ['symbol' => 'MATICUSD', 'name' => 'Polygon (MATIC)', 'img' => 'https://cryptologos.cc/logos/polygon-matic-logo.png'],
            ['symbol' => 'UNIUSD', 'name' => 'Uniswap', 'img' => 'https://cryptologos.cc/logos/uniswap-uni-logo.png'],
            ['symbol' => 'SHIBUSD', 'name' => 'Shiba Inu', 'img' => 'https://cryptologos.cc/logos/shiba-inu-shib-logo.png'],
            ['symbol' => 'ATOMUSD', 'name' => 'Cosmos', 'img' => 'https://cryptologos.cc/logos/cosmos-atom-logo.png'],
        ];
        
        // Create a comma-separated string of all cryptocurrency symbols
        $cryptoSymbols = implode(',', array_column($cryptos, 'symbol'));
        
        // Fetch cryptocurrency data from financialmodelingprep.com
        $cryptoApiUrl = "https://financialmodelingprep.com/api/v3/quote/{$cryptoSymbols}?apikey=BxRzCvi46ZOnN32A2sIGuhGEsH9Mksw7";

        $cryptoResponse = Http::get($cryptoApiUrl);

        // Check if API request for cryptocurrencies was successful
        if ($cryptoResponse->successful()) {
            $cryptosData = $cryptoResponse->json(); // Assuming this returns a list of cryptocurrency data

            // Iterate through the cryptocurrencies returned from the API
            foreach ($cryptosData as $cryptoData) {
                try {
                    $crypto = Crypto::where('symbol', $cryptoData['symbol'])->first();
                    if ($crypto) {
                        $crypto->update([
                            'price' => $cryptoData['price'],
                            'market_cap' => $cryptoData['marketCap'], // Ensure this field is available in the response
                            'volume' => $cryptoData['volume'], // Ensure this field is available in the response
                            'changes_percentage' => $cryptoData['changesPercentage'], // Assuming it exists in the response
                            // Add other fields as needed
                        ]);
                        $command->info("Updated cryptocurrency: {$crypto->symbol}");
                    } else {
                        $command->warn("Cryptocurrency with symbol {$cryptoData['symbol']} not found.");
                    }
                } catch (\Exception $e) {
                    Log::error("Error updating cryptocurrency {$cryptoData['symbol']}: " . $e->getMessage());
                }
            }
        } else {
            Log::error("Failed to fetch cryptocurrency data. Status: " . $cryptoResponse->status());
            $command->error('Failed to fetch cryptocurrency data.');
        }
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
                // Credit user's wallet
                $investment->user->investmentWallet->increment('balance', $profit_for_today);

                // Create a wallet transaction for the profit
                $investment->investmentTransactions()->create(
                    [
                        'user_id' => $investment->user->id,
                        'amount' => $profit_for_today,
                        'type' => 'deposit',
                        'account_type' => 'investment',
                        'description' => '$'. $profit_for_today . ' profit on ' . $investment->package->name,
                        'method' => 'wallet',
                        'status' => 'approved',
                        'is_profit' => 1
                    ]
                );

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
