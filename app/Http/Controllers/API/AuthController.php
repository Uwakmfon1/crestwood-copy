<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\API\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(public AuthService $authService) 
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'sendPasswordResetOtp', 'resetPassword']]);
    }

    public function register()
    {
        return $this->authService->register();
    }    

    public function sendPasswordResetOtp(Request $request)
    {
        return $this->authService->sendPasswordResetOtp($request);
    }
    
    public function resetPassword()
    {
        return $this->authService->resetPassword();
    }

    public function resendEmailVerificationLink(Request $request) 
    {
        return $this->authService->resendEmailVerificationLink($request);
    }

    public function verifyEmail(Request $request) 
    {
        return $this->verifyEmail($request);
    }

    public function login() 
    {
        return $this->authService->login();
    }
 
    public function me() 
    {
        return $this->authService->me();        
    }

    public function logout() 
    {
      return $this->authService->logout();
    }

    public function refresh() 
    {
        return $this->authService->refresh();
    }

}
