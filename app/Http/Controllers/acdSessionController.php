<?php

namespace App\Http\Controllers;

use App\Models\acdSessionModel;
use Illuminate\Http\Request;
use DB;

class acdSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = DB::table('acd_session')->get();
        return view("student_section.acdSession.index", ['sessions' => $sessions, 'i' => 1]);
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
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'strt_dt' => 'required|date',
            'end_dt' => 'required|date|after:strt_dt',
            'is_open' => 'required|boolean', // Ensures "1" (Open) or "0" (Closed)
        ]);

        // Insert new session record
        DB::table('acd_session')->insert([
            'name' => $request->input('name'),
            'strt_dt' => $request->input('strt_dt'),
            'end_dt' => $request->input('end_dt'),
            'is_open' => $request->input('is_open'), // Save the status
        ]);

        return redirect()->back()->with('success', 'Session added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(acdSessionModel $acdSessionModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(acdSessionModel $acdSessionModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'strt_dt' => 'required|date',
            'end_dt' => 'required|date|after:strt_dt',
            'is_open' => 'required|boolean',
        ]);

        // Update the session record
        DB::table('acd_session')
            ->where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'strt_dt' => $request->input('strt_dt'),
                'end_dt' => $request->input('end_dt'),
                'is_open' => $request->input('is_open'),
            ]);

        return redirect()->back()->with('success', 'Session updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Check if the session exists
        $session = DB::table('acd_session')->where('id', $id)->first();

        if (!$session) {
            return redirect()->back()->with('error', 'Session not found.');
        }

        // Delete the session
        DB::table('acd_session')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Session deleted successfully!');
    }

}
