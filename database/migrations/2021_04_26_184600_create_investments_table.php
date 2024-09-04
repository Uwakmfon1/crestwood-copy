<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('package_id');
            $table->string('amount');
            $table->enum('duration_type', ['daily', 'monthly', 'weekly', 'yearly']);
            $table->string('duration');
            $table->string('roi_method');
            $table->string('total_return');
            $table->dateTime('investment_date');
            $table->dateTime('return_date');
            $table->enum('status', ['active', 'pending', 'cancelled', 'settled']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('investments');
    }
}
