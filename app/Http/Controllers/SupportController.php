<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Services\SupportService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportController extends Controller
{
    public function __construct(public SupportService $supportService) {}


    public function index()
    {
        return $this->supportService->index();
    }
   
    public function create()
    {
        return $this->supportService->create();
    }
   
    public function show(Support $support)
    {
        return $this->supportService->show($support);
    }

    public function store(Request $request)
    {
        return $this->supportService->store($request);
    }
    
    public function generateUniqueCode()
    {
        return $this->supportService->generateUniqueCode();
    }

    public function destroy($id)
    {
        return $this->supportService->destroy($id);
    }
  
    public function reply(Support $support, Request $request)
    {
        return $this->supportService->reply($support, $request);
    }
}
