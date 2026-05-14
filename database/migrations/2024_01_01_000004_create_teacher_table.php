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
        Schema::create('teacher', function (Blueprint $table) {
            $table->id('teacher_id');
            $table->string('name');
            $table->string('birthday');
            $table->integer('sex');
            $table->string('religion')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address');
            $table->string('phone');
            $table->string('email');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher');
    }
};