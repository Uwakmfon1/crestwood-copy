<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Services\Auth\AdminForgotPasswordService;


class AdminForgotPasswordController extends Controller
{
    //Sends Password Reset emails
    use SendsPasswordResetEmails;

    public function __construct(public AdminForgotPasswordService $adminForgotPasswordService)
    {
        
    }

    
    //Shows form to request password reset
    public function showLinkRequestForm()
    {
        return $this->adminForgotPasswordService->showLinkRequestForm();
    }

    //Password Broker for Admin Model
    public function broker()
    {
        return $this->adminForgotPasswordService->broker();
    }
  
}
