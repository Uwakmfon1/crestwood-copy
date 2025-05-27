<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Admin\HomeService;

class HomeController extends Controller
{
    public function __construct(public HomeService $homeService){}

    public function dashboard()
    {
        return $this->homeService->dashboard();
    }

    public function investmentDashboard()
    {
        return $this->homeService->investmentDashboard();
    }

    public function tradingDashboard()
    {
        return $this->homeService->tradingDashboard();
    }
   
    public function profile()
    {
        return view('admin.profile.index');
    }

    public function market()
    {
        return view('admin.market.index');
    }

    public function investmentMaturity()
    {
        $months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
        return view('admin.maturity.index', ['months' => $months]);
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
   
    public function fetchInvestmentsMaturityWithAjax(Request $request)
    {
        return $this->homeService->fetchInvestmentsMaturityWithAjax($request);
    }

}
