<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_trades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crypto_id');
            $table->foreignId('user_id');
            $table->string('crypto_symbol', 10);
            $table->decimal('amount', 15, 2)->default(0);
            $table->decimal('entry_price');
            $table->decimal('exit_price')->nullable();
            $table->string('lots', 10);
            $table->enum('type', ['buy', 'sell']);
            $table->enum('status', ['open', 'closed']);
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
        Schema::dropIfExists('crypto_trades');
    }
}
