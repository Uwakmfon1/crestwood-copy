<?php

namespace App\Http\Controllers;

use App\Models\Support;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SupportController extends Controller
{

    public function index()
    {
        $user = auth()->user();

        $tickets = $user->support()->latest()->get();

        return view('user_.support.index', [
            'tickets' => $tickets, 
            'user' => $user
        ]);
    }

    public function create()
    {
        return view('user_.support.create');
    }

    public function show(Support $support)
    {
        $user = auth()->user();
        $response = $support->tickets()->latest()->get();

        return view('user_.support.view', [
            'support' => $support,
            'user' => $user,
            'response' => $response,
        ]);
    }

    public function store(Request $request) 
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'body' => ['required'],
            'department' => ['required'],
            'urgency' => ['required', 'in:high,low,medium']
        ]);

        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        $ticket = $user->support()->create([
            'uuid' => $this->generateUniqueCode(),
            'subject' => $request->subject,
            'body' => $request->body,
            'urgency' => $request->urgency,
            'department' => $request->department,
            'status' => 'pending',
        ]);

        if ($ticket) {
            // NotificationController::sendTradeSuccessfulNotification($trade);
            return redirect()->route('support.index')->with('success', 'Ticket created successfully');
        }
        return back()->withInput()->with('error', 'Error processing trade');
    }

    public static function generateUniqueCode()
    {
        do {
            // Generate a random 8-digit number
            $code = mt_rand(10000000, 99999999);
        } while (\App\Models\Support::where('uuid', $code)->exists());

        return $code;
    }

    public function destroy($id)
    {
        $user = auth()->user();

        $ticket = $user->support()->where('id', $id)->first();

        if (!$ticket) {
            return redirect()->route('support.index')->with('error', 'Ticket not found');
        }

        if ($ticket->delete()) {
            return redirect()->route('support.index')->with('success', 'Ticket deleted successfully');
        }

        return back()->with('error', 'Error deleting the ticket');
    }

    public function reply(Support $support, Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'message' => ['required'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }

        // Create a new ticket reply associated with the support ticket
        $support->tickets()->create([
            'message' => $request->message,
            'sender' => 'user',
        ]);

        // Update the support ticket status to "open"
        $ticket = $support->update([
            'status' => 'open',
        ]);

        if ($ticket) {
            return back()->with('success', 'Reply added successfully and ticket reopened');
        }

        return back()->withInput()->with('error', 'Error processing reply');
    }

}
