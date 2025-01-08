<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Setting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use App\Providers\RouteServiceProvider;
use App\Notifications\CustomNotification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware(['guest', 'guest:admin']);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:20'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'bank_name' => ['nullable', 'string', 'max:255'],
            'account_number' => ['nullable', 'string', 'max:255'],
            'account_name' => ['nullable', 'string', 'max:255'],
            'account_info' => ['nullable', 'string'],
            'wallet_asset' => ['nullable', 'string'],
            'wallet_network' => ['nullable', 'string'],
            'wallet_address' => ['nullable', 'string'],
            'identification' => ['nullable', 'string'],
            'avatar' => ['nullable', 'string'],
            'nk_name' => ['nullable', 'string', 'max:255'],
            'nk_phone' => ['nullable', 'string', 'max:20'],
            'nk_relation' => ['nullable', 'string', 'max:255'],
            'nk_postal' => ['nullable', 'string', 'max:20'],
            'nk_country' => ['nullable', 'string', 'max:255'],
            'nk_state' => ['nullable', 'string', 'max:255'],
            'nk_address' => ['nullable', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[0-9])(?=.*[\W_]).+$/',
                'confirmed',
            ],
            'ref_code' => ['sometimes', 'nullable', 'string', 'exists:users,ref_code'], 
        ], [
            'password.regex' => 'The password must be at least 8 characters long, include at least one number, and one special character.',
        ]);
        
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $phone = $data['phone_code'] . $data['phone'];
        
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'account_id' => 1, //$data['account_id'],
            'wallet_id' => 1, //$data['wallet_id'],
            'phone' => $phone,
            'password' => Hash::make($data['password']),
            'facebook_id' => $data['facebook_id'] ?? null,
            'google_id' => $data['google_id'] ?? null,
            'ref_code' => $data['ref_code'] ?? null,
            'gotMail' => $data['gotMail'] ?? false,
            'active' => $data['active'] ?? true,
            'otp' => Crypt::encrypt(random_int(100000, 999999)),
            'otp_expiry' => now()->addHours(3),
            'reset_otp' => $data['reset_otp'] ?? null,
            'reset_otp_expiry' => $data['reset_otp_expiry'] ?? null,
        ]);

        // Handle referral if referral code is provided
        if (isset($data['ref']) && $data['ref']) {
            $referee = User::where('ref_code', $data['ref'])->first();
            if ($referee) {
                $referee->referrals()->create([
                    'referred_id' => $user->id,
                    'amount' => Setting::first()->referral_earning,
                ]);
            }
        }

        self::sendAdminNotification($user);

        return $user;
    }

    public static function sendAdminNotification($user)
    {
        $adminUser = Admin::where('active', 2)->first();
        
        // Construct the user details message part
        $userDetailsMsg = '<b><u>User details:</u></b><br>
                            Name: <b>' . $user->first_name . ' ' . $user->last_name . '</b><br>
                            Email: <b>' . $user->email . '</b><br><br>';

        // Prepare the full title for the notification
        $fullTitle = 'NEW USER - Registeration';

        // Send the notification to the admin user
        try {
            if($adminUser)
                $adminUser->notify(new CustomNotification('Registeration', $fullTitle, $userDetailsMsg, 'Registered User'));
        } catch (\Exception $e) {
            logger('Error sending notification to admin: ' . $e->getMessage());
        }
    }

}
