<?php

namespace App\Http\Controllers;

use App\Models\StaffModel;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staffs = DB::table('staff')
            ->leftJoin('department', 'department.id', '=', 'staff.department_id')
            ->select('staff.*', 'department.name as department_name')
            ->get();

        $departments = DB::table('department')->get();

        return view('staff.index', compact('staffs', 'departments'));
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
        // Validate incoming data
        $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'department_id' => 'required|exists:department,id',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
        ]);

        // **Handle File Upload**
        if ($request->hasFile('file')) {
            $fileName = time() . '.' . $request->file->extension();
            $request->file->move(public_path('staffs_image'), $fileName);
        }else{
            $fileName = 'noimg.jpg';
        }

        // Automatically generate number
        $lastIdCard = DB::table('staff')->max('id_card');
        $newIdCard = str_pad(($lastIdCard ? $lastIdCard + 1 : 1001), 4, '0', STR_PAD_LEFT);


        $email = $request->input('email');

        $exists = DB::table('staff')->where('email', $email)->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'The email has already been taken.');
        }

        // Store staff data
            DB::table('staff')->insert([
                'name' => $request->input('name'),
                'sex' => $request->input('sex'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'department_id' => $request->input('department_id'),
                'position' => $request->input('position'),
                'hire_date' => $request->input('hire_date'),
                'id_card' => $newIdCard,
                'photo' => $fileName,  // Save uploaded file name

                'created_at' => now(),
                'updated_at' => now(),
            ]);

        $position = $request->input('position');

        $roles = [
            'Accountant' => 3,
            'Receptionist' => 4,
        ];

        if (array_key_exists($position, $roles)) {
            DB::table('users')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('123456'), // Default password
                'role' => $roles[$position],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
           // return ->with('success', 'Staff admitted successfully with default password "123456".');
        }

            return redirect()->route('staffs.index')->with('success', 'Staff added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffModel $staffModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffModel $staffModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'sex' => 'required|in:Male,Female',
            'email' => 'required|email|unique:staff,email,' . $id . ',staff_id',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'department_id' => 'required|exists:department,id',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:2048',
        ]);

        // Find staff
        $staff = DB::table('staff')->where('staff_id', $id)->first();

        if (!$staff) {
            return redirect()->back()->with('error', 'Staff not found.');
        }

        // If the photo is NULL, set it to default
        $fileName = $staff->photo ?? 'noimg.jpg';

        // Handle new image upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Ensure valid file format
            if (!in_array($file->getClientOriginalExtension(), ['jpeg', 'jpg', 'png', 'gif', 'ico'])) {
                return redirect()->back()->with('error', 'Invalid image format.');
            }

            // Delete old image only if it's not NULL and not the default image
            if (!empty($staff->photo) && $staff->photo !== 'noimg.jpg') {
                $oldImagePath = public_path("staffs_image/" . $staff->photo);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Save new image
            $fileName = time() . '.' . $file->extension();
            $file->move(public_path('staffs_image'), $fileName);
        }

        try {
            // Update staff data
            DB::table('staff')
                ->where('staff_id', $id)
                ->update([
                    'name' => $request->input('name'),
                    'sex' => $request->input('sex'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'address' => $request->input('address'),
                    'department_id' => $request->input('department_id'),
                    'position' => $request->input('position'),
                    'hire_date' => $request->input('hire_date'),
                    'photo' => $fileName, // Save uploaded file name
                    'updated_at' => now(),
                ]);

            return redirect()->route('staffs.index')->with('success', 'Staff updated successfully!');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Failed to update staff: ' . $e->getMessage())->withInput();
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            // Delete staff record
            DB::table('staff')->where('staff_id', $id)->delete();

            return redirect()->route('staffs.index')->with('success', 'Staff deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete staff: ' . $e->getMessage());
        }
    }

}
