<?php

namespace App\Http\Controllers;

use App\Models\ExamMarkModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamMarkController extends Controller
{
    public function getStudentsForExam(Request $request)
    {
        $exam_id = $request->exam_id;
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;

        if (!$class_id || !$subject_id || !$exam_id) {
            return response()->json(['error' => 'Invalid request parameters'], 400);
        }

        // Fetch students in the selected class
        $students = DB::table('student_classes')
            ->join('student', 'student_classes.student_id', '=', 'student.student_id')
            ->where('student_classes.class_id', $class_id)
            ->select('student_classes.id as student_class_id', 'student.name', 'student_classes.roll')
            ->get();

        // Fetch existing marks for the subject, exam, and class
        $existingMarks = DB::table('mark')
            ->where('exam_id', $exam_id)
            ->where('subject_id', $subject_id)
            ->get()
            ->keyBy('student_class_id'); // Key by student_class_id for easy lookup

        return response()->json([
            'students' => $students,
            'marks' => $existingMarks
        ]);
    }

    public function assignMarks(Request $request)
    {
        $marksData = $request->input('marks');

        if (!$marksData) {
            return back()->withErrors(['message' => 'No marks data provided.']);
        }

        foreach ($marksData as $student_class_id => $markData) {
            DB::table('mark')->updateOrInsert(
                [
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'student_class_id' => $student_class_id,
                ],
                [
                    'mark_obtained' => $markData['mark_obtained'],
                    'comment' => $markData['comment'] ?? null,
                    'mark_total' => 100, // Default max marks, or make this configurable
                ]
            );
        }

        return redirect()->back()->with('success', 'Marks saved successfully.');
    }


    public function loadStudents(Request $request)
    {
        $exam_id = $request->exam_id;
        $class_id = $request->class_id;
        $subject_id = $request->subject_id;

        // Fetch students in the selected class
        $students = DB::table('student_classes')
            ->join('student', 'student_classes.student_id', '=', 'student.student_id')
            ->where('student_classes.class_id', $class_id)
            ->select('student_classes.*', 'student.student_name', 'student_classes.roll')
            ->get();

        // Fetch existing marks for the subject, exam, and class
        $existingMarks = DB::table('mark')
            ->where('exam_id', $exam_id)
            ->where('subject_id', $subject_id)
            ->get()
            ->keyBy('student_class_id'); // Key by student_class_id for easy lookup

        return response()->json([
            'students' => $students,
            'marks' => $existingMarks
        ]);
    }

    public function saveMarks(Request $request)
    {
        $marksData = $request->input('marks');

        foreach ($marksData as $data) {
            DB::table('mark')->updateOrInsert(
                [
                    'exam_id' => $request->exam_id,
                    'subject_id' => $request->subject_id,
                    'student_class_id' => $data['student_class_id'],
                ],
                [
                    'mark_obtained' => $data['mark_obtained'],
                    'comment' => $data['comment'] ?? null,
                ]
            );
        }

        return redirect()->back()->with('success', 'Marks saved successfully!');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $exams = DB::table('exam')->get(); // Get all exams

        // Fetch classes based on the user's role
        if ($user->role == 1) {
            $classes = DB::table('class')
                ->join('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.class_id', 'class.name')
                ->get();

            $subjects = DB::table('subject')
                ->join('teacher', 'subject.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('subject.subject_id', 'subject.name')
                ->get();


        } else {
            $classes = DB::table('class')->get();
            $subjects = DB::table('subject')->get(); // Get all subjects
        }


        return view('exam.exam_mark', compact('exams', 'classes', 'subjects'));
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
    public function show(ExamMarkModel $examMarkModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamMarkModel $examMarkModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ExamMarkModel $examMarkModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExamMarkModel $examMarkModel)
    {
        //
    }
}
