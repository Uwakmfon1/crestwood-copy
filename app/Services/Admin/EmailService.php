<?php 
namespace App\Services\Admin;

use App\Http\Controllers\CommandController;
use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailService
{
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