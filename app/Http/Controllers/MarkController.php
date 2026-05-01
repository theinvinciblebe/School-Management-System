<?php

namespace App\Http\Controllers;

use App\Models\MarkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $studentsQuery = DB::table('student')
            ->join('student_classes', 'student.student_id', '=', 'student_classes.student_id')
            ->join('class', 'student_classes.class_id', '=', 'class.class_id')
            ->join('section', 'student_classes.section_id', '=', 'section.section_id')
            ->select(
                'student.student_id',
                'student.name as student_name',
                'student.sex',
                'section.section_id',
                'section.name as section_name',
                'student_classes.class_id',
                'student_classes.roll'
            );
        if ($user->role == 1) {
            $studentsQuery->where('class.teacher_id', '=', $user->id);
        }

        $students = $studentsQuery->get();

        // Fetch classes based on the user's role
        if ($user->role == 1) {
            $classes = DB::table('class')
                ->join('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.class_id', 'class.name')
                ->get();
        } else {
            $classes = DB::table('class')->get();
        }

        // Fetch sections based on the user's role
        if ($user->role == 1) {
            $sections = DB::table('section')
                ->join('class', 'section.class_id', '=', 'class.class_id')
                ->where('class.teacher_id', $user->id)
                ->select('section.section_id', 'section.name')
                ->get();
        } else {
            $sections = DB::table('section')->get();
        }

        return view('student_section.student_mark.index', compact('students','classes','sections'));
    }

    public function showByClass($class_id)
    {
        $students = DB::table('student')
            ->join('student_classes', 'student.student_id', '=', 'student_classes.student_id')
            ->join('section', 'student_classes.section_id', '=', 'section.section_id')
            ->join('class', 'student_classes.class_id', '=', 'class.class_id')
            ->select(
                'student.student_id',
                'student.name as student_name',
                'class.name as class_name',
                'section.name as section_name',
                'section.section_id',
                'student_classes.roll'
            )
            ->where('student_classes.class_id', $class_id)
            ->get();

        $marks = DB::table('mark')
            ->join('student_classes', 'mark.student_class_id', '=', 'student_classes.id')
            ->join('exam', 'mark.exam_id', '=', 'exam.exam_id')
            ->join('subject', 'mark.subject_id', '=', 'subject.subject_id')
            ->where('student_classes.class_id', $class_id)
            ->select(
                'mark.*',
                'exam.name as exam_name',
                'subject.name as subject_name'
            )
            ->get();

        $sections = DB::table('section')->where('class_id', $class_id)->get();
        $class = DB::table('class')->where('class_id', $class_id)->first();

        return view('student_section.student_mark.index', compact('students', 'sections', 'class', 'marks'));
    }

    public function getStudentMarks($class_id, $student_id)
    {
        // Join related tables to get detailed data
        $marks = DB::table('mark')
            ->join('student_classes', 'mark.student_class_id', '=', 'student_classes.id')
            ->join('subject', 'mark.subject_id', '=', 'subject.subject_id')
            ->join('exam', 'mark.exam_id', '=', 'exam.exam_id')
            ->leftJoin('grade', function ($join) {
                $join->on('mark.mark_obtained', '>=', 'grade.mark_from')
                    ->on('mark.mark_obtained', '<=', 'grade.mark_upto');
            })
            ->where('student_classes.student_id', $student_id)
            ->where('student_classes.class_id', $class_id)  // Add this line to filter by class_id
            ->select(
                'exam.name as exam_name',
                'subject.name as subject_name',
                'mark.mark_obtained',
                'mark.mark_total',
                'grade.name as grade',
                'grade.comment'
            )
            ->get()
            ->groupBy('exam_name'); // Group marks by exam

        $exams = $marks->map(function ($examMarks, $examName) {
            $totalMarks = $examMarks->sum('mark_obtained');
            $gpa = $totalMarks / ($examMarks->count() * 100); // Example GPA calculation

            return [
                'name' => $examName,
                'subjects' => $examMarks,
                'total_marks' => $totalMarks,
                'gpa' => round($gpa, 2)
            ];
        });

        return response()->json(['exams' => $exams]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MarkModel $markModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MarkModel $markModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MarkModel $markModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MarkModel $markModel)
    {
        //
    }
}
