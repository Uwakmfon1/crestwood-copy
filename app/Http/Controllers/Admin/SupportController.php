<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Admin\SupportService;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function __construct
    (
        public SupportService $supportService,
    ){ }

    public function index()
    {
        return $this->supportService->index();
    }
    
    public function show(Support $support)
    {
        return $this->supportService->show($support);
    }
   
    public function reply(Support $support, Request $request)
    {
        return $this->supportService->reply($support,$request);
    }
    
}
