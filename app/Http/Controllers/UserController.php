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
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
        ]);

        $photoName = $this->handleImageUpload($request, (int)$request->role);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'photo' => $photoName,
        ]);

        if ($photoName) {
            $this->syncRolePhoto($user, $photoName);
        }

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
            'password' => 'nullable|string|min:6',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
        ]);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->role = $request->role;

        // Check if remove photo is requested
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($user->photo && $user->photo !== 'noimg.jpg') {
                foreach (['admin_image', 'teachers_image', 'students_image', 'staffs_image'] as $dir) {
                    $path = public_path($dir . '/' . $user->photo);
                    if (file_exists($path) && is_file($path)) {
                        @unlink($path);
                    }
                }
            }
            $user->photo = null;
        }

        // Handle new photo upload
        $newPhoto = $this->handleImageUpload($request, (int)$user->role, $user->photo);
        if ($newPhoto) {
            $user->photo = $newPhoto;
            $this->syncRolePhoto($user, $newPhoto);
        }

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
        } elseif ($user->role == 3 || $user->role == 4) { // Accountant or Receptionist
            $additionalData = DB::table('staff')
                ->where('user_id', $user->id)
                ->first();
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
        if (!$user) {
            return response()->json(['photo' => asset('user-profile-default.png')]);
        }

        return response()->json(['photo' => $user->photo_url]);
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,ico|max:3072',
        ];

        if ($request->filled('password_confirmation')) {
            $rules['password'] = 'required|string|min:6|confirmed';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        $request->validate($rules);

        $user = User::findOrFail($request->id);
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Handle photo removal
        if ($request->has('remove_photo') && $request->remove_photo == '1') {
            if ($user->photo && $user->photo !== 'noimg.jpg') {
                foreach (['admin_image', 'teachers_image', 'students_image', 'staffs_image'] as $dir) {
                    $path = public_path($dir . '/' . $user->photo);
                    if (file_exists($path) && is_file($path)) {
                        @unlink($path);
                    }
                }
            }
            $user->photo = null;
        }

        // Handle new photo upload
        $newPhoto = $this->handleImageUpload($request, (int)$user->role, $user->photo);
        if ($newPhoto) {
            $user->photo = $newPhoto;
            $this->syncRolePhoto($user, $newPhoto);
        }

        $user->save();

        // Optionally update phone and address if provided for linked role
        $extraData = [];
        if ($request->has('phone')) $extraData['phone'] = $request->phone;
        if ($request->has('address')) $extraData['address'] = $request->address;

        if (!empty($extraData)) {
            if ($user->role == 1) {
                DB::table('teacher')->where('user_id', $user->id)->update($extraData);
            } elseif ($user->role == 2) {
                DB::table('student')->where('user_id', $user->id)->update($extraData);
            } elseif ($user->role == 3 || $user->role == 4) {
                DB::table('staff')->where('user_id', $user->id)->update($extraData);
            }
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->photo && $user->photo !== 'noimg.jpg') {
            foreach (['admin_image', 'teachers_image', 'students_image', 'staffs_image'] as $dir) {
                $path = public_path($dir . '/' . $user->photo);
                if (file_exists($path) && is_file($path)) {
                    @unlink($path);
                }
            }
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully!');
    }

    /**
     * Handle image upload helper
     */
    private function handleImageUpload(Request $request, int $role, ?string $oldPhoto = null): ?string
    {
        $file = $request->file('photo') ?? $request->file('file');
        if (!$file) {
            return null;
        }

        $folder = match ($role) {
            1 => 'teachers_image',
            2 => 'students_image',
            3, 4 => 'staffs_image',
            default => 'admin_image',
        };

        $targetPath = public_path($folder);
        if (!file_exists($targetPath)) {
            mkdir($targetPath, 0777, true);
        }

        // If old photo exists and is not default, delete it
        if ($oldPhoto && $oldPhoto !== 'noimg.jpg' && $oldPhoto !== 'user-profile-default.png') {
            foreach (['admin_image', 'teachers_image', 'students_image', 'staffs_image'] as $dir) {
                $oldPath = public_path($dir . '/' . $oldPhoto);
                if (file_exists($oldPath) && is_file($oldPath)) {
                    @unlink($oldPath);
                }
            }
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($targetPath, $fileName);

        return $fileName;
    }

    /**
     * Sync photo to role-specific tables if they exist
     */
    private function syncRolePhoto(User $user, string $fileName): void
    {
        if ($user->role == 1) {
            DB::table('teacher')->where('user_id', $user->id)->update(['photo' => $fileName]);
        } elseif ($user->role == 2) {
            DB::table('student')->where('user_id', $user->id)->update(['photo' => $fileName]);
        } elseif ($user->role == 3 || $user->role == 4) {
            DB::table('staff')->where('user_id', $user->id)->update(['photo' => $fileName]);
        }
    }
}
