<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deptNames = [
            'Administration',
            'Academic & Teaching',
            'Finance & Accounting',
            'Reception & Front Desk',
            'IT & Support',
        ];

        $existingDepts = DB::table('department')->pluck('id', 'name')->toArray();

        foreach ($deptNames as $name) {
            if (!isset($existingDepts[$name])) {
                $id = DB::table('department')->insertGetId([
                    'name' => $name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $existingDepts[$name] = $id;
            }
        }

        // Link accountant
        DB::table('staff')->where('position', 'Accountant')->update([
            'department_id' => $existingDepts['Finance & Accounting'],
        ]);

        // Link receptionist
        DB::table('staff')->where('position', 'Receptionist')->update([
            'department_id' => $existingDepts['Reception & Front Desk'],
        ]);

        // Add Teacher as staff if not present
        $teacherUser = DB::table('users')->where('email', 'TeacherTest@gmail.com')->first();
        if ($teacherUser && !DB::table('staff')->where('user_id', $teacherUser->id)->exists()) {
            DB::table('staff')->insert([
                'name' => 'TeacherTest',
                'sex' => 'Female',
                'email' => 'TeacherTest@gmail.com',
                'address' => '456 Campus Blvd',
                'phone' => '0129876543',
                'department_id' => $existingDepts['Academic & Teaching'],
                'position' => 'Senior Instructor',
                'hire_date' => '2022-03-01',
                'user_id' => $teacherUser->id,
                'photo' => 'noimg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add Admin as staff if not present
        $adminUser = DB::table('users')->where('email', 'admin@mail.com')->first();
        if ($adminUser && !DB::table('staff')->where('user_id', $adminUser->id)->exists()) {
            DB::table('staff')->insert([
                'name' => 'School Administrator',
                'sex' => 'Male',
                'email' => 'admin@mail.com',
                'address' => '100 School Lane',
                'phone' => '0112233445',
                'department_id' => $existingDepts['Administration'],
                'position' => 'Director / Admin',
                'hire_date' => '2020-01-01',
                'user_id' => $adminUser->id,
                'photo' => 'noimg.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
