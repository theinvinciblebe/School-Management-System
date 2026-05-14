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
        Schema::create('fee_receipt_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fee_receipt_id')->nullable();
            $table->string('description');
            $table->integer('qty');
            $table->decimal('price', 10, 2);
            $table->string('discount')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('fee_receipt_id')
                ->references('id')
                ->on('fee_receipt')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_receipt_items');
    }
};