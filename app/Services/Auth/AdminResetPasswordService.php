<?php 

namespace App\Services\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Contracts\Auth\PasswordBroker;


class AdminResetPasswordService 
{

     //admin redirect path
    protected $redirectTo = '/admin/dashboard';

    //trait for handling reset Password
    use ResetsPasswords;


    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.admin-reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    //returns Password broker of admin
    public function broker(): PasswordBroker
    {
        return Password::broker('admins');
    }

   

}