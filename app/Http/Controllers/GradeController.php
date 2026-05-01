<?php

namespace App\Http\Controllers;

use App\Models\GradeModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grades = DB::table('grade')->get();
        return view("exam.exam_grade", compact("grades"));
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
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'grade_point' => 'required|string|max:255',
            'mark_from' => 'required|integer|min:0',
            'mark_upto' => 'required|integer|min:0|gte:mark_from', // Ensure mark_upto is greater than or equal to mark_from
            'comment' => 'required|string|max:255',
        ]);

        DB::table('grade')->insert([
            'name' => $request->input('name'),
            'grade_point' => $request->input('grade_point'),
            'mark_from' => $request->input('mark_from'),
            'mark_upto' => $request->input('mark_upto'),
            'comment' => $request->input('comment'),
        ]);

        return redirect()->route('exams_grade.index')->with('success', 'Grade added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(GradeModel $gradeModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GradeModel $gradeModel)
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
            'grade_point' => 'required|string|max:255',
            'mark_from' => 'required|integer|min:0',
            'mark_upto' => 'required|integer|min:0|gte:mark_from', // Ensure mark_upto is greater than or equal to mark_from
            'comment' => 'required|string|max:255',
        ]);


        // Update the exam record
        DB::table('grade')
            ->where('grade_id', $id)
            ->update([
                'name' => $request->input('name'),
                'grade_point' => $request->input('grade_point'),
                'mark_from' => $request->input('mark_from'),
                'mark_upto' => $request->input('mark_upto'),
                'comment' => $request->input('comment'),
            ]);

        return redirect()->back()->with('success', 'Grade updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $grade = DB::table('grade')->where('grade_id', $id)->first();

        if (!$grade) {
            return redirect()->back()->with('error', 'Grade not found.');
        }

        // Delete the grade
        DB::table('grade')->where('grade_id', $id)->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully!');
    }
}
