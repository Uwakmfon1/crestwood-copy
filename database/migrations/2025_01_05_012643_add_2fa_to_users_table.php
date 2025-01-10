<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add2faToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('two_factor', ['enabled', 'disabled'])->default('disabled');
            $table->string('two_factor_code')->nullable();
            $table->timestamp('two_factor_expires_at')->nullable();
            $table->enum('id_type', ['national', 'drivers', 'passport'])->nullable();
            $table->string('id_number')->nullable();
            $table->text('front_id')->nullable();
            $table->text('back_id')->nullable();
            $table->enum('is_id_approved', ['approved', 'pending', 'decline'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
