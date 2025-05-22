<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use App\Services\Auth\EmailVerificationService;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailverificationController extends Controller
{

    public function __construct(public EmailVerificationService $emailVerificationService){ }


    public function verify()
    {
        return $this->emailVerificationService->verify();
    }

    public function verifyMail(EmailVerificationRequest $request)
    {
        return $this->emailVerificationService->verifyMail($request);
    }
    
    public function verify2Factor(){
        return $this->emailVerificationService->verify2Factor();
    }

    public function verifyWithCode(Request $request)
    {
        return $this->emailVerificationService->verifyWithCode($request);
    }

    public function resend(Request $request)
    {
        return $this->emailVerificationService->resend($request);
    }

    public function sendTwoFactorCode()
    {
        return $this->emailVerificationService->sendTwoFactorCode();
    }

    public function verifyTwoFactor(Request $request)
    {
        return $this->emailVerificationService->verifyTwoFactor($request);
    }


}
