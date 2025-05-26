<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\AccountAddress;
use App\Models\AccountNetwork;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\CommandController;
use App\Models\AccountCoin;
use App\Services\Admin\SettingService;

class SettingController extends Controller
{
    public function __construct(public SettingService $settingService){}

    public function index()
    {
        return $this->settingService->index();
    }
    
    public function storeNetwork(Request $request)
    {
        return $this->settingService->storeNetwork($request);
    }
    
    // Store the new address
    public function store(Request $request)
    {
        return $this->settingService->store($request);
    }

   
    public function storeNote(Request $request)
    {
        return $this->settingService->storeNote($request);
    }

    public function updateBankDetails(Request $request)
    {
        return $this->settingService->updateBankDetails($request);
    }

    public function setMobileAppVersion(Request $request)
    {
        return $this->settingService->setMobileAppVersion($request);
    }

    
    public function depositSettings(Request $request)
    {
        return $this->settingService->depositSettings($request);
    }

   
    public function destroyNetwork(AccountNetwork $network)
    {
        return $this->settingService->destroyNetwork($network);
    }
   

    public function saveSettings(Request $request)
    {
        return $this->settingService->saveSettings($request);
    }
    
}
