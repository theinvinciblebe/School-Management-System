<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use Illuminate\Http\Request;
use DB;

class ParentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $parents = DB::table('parent')->get(); // Fetch all parents
        return view("parent.index", ['parents' => $parents, 'i' => 1]);
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
            'email' => 'required|email|unique:parent,email',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:15',
            'profession' => 'nullable|string|max:15',
        ]);

        DB::table('parent')->insert([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'profession' => $request->input('profession'),
        ]);

        return redirect()->route('parents.index')->with('success', 'Parent added successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(ParentModel $parentModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
//        // Fetch the parent record by ID
//        $parent = DB::table('parent')->where('parent_id', $id)->first();
//
//        if (!$parent) {
//            return redirect()->route('parents.index')->with('error', 'Parent not found.');
//        }
//
//        // Pass the parent data to the edit view
//        return view('parents.index', compact('parent'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:15',
            'profession' => 'nullable|string|max:15',
        ]);

        // Update the parent record in the database
        DB::table('parent')
            ->where('parent_id', $id)
            ->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'address' => $request->input('address'),
                'profession' => $request->input('profession'),
            ]);

        return redirect()->route('parents.index')->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the parent exists
        $parent = DB::table('parent')->where('parent_id', $id)->first();
        if (!$parent) {
            return redirect()->route('parents.index')->with('error', 'Parent not found.');
        }

        // Delete the parent
        DB::table('parent')->where('parent_id', $id)->delete();

        return redirect()->route('parents.index')->with('success', 'Parent deleted successfully.');
    }

}
