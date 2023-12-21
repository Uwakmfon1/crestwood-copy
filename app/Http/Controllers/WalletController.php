<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    public function index()
    {
        return view('user.wallet.index', ['title', 'Wallets', 'setting' => Setting::all()->first()]);
    }
}
