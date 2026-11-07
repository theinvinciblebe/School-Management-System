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
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->string('action')->nullable()->after('user_id');
            $table->text('description')->nullable()->after('action');
            $table->string('method', 10)->nullable()->after('description');
            $table->text('url')->nullable()->after('method');
            $table->text('user_agent')->nullable()->after('url');
            $table->string('device', 60)->nullable()->after('user_agent');
            $table->integer('status_code')->nullable()->after('device');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->dropColumn([
                'action',
                'description',
                'method',
                'url',
                'user_agent',
                'device',
                'status_code',
            ]);
        });
    }
};
