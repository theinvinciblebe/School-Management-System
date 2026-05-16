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
        Schema::create('customize', function (Blueprint $table) {
            $table->id();
            $table->string('url_icon')->nullable();
            $table->string('url_title')->nullable();
            $table->string('brand_logo')->nullable();
            $table->string('brand_title')->nullable();
            $table->string('nav_color')->nullable();
            $table->string('sidebar_color')->nullable();
            $table->string('dark_sidebar_variants')->nullable();
            $table->string('accent_color')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customize');
    }
};