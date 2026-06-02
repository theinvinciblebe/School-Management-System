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
        Schema::create('staff_attendance', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->date('date');
            $table->enum('status', ['Present', 'Absent', 'Undefined'])->default('Undefined');
            $table->string('time_in')->nullable();
            $table->string('time_out')->nullable();
            $table->timestamps();
            $table->foreign('staff_id')
                ->references('staff_id')
                ->on('staff')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_attendance');
    }
};