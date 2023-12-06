<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;
use App\Models\Setting;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use function auth;

class HomeController extends Controller
{
    /**
     * @OA\Get(
     ** path="/api/app/version",
     *   tags={"App Version"},
     *   summary="Mobile App Version",
     *   operationId="mobile app version",
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
    public function appVersion(): JsonResponse
    {
        return response()->json(['data' => [
            'android' => env('MOBILE_APP_ANDROID_VERSION'),
            'ios' => env('MOBILE_APP_IOS_VERSION')
        ]]);
    }

    /**
     * @OA\Get(
     ** path="/api/activity/summary",
     *   tags={"Others"},
     *   summary="Activity Summary",
     *   operationId="activity summary",
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
    public function activitySummary(): JsonResponse
    {
        $data = $this->getDashboardData();
        return response()->json(['data' => [
            'total_investments' => auth('api')->user()->investments()->whereIn('status', ['active', 'settled'])->sum('amount'),
            'active_investments' => auth('api')->user()->investments()->where('status', 'active')->sum('amount'),
            'total_trades_ngn' => auth('api')->user()->trades()->where('status', 'success')->sum('amount'),
            'transactions' => $data['transactions'],
            'investments' => $data['investments'],
            'tradesBuy' => $data['tradesBuy'],
            'tradesSell' => $data['tradesSell'],
            'paidInvestment' => ['regular_format' => $data['paidInvestment'], 'human_friendly_format' => \App\Http\Controllers\HomeController::formatHumanFriendlyNumber($data['paidInvestment'])],
            'totalInvestment' => ['regular_format' => $data['totalInvestment'], 'human_friendly_format' => \App\Http\Controllers\HomeController::formatHumanFriendlyNumber($data['totalInvestment'])],
        ]]);
    }

    /**
     * @OA\Get(
     ** path="/api/rates",
     *   tags={"Others"},
     *   summary="Get Rates",
     *   operationId="get rates",
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
    public function getRates(): JsonResponse
    {
        return response()->json(['data' => [
            'gold' => [
                'buy' => round(\App\Http\Controllers\HomeController::fetchGoldBuyPriceInNGN(), 2),
                'sell' => round(\App\Http\Controllers\HomeController::fetchGoldSellPriceInNGN(), 2),
            ],
            'silver' => [
                'buy' => round(\App\Http\Controllers\HomeController::fetchSilverBuyPriceInNGN(), 2),
                'sell' => round(\App\Http\Controllers\HomeController::fetchSilverSellPriceInNGN(), 2),
            ]
        ]]);
    }

    /**
     * @OA\Post(
     ** path="/api/password/custom/change",
     *   tags={"Others"},
     *   summary="Change Password",
     *   operationId="change password",
     *
     *     @OA\Parameter(
     *      name="old_password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="new_password",
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
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *    @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *      @OA\Response(
     *      response=400,
     *       description="Bad Request",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function changePassword(Request $request)
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'same:confirm_password'],
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Check if user didn't auth with socials
        if (auth('api')->user()->authenticatedWithSocials()){
            return response()->json(['message' => 'Action not allowed'], 400);
        }
//      Check if old password matches
        if (!Hash::check($request['old_password'], auth('api')->user()['password'])){
            return response()->json(['message' => 'Old password incorrect'], 400);
        }
//      Change password
        if (auth('api')->user()->update(['password' => Hash::make($request['new_password'])])){
            return response()->json(['message' => 'Password changed successfully']);
        }
        return response()->json(['message' => 'Error changing password']);
    }

    /**
     * @OA\Post(
     ** path="/api/profile/update",
     *   tags={"Others"},
     *   summary="Update Profile",
     *   operationId="update profile",
     *
     *     @OA\Parameter(
     *      name="name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="phone",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="phone_code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="state",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="country",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="city",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *     @OA\Parameter(
     *      name="bank_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="account_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="account_number",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="nk_name",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="nk_phone",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="nk_address",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="avatar",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="file"
     *      )
     *   ),
     *
     *      @OA\Parameter(
     *      name="id",
     *      in="query",
     *      required=false,
     *      @OA\Schema(
     *           type="file"
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
     *
     *    @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *      @OA\Response(
     *      response=400,
     *       description="Bad Request",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function updateProfile(Request $request): JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['sometimes'],
            'phone' => ['sometimes', 'size:10'],
            'phone_code' => ['sometimes'],
            'state' => ['sometimes'],
            'country' => ['sometimes'],
            'city' => ['sometimes'],
            'address' => ['sometimes'],
            'bank_name' => ['sometimes'],
            'account_number' => ['sometimes'],
            'account_name' => ['sometimes'],
            'nk_name' => ['sometimes'],
            'nk_phone' => ['sometimes'],
            'nk_address' => ['sometimes'],
            'avatar' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:5120'],
            'id' => ['sometimes', 'mimes:jpg,png,jpeg']
        ],[
            'nk_name.required' => 'The next of kin name is required',
            'nk_phone.required' => 'The next of kin phone is required',
            'nk_address.required' => 'The next of kin address is required'
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
//        Collect data from request
        $data = $request->only([
            'name', 'phone', 'phone_code', 'state', 'country', 'city',
            'address', 'bank_name', 'account_name', 'account_number',
            'nk_name', 'nk_phone', 'nk_address']);
//        Check if user uploaded file and save
        if ($request->file('avatar')){
            if ($oldAvatar = auth()->user()['avatar'])
                try {unlink($oldAvatar);}
                catch(Exception $e){}
            $destinationPath = 'assets/photos'; // upload path
            \App\Http\Controllers\HomeController::createDirectoryIfNotExists($destinationPath);
            $transferImage = auth('api')->user()['id'].'-'. time() . '.' . $request['avatar']->getClientOriginalExtension();
            $image = Image::make($request->file('avatar'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['avatar'] = $destinationPath ."/".$transferImage;
        }
        if ($request->file('id')){
            if ($oldID = auth()->user()['identification'])
                try {unlink($oldID);}
                catch(Exception $e){}
            $destinationPath = 'assets/ids'; // upload path
            \App\Http\Controllers\HomeController::createDirectoryIfNotExists($destinationPath);
            $transferImage = auth('api')->user()['id'].'-'. time() . '.' . $request['id']->getClientOriginalExtension();
            $image = Image::make($request->file('id'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['identification'] = $destinationPath ."/".$transferImage;
        }
//        Update profile
        if (auth('api')->user()->update($data)){
            if (auth('api')->user()['gotMail'] == 0) {
                NotificationController::sendWelcomeEmailNotification(auth('api')->user());
                auth('api')->user()->update(['gotMail' => 1]);
            }
            return response()->json(['message' => 'Profile updated successfully']);
        }
        return response()->json(['message' => 'Error updating profile'], 400);
    }

    /**
     * @OA\Post(
     ** path="/api/bank/verify",
     *   tags={"Others"},
     *   summary="Verify Bank",
     *   operationId="verify bank",
     *
     *     @OA\Parameter(
     *      name="account_number",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="bank_code",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *    @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function verifyBank(Request $request): JsonResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'account_number' => ['required', 'size:10'],
            'bank_code' => ['required'],
        ]);
        if ($validator->fails()){
            return response()->json(['message' => $validator->messages()], 422);
        }
        $res = Http::withHeaders([
            'Authorization' => 'Bearer '.env('PAYSTACK_SECRET_KEY')
        ])->get('https://api.paystack.co/bank/resolve', [
            'account_number' => $request['account_number'],
            'bank_code' => $request['bank_code'],
        ]);
        return response()->json(json_decode($res, true));
    }

    /**
     * @OA\Get(
     ** path="/api/bank/details",
     *   tags={"Others"},
     *   summary="Get Sandbox Bank Details",
     *   operationId="get sandbox bank details",
     *
     *   @OA\Response(
     *      response=200,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *
     *    @OA\Response(
     *      response=422,
     *       description="Unprocessed Entity",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   )
     *)
     **/
    public function bank(): JsonResponse
    {
        return response()->json(['data' => Setting::first(['bank_name', 'account_name', 'account_number'])]);
    }

    public static function fetchPaginationLinks($data): array
    {
        return [
            "first_page_url" => $data->url(1),
            "from" => $data->firstItem(),
            "next_page_url" => $data->nextPageUrl(),
            "path" => $data->path(),
            "current_page" => $data->currentPage(),
            "current_page_url" => $data->url($data->currentPage()),
            "per_page" => $data->perPage(),
            "prev_page_url" => $data->previousPageUrl(),
            "to" => $data->lastItem(),
            "last_page" => $data->lastPage(),
            "last_page_url" => $data->url($data->lastPage()),
            "total" => $data->total(),
            "pages_url" => $data->getUrlRange(1, $data->lastPage())
        ];
    }

    protected function getDashboardData(): array
    {
        $transactionsMonth = [];
        $transactionsYear = [];
        $investmentsMonth = [];
        $investmentsYear = [];
        $tradesBuyMonth = [];
        $tradesSellMonth = [];
        $tradesBuyYear = [];
        $tradesSellYear = [];
//        Generate current month data
        for ($day = 1; $day <= date('t'); $day++){
            $transactionsMonth[$day] = round(auth('api')->user()->transactions()
                ->where('status', 'approved')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $investmentsMonth[$day] = round(auth('api')->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesBuyMonth[$day] = round(auth('api')->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesSellMonth[$day] = round(auth('api')->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
        }
//        Generate current year data
        $months = ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"];
        for ($month = 1; $month <= 12; $month++){
            $transactionsYear[$months[$month - 1]] = round(auth('api')->user()->transactions()
                ->where('status', 'approved')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $investmentsYear[$months[$month - 1]] = round(auth('api')->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesBuyYear[$months[$month - 1]] = round(auth('api')->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesSellYear[$months[$month - 1]] = round(auth('api')->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
        }
//       compute paid investment data
        $paidInvestment = auth('api')->user()->investments()
            ->where('status', 'settled')
            ->sum('amount');
//       compute total investment data
        $totalInvestment = auth('api')->user()->investments()
            ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
            ->sum('amount');
        return [
            'transactions' => ['current_month' => $transactionsMonth, 'current_year' => $transactionsYear],
            'tradesBuy' => ['current_month' => $tradesBuyMonth, 'current_year' => $tradesBuyYear],
            'tradesSell' => ['current_month' => $tradesSellMonth, 'current_year' => $tradesSellYear],
            'investments' => ['current_month' => $investmentsMonth, 'current_year' => $investmentsYear],
            'paidInvestment' => $paidInvestment,
            'totalInvestment' => $totalInvestment
        ];
    }
}
