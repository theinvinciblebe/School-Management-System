<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', compact('users'));
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|integer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->back()->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'role' => 'required|integer',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully!');
    }

    public function profile()
    {
        $user = auth()->user(); // Get the logged-in user's information
        $additionalData = null; // Initialize additional data

        if ($user->role == 1) { // If the user is a teacher
            $additionalData = DB::table('teacher')
                ->where('user_id', $user->id)
                ->first(); // Fetch the teacher's data
        } elseif ($user->role == 2) { // If the user is a student
            $additionalData = DB::table('student')
                ->where('user_id', $user->id)
                ->first(); // Fetch the student's data
        }elseif ($user->role == 3) { // If the user is a accountant
            $additionalData = DB::table('staff')
                ->where('user_id', $user->id)
                ->first(); // Fetch the student's data
        }

        return view('user.profile', compact('user', 'additionalData')); // Pass user and additional data to the view
    }



    public function getProfile()
    {
        $user = auth()->user();
        return response()->json($user);
    }

    public function getProfilePhoto(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user(); // Get the logged-in user

        //$photoPath = asset('favicon.ico'); // Default icon for Admin

        if ($user->role == 0) { // Teacher
            $profile = DB::table('users')->where('id', $user->id)->first();
            if ($profile && !empty($profile->photo)) {
                $photoPath = asset('admin_image/' . $profile->photo);
            } else {
                $photoPath = asset('teachers_image/noimg.jpg');
            }
        }  elseif ($user->role == 1) { // Teacher
            $profile = DB::table('teacher')->where('user_id', $user->id)->first();
            if ($profile && !empty($profile->photo)) {
                $photoPath = asset('teachers_image/' . $profile->photo);
            } else {
                $photoPath = asset('teachers_image/noimg.jpg');
            }
        } elseif ($user->role == 2) { // Student
            $profile = DB::table('student')->where('user_id', $user->id)->first();
            if ($profile && !empty($profile->photo)) {
                $photoPath = asset('students_image/' . $profile->photo);
            } else {
                $photoPath = asset('students_image/noimg.jpg');
            }
        } elseif ($user->role == 3) { // Accountant
            $profile = DB::table('staff')->where('user_id', $user->id)->first();
            if ($profile && !empty($profile->photo)) {
                $photoPath = asset('staffs_image/' . $profile->photo);
            } else {
                $photoPath = asset('staffs_image/noimg.jpg');
            }
        }

        return response()->json(['photo' => $photoPath]); // Return JSON response
    }



    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }
}
