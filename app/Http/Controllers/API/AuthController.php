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

    // public function register() 
    // {
    //     $credentials = request(['email', 'name', 'password', 'confirm_password', 'ref']);

    //     $validator = Validator::make($credentials, [
    //         'email' => ['required', 'unique:users,email', 'max:255'],
    //         'name' => ['required', 'max:255'],
    //         'password' => ['required', 'same:confirm_password', 'min:8'],
    //         'ref' => ['sometimes']
    //     ]);

    //     if ($validator->fails()){
    //         return response()->json($validator->messages(), 422);
    //     }

    //     $user = User::query()->create([
    //         'name' => $credentials['name'],
    //         'email' => $credentials['email'],
    //         'password' => Hash::make($credentials['password']),
    //         'otp' => Crypt::encrypt(random_int(100000, 999999)),
    //         'otp_expiry' => now()->addHours(3)
    //     ]);
    //     if (isset($credentials['ref']) && $credentials['ref']){
    //         $referee = User::all()->where('ref_code', $credentials['ref'])->first();
    //         if ($referee){
    //             $referee->referrals()->create([
    //                 'referred_id' => $user['id'],
    //                 'amount' => Setting::all()->first()['referral_earning']
    //             ]);
    //         }
    //     }
    //     $user->sendEmailVerificationNotification();
    //     $token = auth('api')->attempt(request(['email', 'password']));

    //     if (!($token)){
    //         return response()->json(['error' => 'Something went wrong'], 400);
    //     }

    //     return $this->respondWithTokenAndUser(User::query()->where('email', $credentials['email'])->first(), $token);
   
    // }

    public function sendPasswordResetOtp(Request $request)
    {
        return $this->authService->sendPasswordResetOtp($request);
    }

    // public function sendPasswordResetOtp(Request $request) 
    // {
    //     $credentials = request(['email']);
    //     $validator = Validator::make($credentials, [
    //         'email' => 'required|email'
    //     ]);
    //     if ($validator->fails())
    //         return response()->json($validator->messages(), 422);
    //     if (!$user = User::where('email', $credentials['email'])->first())
    //         return response()->json(["message" => "We can't find a user with this email address"], 400);
    //     $otp = random_int(100000, 999999);
    //     $user->update([
    //         'reset_otp' => Hash::make($otp),
    //         'reset_otp_expiry' => now()->addHour()
    //     ]);
    //     try {
    //         $user->notify(new PasswordResetOtpNotification($otp));
    //     }catch (\Exception) {
    //         logger('There was an error sending the email');
    //     }
    //     return response()->json(["message" => "Reset OTP sent successfully"]);
    // }

    public function resetPassword()
    {
        return $this->authService->resetPassword();
    }

    // public function resetPassword()
    // {
    //     $credentials = request(['email', 'password', 'confirm_password', 'otp']);
    //     $validator = Validator::make($credentials, [
    //         'email' => 'required|email',
    //         'password' => 'required|same:confirm_password|min:8',
    //         'otp' => 'required'
    //     ]);
    //     if ($validator->fails())
    //         return response()->json($validator->messages(), 422);
    //     if (!$user = User::where('email', $credentials['email'])->first())
    //         return response()->json(["message" => "We can't find a user with this email address"], 400);
    //     // Verify otp
    //     if (!Hash::check($credentials['otp'], $user['reset_otp']))
    //         return response()->json(["message" => "Otp is invalid."], 400);
    //     // Check if token has expired
    //     if (now()->gt(Carbon::parse($user['reset_otp_expiry'])))
    //         return response()->json(["message" => "Otp expired."], 400);
    //     $user->update([
    //         'password' => Hash::make($credentials['password']),
    //         'reset_otp' => null
    //     ]);
    //     return response()->json(["message" => "Password reset successful"]);
    // }

    public function resendEmailVerificationLink(Request $request) 
    {
        return $this->authService->resendEmailVerificationLink($request);
    }

    // public function resendEmailVerificationLink(Request $request) 
    // {
    //     if (auth('api')->user()->hasVerifiedEmail()) {
    //         return response()->json(["message" => "Email already verified."], 400);
    //     }

    //     auth('api')->user()->update([
    //         'otp' => Crypt::encrypt(random_int(100000, 999999)),
    //         'otp_expiry' => now()->addHours(3)
    //     ]);

    //     auth('api')->user()->sendEmailVerificationNotification();

    //     return response()->json(["message" => "Email verification link sent to your email address"]);
    // }

    public function verifyEmail(Request $request) 
    {
        return $this->verifyEmail($request);
    }

    // public function verifyEmail(Request $request) 
    // {
    //     $credentials = request(['otp']);

    //     $validator = Validator::make($credentials, [
    //         'otp' => 'required'
    //     ]);

    //     if ($validator->fails())
    //         return response()->json($validator->messages(), 422);
    //     if (auth('api')->user()['email_verified_at'])
    //         return response()->json(["message" => "Email already verified."], 400);

    //     $user = auth('api')->user();
    //     // Verify otp
    //     if (Crypt::decrypt($user['otp']) != $credentials['otp'])
    //         return response()->json(["message" => "Otp is invalid."], 400);
    //     // Check if token has expired
    //     if (now()->gt(Carbon::parse($user['otp_expiry'])))
    //         return response()->json(["message" => "Otp expired."], 400);
    //     // Verify email
    //     $user->update([
    //         'email_verified_at' => now()
    //     ]);
    //     return response()->json(["message" => "Email verified successfully"]);
    // }

    public function login() 
    {
        return $this->authService->login();
    }

    // public function login() 
    // {
    //     $credentials = request(['email', 'password']);

    //     $validator = Validator::make($credentials, [
    //         'email' => 'required',
    //         'password' => 'required'
    //     ]);

    //     if ($validator->fails()){
    //         return response()->json($validator->messages(), 422);
    //     }

    //     if (! $token = auth('api')->attempt($credentials)) {
    //         return response()->json(['error' => 'Invalid login credentials'], 401);
    //     }

    //     return $this->respondWithTokenAndUser(User::all()->where('email',$credentials['email'])->first(), $token);
    // }

 
    public function me() 
    {
        return $this->authService->me();        
    }

    // public function me() 
    // {
    //     return response()->json(new AuthResource(auth('api')->user()));
    // }

    public function logout() 
    {
      return $this->authService->logout();
    }

    // public function logout()
    // {
    //     auth('api')->logout();
    //     return response()->json(['message' => 'Successfully logged out']);
    // }
 
    public function refresh() 
    {
        return $this->authService->refresh();
    }

    // public function refresh() 
    // {
    //     return $this->respondWithToken(auth('api')->refresh());
    // }

    // protected function respondWithTokenAndUser($user, $token) 
    // {
    //     return response()->json([
    //         'data' => new AuthResource($user),
    //         'access_token' => $token,
    //         'token_type' => 'bearer'
    //     ]);
    // }

    // protected function respondWithToken($token) 
    // {
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'bearer'
    //     ]);
    // }

}
