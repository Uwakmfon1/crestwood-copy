<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CommandController;
use App\Http\Controllers\Controller;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\EmailService;

class EmailController extends Controller
{
    public function __construct(public EmailService $emailService){  }

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
        return $this->emailService->store($request);
    }
}
