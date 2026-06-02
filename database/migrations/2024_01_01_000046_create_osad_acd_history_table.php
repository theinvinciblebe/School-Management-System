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
        Schema::create('osad_acd_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('osad_student_id');
            $table->longText('examtype');
            $table->longText('group');
            $table->longText('board');
            $table->longText('passing_yr');
            $table->longText('special_mark');
            $table->longText('ttl_mark');
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osad_acd_history');
    }
};