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
        Schema::create('attendance', function (Blueprint $table) {
            $table->id('attendance_id');
            $table->tinyInteger('status')->comment('0 undefined, 1 present, 2 absent, 3 medical, 4 late');
            $table->unsignedInteger('student_class_id');
            $table->date('date');
            $table->unsignedBigInteger('attendance_by');
            $table->timestamps();
            $table->foreign('student_class_id')
                ->references('id')
                ->on('student_classes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->foreign('attendance_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance');
    }
};