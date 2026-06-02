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
        Schema::create('mark', function (Blueprint $table) {
            $table->id('mark_id');
            $table->unsignedInteger('student_class_id')->nullable();
            $table->unsignedInteger('subject_id')->nullable();
            $table->unsignedInteger('exam_id')->nullable();
            $table->integer('mark_obtained')->default(0);
            $table->integer('mark_total')->default(100);
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->foreign('student_class_id')
                ->references('id')
                ->on('student_classes')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('subject_id')
                ->references('subject_id')
                ->on('subject')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('exam_id')
                ->references('exam_id')
                ->on('exam')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mark');
    }
};