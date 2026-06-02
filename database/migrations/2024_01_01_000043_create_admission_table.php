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
        Schema::create('admission', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('gender');
            $table->string('dob')->nullable();
            $table->string('phone')->nullable();
            $table->string('street')->nullable();
            $table->string('apartment')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->string('course')->nullable();
            $table->string('mode')->nullable();
            $table->string('subject')->nullable();
            $table->string('work_exp')->nullable();
            $table->string('education')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('reference')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('decide_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission');
    }
};
