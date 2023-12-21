<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index', ['roles' => Role::query()->where('name', '!=', 'Super Admin')->get()]);
    }

    public function create()
    {
        return view('admin.role.create');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name'],
            'permissions' => ['required']
        ],[
            'permissions.required' => 'Select at least one permission'
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Create role
        $role = Role::create([
            'name' => $request['name']
        ]);
//        Sync permissions to role
        $permissions = $request['permissions'];
        $permissions[] = 'View Quick Overview';
        if ($role){
            $role->syncPermissions($permissions);
            return redirect()->route('admin.roles')->with('success', 'Role created successfully');
        }
        return back()->with('error', 'Error creating role');
    }

    public function edit(Role $role)
    {
        return view('admin.role.edit', ['role' => $role]);
    }

    public function update(Role $role, Request $request): \Illuminate\Http\RedirectResponse
    {
//        Validate request
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'unique:roles,name,'.$role['id']],
            'permissions' => ['required']
        ],[
            'permissions.required' => 'Select at least one permission'
        ]);
        if ($validator->fails()){
            return back()->withErrors($validator)->withInput()->with('error', 'Invalid input data');
        }
//        Update role
        $role->update([
            'name' => $request['name']
        ]);
//        Sync permissions to role
        $permissions = $request['permissions'];
        $permissions[] = 'View Quick Overview';
        if ($role->syncPermissions($permissions))
            return redirect()->route('admin.roles')->with('success', 'Role updated successfully');
        return back()->with('error', 'Error updating role');
    }

    public function destroy(Role $role): \Illuminate\Http\RedirectResponse
    {
//        Check if role has admin
        if (Admin::role($role['name'])->count() > 0)
            return back()->with('error', 'Can\'t delete role, admins already assigned');
//        Delete role if no admin
        if ($role->delete())
            return back()->with('success', 'Role deleted successfully');
        return back()->with('error', 'Error deleting role');
    }
}
