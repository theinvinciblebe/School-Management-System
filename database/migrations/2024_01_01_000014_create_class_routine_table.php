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
        Schema::create('class_routine', function (Blueprint $table) {
            $table->id('class_routine_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('subject_id');
            $table->integer('time_start');
            $table->integer('time_end');
            $table->string('day');
            $table->timestamps();
            $table->foreign('class_id')
                ->references('class_id')
                ->on('class')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('subject_id')
                ->references('subject_id')
                ->on('subject')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_routine');
    }
};