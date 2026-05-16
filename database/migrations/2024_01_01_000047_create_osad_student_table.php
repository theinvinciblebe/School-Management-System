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
        Schema::create('osad_student', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('acd_session_id');
            $table->integer('app_sno');
            $table->longText('name_en');
            $table->longText('name_bn');
            $table->longText('father_name');
            $table->longText('mother_name');
            $table->longText('gardian_name');
            $table->longText('nationality');
            $table->longText('technology');
            $table->integer('ff_son');
            $table->integer('upjati');
            $table->longText('birthday');
            $table->longText('sex');
            $table->longText('religion');
            $table->longText('blood_group');
            $table->longText('pr_address');
            $table->longText('phone');
            $table->longText('email');
            $table->longText('password');
            $table->longText('class_id');
            $table->integer('section_id');
            $table->integer('parent_id');
            $table->longText('roll');
            $table->integer('transport_id');
            $table->integer('dormitory_id');
            $table->longText('dormitory_room_number');
            $table->longText('pay_no');
            $table->date('pay_date');
            $table->date('app_date');
            $table->string('photo', 200)->nullable();
            $table->integer('pay_status')->nullable();
            $table->longText('cur_address')->nullable();
            $table->timestamps();
            $table->foreign('acd_session_id')
                ->references('id')
                ->on('acd_session')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('osad_student');
    }
};