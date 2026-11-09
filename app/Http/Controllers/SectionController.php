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
        if (!in_array((int) Auth::user()->role, [0, 1, 3, 4], true)) {
            abort(403);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorizeAccountantAccess();

        // Fetch all classes with section counts for selector
        $classes = DB::table('class')
            ->select('class.*')
            ->orderBy('name')
            ->get();

        foreach ($classes as $c) {
            $c->sections_count = DB::table('section')->where('class_id', $c->class_id)->count();
        }

        // Fetch all teachers
        $teachers = DB::table('teacher')->orderBy('name')->get();

        // Selected class
        $selectedClassId = $request->input('class_id', $classes->first()->class_id ?? null);
        $currentClass = DB::table('class')
            ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
            ->where('class.class_id', $selectedClassId)
            ->select('class.*', 'teacher.name as teacher_name')
            ->first();

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
                'section.time_out'
            )
            ->orderBy('section.name')
            ->get();

        foreach ($sections as $s) {
            $s->students_count = DB::table('student_classes')->where('section_id', $s->section_id)->count();
        }

        $metrics = [
            'total_sections'          => DB::table('section')->count(),
            'total_classes'           => $classes->count(),
            'current_class_sections'  => $sections->count(),
            'current_class_students'  => DB::table('student_classes')->where('class_id', $selectedClassId)->count(),
        ];

        return view('section.index', compact('classes', 'teachers', 'sections', 'selectedClassId', 'currentClass', 'metrics'));
    }

    public function getSectionsByClass($classId)
    {
        try {
            $currentClass = DB::table('class')
                ->leftJoin('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                ->where('class.class_id', $classId)
                ->select('class.*', 'teacher.name as teacher_name')
                ->first();

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
                ->orderBy('section.name')
                ->get();

            foreach ($sections as $s) {
                $s->students_count = DB::table('student_classes')->where('section_id', $s->section_id)->count();
            }

            $teachers = DB::table('teacher')
                ->select('teacher_id', 'name')
                ->orderBy('name')
                ->get();

            return response()->json([
                'class'    => $currentClass,
                'sections' => $sections,
                'teachers' => $teachers,
                'total_students' => DB::table('student_classes')->where('class_id', $classId)->count(),
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching sections:', ['error' => $e->getMessage()]);
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

        $request->validate([
            'section_name' => 'required|string|max:255',
            'nick_name'    => 'nullable|string|max:255',
            'class_id'     => 'required|exists:class,class_id',
            'teacher_id'   => 'nullable|exists:teacher,teacher_id',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
            'start_time'   => 'nullable|string',
            'end_time'     => 'nullable|string',
        ]);

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        // Fallback to date_range if start_date/end_date not directly passed
        if ((!$startDate || !$endDate) && $request->filled('date_range')) {
            $dates = explode(" - ", $request->input('date_range'));
            $startDate = $dates[0] ?? null;
            $endDate   = $dates[1] ?? null;
        }

        $timeIn = $request->input('start_time');
        if ($timeIn && strlen($timeIn) === 5) {
            $timeIn .= ':00';
        }

        $timeOut = $request->input('end_time');
        if ($timeOut && strlen($timeOut) === 5) {
            $timeOut .= ':00';
        }

        DB::table('section')->insert([
            'name'       => $request->input('section_name'),
            'nick_name'  => $request->input('nick_name'),
            'class_id'   => $request->input('class_id'),
            'teacher_id' => $request->input('teacher_id'),
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'time_in'    => $timeIn,
            'time_out'   => $timeOut,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('sections.index', ['class_id' => $request->input('class_id')])
            ->with('success', 'Section added successfully!');
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

        $request->validate([
            'section_name' => 'required|string|max:255',
            'nick_name'    => 'nullable|string|max:255',
            'teacher_id'   => 'nullable|exists:teacher,teacher_id',
            'start_date'   => 'nullable|date',
            'end_date'     => 'nullable|date',
            'start_time'   => 'nullable|string',
            'end_time'     => 'nullable|string',
        ]);

        $section = DB::table('section')->where('section_id', $id)->first();
        if (!$section) {
            return redirect()->back()->with('error', 'Section not found.');
        }

        $startDate = $request->input('start_date');
        $endDate   = $request->input('end_date');

        if ((!$startDate || !$endDate) && $request->filled('date_range')) {
            $dates = explode(" - ", $request->input('date_range'));
            $startDate = $dates[0] ?? $section->start_date;
            $endDate   = $dates[1] ?? $section->end_date;
        }

        $timeIn = $request->input('start_time', $section->time_in);
        if ($timeIn && strlen($timeIn) === 5) {
            $timeIn .= ':00';
        }

        $timeOut = $request->input('end_time', $section->time_out);
        if ($timeOut && strlen($timeOut) === 5) {
            $timeOut .= ':00';
        }

        DB::table('section')->where('section_id', $id)->update([
            'name'       => $request->input('section_name'),
            'nick_name'  => $request->input('nick_name'),
            'teacher_id' => $request->input('teacher_id'),
            'start_date' => $startDate ?? $section->start_date,
            'end_date'   => $endDate ?? $section->end_date,
            'time_in'    => $timeIn,
            'time_out'   => $timeOut,
            'updated_at' => now(),
        ]);

        return redirect()->route('sections.index', ['class_id' => $section->class_id])
            ->with('success', 'Section updated successfully!');
    }

    public function destroy($id)
    {
        $this->authorizeAccountantAccess();

        $section = DB::table('section')->where('section_id', $id)->first();
        $classId = $section ? $section->class_id : null;

        DB::table('section')->where('section_id', $id)->delete();

        $params = $classId ? ['class_id' => $classId] : [];
        return redirect()->route('sections.index', $params)->with('success', 'Section deleted successfully!');
    }

}
