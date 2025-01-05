<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommandController;
use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function index()
    {
//        CommandController::markEmailsAsFailed();
        return view('admin.email.index', ['emails' => Email::query()->latest()->paginate(20)]);
    }

    public function show(Email $email)
    {
        return view('admin.email.show', ['email' => $email]);
    }

    public function create()
    {
        return view('admin.email.create');
    }

    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'type' => ['required'],
            'to' => ['required'],
            'subject' => ['required'],
            'body' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
        
        if (Email::create([
            'type' => $request['type'], 
            'to' => $request['to'],
            'cc' => $request['cc'], 
            'subject' => $request['subject'], 'recipients' => $request['to'],
            'body' => $request['body'], 
            'platform' => $request['platform'],
            'notification' => true,
        ]))
            return redirect()->route('admin.email')->with('success', 'Email queued successfully');
        return redirect()->back()->with('error', 'Error sending email');
    }
}
