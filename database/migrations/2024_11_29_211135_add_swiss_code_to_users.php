<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSwissCodeToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'swiss_code')) {
                $table->string('swiss_code')->nullable();
            }
            if (!Schema::hasColumn('users', 'reference')) {
                $table->string('reference')->nullable();
            }
            if (!Schema::hasColumn('users', 'ssn')) {
                $table->string('ssn')->nullable();
            }
            if (!Schema::hasColumn('users', 'dob')) {
                $table->dateTime('dob')->nullable();
            }
            if (!Schema::hasColumn('users', 'mode')) {
                $table->enum('mode', ['light', 'dark'])->default('light');
            }
            if (!Schema::hasColumn('users', 'proof')) {
                $table->text('proof')->nullable();
            }
            if (!Schema::hasColumn('users', 'is_approved')) {
                $table->enum('is_approved', ['approved', 'pending', 'decline'])->default('pending');
            }
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
