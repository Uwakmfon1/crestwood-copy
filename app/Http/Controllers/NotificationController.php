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
use App\Services\NotificationService;

class NotificationController extends Controller
{
    public function __construct(public NotificationService $notificationService){ }

    public function index(){ return $this->notificationService->index();}
   
    public function show($notification){return $this->notificationService->show($notification);}
   
    public function read(){return $this->notificationService->read();}
   
    public function sendWelcomeEmailNotification($user)
    {
        return $this->notificationService->sendWelcomeEmailNotification($user);
    }

    public function sendSavingsNotification($savings)
    {
        return $this->sendSavingsNotification($savings);
    }

    public function sendSettleSavingsNotification($savings, $amount)
    {
        return $this->notificationService->sendSettleSavingsNotification($savings, $amount);
    }

    public function sendInvestmentCreatedNotification($investment)
    {
        return $this->notificationService->sendInvestmentCreatedNotification($investment);
    }

    public function sendInvestmentQueuedNotification($investment)
    {
        return $this->notificationService->sendInvestmentQueuedNotification($investment);
    }

    public function sendInvestmentCancelledNotification($investment)
    {
        return $this->notificationService->sendInvestmentCancelledNotification($investment);
    }

    public function sendTradeSuccessfulNotification($trade)
    {
        return $this->notificationService->sendTradeSuccessfulNotification($trade);
    }

    public function sendTradeQueuedNotification($trade)
    {
        return $this->notificationService->sendTradeQueuedNotification($trade);
    }

    public function sendTradeCancelledNotification($trade)
    {
        return $this->notificationService->sendTradeCancelledNotification($trade);
    }
 
    public function sendDepositSuccessfulNotification($transaction)
    {
        return $this->notificationService->sendDepositSuccessfulNotification($transaction);
    }

    public function sendDepositQueuedNotification($transaction)
    {
        return $this->notificationService($transaction);
    }

    public function sendDepositCancelledNotification($transaction)
    {
        return $this->notificationService->sendDepositCancelledNotification($transaction);
    }

    public function sendWithdrawalSuccessfulNotification($transaction)
    {
        return $this->notificationService->sendWithdrawalSuccessfulNotification($transaction);
    }

    public function sendWithdrawalQueuedNotification($transaction)
    {
        return $this->notificationService->sendWithdrawalQueuedNotification($transaction);
    }

    public function sendWithdrawalCancelledNotification($transaction)
    {
        return $this->notificationService->sendWithdrawalCancelledNotification($transaction);
    }

    public function sendRolloverSuccessfulNotification($rollover)
    {
        return $this->notificationService->sendRolloverSuccessfulNotification($rollover);
    }

    public function sendRolloverInvestmentCreatedNotification($investment) 
    {
        return $this->notificationService->sendRolloverInvestmentCreatedNotification($investment);
    }


    public function sendInvestmentSettledNotification($investment)
    {
        return $this->notificationService->sendInvestmentSettledNotification($investment);
    }

    public function sendInvestmentAlmostMaturedNotification($user)
    {
        return $this->notificationService->sendInvestmentSettledNotification($user);
    }

    public function sendTransferSuccessfulNotification($transaction, $from, $to)
    {
        return $this->notificationService->sendTransferSuccessfulNotification($transaction, $from, $to);
    }

    public function sendSavingsCreatedNotification($savings)
    {
        return $this->notificationService->sendSavingsCreatedNotification($savings);
    }

    public function sendTradeNotification($trade, $type, $method)
    {
        return $this->notificationService->sendTradeNotification($trade,$type,$method);
    }
   
    public function sendIDApprovalNotification($user,$action)
    {
        return $this->notificationService->sendIDApprovalNotification($user,$action);
    }

}
