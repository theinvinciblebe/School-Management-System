<?php

namespace App\Http\Controllers;

use App\Models\SectionModel;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
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
    public function index(Request $request)
    {
        $this->authorizeAccountantAccess();

        // Fetch all classes
        $classes = DB::table('class')->get();

        // Fetch all teachers
        $teachers = DB::table('teacher')->get();

        // Fetch sections for the selected class (default to the first class if none selected)
        $selectedClassId = $request->input('class_id', $classes->first()->class_id ?? null);
        $sections = DB::table('section')
            ->leftjoin('teacher', 'section.teacher_id', '=', 'teacher.teacher_id')
            ->where('section.class_id', $selectedClassId)
            ->select(
                'section.section_id',
                'section.name as section_name',
                'section.nick_name',
                'teacher.name as teacher_name',
                'section.teacher_id',
                'section.start_date',
                'section.end_date',
                'section.time_in',
                'section.time_out',
            )
            ->get();

        return view('section.index', compact('classes', 'teachers', 'sections', 'selectedClassId'));
    }


    public function getSectionsByClass($classId)
    {
        try{
            $sections = DB::table('section')
                ->leftjoin('class', 'section.class_id', '=', 'class.class_id')
                ->leftjoin('teacher', 'section.teacher_id', '=', 'teacher.teacher_id')
                ->where('section.class_id', $classId)
                ->select(
                    'section.section_id',
                    'section.name as section_name',
                    'section.nick_name',
                    'section.start_date',
                    'section.end_date',
                    'section.time_in',
                    'section.time_out',
                    'teacher.name as teacher_name',
                    'section.teacher_id'
                )
                ->get();
            // Fetch All Teachers
            $teachers = DB::table('teacher')
                ->select('teacher_id', 'name')
                ->get();

            return response()->json([
                'sections' => $sections,
                'teachers' => $teachers
            ]);
        } catch (\Exception $e) {
            // Log the error
        \Log::error('Error fetching attendance:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Internal Server Error'], 500);
        }
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
        $this->authorizeAccountantAccess();
        // Validate the incoming data
        $request->validate([
            'section_name' => 'required|string|max:255',
            'nick_name' => 'nullable|string|max:255',
            'class_id' => 'required|exists:class,class_id',
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
            'date_range' => 'required',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Extract start and end date from date_range
        $dates = explode(" - ", $request->input('date_range'));
        $start_date = isset($dates[0]) ? $dates[0] : null;
        $end_date = isset($dates[1]) ? $dates[1] : null;

        DB::table('section')->insert([
            'name' => $request->input('section_name'),
            'nick_name' => $request->input('nick_name'),
            'class_id' => $request->input('class_id'),
            'teacher_id' => $request->input('teacher_id'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'time_in' => $request->input('start_time'),
            'time_out' => $request->input('end_time'),
        ]);

        return redirect()->route('sections.index')->with('success', 'Section added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(SectionModel $sectionModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SectionModel $sectionModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->authorizeAccountantAccess();

        // Validate the incoming request
        $request->validate([
            'section_name' => 'required|string|max:255',
            'nick_name' => 'nullable|string|max:255',
            'teacher_id' => 'nullable|exists:teacher,teacher_id',
            'date_range' => 'required|string',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        // Extract start and end dates from date_range
        // Extract start and end date from date_range
        $dates = explode(" - ", $request->input('date_range'));
        $start_date = isset($dates[0]) ? $dates[0] : null;
        $end_date = isset($dates[1]) ? $dates[1] : null;

        // Extract start and end time
//        $start_time = \Carbon\Carbon::parse($request->input('start_time'))->format('H:i:s');
//        $end_time = \Carbon\Carbon::parse($request->input('end_time'))->format('H:i:s');

        // Check if section exists
        $section = DB::table('section')->where('section_id', $id)->first();
        if (!$section) {
            return redirect()->back()->with('error', 'Section not found.');
        }

        // Update the section in the database
        DB::table('section')->where('section_id', $id)->update([
            'name' => $request->input('section_name'),
            'nick_name' => $request->input('nick_name'),
            'teacher_id' => $request->input('teacher_id'),
            'start_date' => $start_date,
            'end_date' => $end_date,
            'time_in' => $request->input('start_time'),
            'time_out' => $request->input('end_time'),
        ]);

        return redirect()->route('sections.index')->with('success', 'Section updated successfully!');
    }


    public function destroy($id)
    {
        $this->authorizeAccountantAccess();

        // Delete the section from the database
        DB::table('section')->where('section_id', $id)->delete();

        return redirect()->route('sections.index')->with('success', 'Section deleted successfully!');
    }

}
