<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Services\Auth\SocialService;

class SocialController extends Controller
{
    public function __construct(public SocialService $socialService) { }

    public function redirect($provider)
    {
        return $this->socialService->redirect($provider);
    }
   
    public function socialLoginAttempt($provider)
    {
        return $this->socialService->socialLoginAttempt($provider);
    }
   
    protected function getUser($id) {
        return User::where(function ($q) use ($id) {
            $q->where('facebook_id', $id)
                ->orWhere('google_id', $id);
        })->first();
    }
}
