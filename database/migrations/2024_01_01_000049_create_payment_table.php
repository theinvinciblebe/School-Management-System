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
        Schema::create('payment', function (Blueprint $table) {
            $table->id('payment_id');
            $table->unsignedInteger('expense_category_id');
            $table->longText('title');
            $table->longText('payment_type');
            $table->unsignedInteger('invoice_id');
            $table->unsignedInteger('student_id');
            $table->longText('method');
            $table->longText('description');
            $table->longText('amount');
            $table->longText('timestamp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};