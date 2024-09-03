<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Trading;
use App\Notifications\EmailOTPNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;


use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {

        $savings = auth()->user()->savingsWalletBalance();
        $investment = auth()->user()->investmentWalletBalance();
        $trading = auth()->user()->tradingWalletBalance();

        $assets = Trading::where('user_id', auth()->id())->latest()->get();

        $transactions = auth()->user()->walletsTransactions()->latest()->paginate(6); 

        // Calculate the total amount of all trades
        $totalAmount = $assets->sum(function($asset) {
            return $asset->amount * $asset->quantity;
        });

        return view('user_.dashboard.index', [
            'title' => 'Dashboard', 
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
            'assets' => $totalAmount,
            'transactions' => $transactions,
        ]);
    }

    public function profile()
    {
        try {
            $banks = json_decode(Http::get('https://api.paystack.co/bank')->getBody(), true)['data'];
        }catch (\Exception $exception){
            $banks = [];
        }

        $user = auth()->user();
        $balance = auth()->user()->walletBalance();

        $savings = auth()->user()->savings()->count();
        $trading = auth()->user()->trades()->count();
        $investment = auth()->user()->investments()->count();
        
        return view('user_.profile.index', [
            'banks' => $banks, 
            'title' => 'Profile',
            'user' => $user,
            'balance' => $balance,
            'savings' => $savings,
            'trading' => $trading,
            'investment' => $investment,
        ]);
    }

    public function settings()
    {
        $user = auth()->user();
        
        return view('user_.profile.settings', [
            'title' => 'Profile',
            'user' => $user,
        ]);
    }

    public function showMarket($product)
    {
        return view('user.market.data', compact('product'));
    }

    public function market()
    {
        return view('user.market.index');
    }

    public function download(Request $request)
    {
        if ($request['path']){
            return Response::download($request['path']);
        }
        return back()->with('error', 'Error downloading file');
    }

    public function updateProfile(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'phone' => ['required', 'size:10'],
            'phone_code' => ['required'],
            'state' => ['required'],
            'country' => ['required'],
            'city' => ['required'],
            'address' => ['required'],
            'bank_name' => ['required'],
            'account_number' => ['required'],
            'account_name' => ['required'],
            'nk_name' => ['required'],
            'nk_phone' => ['required'],
            'nk_address' => ['required'],
            'avatar' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:2048'],
            'id' => ['sometimes', 'mimes:jpg,png,jpeg', 'max:2048']
        ],[
            'nk_name.required' => 'The next of kin name is required',
            'nk_phone.required' => 'The next of kin phone is required',
            'nk_address.required' => 'The next of kin address is required'
        ]);
        if ($validator->fails()){
            return back()->withInput()->withErrors($validator)->with('error', 'Invalid input data');
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
                catch(\Exception $e){}
            $destinationPath = 'assets/photos'; // upload path
            static::createDirectoryIfNotExists($destinationPath);
            $transferImage = \auth()->user()['id'].'-'. time() . '.' . $request['avatar']->getClientOriginalExtension();
            $image = Image::make($request->file('avatar'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['avatar'] = $destinationPath ."/".$transferImage;
        }
        if ($request->file('id')){
            if ($oldID = auth()->user()['identification'])
                try {unlink($oldID);}
                catch(\Exception $e){}
            $destinationPath = 'assets/ids'; // upload path
            static::createDirectoryIfNotExists($destinationPath);
            $transferImage = \auth()->user()['id'].'-'. time() . '.' . $request['id']->getClientOriginalExtension();
            $image = Image::make($request->file('id'));
            $image->save($destinationPath . '/' . $transferImage, 40);
            $data['identification'] = $destinationPath ."/".$transferImage;
        }
//        Update profile
        if (auth()->user()->update($data)){
            if (auth()->user()['gotMail'] == 0) {
                NotificationController::sendWelcomeEmailNotification(auth()->user());
                auth()->user()->update(['gotMail' => 1]);
            }

            //Generate wallet
            // $walletController = new WalletController();
            // $walletController->generateVirtualAccount();

            return back()->with('success', 'Profile updated successfully');
        }
        return back()->withInput()->with('error', 'Error updating profile');
    }

    public function changePassword(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'old_password' => ['required'],
            'new_password' => ['required', 'min:8', 'same:confirm_password'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->with('error', 'Invalid input data');
        }
//        Check if user didn't auth with socials
        if (auth()->user()->authenticatedWithSocials()){
            return back()->with('error', 'Action not allowed');
        }
//      Check if old password matches
        if (!Hash::check($request['old_password'], auth()->user()['password'])){
            return back()->with('error', 'Old password incorrect');
        }
//      Change password
        if (auth()->user()->update(['password' => Hash::make($request['new_password'])])){
            return back()->with('success', 'Password changed successfully');
        }
        return back()->with('error', 'Error changing password');
    }

    public function verificationSuccess()
    {
        return view('auth.verified');
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
            $transactionsMonth[] = round(auth()->user()->transactions()
                ->where('status', 'approved')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $investmentsMonth[] = round(auth()->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesBuyMonth[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
            $tradesSellMonth[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereDate('created_at', date('Y-m') . '-' . $day)
                ->sum('amount'));
        }
//        Generate current year data
        for ($month = 1; $month <= 12; $month++){
            $transactionsYear[] = round(auth()->user()->transactions()
                ->where('status', 'approved')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $investmentsYear[] = round(auth()->user()->investments()
                ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesBuyYear[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'buy')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
            $tradesSellYear[] = round(auth()->user()->trades()
                ->where('status', 'success')
                ->where('type', 'sell')
                ->whereMonth('created_at', $month)
                ->sum('amount'));
        }
//       compute paid investment data
        $paidInvestment = auth()->user()->investments()
            ->where('status', 'settled')
            ->sum('amount');
//       compute total investment data
        $totalInvestment = auth()->user()->investments()
            ->where(function ($q) { $q->where('status', 'active')->orwhere('status', 'settled'); })
            ->sum('amount');
        return [
            'transactions' => ['month' => $transactionsMonth, 'year' => $transactionsYear],
            'tradesBuy' => ['month' => $tradesBuyMonth, 'year' => $tradesBuyYear],
            'tradesSell' => ['month' => $tradesSellMonth, 'year' => $tradesSellYear],
            'investments' => ['month' => $investmentsMonth, 'year' => $investmentsYear],
            'paidInvestment' => $paidInvestment,
            'totalInvestment' => $totalInvestment
        ];
    }

    private function _stateCountryIDForCountryName($country_name)
    {
        return DB::table('countries')->where("name", "$country_name")->first()->id;
    }
    
    public function getState($country_name)
    {
        $country_name = urldecode($country_name);
        $country_id = self::_stateCountryIDForCountryName($country_name);
        $states = DB::table("states")
            ->where("country_id", $country_id)
            ->get('name', 'id');

        return json_encode($states);
    }

    public static function formatHumanFriendlyNumber($num)
    {
        $num = (int) $num;
        if($num>1000) {
            $x = round($num);
            $x_number_format = number_format($x);
            $x_array = explode(',', $x_number_format);
            $x_parts = array('k', 'm', 'b', 't');
            $x_count_parts = count($x_array) - 1;
            $x_display = $x;
            $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
            $x_display .= $x_parts[$x_count_parts - 1];
            return $x_display;
        }
        return $num;
    }

    public static function createDirectoryIfNotExists($path)
    {
        if (!file_exists($path)) {
            File::makeDirectory($path);
        }
    }
}
