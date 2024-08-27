<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTradingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tradings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id');
            $table->foreignId('user_id');
            $table->string('stock_symbol', 10);
            $table->string('quantity', 10);
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('type', ['buy', 'sell']);
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
        Schema::dropIfExists('tradings');
    }
}
