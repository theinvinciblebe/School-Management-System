<?php

namespace App\Http\Controllers;

use App\Models\ClassRoutineModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class ClassRoutineController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Show all classes to select one
    public function showClasses()
    {
        $user = Auth::user();
        $classes = collect(); // Initialize as an empty collection to prevent errors

        // If user is an admin
        if (in_array($user->role, [0, 3, 4])) {
            $classes = \Illuminate\Support\Facades\DB::table('class')->get();
        }
        // If user is a teacher
        else if ($user->role === 1) {
            $classes = DB::table('class')
                ->leftjoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.*') // Select only class columns to avoid conflicts
                ->get();
        }
        // If user is a student
        else if ($user->role === 2) {
            $classes = DB::table('class')
                ->join('student_classes', 'class.class_id', '=', 'student_classes.class_id')
                ->join('student', 'student_classes.student_id', '=', 'student.student_id')
                ->where('student.user_id', $user->id)
                ->select('class.*')
                ->get();
        }
        return view('class_routine.select_class', compact('classes'));
    }

    public function showClassRoutine($class_id)
    {
        $class = DB::table('class')->where('class_id', $class_id)->first();

        if (!$class) {
            return redirect()->route('class_routines.show_classes')->with('error', 'Class not found.');
        }

        // Fetch all subjects assigned to this class
        $subjects = DB::table('subject')
            ->where('class_id', $class_id)
            ->get();

        // Pass the data to the view
        return view('class_routine.index', compact('class', 'subjects'));
    }


    // Display class routine index
    public function index($class_id)
    {
        // Fetch class and subjects
        $class = DB::table('class')->where('class_id', $class_id)->first();

        if (!$class) {
            return redirect()->route('class_routines.show_classes')->with('error', 'Class not found.');
        }

        $subjects = DB::table('subject')->where('class_id', $class_id)->get();
        $routines = DB::table('class_routine')
            ->join('subject', 'class_routine.subject_id', '=', 'subject.subject_id')
            ->select('class_routine.*', 'subject.name as subject_name')
            ->where('class_routine.class_id', $class_id)
            ->orderBy('day')
            ->orderBy('time_start')
            ->get();

            // Define days of the week
            $daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];


        return view('class_routine.index', compact('class', 'subjects', 'routines', 'daysOfWeek'));
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
        $request->validate([
            'class_id' => 'required',
            'subject_id' => 'required',
            'time_start' => 'required|integer',
            'time_end' => 'required|integer|gt:time_start',
            'day' => 'required|string',
        ]);

        DB::table('class_routine')->insert([
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'time_start' => $request->time_start,
            'time_end' => $request->time_end,
            'day' => $request->day,
        ]);

        return redirect()->route('class_routines.index', $request->class_id)->with('success', 'Class routine added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClassRoutineModel $classRoutineModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ClassRoutineModel $classRoutineModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'subject_id' => 'required',
            'time_start' => 'required|integer',
            'time_end' => 'required|integer|gt:time_start',
            'day' => 'required|string',
        ]);

        $routine = DB::table('class_routine')->where('class_routine_id', $id)->first();

        if (!$routine) {
            return redirect()->back()->with('error', 'Routine not found.');
        }

        DB::table('class_routine')
            ->where('class_routine_id', $id)
            ->update([
                'subject_id' => $request->subject_id,
                'time_start' => $request->time_start,
                'time_end' => $request->time_end,
                'day' => $request->day,
            ]);

         return redirect()->route('class_routines.index', $routine->class_id)->with('success', 'Class routine updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $routine = DB::table('class_routine')->where('class_routine_id', $id)->first();

        if (!$routine) {
            return redirect()->back()->with('error', 'Routine not found.');
        }

        DB::table('class_routine')->where('class_routine_id', $id)->delete();

        return redirect()->route('class_routines.index', $routine->class_id)->with('success', 'Class routine deleted successfully!');
    }
}
