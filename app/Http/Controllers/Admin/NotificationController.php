<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Notifications\CustomNotificationByEmail;
use App\Notifications\CustomNotificationByStaticEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Services\Admin\NotificationService;


class NotificationController extends Controller
{
    public function __construct(public NotificationService $notificationService) {}

    public function sendAdminRegistrationEmailNotification($admin, $password)
    {
        return $this->notificationService->sendAdminRegistrationEmailNotification($admin, $password);
    }

    public function sendPendingTransactionNotificationOnScheduleToAdmin($transactions)
    {
        return $this->notificationService->sendPendingTransactionNotificationOnScheduleToAdmin($transactions);
    }

    public function dispatchExchangeRateErrorNotification()
    {
        return $this->notificationService->dispatchExchangeRateErrorNotification();
    }
    
}
