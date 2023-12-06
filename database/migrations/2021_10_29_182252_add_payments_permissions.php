<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaymentsPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::table('permissions')->insert([
            ['name' => 'View Payments', 'guard_name' => 'admin'],
            ['name' => 'Resolve Payments', 'guard_name' => 'admin'],
        ]);
        $role = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
        $permissions = \Spatie\Permission\Models\Permission::all();
        $role->syncPermissions($permissions);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $permissions = \Illuminate\Support\Facades\DB::table('permissions')
            ->where('name', 'View Payments')
            ->orWhere('name', 'Resolve Payments');
        $role = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
        $role->revokePermissionTo($permissions->pluck('name'));
        $permissions->delete();
    }
}
