<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\TwoFactorCode;  // Assuming you have this notification
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['guest', 'guest:admin'])->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return void
     */
    protected function authenticated($request, $user)
    {
        // Check if the user has 2FA enabled
        if ($user->two_factor == 'enabled') {
            // Generate and send the 2FA code
            $this->sendTwoFactorCode($user);

            // Redirect to the 2FA verification page
            return redirect()->route('user.verifyTwoFactor');
        }

        return redirect()->intended($this->redirectPath());
    }

    /**
     * Send the two-factor authentication code to the user's email.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    protected function sendTwoFactorCode($user)
    {
        // Generate a 6-digit OTP
        $code = rand(100000, 999999);

        // Store the code and its expiration time in the database
        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        // Send the OTP via email
        $user->notify(new TwoFactorCode($code));
    }
}

