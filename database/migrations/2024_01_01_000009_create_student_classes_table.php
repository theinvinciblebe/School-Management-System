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
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('student_id')->nullable();
            $table->unsignedInteger('class_id')->nullable();
            $table->string('roll')->nullable();
            $table->unsignedInteger('section_id')->nullable();
            $table->timestamps();
            $table->foreign('student_id')
                ->references('student_id')
                ->on('student')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('class_id')
                ->references('class_id')
                ->on('class')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('section_id')
                ->references('section_id')
                ->on('section')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_classes');
    }
};