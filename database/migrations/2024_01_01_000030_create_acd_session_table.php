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
        Schema::create('acd_session', function (Blueprint $table) {
            $table->id();
            $table->longText('name');
            $table->longText('is_dt')->nullable();
            $table->integer('is_open');
            $table->date('strt_dt')->nullable();
            $table->longText('end_dt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acd_session');
    }
};