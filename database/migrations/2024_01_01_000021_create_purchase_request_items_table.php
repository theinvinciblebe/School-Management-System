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
        Schema::create('purchase_request_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_request_id');
            $table->text('description');
            $table->string('asset_class')->nullable();
            $table->integer('qty');
            $table->string('unit')->nullable();
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 12, 2)->nullable();
            $table->timestamps();
            $table->foreign('purchase_request_id')
                ->references('id')
                ->on('purchase_request')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_request_items');
    }
};