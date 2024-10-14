<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ledgers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 20);
            $table->morphs('ledgerable');
            $table->enum('type', ['debit', 'credit']);
            $table->enum('account', ['wallet', 'invest', 'save', 'trade']);
            $table->text('reason');
            $table->string('currency_code')->default('USD');
            $table->decimal('old_balance', 20)->nullable();
            $table->decimal('new_balance', 20)->nullable();
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
        Schema::dropIfExists('ledgers');
    }
}
