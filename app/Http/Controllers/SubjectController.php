<?php

namespace App\Http\Controllers;

use App\Models\SubjectModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($class_id)
    {
       $class = DB::table('class')->where('class_id', $class_id)->first();

        // Handle case when the class is not found
        if (!$class) {
            return redirect()->back()->with('error', 'Class not found.');
        }

        // Fetch the subjects for this class
        $subjects = DB::table('subject')
            ->leftjoin('teacher', 'subject.teacher_id', '=', 'teacher.teacher_id')
            ->select('subject.subject_id', 'subject.name', 'subject.teacher_id', 'teacher.name as teacher_name')
            ->where('subject.class_id', $class_id)
            ->get();

        // Fetch the list of teachers for the dropdown

        $teachers = DB::table('teacher')->get();

        return view('subject.index', compact('class', 'subjects', 'teachers'));
    }

    public function classesSubject()
    {
        $user = Auth::user();
        $classes = collect(); // Initialize as an empty collection to prevent errors

        // If user is an admin
        if (in_array($user->role, [0, 3, 4])) {
            $classes = DB::table('class')->get();
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

//        dd([
//            'user_id' => $user->id,
//            'user_role' => $user->role,
//        ]);

        return view('subject.indexClass', compact('classes'));
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
            'name' => 'required',
            'class_id' => 'required|exists:class,class_id',
            'teacher_id' => 'required|exists:teacher,teacher_id',
        ]);

        DB::table('subject')->insert([
            'name' => $request->name,
            'class_id' => $request->class_id,
            'teacher_id' => $request->teacher_id,
        ]);

        return redirect()->route('subject.index', ['class_id' => $request->class_id])->with('success', 'Subject added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(SubjectModel $subjectModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubjectModel $subjectModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teacher,teacher_id',
        ]);

        DB::table('subject')->where('subject_id', $id)->update([
            'name' => $request->input('name'),
            'teacher_id' => $request->input('teacher_id'),
        ]);

        return redirect()->back()->with('success', 'Subject updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if subject exists
        $subject = DB::table('subject')->where('subject_id', $id)->first();

        if (!$subject) {
            return redirect()->route('subject.index')->with('error', 'Subject not found.');
        }

        // Perform the delete operation using the correct column name
        DB::table('subject')->where('subject_id', $id)->delete();

        // Redirect with the class_id
        return redirect()->route('subject.index', ['class_id' => $subject->class_id])->with('success', 'Subject deleted successfully!');
    }

}
