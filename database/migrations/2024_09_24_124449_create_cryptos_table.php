<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cryptos', function (Blueprint $table) {
            $table->id();
            $table->string('symbol', 10)->unique();
            $table->string('name');
            $table->string('img', 255)->default('https://pngimg.com/d/dollar_sign_PNG35.png');
            $table->decimal('price', 15, 2);
            $table->decimal('changes_percentage', 10, 4);
            $table->decimal('change', 10, 2);
            $table->decimal('day_low', 15, 2);
            $table->decimal('day_high', 15, 2);
            $table->decimal('year_low', 15, 2);
            $table->decimal('year_high', 15, 2);
            $table->bigInteger('market_cap');
            $table->decimal('price_avg_50', 15, 4);
            $table->decimal('price_avg_200', 15, 4);
            $table->string('exchange', 10);
            $table->bigInteger('volume');
            $table->bigInteger('avg_volume');
            $table->decimal('open', 15, 2);
            $table->decimal('previous_close', 15, 2);
            $table->decimal('eps', 10, 2);
            $table->decimal('pe', 10, 2);
            $table->enum('status', ['active', 'inactive']);
            $table->enum('tradeable', [1, 0]);
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
        Schema::dropIfExists('cryptos');
    }
}
