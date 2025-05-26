<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Models\Package;
use App\Models\Investment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\RolloverService;
use Illuminate\Support\Facades\Validator;

class RolloverController extends Controller
{
    public function __construct(public RolloverService $rolloverService)   {}

        public function store(Request $request)
        {
            return $this->rolloverService->store($request);
        }
}
