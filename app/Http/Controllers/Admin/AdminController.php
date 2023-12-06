<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.admin.index', ['admins' => Admin::query()->where('id', '!=' ,1)->get()]);
    }

    public function create()
    {
        return view('admin.admin.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:admins,email'],
            'role' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Generate password for user
        $password = Str::random(8);
//        Find role
        $role = Role::findById($request['role']);
        if (!$role){
            return back()->withErrors($validator)->withInput()->with('error', 'Role not found');
        }
//        Create admin
        $admin = Admin::create([
            'name' => $request['name'], 'email' => $request['email'],
            'password' => Hash::make($password)
        ]);
//        Create role for admin
        $admin->assignRole($role);
//        Send password to admin email
        if ($admin){
            NotificationController::sendAdminRegistrationEmailNotification($admin, $password);
            return redirect()->route('admin.admins')->with('success', 'Admin created successfully');
        }
        return back()->with('error', 'Error creating admin');
    }

    public function block(Admin $admin): \Illuminate\Http\RedirectResponse
    {
//        if admin is blocked
        if ($admin['active'] == 0){
            return back()->with('error', 'Can\'t block admin, admin already blocked');
        }
//        block admin
        if ($admin->update(['active' => 0])){
            return back()->with('success', 'Admin blocked successfully');
        }
        return back()->with('error', 'Error blocking admin');
    }

    public function unblock(Admin $admin): \Illuminate\Http\RedirectResponse
    {
//        if admin is active
        if ($admin['active'] == 1){
            return back()->with('error', 'Can\'t unblock admin, admin already active');
        }
//        unblock admin
        if ($admin->update(['active' => 1])){
            return back()->with('success', 'Admin unblocked successfully');
        }
        return back()->with('error', 'Error unblocking admin');
    }

    public function changeRole(Request $request): \Illuminate\Http\RedirectResponse
    {
        //        Validate request
        $validator = Validator::make($request->all(), [
            'admin' => ['required'],
            'role' => ['required'],
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Find admin
        $admin = Admin::find($request['admin']);
        if (!$admin){
            return back()->withErrors($validator)->withInput()->with('error', 'Admin not found');
        }
//        Find role
        $role = Role::findById($request['role']);
        if (!$role){
            return back()->withErrors($validator)->withInput()->with('error', 'Role not found');
        }
//        Change admin role
        if ($admin->syncRoles($role['name']))
            return back()->with('success', 'Admin role changed successfully');
        return back()->with('error', 'Error changing role');
    }
}
