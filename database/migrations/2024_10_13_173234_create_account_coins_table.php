<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_coins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('symbol');
            $table->decimal('rate', 20, 5);
            $table->timestamps();
        });

        \App\Models\AccountCoin::create([
            'name' => 'Test Net',
            'symbol' => 'HH',
            'trc_wallet' => '243k5jhjw342gq0x123456789ABCDEF',
            'erc_wallet' => 'oaoireuksw3iu0x123456789ABCDEF',
            'wallet_note' => 'Default note',
            'bank_name' => 'Default Bank',
            'bank_number' => '123456',
            'bank_account_name' => 'Default Bank Name',
            'bank_account_number' => '0000000000',
            'bank_routing_number' => '999999',
            'bank_reference' => 'Default Reference',
            'bank_address' => 'Default Address',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_coins');
    }
}
