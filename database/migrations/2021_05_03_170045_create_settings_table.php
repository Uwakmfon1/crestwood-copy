<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('bank_name')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('referral_earning')->nullable();
            $table->string('gold_to_usd')->default(0);
            $table->string('silver_to_usd')->default(0);
            $table->string('usd_to_ngn')->default(0);
            $table->string('gram_to_ounce')->default(0);
            $table->string('buy_rate_plus')->default(0);
            $table->string('sell_rate_plus')->default(0);
            $table->boolean('show_cash')->default(true);
            $table->boolean('invest')->default(true);
            $table->boolean('rollover')->default(true);
            $table->boolean('trade')->default(true);
            $table->boolean('withdrawal')->default(true);
            $table->boolean('auto_delete_unverified_users')->default(true);
            $table->string('auto_delete_unverified_users_after')->default('3 days');
            $table->boolean('exchange_rate_error_mail')->default(true);
            $table->boolean('pending_transaction_mail')->default(true);
            $table->string('error_mail_interval')->default('30 minutes');
            $table->string('pending_transaction_mail_interval')->default('5 minutes');
            $table->dateTime('last_exchange_rate_notification')->default(now());
            $table->dateTime('last_pending_transaction_notification')->default(now());
            $table->enum('sidebar', ['light', 'dark'])->default('dark');
            $table->timestamps();
        });

        \App\Models\Setting::create([
            'referral_earning' => 0,
            'bank_name' => 'Access Bank',
            'account_number' => '0123456789',
            'account_name' => 'SandBox'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
