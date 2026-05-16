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
        Schema::create('language', function (Blueprint $table) {
            $table->id('phrase_id');
            $table->longText('phrase');
            $table->longText('english');
            $table->longText('bengali');
            $table->longText('spanish');
            $table->longText('arabic');
            $table->longText('dutch');
            $table->longText('russian');
            $table->longText('chinese');
            $table->longText('turkish');
            $table->longText('portuguese');
            $table->longText('hungarian');
            $table->longText('french');
            $table->longText('greek');
            $table->longText('german');
            $table->longText('italian');
            $table->longText('thai');
            $table->longText('urdu');
            $table->longText('hindi');
            $table->longText('latin');
            $table->longText('indonesian');
            $table->longText('japanese');
            $table->longText('korean');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('language');
    }
};