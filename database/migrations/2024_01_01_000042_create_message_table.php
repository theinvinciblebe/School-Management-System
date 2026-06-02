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
        Schema::create('message', function (Blueprint $table) {
            $table->id('message_id');
            $table->longText('message_thread_code');
            $table->longText('message');
            $table->longText('sender');
            $table->longText('timestamp');
            $table->integer('read_status')->default(0)->comment('0 unread 1 read');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message');
    }
};