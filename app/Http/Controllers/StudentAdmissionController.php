<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\StudentAdmissionModel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class StudentAdmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admissions = DB::table('admission')->orderBy('created_at', 'desc')->get();

        return view('student_admission.index', ['admissions' => $admissions]);
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'phone' => 'required|string',
            'street_address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip' => 'required|string',
            'country' => 'required|string',
            'apartment' => 'nullable|string',
            'courses' => 'required|array',
            'mode' => 'required|string',
            'subject' => 'required|string',
            'work_exp' => 'nullable|string',
            'education' => 'required|array',
            'guardian_name' => 'nullable|string',
            'guardian_relationship' => 'nullable|string',
            'guardian_email' => 'nullable|email',
            'guardian_phone' => 'nullable|string',
            'reference' => 'nullable|string',
            //'consent' => 'required|accepted',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Use query builder
        DB::table('admission')->insert([
            'full_name' => $request->input('name'),
            'email' => $request->input('email'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
            'phone' => $request->input('phone'),
            'street' => $request->input('street_address'),
            'apartment' => $request->input('apartment'),
            'city' => $request->input('city'),
            'province' => $request->input('state'),
            'zip' => $request->input('zip'),
            'country' => $request->input('country'),
            'mode' => $request->input('mode'),
            'subject' => $request->input('subject'),
            'work_exp' => $request->input('work_exp'),
            'course' => implode(', ', $request->input('courses', [])), // Assuming courses[] from frontend
            'education' => json_encode($request->input('education', [])),
            'guardian_name' => $request->input('guardian_name'),
            'guardian_relationship' => $request->input('guardian_relationship'),
            'guardian_email' => $request->input('guardian_email'),
            'guardian_phone' => $request->input('guardian_phone'),
            'reference' => $request->input('reference'),
            //'consent' => $request->has('consent'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $userName = $request->input('name');
        // Find Admins (assuming role_id 1 is admin)
        $admins = User::where('role', 0)->get();

        foreach ($admins as $admin) {
            Notification::create([
                //'user_id' => 1,
                'admin_id' => $admin->id,
                'type' => 'Admission',
                'message' => "New apply from {$userName}. Requires approval.",
                'is_read' => false
            ]);
        }

        return response()->json(['message' => 'Form submitted successfully']);
    }


    public function approve($id)
    {
        try {
        // Find the request
        $adminId = Auth::id();

        $admission = DB::table('admission')
            ->where('id', $id)->first();

        if (!$admission) {
            return redirect()->back()->with('error', 'Admission not found.');
        }

        // Update status and store approver ID
        DB::table('admission')
            ->where('id', $id)->update([
                'status' => 'approved',
                'decide_by' => $adminId, // Store approver's ID
            ]);

            $userExists = DB::table('users')->where('email', $admission->email)->exists();

            if ($userExists) {
                return response()->json(['error' => 'Email for user is already taken!.'], 409);
            }

        //Create the user in the `users` table
        $userId = DB::table('users')->insertGetId([
            'name' => $admission->full_name,
            'email' => $admission->email,
            'password' => Hash::make('123456'), // Default password
            'role' => 2, // Role = Student
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Insert new parent record
        $parentId = null;

        if ($admission->guardian_name || $admission->guardian_phone || $admission->guardian_email) {
            $parentId = DB::table('parent')->insertGetId([
                'name' => $admission->guardian_name ?? '',
                'phone' => $admission->guardian_phone ?? '',
                'email' => $admission->guardian_email ?? '',
            ]);
        }

        $fileName = 'noimg.jpg';

        // Compose address from admission fields
        $address = implode(', ', array_filter([
            $admission->apartment,
            $admission->street,
            $admission->province,
            $admission->city,
            $admission->country
        ]));

        $gender=null;
            if($admission->gender==='Male'){
                $gender=0;
            }else{
                $gender=1;
            }

        // Insert into student table
         DB::table('student')->insert([
            'user_id' => $userId, // Foreign key
            'name' => $admission->full_name,
            'birthday' => $admission->dob,
            'sex' => $gender,
            'address' => $address,
            'phone' => $admission->phone,
            'photo' => $fileName,  // Save uploaded file name
            'email' => $admission->email,
            'parent_id' => $parentId,  // Link to newly created parent
        ]);

        // Insert into student_classes table
//        DB::table('student_classes')->insert([
//            'student_id' => $studentId,
//            'class_id' => $request->input('class_id'),
//            'section_id' => $request->input('section_id'),
//            'roll' => $newRoll, // Auto-assigned roll number
//        ]);

        // Send a notification to the requesting user
//        DB::table('notifications')->insert([
//            'user_id' => $admission->$userId, // Requesting user ID
//            'admin_id' => Auth::id(), // Admin who approved
//            'type' => 'Purchase Approval',
//            'message' => 'Your purchase request has been approved!',
//            'is_read' => 0,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);


        return response()->json(['success' => 'Admission  request approved successfully.']);
    }catch (\Exception $e) {
        Log::error('Approval Error: ' . $e->getMessage());
        return response()->json(['error' => 'Something went wrong.'], 500);
    }
}

    public function reject($id)
    {
        $adminId = Auth::id();

        // Find the request
        $admission = DB::table('admission')
            ->where('id', $id)->first();

        if (!$admission) {
            return redirect()->back()->with('error', 'Admission not found.');
        }

        DB::table('admission')
            ->where('id', $id)->update([
                'status' => 'rejected',
                'decide_by' => $adminId, // Store approver's ID
            ]);

        // Send a notification to the requesting user
//        DB::table('notifications')->insert([
//            'user_id' => $purchaseRequest->user_id, // Requesting user ID
//            'admin_id' => Auth::id(), // Admin who approved
//            'type' => 'Purchase Rejected',
//            'message' => 'Your purchase request has been rejected!',
//            'is_read' => 0,
//            'created_at' => now(),
//            'updated_at' => now(),
//        ]);

        return response()->json(['success' => 'purchase request rejected.']);
        //return redirect()->back()->with('success', 'Fee receipt rejected!');
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $admission = DB::table('admission')
            ->where('id', $id)
            ->first();
        return view('student_admission.admission-view', compact('admission'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StudentAdmissionModel $studentAdmissionModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StudentAdmissionModel $studentAdmissionModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the teacher exists
        $admission = DB::table('admission')->where('id', $id)->first();

        if (!$admission) {
            return redirect()->back()->with('error', 'Admission not found.');
        }

        // Delete the teacher
        DB::table('admission')->where('id', $id)->delete();
        //DB::table('users')->where('id', $admission->user_id)->delete();

        return redirect()->back()->with('success', 'Admission data are deleted successfully!');
    }
}
