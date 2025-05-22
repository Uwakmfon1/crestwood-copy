<?php 
namespace App\Services\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;

class AdminForgotPasswordService
{

  //Sends Password Reset emails
    use SendsPasswordResetEmails;

    //Shows form to request password reset
    public function showLinkRequestForm()
    {
        return view('auth.passwords.admin-email');
    }

    //Password Broker for Admin Model
    public function broker(): PasswordBroker
    {
        return Password::broker('admins');
    }

}