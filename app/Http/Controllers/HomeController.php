<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Stock;
use App\Models\Crypto;
use App\Models\Setting;
use App\Models\Trading;
use App\Models\Watchlist;
use App\Models\Investment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;


use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use App\Notifications\EmailOTPNotification;
use Illuminate\Validation\ValidationException;

use App\Services\HomeService;

class HomeController extends Controller
{
    public function __construct(public HomeService $homeService) {  }

    public function index()
    {
        return $this->homeService->index();
    }

    public function getTopAssets()
    {
        return $this->homeService->getTopAssets();
    }

    public function kyc()
    {
        return $this->homeService->kyc();
    }

    public function user_kyc()
    {
        return $this->homeService->user_kyc();
    }

    public function profile()
    {
        return $this->homeService->profile();
    }

    public function settings()
    {
        return $this->homeService->settings();
    }

    public function showMarket($product)
    {
        return $this->homeService->showMarket($product);
    }

    public function market()
    {
        return $this->homeService->market();
    }

    public function download(Request $request)
    {
        return $this->homeService->download($request);
    }

    public function updateProfile(Request $request)
    {
        return $this->homeService->updateProfile($request);
    }

    public function changePassword(Request $request)
    {
        return $this->homeService->changePassword($request);
    }

    public function verificationSuccess()
    {
        return $this->homeService->verificationSuccess();
    }
 
    

    public function getState($country_name)
    {
        return $this->homeService->getState($country_name);
    }    
   
    public function updateUserInfo(Request $request)
    {        
        return $this->homeService->updateUserInfo($request);
    }

    public function tabUpdates(Request $request)
    {
        return $this->homeService->tabUpdates($request);        
    }

    public function storeKYC(Request $request)
    {
        return $this->homeService->storeKYC($request);
    }

    public function userMode(Request $request)
    {
        return $this->homeService->userMode($request);        
    }

    public function storeWatchlist(Request $request)
    {
        return $this->homeService->storeWatchlist($request);    
    }

    public function updateTwoFactorStatus(Request $request)
    {
        return $this->homeService->updateTwoFactorStatus($request);       
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


    // Protected and private functions 
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
    
}
