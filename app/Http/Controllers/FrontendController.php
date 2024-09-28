<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{
    /**
     * undocumented function summary
     *
     * Undocumented function long description
     *
     * @param Type $var Description
     * @return type
     * @throws conditon
     **/
    public function index()
    {
        return view('frontend.index');
    }

    public function investment()
    {
        return view('frontend.investment');
    }

    public function cash()
    {
        return view('frontend.cash');
    }

    public function stocks()
    {
        return view('frontend.stocks');
    }

    public function blog()
    {
        return view('frontend.blog');
    }

    public function retirement()
    {
        return view('frontend.retirement');
    }

    public function college()
    {
        return view('frontend.college');
    }
}
