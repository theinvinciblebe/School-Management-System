<?php

namespace App\Http\Controllers;

use App\Models\AttendanceModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($class_id = null)
    {
        //$sections = DB::table('section')->where('class_id', $class_id)->get();
        $date = now()->format('Y-m-d');
        $user = auth()->user();

        if ($user->role == 1) {
            // Fetch only the classes assigned to the teacher
            $classes = DB::table('class')
                ->join('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('teacher.user_id', $user->id)
                ->select('class.class_id', 'class.name')
                ->get();
        } else {
            // Admins or other roles can view all classes
            $classes = DB::table('class')->get();
        }

        // Fetch sections for the first class if $class_id is null
        $selectedClass = $class_id ?? ($classes->first()->class_id ?? null);
        $sections = $selectedClass ? DB::table('section')->where('class_id', $selectedClass)->get() : [];

        $attendanceExists = false;
        if ($user->role == 1) {
            // Check if attendance already exists for the teacher
            $attendanceExists = DB::table('attendance')
                ->join('student_classes', 'attendance.student_class_id', '=', 'student_classes.id')
                ->where('student_classes.class_id', $class_id)
                ->where('attendance.date', $date)
                ->where('attendance.attendance_by', $user->id)
                ->exists();
        }

        return view('attendance.index', compact('class_id', 'classes', 'sections', 'selectedClass', 'attendanceExists'));
    }



    public function viewAttendance($class_id, $date)
    {
        // Get attendance records for the given class and date
        $attendance = DB::table('attendance')
            ->join('student_classes', 'attendance.student_class_id', '=', 'student_classes.id')
            ->join('student', 'student_classes.student_id', '=', 'student.student_id')
            ->select(
                'student.name as student_name',
                'student_classes.roll',
                'attendance.status'
            )
            ->where('student_classes.class_id', $class_id)
            ->where('attendance.date', $date)
            ->get();

        // Return as JSON for frontend JavaScript to render
        return response()->json(['attendance' => $attendance]);
    }

    public function requestList()
    {
        $requests = DB::table('attendance_edit_requests')
            ->join('class', 'attendance_edit_requests.class_id', '=', 'class.class_id')
            ->join('teacher', 'attendance_edit_requests.teacher_id', '=', 'teacher.teacher_id')
            ->join('section', 'attendance_edit_requests.section_id', '=', 'section.section_id')
            ->select(
                'attendance_edit_requests.id', // Include the ID
                'class.name as class_name',
                'teacher.name as teacher_name',
                'section.name as section_name',
                'attendance_edit_requests.date',
                'attendance_edit_requests.reason',
                'attendance_edit_requests.status'
            )
            ->get();

        return view('attendance.request_list', compact('requests'));
    }


    public function requestEdit(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'date' => 'required|date',
            'reason' => 'required|string|max:255',
        ]);
        // Ensure the user is a teacher
        if ($user->role != 1) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Retrieve the class_id and section_id from the attendance table
        $attendanceData = DB::table('attendance')
            ->join('student_classes', 'attendance.student_class_id', '=', 'student_classes.id')
            ->select('student_classes.class_id', 'student_classes.section_id')
            ->where('attendance.attendance_by', $user->id)
            ->where('attendance.date', $request->date)
            ->first();

        if (!$attendanceData) {
            return redirect()->back()->with('error', 'No attendance records found for the selected date.');
        }

        $teacher = DB::table('teacher')->where('user_id', $user->id)->first();
        if (!$teacher) {
            return redirect()->back()->with('error', 'Teacher not found.');
        }

        // Insert the edit request into the attendance_edit_requests table
        DB::table('attendance_edit_requests')->insert([
            'teacher_id' => $teacher->teacher_id,
            'date' => $request->date,
            'reason' => $request->reason,
            'status' => 'Pending',
            'class_id' => $attendanceData->class_id,
            'section_id' => $attendanceData->section_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Attendance edit request submitted successfully. Please wait for approval.');
    }

    public function updateRequestStatus(Request $request, $id)
    {
        if (auth()->user()->role != 0) { // Assuming role 0 is for admin
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $request->validate([
            'status' => 'required|in:Approved,Rejected',
        ]);
        // Get the request details
        $attendanceRequest = DB::table('attendance_edit_requests')->where('id', $id)->first();

        if ($request->status === 'Approved') {
            // Enable attendance editing for the teacher
            DB::table('attendance_edit_requests')->where('id', $id)->update([
                'status' => 'Approved',
                'updated_at' => now(),
            ]);

            // Optional: Track in a separate table or log if needed
        } else {
            // Update status to 'Rejected'
            DB::table('attendance_edit_requests')->where('id', $id)->update([
                'status' => 'Rejected',
                'updated_at' => now(),
            ]);
        }

            return redirect()->back()->with('success', 'Request status updated successfully.');
    }



    public function getSections($class_id)
    {
        $sections = DB::table('section')->where('class_id', $class_id)->get();
        return response()->json(['sections' => $sections]);
    }

    public function getStudents($section_id, Request $request)
    {
        $students = DB::table('student_classes')
            ->join('student', 'student.student_id', '=', 'student_classes.student_id')
            ->leftJoin('attendance', function ($join) use ($request) {
                $join->on('attendance.student_class_id', '=', 'student_classes.id')
                    ->where('attendance.date', '=', $request->date);
            })
            ->select('student_classes.id as student_class_id', 'student.name', 'student_classes.roll', 'attendance.status')
            ->where('student_classes.section_id', $section_id)
            ->get();

        return response()->json(['students' => $students]);
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
        $attendanceData = $request->input('attendance');
        $date = $request->input('date');

        foreach ($attendanceData as $attendance) {
            DB::table('attendance')->updateOrInsert(
                [
                    'student_class_id' => $attendance['student_class_id'],
                    'date' => $date,
                ],
                [
                    'status' => $attendance['status']
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AttendanceModel $attendanceModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'attendance.*.status' => 'required|integer',
            'attendance.*.student_class_id' => 'required|integer',
        ]);

        $class_id = $request->input('class_id');
        $date = $validatedData['date'];
        $user = auth()->user();  // Get logged-in user
        $teacher = DB::table('teacher')->where('user_id', $user->id)->first();

        // Check for teacher role (role = 1)
        if ($user->role == 1) {

            // Check if the edit request is approved for the selected class and date
            $approvedRequest = DB::table('attendance_edit_requests')
                ->where('teacher_id', $teacher->teacher_id)
                ->where('class_id', $class_id)
                ->where('date', $date)
                ->where('status', 'Approved') // Ensure the request is approved
                ->exists();

            // Check if attendance has already been submitted for the given class and date
            $existingAttendance = DB::table('attendance')
                ->join('student_classes', 'attendance.student_class_id', '=', 'student_classes.id')
                ->where('student_classes.class_id', $class_id)
                ->where('attendance.date', $date)
                ->where('attendance.attendance_by', $user->id)
                ->exists();

            // If attendance exists and no approved request, deny submission
            if ($existingAttendance && !$approvedRequest) {
                return redirect()->back()->with('error', 'You have already submitted attendance for this class and date.');
            }
        }
        // Save attendance
        foreach ($validatedData['attendance'] as $studentAttendance) {
            DB::table('attendance')->updateOrInsert(
                [
                    'student_class_id' => $studentAttendance['student_class_id'],
                    'date' => $validatedData['date'],
                ],
                [
                    'status' => $studentAttendance['status'],
                    'attendance_by' => $user->id,

                ]
            );
        }
        // Optionally mark the request as completed after updating attendance
        if ($user->role == 1) {
            DB::table('attendance_edit_requests')
                ->where('teacher_id', $teacher->teacher_id)
                ->where('class_id', $class_id)
                ->where('date', $date)
                ->where('status', 'Approved')
                ->update(['status' => 'Completed']);
        }


        return redirect()->back()->with('success', 'Attendance saved successfully.');
    }

    public function checkAttendance($class_id, Request $request)
    {
        // Validate the inputs
        $request->validate([
            'date' => 'required|date', // Ensure date is provided and valid
        ]);

        $date = $request->query('date');
        $user = auth()->user();  // Get current user's info

        $attendanceExists = DB::table('attendance')
            ->join('student_classes', 'attendance.student_class_id', '=', 'student_classes.id')
            ->where('student_classes.class_id', $class_id)  // Join to get class_id
            ->where('attendance.date', $date)
            ->where('attendance.attendance_by', $user->id)
            ->exists();

        return response()->json([
            'attendance_exists' => $attendanceExists,
            'role' => $user->role,
        ]);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AttendanceModel $attendanceModel)
    {
        //
    }
}
