<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['single', 'bulk']);
            $table->text('to');
            $table->text('cc')->nullable();
            $table->text('subject');
            $table->text('body');
            $table->boolean('notification');
            $table->enum('status', ['queued', 'sending', 'success', 'failed'])->default('queued');
            $table->text('recipients')->nullable();
            $table->text('platform')->nullable();
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
        Schema::dropIfExists('emails');
    }
}
