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
        Schema::create('class', function (Blueprint $table) {
            $table->id('class_id');
            $table->string('name');
            $table->string('class_code')->nullable();
            $table->string('class_room')->nullable();
            $table->unsignedInteger('teacher_id')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('class');
    }
};