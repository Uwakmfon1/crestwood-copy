<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index()
    {
        return view('user_.investment.packages', ['title' => 'Packages', 'packages' => Package::where('investment', 'enabled')->get()]);
    }
}
