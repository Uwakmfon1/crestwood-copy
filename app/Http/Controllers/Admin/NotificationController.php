<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Notifications\CustomNotificationByEmail;
use App\Notifications\CustomNotificationByStaticEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
    public static function sendAdminRegistrationEmailNotification($admin, $password)
    {
        $msg = 'Welcome to '.env('APP_NAME').'.<br>
                An administrator account with role of <b>'.$admin->roles()->first()['name'].'</b> has been created for you, find your login credentials below.<br><br>
                Email: <b>'.$admin['email'].'</b><br>
                Password: <b>'.$password.'</b><br>';
        try {
            $admin->notify(new CustomNotificationByEmail('Administrator Welcome', $msg, 'Login to Dashboard', route('admin.login')));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function sendPendingTransactionNotificationOnScheduleToAdmin($transactions)
    {
        if ($transactions > 1){
            $msg = 'There are <b>'.$transactions.'</b> pending transactions awaiting administrator action.<br>
                Kindly attend to these transaction as soon as possible<br>';
            $title = $transactions.' Pending Transactions';
        }else{
            $msg = 'There is <b>'.$transactions.'</b> pending transaction awaiting administrator action.<br>
                Kindly attend to these transaction as soon as possible<br>';
            $title = $transactions.' Pending Transaction';
        }
        try {
            Notification::route('mail', env('ADMIN_EMAIL'))->notify(new CustomNotificationByStaticEmail($title, $msg, 'View Transactions', route('admin.transactions')));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }

    public static function dispatchExchangeRateErrorNotification()
    {
        $settings = Setting::all()->first();
        $msg = 'There was an error trying to update the exchange rates, see current exchange rates details below.<br><br>
                The current USD to NGN exchange rate in use: <br>
                Buy: <b>₦ '.($settings['usd_to_ngn'] + $settings['gold_buy_rate_plus']).' per USD</b><br>
                Sell: <b>₦ '.($settings['usd_to_ngn'] + $settings['gold_sell_rate_plus']).' per USD</b><br><br>
                Gold trade rates: <br>
                Buy USD: <b>$ '.number_format($settings['gold_to_usd'], 2).' per Unit</b><br>
                Buy NGN: <b>₦ '.number_format($settings['gold_to_usd'] * ($settings['usd_to_ngn'] + $settings['buy_rate_plus']), 2).' per Unit</b><br>
                Sell USD: <b>$ '.number_format($settings['gold_to_usd'], 2).' per Unit</b><br>
                Sell NGN: <b>₦ '.number_format($settings['gold_to_usd'] * ($settings['usd_to_ngn'] + $settings['sell_rate_plus']), 2).' USD per Unit</b><br><br>
                Silver trade rates: <br>
                Buy USD: <b>$ '.number_format($settings['silver_to_usd'], 2).' per Unit</b><br>
                Buy NGN: <b>₦ '.number_format($settings['silver_to_usd'] * ($settings['usd_to_ngn'] + $settings['buy_rate_plus']), 2).' per Unit</b><br>
                Sell USD: <b>$ '.number_format($settings['silver_to_usd'], 2).' per Unit</b><br>
                Sell NGN: <b>₦ '.number_format($settings['silver_to_usd'] * ($settings['usd_to_ngn'] + $settings['sell_rate_plus']), 2).' USD per Unit</b><br><br>
                Verify exchange rate manually and update on your dashboard.';
        try {
            Notification::route('mail', env('ADMIN_EMAIL'))->notify(new CustomNotificationByStaticEmail('Exchange Rate Update Error',$msg, 'Update Rate Manually', route('admin.settings'), [env('SUPPORT_EMAIL'), env('TECHNICAL_SUPPORT_EMAIL')]));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
    }
}
