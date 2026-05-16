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
        Schema::create('ci_sessions', function (Blueprint $table) {
            $table->string('id', 40)->primary();
            $table->string('ip_address', 45);
            $table->unsignedInteger('timestamp')->default(0);
            $table->binary('data');
            $table->index('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ci_sessions');
    }
};