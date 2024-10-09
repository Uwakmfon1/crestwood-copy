<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradeTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trade_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_id')->constrained('trades')->onDelete('cascade');
            $table->decimal('amount', 15, 5)->default(0);
            $table->enum('type', ['buy', 'sell']);
            $table->decimal('profit', 15, 2)->default(0);
            $table->decimal('quantity', 15, 10);
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
        Schema::dropIfExists('trade_transactions');
    }
}
