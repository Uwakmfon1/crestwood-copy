<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use App\Models\Setting;
use App\Models\User;
use App\Notifications\PasswordResetOtpNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'sendPasswordResetOtp', 'resetPassword']]);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/register",
     *   tags={"Auth"},
     *   summary="Register",
     *   operationId="register",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="confirm_password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *     @OA\Parameter(
     *      name="ref",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=400,
     *       description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Unprocessed Entity"
     *   )
     *)
     **/
    public function register(): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'name', 'password', 'confirm_password', 'ref']);

        $validator = Validator::make($credentials, [
            'email' => ['required', 'unique:users,email', 'max:255'],
            'name' => ['required', 'max:255'],
            'password' => ['required', 'same:confirm_password', 'min:8'],
            'ref' => ['sometimes']
        ]);

        if ($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        $user = User::query()->create([
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'otp' => Crypt::encrypt(random_int(100000, 999999)),
            'otp_expiry' => now()->addHours(3)
        ]);
        if (isset($credentials['ref']) && $credentials['ref']){
            $referee = User::all()->where('ref_code', $credentials['ref'])->first();
            if ($referee){
                $referee->referrals()->create([
                    'referred_id' => $user['id'],
                    'amount' => Setting::all()->first()['referral_earning']
                ]);
            }
        }
        $user->sendEmailVerificationNotification();
        $token = auth('api')->attempt(request(['email', 'password']));

        if (!($token)){
            return response()->json(['error' => 'Something went wrong'], 400);
        }

        return $this->respondWithTokenAndUser(User::query()->where('email', $credentials['email'])->first(), $token);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/password/reset/otp",
     *   tags={"Auth"},
     *   summary="Send password reset OTP",
     *   operationId="send password reset OTP",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=400,
     *       description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity"
     *   )
     *)
     **/
    public function sendPasswordResetOtp(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email'
        ]);
        if ($validator->fails())
            return response()->json($validator->messages(), 422);
        if (!$user = User::where('email', $credentials['email'])->first())
            return response()->json(["message" => "We can't find a user with this email address"], 400);
        $otp = random_int(100000, 999999);
        $user->update([
            'reset_otp' => Hash::make($otp),
            'reset_otp_expiry' => now()->addHour()
        ]);
        try {
            $user->notify(new PasswordResetOtpNotification($otp));
        }catch (\Exception) {
            logger('There was an error sending the email');
        }
        return response()->json(["message" => "Reset OTP sent successfully"]);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/password/reset",
     *   tags={"Auth"},
     *   summary="Reset password",
     *   operationId="reset password",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
      *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
      *   @OA\Parameter(
     *      name="confirm_password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="otp",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=400,
     *       description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity"
     *   )
     *)
     **/
    public function resetPassword(): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'password', 'confirm_password', 'otp']);
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|same:confirm_password|min:8',
            'otp' => 'required'
        ]);
        if ($validator->fails())
            return response()->json($validator->messages(), 422);
        if (!$user = User::where('email', $credentials['email'])->first())
            return response()->json(["message" => "We can't find a user with this email address"], 400);
        // Verify otp
        if (!Hash::check($credentials['otp'], $user['reset_otp']))
            return response()->json(["message" => "Otp is invalid."], 400);
        // Check if token has expired
        if (now()->gt(Carbon::parse($user['reset_otp_expiry'])))
            return response()->json(["message" => "Otp expired."], 400);
        $user->update([
            'password' => Hash::make($credentials['password']),
            'reset_otp' => null
        ]);
        return response()->json(["message" => "Password reset successful"]);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/email/resend",
     *   tags={"Auth"},
     *   summary="Resend Email Verfication Link",
     *   operationId="resend email verfication link",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=400,
     *       description="Bad Request"
     *   )
     *)
     **/
    public function resendEmailVerificationLink(Request $request): \Illuminate\Http\JsonResponse
    {
        if (auth('api')->user()->hasVerifiedEmail()) {
            return response()->json(["message" => "Email already verified."], 400);
        }

        auth('api')->user()->update([
            'otp' => Crypt::encrypt(random_int(100000, 999999)),
            'otp_expiry' => now()->addHours(3)
        ]);

        auth('api')->user()->sendEmailVerificationNotification();

        return response()->json(["message" => "Email verification link sent to your email address"]);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/email/verify",
     *   tags={"Auth"},
     *   summary="Verify email address",
     *   operationId="verify email address",
     *
     *   @OA\Parameter(
     *      name="otp",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=400,
     *       description="Bad Request"
     *   )
     *)
     **/
    public function verifyEmail(Request $request): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['otp']);

        $validator = Validator::make($credentials, [
            'otp' => 'required'
        ]);

        if ($validator->fails())
            return response()->json($validator->messages(), 422);
        if (auth('api')->user()['email_verified_at'])
            return response()->json(["message" => "Email already verified."], 400);

        $user = auth('api')->user();
        // Verify otp
        if (Crypt::decrypt($user['otp']) != $credentials['otp'])
            return response()->json(["message" => "Otp is invalid."], 400);
        // Check if token has expired
        if (now()->gt(Carbon::parse($user['otp_expiry'])))
            return response()->json(["message" => "Otp expired."], 400);
        // Verify email
        $user->update([
            'email_verified_at' => now()
        ]);
        return response()->json(["message" => "Email verified successfully"]);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/login",
     *   tags={"Auth"},
     *   summary="Login",
     *   operationId="login",
     *
     *   @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *          type="string"
     *      )
     *   ),
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=422,
     *      description="Unprocessed Entity"
     *   )
     *)
     **/
    public function login(): \Illuminate\Http\JsonResponse
    {
        $credentials = request(['email', 'password']);

        $validator = Validator::make($credentials, [
            'email' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json($validator->messages(), 422);
        }

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Invalid login credentials'], 401);
        }

        return $this->respondWithTokenAndUser(User::all()->where('email',$credentials['email'])->first(), $token);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/me",
     *   tags={"Auth"},
     *   summary="Get Authenticated User Informations",
     *   operationId="get authenticated user informations",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function me(): \Illuminate\Http\JsonResponse
    {
        return response()->json(new AuthResource(auth('api')->user()));
    }

    /**
     * @OA\Post(
     ** path="/api/auth/logout",
     *   tags={"Auth"},
     *   summary="Logout",
     *   operationId="logout",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function logout(): \Illuminate\Http\JsonResponse
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post(
     ** path="/api/auth/refresh",
     *   tags={"Auth"},
     *   summary="Refresh Authenticated User Token",
     *   operationId="refresh authenticated user token",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function refresh(): \Illuminate\Http\JsonResponse
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    protected function respondWithTokenAndUser($user, $token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => new AuthResource($user),
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    protected function respondWithToken($token): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }
}
