<?php 

namespace App\Services\Admin;

use App\Models\User;
use Illuminate\Http\Request;

class ReferralService
{
     public function index()
    {
        $users = User::query()->whereHas('referrals')
                                ->with('referrals')
                                ->get()
                                ->take(100)
                                ->sortByDesc(function ($q) { $q->referrals->count(); });
        return view('admin.referral.index', ['users' => $users]);
    }
}