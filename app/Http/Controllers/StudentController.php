<?php

namespace App\Http\Controllers;

use App\Models\StudentModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    protected function authorizeAccountantAccess()
    {
        if (!in_array(Auth::user()->role, [0, 3, 4])) {
            abort(403);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = DB::table('student')
            ->leftjoin('student_classes', 'student.student_id', '=', 'student_classes.student_id')
            ->leftjoin('class', 'student_classes.class_id', '=', 'class.class_id')
            ->leftjoin('section', 'student_classes.section_id', '=', 'section.section_id')
            ->leftjoin('parent', 'student.parent_id', '=', 'parent.parent_id')
            ->select(
                'student.student_id',
                'student.name as student_name',
                'student.birthday',
                'student.sex',
                'student.address',
                'student.phone',
                'student.photo',
                'student.email',
                'student.parent_id',
                'class.name as class_name',
                'section.section_id',
                'section.name as section_name',
                'parent.name as parent_name',
                'parent.phone as parent_phone',
                'student_classes.class_id',
                'student_classes.roll'
            )
            ->get();

        $parents = DB::table('parent')->get();
        $classes = DB::table('class')->get();
        $sections = DB::table('section')->get();

        return view('student_section.admit_student.index', compact('students', 'parents', 'classes','sections'));
    }


    public function getSectionsByClass($class_id)
    {
        $sections = DB::table('section')
            ->where('class_id', $class_id)
            ->get(['section_id', 'name']);

        return response()->json(['sections' => $sections]); // Return as JSON
    }

    public function addStudentToClassView($class_id)
    {
        $this->authorizeAccountantAccess();

        // Get all students (including those not in the class)
        $allStudents = DB::table('student')
            ->leftJoin('parent', 'student.parent_id', '=', 'parent.parent_id')
            ->select('student.*', 'parent.name as parent_name')
            ->get();

        // Get the specific class and its sections
        $class = DB::table('class')->where('class_id', $class_id)->first();
        $sections = DB::table('section')->where('class_id', $class_id)->get();

        return view('student_section.student_info.add_student_to_class', compact('allStudents', 'class','class_id', 'sections'));
    }

    public function showByClass($class_id)
    {
        $students = DB::table('student')
            ->join('student_classes', 'student.student_id', '=', 'student_classes.student_id') // Correct table
            ->join('section', 'student_classes.section_id', '=', 'section.section_id')
            ->join('class', 'student_classes.class_id', '=', 'class.class_id') // Match with class_id
            ->join('parent', 'student.parent_id', '=', 'parent.parent_id')
            ->select(
                'student.*',
                'class.name as class_name',
                'section.name as section_name',
                'section.section_id',
                'parent.name as parent_name',
                'student_classes.roll'
            )
            ->where('student_classes.class_id', $class_id) // Correct filter
            ->get();

        $sections = DB::table('section')->where('class_id', $class_id)->get();
        $class = DB::table('class')->where('class_id', $class_id)->first();

        return view('student_section.student_info.index', compact('students', 'sections', 'class'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeAccountantAccess();

        $classes = DB::table('class')->get(); // Fetch all classes
        $parents = DB::table('parent')->get(); // Fetch all parents
        $sections = []; // Initially no sections, as they will be dynamically loaded

        return view('student_section.admit_student.add', compact('classes', 'parents', 'sections'));
    }

    public function addStudentToClass(Request $request)
    {
        $this->authorizeAccountantAccess();

        $request->validate([
            'student_id' => 'required|exists:student,student_id',
            'class_id' => 'required|exists:class,class_id',
            'section_id' => 'required|exists:section,section_id',
            'roll' => 'required|string|max:20',
        ]);

        // Check for duplicate entry
        $exists = DB::table('student_classes')
            ->where('student_id', $request->student_id)
            ->where('class_id', $request->class_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Student is already enrolled in this class.');
        }

        // Insert new record
        DB::table('student_classes')->insert([
            'student_id' => $request->student_id,
            'class_id' => $request->class_id,
            'section_id' => $request->section_id,
            'roll' => $request->roll,
        ]);

        return redirect()->route('students.byClass', $request->class_id)->with('success', 'Student added successfully!');
    }

    public function updateClassAssignment(Request $request, $student_id, $class_id)
    {
        $this->authorizeAccountantAccess();

        $request->validate([
            'section_id' => 'required|exists:section,section_id',
            'roll' => 'required|string|max:20',
        ]);

        // Update the student class assignment
        DB::table('student_classes')
            ->where('student_id', $student_id)
            ->where('class_id', $class_id)
            ->update([
                'section_id' => $request->section_id,
                'roll' => $request->roll,
            ]);

        return redirect()->route('students.byClass', $class_id)->with('success', 'Student class assignment updated successfully!');
    }

    public function removeFromClass($student_id, $class_id)
    {
        $this->authorizeAccountantAccess();

        // Remove the student from the class
        DB::table('student_classes')
            ->where('student_id', $student_id)
            ->where('class_id', $class_id)
            ->delete();

        return redirect()->route('students.byClass', $class_id)->with('success', 'Student removed from the class successfully!');
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeAccountantAccess();

        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|integer',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users',
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
            'parent_name' => 'nullable|max:255',  // Parent name
            'parent_phone' => 'nullable|max:15',  // Parent phone
            'parent_id' => 'nullable|integer',
//            'roll' => 'required|string|max:255|unique:student_classes,roll,NULL,id,class_id,' . $request->class_id, // Ensure roll is unique per class
        ]);

        // Automatically generate roll number
        $lastRoll = DB::table('student_classes')
            ->where('class_id', $request->class_id)
            ->max('roll');

        //$newRoll = $lastRoll ? $lastRoll + 1 : 1; // Increment roll number
        $newRoll = $lastRoll ? str_pad($lastRoll + 1, 4, '0', STR_PAD_LEFT) : '0001'; // Ensures four-digit format


        // **Handle File Upload**
        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('students_image'), $fileName);
        }else{
            $fileName = 'noimg.jpg';
        }

        //Create the user in the `users` table
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456'), // Default password
            'role' => 2, // Role = Student
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert new parent record
        $parent = DB::table('parent')->insertGetId([
            'name' => $request->input('parent_name'),
            'phone' => $request->input('parent_phone'),
        ]);

        // Insert into student table
        $studentId = DB::table('student')->insertGetId([
            'user_id' => $userId, // Foreign key
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'sex' => $request->input('sex'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'photo' => $fileName,  // Save uploaded file name
            'email' => $request->input('email'),
            'parent_id' => $parent,  // Link to newly created parent
        ]);

        // Insert into student_classes table
        DB::table('student_classes')->insert([
            'student_id' => $studentId,
            'class_id' => $request->input('class_id'),
            'section_id' => $request->input('section_id'),
            'roll' => $newRoll, // Auto-assigned roll number
        ]);

        return redirect()->route('students.index')->with('success', 'Student admitted successfully with default password "123456".');
    }

    public function syncUserEmail($userId, $name, $email)
    {
        DB::table('users')->where('id', $userId)->update([
            'name' => $name,
            'email' => $email,
            'updated_at' => now(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAccountantAccess();

        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|boolean',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:student,email,' . $id . ',student_id',
            'section_id' => 'required|exists:section,section_id',
            'class_id' => 'required|exists:class,class_id', // Ensure class is valid
            'parent_id' => 'nullable|exists:parent,parent_id',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
        ]);


        // Find the student
        $student = DB::table('student')->where('student_id', $id)->first();
        if (!$student || !$student->user_id) {
            return redirect()->back()->with('error', 'Student or associated user not found.');
        }

        $student = DB::table('student')->where('student_id', $id)->first();
        $fileName = $student->photo; // Keep old image by default
        // Handle new image upload
        if ($request->hasFile('file')) {
            // Delete old image (if it's not the default)
            if ($student->photo && $student->photo !== 'noimg.jpg') {
                $oldImagePath = public_path("students_image/" . $student->photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Save new image
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('students_image'), $fileName);
        }

        // Update student information in `student` table
        DB::table('student')->where('student_id', $id)->update([
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'sex' => $request->input('sex'),
            'address' => $request->input('address'),
            'photo' => $fileName, // Save new file name
            'email' => $request->input('email'),
            'parent_id' => $request->input('parent_id'),
        ]);
        // Automatically generate roll number
        $lastRoll = DB::table('student_classes')
            ->where('class_id', $request->class_id)
            ->max('roll');

        //$newRoll = $lastRoll ? $lastRoll + 1 : 1; // Increment roll number
        $newRoll = $lastRoll ? str_pad($lastRoll + 1, 4, '0', STR_PAD_LEFT) : '0001'; // Ensures four-digit format

        // Update student information in `student_classes` table
        DB::table('student_classes')->where('student_id', $id)->updateOrInsert([
            'student_id' => $id,
            'class_id' => $request->input('class_id'),
            'section_id' => $request->input('section_id'),
            'roll' => $newRoll, // Auto-assigned roll number
        ]);

        $this->syncUserEmail($student->user_id, $request->name, $request->email);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $this->authorizeAccountantAccess();

        // Check if the student exists
        $student = DB::table('student')->where('student_id', $id)->first();
        if (!$student) {
            return redirect()->route('students.index')->with('error', 'Student not found.');
        }

        // Delete from student_classes (since it links student to class and section)
        DB::table('student_classes')->where('student_id', $id)->delete();

        // Delete the student record
        DB::table('student')->where('student_id', $id)->delete();

       DB::table('users')->where('id', $student->user_id)->delete();


        return redirect()->route('students.index')->with('success', 'Student and user are deleted successfully!');
    }

}
