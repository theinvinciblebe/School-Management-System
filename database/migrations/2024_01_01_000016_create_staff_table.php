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
        Schema::create('staff', function (Blueprint $table) {
            $table->id('staff_id');
            $table->string('name');
            $table->enum('sex', ['Male', 'Female'])->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('id_card')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->string('position');
            $table->date('hire_date')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->foreign('department_id')
                ->references('id')
                ->on('department')
                ->onDelete('set null')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('staff');
    }
};