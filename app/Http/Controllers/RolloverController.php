<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use App\Models\Package;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\NotificationController;
use App\Services\RolloverService;

class RolloverController extends Controller
{
    public function __construct(public RolloverService $rolloverService) {  }

    public function store(Request $request)
    {
        return $this->rolloverService->store($request);
    }

}
