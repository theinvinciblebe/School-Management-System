<?php

namespace App\Http\Controllers;

use App\Models\ExamListModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExamListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $exams = DB::table('exam')->get();
        return view("exam.exam_list", compact("exams"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('exam.create');
    }

    public function createExam(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'nullable|string',
            'questions.*.text' => 'required|string',
            'questions.*.type' => 'required|in:multiple_choice,short_answer,file_upload',
            'questions.*.options' => 'nullable|array'
        ]);

        // Create the exam
        $exam = DB::table('exam')
            ->insertGetId($request->only(['name', 'comment']));

        // Create questions
        foreach ($request->questions as $question) {
            DB::table('exam_questions')
                ->insert([
                'exam_id' => $exam,
                'question_text' => $question['text'],
                'question_type' => $question['type'],
                'options' => isset($question['options']) ? json_encode($question['options']) : null, // Convert array to JSON
            ]);
        }

        return redirect()->route('exams_list.index')->with('success', 'Exam created successfully!');
    }

    public function showExamQuestions($examId)
    {
        $exam = DB::table('exam')->where('exam_id', $examId)->first();

        if (!$exam) {
            return redirect()->back()->with('error', 'Exam not found.');
        }

        $questions = DB::table('exam_questions')
            ->where('exam_id', $examId)
            ->get();

        return view('exam.question_list', compact('exam', 'questions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'comment' => 'nullable|string|max:255',
        ]);

        DB::table('exam')->insert([
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('exams_list.index')->with('success', 'Exam added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ExamListModel $examModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ExamListModel $examModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'comment' => 'nullable|string|max:255',
        ]);

        // Update the exam record
        DB::table('exam')
            ->where('exam_id', $id)
            ->update([
                'name' => $request->input('name'),
                'date' => $request->input('date'),
                'comment' => $request->input('comment'),
            ]);

        return redirect()->back()->with('success', 'Exam updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the exam exists
        $exam = DB::table('exam')->where('exam_id', $id)->first();

        if (!$exam) {
            return redirect()->back()->with('error', 'Exam not found.');
        }

        // Delete the teacher
        DB::table('exam')->where('exam_id', $id)->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully!');
    }
}
