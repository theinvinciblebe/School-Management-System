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
        $classes = collect();

        // If user is an admin / accountant / receptionist
        if (in_array($user->role, [0, 3, 4])) {
            $classes = DB::table('class')
                ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->select('class.*', 'teacher.name as teacher_name')
                ->get();
        }
        // If user is a teacher
        else if ($user->role === 1) {
            $classes = DB::table('class')
                ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.*', 'teacher.name as teacher_name')
                ->get();
        }
        // If user is a student
        else if ($user->role === 2) {
            $classes = DB::table('class')
                ->join('student_classes', 'class.class_id', '=', 'student_classes.class_id')
                ->join('student', 'student_classes.student_id', '=', 'student.student_id')
                ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('student.user_id', $user->id)
                ->select('class.*', 'teacher.name as teacher_name')
                ->get();
        }

        $classIds = $classes->pluck('class_id')->toArray();

        // Subjects grouped by class with assigned teachers
        $subjectsByClass = DB::table('subject')
            ->leftJoin('teacher', 'subject.teacher_id', '=', 'teacher.teacher_id')
            ->whereIn('subject.class_id', $classIds)
            ->select('subject.*', 'teacher.name as teacher_name')
            ->get()
            ->groupBy('class_id');

        // Student counts per class
        $studentCounts = DB::table('student_classes')
            ->whereIn('class_id', $classIds)
            ->select('class_id', DB::raw('count(*) as count'))
            ->groupBy('class_id')
            ->pluck('count', 'class_id');

        // Sections per class
        $sectionsByClass = DB::table('section')
            ->whereIn('class_id', $classIds)
            ->get()
            ->groupBy('class_id');

        // Teachers for modal assignment
        $teachers = DB::table('teacher')->get();

        // Summary Statistics
        $totalClasses = $classes->count();
        $totalSubjects = DB::table('subject')->whereIn('class_id', $classIds)->count();
        $totalTeachers = DB::table('teacher')->count();
        $totalStudents = DB::table('student_classes')->whereIn('class_id', $classIds)->count();

        return view('subject.indexClass', compact(
            'classes',
            'subjectsByClass',
            'studentCounts',
            'sectionsByClass',
            'teachers',
            'totalClasses',
            'totalSubjects',
            'totalTeachers',
            'totalStudents'
        ));
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
            'class_id' => 'nullable|exists:class,class_id',
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
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
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
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
