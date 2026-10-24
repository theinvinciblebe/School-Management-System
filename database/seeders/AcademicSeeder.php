<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Classes
        $classes = [
            ['class_id' => 62, 'name' => 'Web Development', 'class_code' => 'WD', 'class_room' => '1A', 'teacher_id' => null],
            ['class_id' => 63, 'name' => 'Graphic Design', 'class_code' => '123', 'class_room' => '1A', 'teacher_id' => null],
            ['class_id' => 64, 'name' => 'Mathematics', 'class_code' => '123', 'class_room' => '2A', 'teacher_id' => null],
        ];

        foreach ($classes as $c) {
            DB::table('class')->updateOrInsert(
                ['class_id' => $c['class_id']],
                array_merge($c, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // 2. Sections
        $sections = [
            ['section_id' => 52, 'name' => 'Morning', 'nick_name' => 'm', 'class_id' => 62, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-15', 'time_in' => '09:00:00', 'time_out' => '12:00:00'],
            ['section_id' => 53, 'name' => 'Test2', 'nick_name' => 'gt', 'class_id' => 62, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-13', 'time_in' => '18:20:00', 'time_out' => '19:05:00'],
            ['section_id' => 54, 'name' => 'Test3', 'nick_name' => 'sf', 'class_id' => 62, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-12', 'time_in' => '09:15:00', 'time_out' => '17:15:00'],
            ['section_id' => 55, 'name' => 'Test2', 'nick_name' => 'gt', 'class_id' => 63, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-11', 'time_in' => '18:10:00', 'time_out' => '18:20:00'],
            ['section_id' => 56, 'name' => 'Test3', 'nick_name' => 'm', 'class_id' => 63, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-12', 'time_in' => '18:10:00', 'time_out' => '18:20:00'],
            ['section_id' => 57, 'name' => 'Morning', 'nick_name' => 'm', 'class_id' => 64, 'teacher_id' => null, 'start_date' => '2026-07-15', 'end_date' => '2026-08-12', 'time_in' => '18:10:00', 'time_out' => '18:20:00'],
        ];

        foreach ($sections as $s) {
            DB::table('section')->updateOrInsert(
                ['section_id' => $s['section_id']],
                array_merge($s, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // 3. Subjects
        $subjects = [
            ['subject_id' => 77, 'name' => 'Figma', 'class_id' => 62, 'teacher_id' => null],
            ['subject_id' => 78, 'name' => 'HTML & CSS', 'class_id' => 62, 'teacher_id' => null],
            ['subject_id' => 79, 'name' => 'Web Design', 'class_id' => 63, 'teacher_id' => null],
            ['subject_id' => 80, 'name' => 'Python', 'class_id' => 64, 'teacher_id' => null],
        ];

        foreach ($subjects as $sub) {
            DB::table('subject')->updateOrInsert(
                ['subject_id' => $sub['subject_id']],
                array_merge($sub, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }

        // 4. Link Student to Class
        $student = DB::table('student')->first();
        if ($student) {
            DB::table('student_classes')->updateOrInsert(
                ['student_id' => $student->student_id, 'class_id' => 62],
                [
                    'section_id' => 52,
                    'roll' => '1',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
