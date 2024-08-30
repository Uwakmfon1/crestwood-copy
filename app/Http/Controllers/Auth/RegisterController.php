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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'state' => 'required',
            'country' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'wallet' => 'required',
            'wallet_type' => 'required',
            'nk_name' => 'required',
            'nk_country' => 'required',
            'nk_state' => 'required',
            'nk_address' => 'required',
            'nk_phone' => 'required',
            // 'account' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ref' => ['sometimes']
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
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'state' => $data['state'],
            'country' => $data['country'],
            'phone' => $data['phone'],
            'address' => $data['address'],
            'wallet' => $data['wallet'],
            'wallet_type' => $data['wallet_type'],
            'nk_name' => $data['nk_name'],
            'nk_country' => $data['nk_country'],
            'nk_state' => $data['nk_state'],
            'nk_address' => $data['nk_address'],
            'nk_phone' => $data['nk_phone'],
            'password' => Hash::make($data['password']),
            'otp' => Crypt::encrypt(random_int(100000, 999999)),
            'otp_expiry' => now()->addHours(3)
        ]);
        if (isset($data['ref']) && $data['ref']){
            $referee = User::all()->where('ref_code', $data['ref'])->first();
            if ($referee){
                $referee->referrals()->create([
                    'referred_id' => $user['id'],
                    'amount' => Setting::all()->first()['referral_earning']
                ]);
            }
        }
        return $user;
    }
}
