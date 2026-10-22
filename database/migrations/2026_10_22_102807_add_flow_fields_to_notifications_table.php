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
        Schema::table('notifications', function (Blueprint $table) {
            $table->unsignedBigInteger('target_id')->nullable()->after('type');
            $table->string('target_type', 50)->nullable()->after('target_id');
            $table->string('action_url', 255)->nullable()->after('target_type');
            $table->string('status', 50)->default('pending')->after('action_url');
            $table->boolean('starred')->default(false)->after('is_read');
            $table->json('data')->nullable()->after('starred');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            $table->dropColumn(['target_id', 'target_type', 'action_url', 'status', 'starred', 'data']);
        });
    }
};
