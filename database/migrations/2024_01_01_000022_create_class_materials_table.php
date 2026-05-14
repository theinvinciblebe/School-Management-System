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
        Schema::create('class_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('subject_id')->nullable();
            $table->string('author_name')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->text('url_vdo')->nullable();
            $table->text('gallery_path')->nullable();
            $table->text('file_path')->nullable();
            $table->timestamps();
            $table->foreign('subject_id')
                ->references('subject_id')
                ->on('subject')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_materials');
    }
};