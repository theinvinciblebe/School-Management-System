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
        Schema::create('subject', function (Blueprint $table) {
            $table->id('subject_id');
            $table->string('name');
            $table->unsignedInteger('class_id')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();
            $table->timestamps();
            $table->foreign('class_id')
                ->references('class_id')
                ->on('class')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('teacher_id')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject');
    }
};