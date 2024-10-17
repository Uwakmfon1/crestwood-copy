<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wallet_id')->constrained('wallets')->onDelete('cascade');
            $table->decimal('amount', 15, 2)->default(0);
            $table->enum('type', ['debit', 'credit']);
            $table->enum('method', ['coin', 'bank']);
            $table->string('currency');
            $table->text('proof')->nullable();
            $table->string('delivering')->nullable();
            $table->string('swift')->nullable();
            $table->string('account')->nullable();
            $table->time('time')->nullable();
            $table->decimal('value', 15, 5)->default(1);
            $table->enum('status', ['pending', 'approved', 'decline'])->default('pending');
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
        Schema::dropIfExists('deposits');
    }
}
