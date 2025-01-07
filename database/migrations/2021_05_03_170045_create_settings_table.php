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
            $table->text('crypto_note')->nullable();
            $table->text('bank_note_initial')->nullable();
            $table->text('bank_note_final')->nullable();
            $table->string('bank_address')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('bank_phone')->nullable();
            $table->string('bank_country')->nullable();
            $table->string('bank_state')->nullable();
            $table->string('bank_address_address')->nullable();
            $table->string('bank_reference')->nullable();
            $table->string('routing')->nullable();

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
            'bank_address' => 'Bell Str 1157 City',
            'bank_phone' => '0123456789',
            'bank_country' => 'United State',
            'bank_state' => 'Texas',
            'bank_address_address' => 'Houston',
            'bank_reference' => 'JUUTrRvXEKKBDXWQTIMO664NYVE33B',
            'account_name' => 'Crestwood Capital Management ',
            'account_number' => '0123456789',
            'bank_name' => 'Swiss Bank Finland',
            'swift_code' => '0065587',

            'crypto_note' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam facere et quaerat optio reprehenderit soluta deleniti magni sapiente, ipsam atque ea cum veritatis aut enim ipsum impedit explicabo ipsa. Tempora.',
            'bank_note_initial' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam facere et quaerat optio reprehenderit soluta deleniti magni sapiente, ipsam atque ea cum veritatis aut enim ipsum impedit explicabo ipsa. Tempora.',
            'bank_note_final' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam facere et quaerat optio reprehenderit soluta deleniti magni sapiente, ipsam atque ea cum veritatis aut enim ipsum impedit explicabo ipsa. Tempora.',
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
