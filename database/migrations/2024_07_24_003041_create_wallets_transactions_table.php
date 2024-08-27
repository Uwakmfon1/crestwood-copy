<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('type', ['deposit', 'withdrawal']);
            $table->enum('account_type', ['savings', 'trading', 'investment']);
            $table->morphs('transactable');
            $table->enum('status', ['approved', 'pending', 'declined']);
            $table->enum('method', ['wallet', 'card', 'deposit'])->nullable();
            $table->string('description');
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
        Schema::dropIfExists('wallets_transactions');
    }
}
