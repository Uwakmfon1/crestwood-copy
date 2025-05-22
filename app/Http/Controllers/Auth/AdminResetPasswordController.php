<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use App\Services\Auth\AdminResetPasswordService;


class AdminResetPasswordController extends Controller
{
    public function __construct(public AdminResetPasswordService $adminResetPasswordService){}


    //Show form to admin where they can save new password
    public function showResetForm(Request $request, $token = null)
    {
        return $this->adminResetPasswordService->showResetForm($request, $token);
    }
    
    //returns Password broker of admin
    public function broker(): \Illuminate\Contracts\Auth\PasswordBroker
    {
        return $this->adminResetPasswordService->broker();       
    }

    //returns authentication guard of admin
    protected function guard()
    {                 
        return Auth::guard('admin');            
    }
}
