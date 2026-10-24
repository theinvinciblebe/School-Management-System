<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Admin Users (Role 0)
        User::updateOrCreate(
            ['email' => 'admin@mail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('123456'),
                'role' => 0,
                'photo' => '1792632103_6ad96527e20f1.jpg',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('123456'),
                'role' => 0,
                'photo' => null,
                'email_verified_at' => now(),
            ]
        );

        // 2. Teacher User (Role 1)
        $teacher = User::updateOrCreate(
            ['email' => 'TeacherTest@gmail.com'],
            [
                'name' => 'TeacherTest',
                'password' => Hash::make('123456'),
                'role' => 1,
                'photo' => null,
                'email_verified_at' => now(),
            ]
        );

        DB::table('teacher')->updateOrInsert(
            ['email' => 'TeacherTest@gmail.com'],
            [
                'name' => 'TeacherTest',
                'birthday' => '1990-01-01',
                'sex' => 1,
                'religion' => null,
                'blood_group' => null,
                'address' => '123 Main Street',
                'phone' => '0123456789',
                'photo' => 'noimg.jpg',
                'user_id' => $teacher->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 3. Student User (Role 2)
        $student = User::updateOrCreate(
            ['email' => 'StudentTest@gmail.com'],
            [
                'name' => 'StudentTest',
                'password' => Hash::make('123456'),
                'role' => 2,
                'photo' => null,
                'email_verified_at' => now(),
            ]
        );

        DB::table('student')->updateOrInsert(
            ['email' => 'StudentTest@gmail.com'],
            [
                'name' => 'StudentTest',
                'birthday' => '2005-01-01',
                'sex' => 1,
                'religion' => null,
                'blood_group' => null,
                'address' => '123 Main Street',
                'phone' => '0123456789',
                'photo' => 'noimg.jpg',
                'user_id' => $student->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 4. Accountant User (Role 3)
        $accountant = User::updateOrCreate(
            ['email' => 'phy@gmail.com'],
            [
                'name' => 'phy',
                'password' => Hash::make('123456'),
                'role' => 3,
                'photo' => '1792632125_6ad9653dc4fa2.jpg',
                'email_verified_at' => now(),
            ]
        );

        DB::table('staff')->updateOrInsert(
            ['email' => 'phy@gmail.com'],
            [
                'name' => 'phy',
                'sex' => 'Male',
                'address' => '123 Main Street',
                'phone' => '0123456789',
                'position' => 'Accountant',
                'hire_date' => '2022-01-01',
                'user_id' => $accountant->id,
                'photo' => '1792632125_6ad9653dc4fa2.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 5. Receptionist User (Role 4)
        $receptionist = User::updateOrCreate(
            ['email' => 'ReceptionistTest@gmail.com'],
            [
                'name' => 'ReceptionistTest',
                'password' => Hash::make('123456'),
                'role' => 4,
                'photo' => null,
                'email_verified_at' => now(),
            ]
        );

        DB::table('staff')->updateOrInsert(
            ['email' => 'ReceptionistTest@gmail.com'],
            [
                'name' => 'ReceptionistTest',
                'sex' => 'Female',
                'address' => '123 Main Street',
                'phone' => '0123456789',
                'position' => 'Receptionist',
                'hire_date' => '2022-01-01',
                'user_id' => $receptionist->id,
                'photo' => 'noimg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
