<?php

namespace App\Http\Controllers;

use App\Models\DepartmentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = DB::table('department')->get();
        return view('department.index', compact('departments'));
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
        ]);

        DB::table('department')->insert([
            'name' => $request->input('name'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('departments.index')->with('success', 'Department added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DepartmentModel $departmentModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DepartmentModel $departmentModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Update the section in the database
        DB::table('department')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'updated_at' => now(),
            ]);

        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Delete the section from the database
        DB::table('department')->where('id', $id)->delete();

        return redirect()->route('departments.index')->with('success', 'Department deleted successfully!');
    }
}
