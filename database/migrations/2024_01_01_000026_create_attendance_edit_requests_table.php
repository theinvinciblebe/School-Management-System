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
        Schema::create('attendance_edit_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('teacher_id');
            $table->unsignedInteger('class_id');
            $table->unsignedInteger('section_id');
            $table->date('date')->nullable();
            $table->string('reason')->nullable();
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Completed'])->default('Pending');
            $table->timestamps();
            $table->foreign('teacher_id')
                ->references('teacher_id')
                ->on('teacher')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('class_id')
                ->references('class_id')
                ->on('class')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('section_id')
                ->references('section_id')
                ->on('section')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_edit_requests');
    }
};