<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceBreakdownToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('gold_buy_price_diff')->default(0);
            $table->string('gold_sell_price_diff')->default(0);
            $table->string('silver_buy_price_diff')->default(0);
            $table->string('silver_sell_price_diff')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('gold_buy_price_diff');
            $table->dropColumn('gold_sell_price_diff');
            $table->dropColumn('silver_buy_price_diff');
            $table->dropColumn('silver_sell_price_diff');
        });
    }
}
