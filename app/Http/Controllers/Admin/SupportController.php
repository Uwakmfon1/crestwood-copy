<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupportController extends Controller
{
    public function index()
    {
        return view('admin.support.index', [
            'tickets' => Support::latest()->get(),
        ]);
    }

    public function show(Support $support)
    {
        $response = $support->tickets()->latest()->get();

        $user = auth()->user();
        
        return view('admin.support.view', [
            'support' => $support,
            'user' => $user,
            'response' => $response,
        ]);
    }

    public function reply(Support $support, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        $support->tickets()->create([
            'message' => $request->message,
            'sender' => 'admin',
        ]);
        $ticket = $support->update([
            'status' => 'open',
        ]);

        if ($ticket) {
            return back()->with('success', 'Reply added successfully and ticket reopened');
        }

        return back()->withInput()->with('error', 'Error processing reply');
    }

}
