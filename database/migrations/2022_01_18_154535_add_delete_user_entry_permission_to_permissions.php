<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDeleteUserEntryPermissionToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permissions', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::table('permissions')->insert([
                ['name' => 'Delete Users', 'guard_name' => 'admin'],
            ]);
            $role = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
            $permissions = \Spatie\Permission\Models\Permission::all();
            $role->syncPermissions($permissions);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permissions', function (Blueprint $table) {
            $role = \Spatie\Permission\Models\Role::where('name', 'Super Admin')->first();
            $role->revokePermissionTo('Delete Users');
            \Illuminate\Support\Facades\DB::table('permissions')->where('name', 'Delete Users')->delete();
        });
    }
}
