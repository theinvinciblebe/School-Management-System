<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('customize', function (Blueprint $table) {
            if (!Schema::hasColumn('customize', 'school_address')) {
                $table->string('school_address')->nullable()->default('No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia');
            }
            if (!Schema::hasColumn('customize', 'school_phone')) {
                $table->string('school_phone')->nullable()->default('+855 12 801 470 / +855 71 220 6315');
            }
            if (!Schema::hasColumn('customize', 'school_email')) {
                $table->string('school_email')->nullable()->default('info@schoolsystem.edu.kh');
            }
        });

        // Set default values if row 1 exists
        DB::table('customize')->where('id', 1)->update([
            'school_address' => 'No.32, Street 606, Tuol Kork, Phnom Penh, Cambodia',
            'school_phone'   => '+855 12 801 470 / +855 71 220 6315',
            'school_email'   => 'info@schoolsystem.edu.kh',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customize', function (Blueprint $table) {
            $table->dropColumn(['school_address', 'school_phone', 'school_email']);
        });
    }
};
