<?php

namespace App\Http\Controllers;

use App\Models\TeacherModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = DB::table('teacher')->get();
        return view('teacher.index', compact('teachers'));
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
            'birthday' => 'required|date',
            'sex' => 'required|boolean',
            'address' => 'required|string|max:255',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ]);

        // **Handle File Upload**
        if ($request->hasFile('file')) {

            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('teachers_image'), $fileName);
        }else{
            $fileName = 'noimg.jpg';
        }

        // Step 1: Create the user in the `users` table
        $userId = DB::table('users')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('123456'), // Default password
            'role' => 1, // Role = Teacher
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('teacher')->insert([
            'user_id' => $userId, // Foreign key
            'name' => $request->input('name'),
            'birthday' => $request->input('birthday'),
            'sex' => $request->input('sex'),
            'address' => $request->input('address'),
            'photo' => $fileName,  // Save uploaded file name
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully with default password "123456".');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherModel $teacherModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherModel $teacherModel)
    {
        //
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
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'birthday' => 'required|date',
            'sex' => 'required|boolean',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
        ]);

        // Find the teacher
        $teacher = DB::table('teacher')->where('teacher_id', $id)->first();
        if (!$teacher || !$teacher->user_id) {
            return redirect()->back()->with('error', 'Teacher or associated user not found.');
        }

        //$teacher = DB::table('teacher')->where('teacher_id', $id)->first();
        $fileName = $teacher->photo; // Keep old image by default
        // Handle new image upload
        if ($request->hasFile('file')) {

            // Delete old image (if it's not the default)
            if ($teacher->photo && $teacher->photo !== 'noimg.jpg') {
                $oldImagePath = public_path("teachers_image/" . $teacher->photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Save new image
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('teachers_image'), $fileName);
        }

        // Update the teacher record
        DB::table('teacher')
            ->where('teacher_id', $id)
            ->update([
                'name' => $request->input('name'),
                'birthday' => $request->input('birthday'),
                'sex' => $request->input('sex'),
                'address' => $request->input('address'),
                'photo' => $fileName,  // Save uploaded file name
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
        $this->syncUserEmail($teacher->user_id, $request->name, $request->email);

        return redirect()->back()->with('success', 'Teacher updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the teacher exists
        $teacher = DB::table('teacher')->where('teacher_id', $id)->first();

        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher not found.');
        }

        // Delete the teacher
        DB::table('teacher')->where('teacher_id', $id)->delete();
        DB::table('users')->where('id', $teacher->user_id)->delete();

        return redirect()->back()->with('success', 'Teacher and teachers user are deleted successfully!');
    }
}
