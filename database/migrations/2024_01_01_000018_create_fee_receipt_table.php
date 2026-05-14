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
        Schema::create('fee_receipt', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->unsignedInteger('student_class_id')->nullable();
            $table->string('paid_via')->nullable();
            $table->decimal('paid', 11, 2)->nullable();
            $table->decimal('grand_total', 10, 2)->nullable();
            $table->decimal('previous_balance', 10, 2)->nullable();
            $table->decimal('remaining_balance', 10, 2)->nullable();
            $table->string('receipt_no')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->timestamps();
            $table->foreign('student_class_id')
                ->references('id')
                ->on('student_classes')
                ->onDelete('set null')
                ->onUpdate('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('restrict');
            $table->foreign('approved_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_receipt');
    }
};