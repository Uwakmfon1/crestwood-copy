<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Notifications\CustomNotification;
use App\Notifications\AdminNotificationMail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\CustomNotificationByEmail;

class NotificationController extends Controller
{
    public function index()
    {
        return view('user.notification.index', ['title' => 'Notifications', 'notifications' => auth()->user()->notifications()->paginate(50)]);
    }

    public function show($notification)
    {
        DB::table('notifications')->where('id', $notification)->update(['read_at' => now()]);
        $notification = DB::table('notifications')->where('id', $notification)->first();
        return view('user.notification.show', ['title' => 'Notification', 'notification' => $notification]);
    }

    public function read(): \Illuminate\Http\RedirectResponse
    {
        foreach (auth()->user()->unreadNotifications()->get() as $notification) {
            $notification->markAsRead();
        }
        return redirect()->route('notifications')->with('success', 'Notifications marked as read');
    }

    public static function sendWelcomeEmailNotification($user)
    {
        $msg = 'Welcome to '.env('APP_NAME').'.<br>
                Your profile has been completed successfully and your account is active.<br>
                You can proceed to making savings and also investing in our packages to earn amazing rewards.';
        try {
            $user->notify(new CustomNotificationByEmail('Welcome to '.env('APP_NAME'), $msg, 'Login to Dashboard', route('login')));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    // public static function sendSavingsCreatedNotification($savings)
    // {
    //     $savingsDate = \Carbon\Carbon::parse($savings->savings_date);
    //     $returnDate = \Carbon\Carbon::parse($savings->return_date);
    //     $description = 'Your Savings of <b>$ '.number_format($savings->amount).'</b> in our <b>'.$savings->package["name"].'</b> package was successful.';
    //     $msg = 'Your savings of <b>$ '.number_format($savings->amount).'</b> in our <b>'.$savings->package["name"].'</b> package was successful.<br><br>
    //             <b><u>Savings details:</u></b><br>
    //             Savings package: <b>'.$savings->package["name"].'</b><br>
    //             Total amount invested: <b>$ '.number_format($savings->amount).'</b><br>
    //             ROI amount: <b>$ '.number_format($savings['amount'] / $savings->package['roi'] * $savings->package['milestone']).'</b><br>
    //             Expected returns: <b>$ '.number_format($savings->total_return).'</b><br>
    //             Savings date: <b>'.$savingsDate->format('M d, Y \a\t h:i A').'</b><br>
    //             Return date: <b>'.$returnDate->format('M d, Y \a\t h:i A').'</b><br>
    //             <b><u>Wallet details:</u></b><br>
    //             Amount debited: <b>$ '.number_format($savings->amount, 2).'</b><br>
    //             Wallet balance: <b>$ '.number_format($savings->user->nairaWallet['balance'], 2).'</b><br>
    //             ';
    //     try {
    //         $savings->user->notify(new CustomNotification('savings', 'Savings Created', $msg, $description));
    //     }catch (\Exception) {
    //         logger('There was an error sending the email');
    //     }
    // }

    public static function sendSavingsNotification($savings)
    {
        $savingsDate = \Carbon\Carbon::parse($savings->savings_date);
        $returnDate = \Carbon\Carbon::parse($savings->return_date);
        $description = 'Your Savings of <b>$ '.number_format($savings->amount).'</b> in our <b>'.$savings->package["name"].'</b> package was successful.';
        $msg = 'A Deposit of <b>$ '.number_format($savings->amount).'</b> in our <b>'.$savings->package["name"].'</b> package was successful.<br><br>
                <b><u>Savings details:</u></b><br>
                Savings package: <b>'.$savings->package["name"].'</b><br>
                Total amount invested: <b>$ '.number_format($savings->amount).'</b><br>
                ROI amount: <b>$ '.number_format($savings['amount'] / $savings->package['roi'] * $savings->package['milestone']).'</b><br>
                Expected returns: <b>$ '.number_format($savings->total_return).'</b><br>
                Savings date: <b>'.$savingsDate->format('M d, Y \a\t h:i A').'</b><br>
                Return date: <b>'.$returnDate->format('M d, Y \a\t h:i A').'</b><br>
                <b><u>Wallet details:</u></b><br>
                Amount debited: <b>$ '.number_format($savings->amount, 2).'</b><br>
                Wallet balance: <b>$ '.number_format($savings->user->nairaWallet['balance'], 2).'</b><br>
                ';
        try {
            $savings->user->notify(new CustomNotification('savings', 'Savings Deposited', $msg, $description));
            self::sendAdminNotification($savings->user, 'Investment Created', $msg, $description);

        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendSettleSavingsNotification($savings, $amount) //
    {
        $description = 'Your Savings of <b>$ '.number_format($amount).'</b> in our <b>'.$savings->package["name"].'</b> package has been settled.';
        $msg = 'Your Savings of <b>$ '.number_format($amount).'</b> in our <b>'.$savings->package["name"].'</b> package has been settled.<br><br>
                <b><u>Wallet details:</u></b><br>
                Amount credited: <b>$ '.number_format($amount, 2).'</b><br>
                Wallet balance: <b>$ '.number_format($savings->user->nairaWallet['balance'], 2).'</b><br>
                ';
        try {
            $savings->user->notify(new CustomNotification('savings', 'Savings Settled', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendInvestmentCreatedNotification($investment)
    {
        try {
            // Ensure required data exists and handle null values
            $amount = $investment->amount ?? 0;
            $packageName = $investment->package['name'] ?? 'Unknown Package';
            $roiAmount = ($investment->total_return ?? 0) - $amount;
            $totalReturn = $investment->total_return ?? 0;
            $investmentDuration = $investment->package['milestone'] .' '. $investment->package['duration'];
            $packageName = $investment->package['name'] ?? 'Unknown Package';
            $investmentDate = $investment->created_at 
                ? $investment->created_at->format('M d, Y \a\t h:i A') 
                : 'N/A';
            $returnDate = $investment->return_date 
                ? $investment->return_date->format('M d, Y \a\t h:i A') 
                : 'N/A';
            $transactionMethod = 'Wallet';
            $walletBalance = $investment->user->wallet->invest ?? 0;

            $description = "Your investment of <b>$ " . number_format($amount, 2) . "</b> in our <b>{$packageName}</b> package was successful.";
            $msg = "Your investment of <b>$ " . number_format($amount, 2) . "</b> in our <b>{$packageName}</b> package was successful.<br><br>
                    <b><u>Investment details:</u></b><br>
                    Investment package: <b>{$packageName}</b><br>
                    Total amount invested: <b>$ " . number_format($amount, 2) . "</b><br>
                    ROI amount: <b>$ " . number_format($roiAmount, 2) . "</b><br>
                    Expected returns: <b>$ " . number_format($totalReturn, 2) . "</b><br>
                    Investment duration: <b>{$investmentDuration}</b><br>
                    Investment date: <b>{$investmentDate}</b><br>
                    Return date: <b>{$returnDate}</b><br>
                    Investment method: <b>{$transactionMethod}</b><br><br>
                    <b><u>Wallet details:</u></b><br>
                    Amount debited: <b>$ " . number_format($amount, 2) . "</b><br>
                    Investment balance: <b>$ " . number_format($walletBalance, 2) . "</b><br>";

            // Send notification
            $investment->user->notify(new CustomNotification('investment', 'Investment Created', $msg, $description));
            self::sendAdminNotification($investment->user, 'Investment Created', $msg, $description);
        } catch (\Exception $e) {
            // Log the error message
            logger('Error sending investment notification: ' . $e->getMessage());
        }
    }


    public static function sendInvestmentQueuedNotification($investment) //
    {
        $description = 'Your investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been queued.';
        $msg = 'Your investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been queued.<br>
                Your investment will be automatically created once you payment has been approved.';
        try {
            $investment->user->notify(new CustomNotification('pending', 'Investment Queued', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendInvestmentCancelledNotification($investment) //
    {
        $description = 'Your queued investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been cancelled.';
        $msg = 'Your queued investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been cancelled.<br>
                Contact administrator <a href="mailto:'.env('SUPPORT_EMAIL').'">'.env('SUPPORT_EMAIL').'</a> for further complaints.';
        try {
            $investment->user->notify(new CustomNotification('cancelled', 'Investment Cancelled', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendTradeSuccessfulNotification($trade) //
    {
        $type = $trade["type"] == "buy" ? "debited" : "credited";
        $description = 'Your trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> was successful.';
        $msg = 'Your trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> was successful.<br><br>
                <b><u>Trade details:</u></b><br>
                Trade Product: <b>'.$trade["product"].'</b><br>
                Trade type: <b>'.$trade["type"].'</b><br>
                Grams traded: <b>'.$trade["grams"].'</b><br>
                Amount traded: <b>$ '.number_format($trade["amount"]).'</b><br>
                Trade method: <b>'.$trade->transaction["method"].'</b><br><br>
                <b><u>Wallet details:</u></b><br>
                Amount '.$type.': <b>$ '.number_format($trade->amount, 2).'</b><br>
                Naira Wallet balance: <b>$ '.number_format($trade->user->nairaWallet['balance'], 2).'</b><br>
                Gold Wallet balance: <b>'.round($trade->user->goldWallet['balance'], 3).' Grams</b><br>
                Silver Wallet balance: <b>'.round($trade->user->silverWallet['balance'], 3).' Grams</b><br>';
        try {
            $trade->user->notify(new CustomNotification('trade', 'Trade Successful', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendTradeQueuedNotification($trade) //
    {
        $description = 'Your trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> has been queued.';
        $msg = 'Your trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> has been queued.<br>
                Your <b>'.$trade["product"].'</b> wallet will be automatically credited once you payment has been approved.';
        try {
            $trade->user->notify(new CustomNotification('pending', 'Trade Queued', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendTradeCancelledNotification($trade) //
    {
        $description = 'Your queued trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> has been cancelled.';
        $msg = 'Your queued trade of <b>'.$trade->grams.'</b> grams of <b>'.$trade["product"].'</b> has been cancelled.<br>
                Contact administrator <a href="mailto:'.env('SUPPORT_EMAIL').'">'.env('SUPPORT_EMAIL').'</a> for further complaints.';
        try {
            $trade->user->notify(new CustomNotification('cancelled', 'Trade Cancelled', $msg, $description));
            self::sendAdminNotification($trade->user, 'Deposit Successful', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendDepositSuccessfulNotification($transaction)
    {
        $method = $transaction["type"] == 'deposit' ? 'deposit / bank transfer' : $transaction["method"];
        $description = 'Your deposit of <b>$ '.number_format($transaction['amount']).'</b> was successful.';
        $msg = 'Your deposit of <b>$ '.number_format($transaction['amount']).'</b> was successful.<br><br>
                <b><u>Deposit details:</u></b><br>
                Amount: <b>$ '.number_format($transaction['amount']).'</b><br>
                Account: <b> Wallet </b><br><br>
                <b><u>Wallet details:</u></b><br>
                Amount credited: <b>$ '.number_format($transaction->amount, 2).'</b><br>
                Wallet balance: <b>$ '.number_format($transaction->user->wallet->balance, 2).'</b><br>';
        try {
            $transaction->user->notify(new CustomNotification('deposit', 'Deposit Successful', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Deposit Successful', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendDepositQueuedNotification($transaction)
    {
        $description = 'Your deposit of <b> '.number_format($transaction['amount']).' USD</b> has been queued.';
        $msg = 'Your deposit of <b> '.number_format($transaction['amount']).' USD</b> has been queued.<br>
                Your wallet will be automatically credited once you payment has been approved.';
        try {
            $transaction->user->notify(new CustomNotification('pending', 'Deposit Queued', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Deposit Queued', $msg, $description);
        }catch (\Exception $e) {
            logger('Error sending email: ' . $e->getMessage());
        }
    }

    public static function sendDepositCancelledNotification($transaction)
    {
        $description = 'Your queued deposit of <b>$ '.number_format($transaction['amount']).'</b> has been declined.';
        $msg = 'Your queued deposit of <b>$ '.number_format($transaction['amount']).'</b> has been declined.<br>
                Contact administrator <a href="mailto:'.env('SUPPORT_EMAIL').'">'.env('SUPPORT_EMAIL').'</a> for further complaints.';
        try {
            $transaction->user->notify(new CustomNotification('cancelled', 'Deposit Declined', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Deposit Declined', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendWithdrawalSuccessfulNotification($transaction)
    {
        $description = 'Your withdrawal of <b>$ '.number_format($transaction['amount']).'</b> was successful.';
        $msg = 'Your withdrawal of <b>$ '.number_format($transaction['amount']).'</b> was successful.<br><br>
                <b><u>Withdrawal details:</u></b><br>
                Amount: <b>$ '.number_format($transaction['amount']).'</b><br>
                Account: <b> Wallet </b><br><br>
                <b><u>Wallet details:</u></b><br>
                Amount debited: <b>$ '.number_format($transaction->amount).'</b><br>
                Wallet balance: <b>$ '.number_format($transaction->user->wallet->balance, 2).'</b><br>';
        try {
            $transaction->user->notify(new CustomNotification('withdrawal', 'Withdrawal Successful', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Withdrawal Successful', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendWithdrawalQueuedNotification($transaction)
    {
        $description = 'Your withdrawal of <b>$ '.number_format($transaction['amount']).'</b> has been queued.';
        $msg = 'Your withdrawal of <b>$ '.number_format($transaction['amount']).'</b> has been queued.<br>
                Your bank account will be credited after administrator approval.';
        try {
            $transaction->user->notify(new CustomNotification('pending', 'Withdrawal Queued', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Withdrawal Queued', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendWithdrawalCancelledNotification($transaction)
    {
        $description = 'Your queued withdrawal of <b>$ '.number_format($transaction['amount']).'</b> has been declined.';
        $msg = 'Your queued withdrawal of <b>$ '.number_format($transaction['amount']).'</b> has been declined.<br>
                Your wallet has been refunded, contact administrator <a href="mailto:'.env('SUPPORT_EMAIL').'">'.env('SUPPORT_EMAIL').'</a> for further complaints.';
        try {
            $transaction->user->notify(new CustomNotification('cancelled', 'Withdrawal Declined', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Withdrawal Declined', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendRolloverSuccessfulNotification($rollover) //
    {
        $description = 'Your rollover of <b>'.number_format($rollover['slots']).'</b> slots in <b>'.$rollover->package['name'].'</b> package has been queued.';
        $msg = 'Your rollover of <b>'.number_format($rollover['slots']).'</b> slots in <b>'.$rollover->package['name'].'</b> package has been queued.<br>
                A new investment will be created when your current investment is settled.';
        try {
            $rollover->investment->user->notify(new CustomNotification('pending', 'Rollover Queued', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendRolloverInvestmentCreatedNotification($investment) //
    {
        $description = 'Your rollover investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package was successful.';
        $msg = 'Your rollover investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package was successful.<br><br>
                <b><u>Investment details:</u></b><br>
                Investment package: <b>'.$investment->package["name"].'</b><br>
                Total amount invested: <b>$ '.number_format($investment->amount).'</b><br>
                ROI amount: <b>$ '.number_format($investment->total_return - $investment->amount).'</b><br>
                Expected returns: <b>$ '.number_format($investment->total_return).'</b><br>
                Investment duration: <b>'.$investment['return_date']->diff($investment['investment_date'])->m.' month(s)</b><br>
                Investment date: <b>'.$investment->investment_date->format('M d, Y \a\t h:i A').'</b><br>
                Return date: <b>'.$investment->return_date->format('M d, Y \a\t h:i A').'</b><br>
                Investment method: <b>'.$investment->transaction["method"].'</b><br><br>
                <b><u>Wallet details:</u></b><br>
                Amount debited: <b>$ '.number_format($investment->amount, 2).'</b><br>
                Wallet balance: <b>$ '.number_format($investment->user->nairaWallet['balance'], 2).'</b><br>
                ';
        try {
            $investment->user->notify(new CustomNotification('investment', 'Rollover Investment Created', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendInvestmentSettledNotification($investment) //
    {
        $description = 'Your investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been settled.';
        $msg = 'Your investment of <b>$ '.number_format($investment->amount).'</b> in our <b>'.$investment->package["name"].'</b> package has been settled.<br><br>
                <b><u>Wallet details:</u></b><br>
                Amount credited: <b>$ '.number_format($investment->total_return, 2).'</b><br>
                Wallet balance: <b>$ '.number_format($investment->user->nairaWallet['balance'], 2).'</b><br>
                ';
        try {
            $investment->user->notify(new CustomNotification('investment', 'Investment Settled', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendInvestmentAlmostMaturedNotification($user) //
    {
        $description = 'This is to notify you that your investment will mature within the next thirty (30) days.<br>';
        $msg = 'This is to notify you that your investment will mature within the next thirty (30) days.<br><br>
                Remember, you have the option to request for a full withdrawal of invested sum plus returns or simply rollover your investment. You can login to your account at any time after the maturity date of your investment to process this.<br><br>
                <table border="0" cellpadding="0" cellspacing="0" role="presentation" style="box-sizing: border-box; margin: auto; text-align: center; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
                <tr>
                <td style="box-sizing: border-box; margin: auto; text-align: center; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative;">
                <a href="'.route('login').'" class="button button-primary" target="_blank" rel="noopener" style="box-sizing: border-box; margin: auto; text-align: center; font-family: -apple-system, BlinkMacSystemFont, \'Segoe UI\', Roboto, Helvetica, Arial, sans-serif, \'Apple Color Emoji\', \'Segoe UI Emoji\', \'Segoe UI Symbol\'; position: relative; -webkit-text-size-adjust: none; border-radius: 4px; color: #fff; display: inline-block; overflow: hidden; text-decoration: none; background-color: #2d3748; border-bottom: 8px solid #2d3748; border-left: 18px solid #2d3748; border-right: 18px solid #2d3748; border-top: 8px solid #2d3748;">Click here to login</a>
                </td>
                </tr>
                </table><br>
                We are available for any further enquiries or assistance. You can email us at support@sandboxnextin.net<br><br>
                Thank you for choosing us as your preferred partner in growing your wealth.<br><br>
                ';
        try {
            $user->notify(new CustomNotification('investment', 'Investment Maturity - 30days Notice', $msg, $description));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendTransferSuccessfulNotification($transaction, $from, $to)
    {
        $description = 'Your transfer of <b>$ '.number_format($transaction['amount']).'</b> was successful.';
        $msg = 'Your transfer of <b>$ '.number_format($transaction['amount']).'</b> was successful.<br><br>
                <b><u>Transfer details:</u></b><br>
                Amount: <b>$ '.number_format($transaction['amount']).'</b><br><br>
                From Account: <b> '. $from .'</b><br><br>
                To Account: <b> '. $to .' </b><br><br>';
                
        try {
            $transaction->user->notify(new CustomNotification('withdrawal', 'Funds Transfer Successful', $msg, $description));
            self::sendAdminNotification($transaction->user, 'Funds Transfer Successful', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendSavingsCreatedNotification($savings)
    {
        $planName = $savings->plan->name ?? 'N/A';
        $userName = $savings->user->name ?? 'User';
        $totalAnswers = $savings->answers->count() ?? 0;
        $createdAt = $savings->created_at->format('M d, Y \a\t h:i A');

        $description = 'Your savings plan, <b> ' . $planName . ' </b>, has been successfully created';
        $msg = 'Your savings plan, <b> ' . $planName . ' </b>, has been successfully created.<br><br>
                <b><u>Savings Details:</u></b><br><br>
                Plan Name:: <b>'. $planName .'</b><br>
                Status: <b> '. ucfirst($savings->status) .'</b><br>
                Created At: <b> '.$createdAt.'</b><br><br>';
        try {
            $savings->user->notify(new CustomNotification('investment', 'Savings Plan Created', $msg, $description));
            self::sendAdminNotification($savings->user, 'Savings Plan Created', $msg, $description);
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendTradeNotification($trade, $type, $method)
    {
        try {
            // Ensure required data exists and handle null values
            $tradeCategory = ucfirst($type); // 'Stock' or 'Crypto'
            $tradeType = ucfirst($method); // 'Buy' or 'Sell' based on method (now directly a string)
            $symbol = $trade->symbol ?? 'Unknown Symbol';
            $quantity = $trade->quantity ?? 0;
            $tradeAmount = $trade->amount ?? 0;
            $pricePerUnit = $trade->purchase_amount ?? 0;
            $totalValue = $quantity * $pricePerUnit;

            $tradeDate = $trade->created_at
                ? $trade->created_at->format('M d, Y \a\t h:i A')
                : 'N/A';

            $walletBalance = $trade->user->wallet->trade ?? 0;

            // Construct the message and description
            $description = "Your <b>{$tradeType}</b> trade of <b>{$quantity} {$symbol}</b> was successful.";
            $msg = "Your <b>{$tradeType}</b> trade of <b>{$quantity} {$symbol}</b> was successful.<br><br>
                    <b><u>Trade Details:</u></b><br>
                    Trade Category: <b>{$tradeCategory}</b><br>
                    Trade type: <b>{$tradeType}</b><br>
                    {$tradeCategory} symbol: <b>{$symbol}</b><br>
                    Quantity: <b>" . number_format($quantity, 5) . "</b><br>
                    Price per unit: <b>$" . number_format($pricePerUnit, 2) . "</b><br>
                    Total trade value: <b>$" . number_format($totalValue, 2) . "</b><br>
                    Trade date: <b>{$tradeDate}</b><br><br>
                    <b><u>Account details:</u></b><br>
                    Amount " . ($method === 'buy' ? 'debited' : 'credited') . ": <b>$ " . number_format($tradeAmount, 2) . "</b><br>
                    Current trading balance: <b>$ " . number_format($walletBalance, 2) . "</b><br>";

            // Send notification
            $trade->user->notify(new CustomNotification('trade', 'Trade Notification', $msg, $description));
            self::sendAdminNotification($trade->user, 'Trade Notification', $msg, $description);
        } catch (\Exception $e) {
            // Log the error message
            logger('Error sending trade notification: ' . $e->getMessage());
        }
    }

    public static function sendAdminNotification($user, $title, $msg, $description)
    {
        $adminUser = Admin::where('active', 2)->first();

        // Construct the user details message part
        $userDetailsMsg = '<b><u>User details:</u></b><br>
                            Name: <b>' . $user->first_name . ' ' . $user->last_name . '</b><br>
                            Email: <b>' . $user->email . '</b><br><br><br>';
        
        // Now, construct the full message
        $msg = $userDetailsMsg . $msg;

        // Prepare the full title for the notification
        $fullTitle = 'USER ACTIVITY - ' . $title;
        $fullDescription = $user->first_name . ' - ' . $description;

        // Send the notification to the admin user
        try {
            if($adminUser)
                $adminUser->notify(new CustomNotification('default', $fullTitle, $msg, $fullDescription));
        } catch (\Exception $e) {
            logger('Error sending notification to admin: ' . $e->getMessage());
        }
    }

    public static function sendIDApprovalNotification($user, $action)
    {
        // Set appropriate message based on the action
        if ($action == 'approved') {
            $subject = 'ID Verification Approved';
            $message = 'We’re pleased to let you know that your ID verification has been successfully approved. Your account is now verified and ready for use.';
        } else {
            $subject = 'ID Verification Declined';
            $message = 'Unfortunately, your ID verification could not be approved at this time. Please review the information provided or contact support for assistance.';
        }
    
        // Format the email content
        $msg = $message . '<br><br>' .
            'If you have any questions or need assistance, feel free to reach out to us at support@crestwoodcapitals.com.<br><br>' .
            'Thank you for choosing Crestwood Capital Management.';
    
        // Send the email notification to the user
        try {
            $user->notify(new CustomNotification('account', $subject, $msg, $msg));
        } catch (\Exception $e) {
            logger('There was an error sending the notification: ' . $e->getMessage());
        }
    }
}
