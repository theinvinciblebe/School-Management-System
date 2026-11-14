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
        Schema::table('customize', function (Blueprint $table) {
            $table->text('url_icon')->nullable()->change();
            $table->text('brand_logo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customize', function (Blueprint $table) {
            $table->string('url_icon', 255)->nullable()->change();
            $table->string('brand_logo', 255)->nullable()->change();
        });
    }
};
