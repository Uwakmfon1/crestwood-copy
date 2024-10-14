<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountNetworksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_networks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('account_coin_id')->constrained('account_coins')->onDelete('cascade');
            $table->string('name');
            $table->string('symbol');
            $table->decimal('fee', 20, 5)->default(0);
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
        Schema::dropIfExists('account_networks');
    }
}
