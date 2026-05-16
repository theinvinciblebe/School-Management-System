<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_thread', function (Blueprint $table) {
            $table->id('message_thread_id');
            $table->longText('message_thread_code');
            $table->longText('sender');
            $table->longText('reciever');
            $table->longText('last_message_timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_thread');
    }
};