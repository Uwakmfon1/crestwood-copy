<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EmailverificationController extends Controller
{
    public function verify()
    {
        return view('auth.verify');
    }

    public function verifyMail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/email/verification/success');
    }

    public function verify2Factor()
    {
        return view('auth.two-factor');
    }

    public function verifyWithCode(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'otp' => ['required', 'numeric']
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        // Verify user is not already verified
        if (auth()->user()['email_verified_at']) {
            return back()->with('otp-error', 'Email already verified.');
        }
        // Verify otp
        if (Crypt::decrypt(auth()->user()['otp']) != $request['otp']){
            return back()->with('otp-error', 'Otp is invalid.');
        }
        // Check if token has expired
        if (now()->gt(Carbon::parse(auth()->user()['otp_expiry'])))
            return back()->with('otp-error', 'Otp expired.');
        // Verify email
        auth()->user()->update([
            'email_verified_at' => now()
        ]);
        return redirect('/email/verification/success');
    }

    public function resend(Request $request): \Illuminate\Http\RedirectResponse
    {
        auth()->user()->update([
            'otp' => Crypt::encrypt(random_int(100000, 999999)),
            'otp_expiry' => now()->addHours(3)
        ]);
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }

    public function sendTwoFactorCode()
    {
        $user = Auth::user();

        // Generate a 6-digit OTP
        $code = rand(100000, 999999);

        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        // Send the OTP via email
        $user->notify(new TwoFactorCode($code));

        return back()->with('status', 'A 2FA code has been sent to your email.');
    }

    public function verifyTwoFactor(Request $request)
    {
        $request->validate(['two_factor_code' => 'required']);

        $user = Auth::user();

        if ($user->two_factor_code !== $request->two_factor_code) {
            return back()->with('error', 'The 2FA code is invalid.');
        }

        if ($user->two_factor_expires_at->lt(now())) {
            return back()->with('error', 'The 2FA code has expired.');
        }

        $user->update([
            'two_factor_code' => null,
            'two_factor_expires_at' => null,
        ]);

        return redirect()->route('dashboard');
    }

}
