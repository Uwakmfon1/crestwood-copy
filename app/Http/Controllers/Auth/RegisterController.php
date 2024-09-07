<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
            // 'account_id' => ['required', 'exists:accounts,id'], // Assuming there is an `accounts` table
            // 'wallet_id' => ['required', 'exists:wallets,id'], // Assuming there is a `wallets` table
            'phone' => ['required', 'string', 'max:20'], // Adjust max length as needed
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'], // Adjust max length as needed
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
            'nk_phone' => ['nullable', 'string', 'max:20'], // Adjust max length as needed
            'nk_relation' => ['nullable', 'string', 'max:255'],
            'nk_postal' => ['nullable', 'string', 'max:20'], // Adjust max length as needed
            'nk_country' => ['nullable', 'string', 'max:255'],
            'nk_state' => ['nullable', 'string', 'max:255'],
            'nk_address' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ref_code' => ['sometimes', 'nullable', 'string', 'exists:users,ref_code'], // Assuming ref_code exists in the users table
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
            // 'state' => $data['state'],
            // 'country' => $data['country'],
            // 'postal_code' => $data['postal_code'],
            // 'location' => $data['location'],
            // 'address' => $data['address'],
            // 'bank_name' => $data['bank_name'] ?? null,
            // 'account_number' => $data['account_number'] ?? null,
            // 'account_name' => $data['account_name'] ?? null,
            // 'account_info' => $data['account_info'] ?? null,
            // 'wallet_asset' => $data['wallet_asset'] ?? null,
            // 'wallet_network' => $data['wallet_network'] ?? null,
            // 'wallet_address' => $data['wallet_address'] ?? null,
            // 'identification' => $data['identification'] ?? null,
            // 'avatar' => $data['avatar'] ?? null,
            // 'nk_name' => $data['nk_name'],
            // 'nk_phone' => $data['nk_phone'],
            // 'nk_relation' => $data['nk_relation'] ?? null,
            // 'nk_postal' => $data['nk_postal'] ?? null,
            // 'nk_country' => $data['nk_country'] ?? null,
            // 'nk_state' => $data['nk_state'] ?? null,
            // 'nk_address' => $data['nk_address'] ?? null,
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

        return $user;
    }

}
