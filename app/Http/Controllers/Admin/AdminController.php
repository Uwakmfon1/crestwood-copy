<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Services\Admin\AdminService;
use App\Services\Admin\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function __construct(
        public NotificationService $notificationService,
        public AdminService $adminService 
    ){}
    public function index()
    {
        return view('admin.admin.index', ['admins' => Admin::query()->where('id', '!=' ,1)->get()]);
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request)
    {
        return $this->adminService->store($request);
    }

    public function block(Admin $admin) 
    {
        return $this->adminService->block($admin);
    }

    public function unblock(Admin $admin)
    {
        return $this->adminService->unblock($admin);
    }

    public function changeRole(Request $request)
    {
        return $this->adminService->changeRole($request);
    }

   
}
