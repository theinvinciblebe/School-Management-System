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
        Schema::create('invoice', function (Blueprint $table) {
            $table->id('invoice_id');
            $table->unsignedInteger('student_id');
            $table->longText('title');
            $table->longText('description');
            $table->integer('amount');
            $table->longText('amount_paid');
            $table->longText('due');
            $table->integer('creation_timestamp');
            $table->longText('payment_timestamp');
            $table->longText('payment_method');
            $table->longText('payment_details');
            $table->longText('status')->comment('paid or unpaid');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice');
    }
};