<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('investment_id')->nullable();
            $table->foreignId('trade_id')->nullable();
            $table->foreignId('saving_id')->nullable();
            $table->enum('type', ['deposit', 'withdrawal', 'savings', 'investment']);
            $table->string('amount');
            $table->string('description');
            $table->enum('method', ['wallet', 'card', 'deposit'])->nullable();
            $table->enum('status', ['approved', 'pending', 'declined']);
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
        Schema::dropIfExists('transactions');
    }
}
