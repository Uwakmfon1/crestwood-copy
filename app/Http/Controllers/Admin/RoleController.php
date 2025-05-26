<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\Admin\RoleService;
use Spatie\Permission\Models\Role;

class RoleController 
{
    public function __construct(public RoleService $roleService){}

    public function index() 
    {
        return $this->roleService->index();
    }
  
    public function create()
    {
        return $this->roleService->create();
    }
    
    public function store(Request $request)
    {
        return $this->roleService->store($request);
    }

    public function edit(Role $role)
    {
        return $this->roleService->edit($role);
    }

    public function update(Role $role, Request $request)
    {
        return $this->roleService->update($role,$request);
    }

    public function destroy(Role $role)
    {
        return $this->roleService->destroy($role);
    }
}
