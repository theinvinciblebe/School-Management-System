<?php

namespace App\Http\Controllers;

use App\Models\StaffAttendanceModel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

function convertTo24HourFormat(?string $time): ?string
{
    if (!$time) {
        return null; // Return null if the time is empty
    }

    return date('H:i', strtotime($time));
}

class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = DB::table('department')->orderBy('name', 'asc')->get();

        return view('staff.staff_attendance', compact('departments'));
    }

    public function getAttendance(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'date' => 'required|date',
                'department_id' => 'nullable',
            ]);

            $departmentId = $request->query('department_id', 'all');

            // Fetch staff with department details
            $staffQuery = DB::table('staff')
                ->leftJoin('department', 'staff.department_id', '=', 'department.id')
                ->select(
                    'staff.staff_id',
                    'staff.name',
                    'staff.position',
                    'staff.photo',
                    'staff.department_id',
                    'department.name as department_name'
                );

            if ($departmentId !== 'all' && !empty($departmentId)) {
                $staffQuery->where('staff.department_id', $departmentId);
            }

            $staff = $staffQuery->orderBy('staff.name', 'asc')->get();

            if ($staff->isEmpty()) {
                return response()->json([
                    'staff' => [],
                    'summary' => [
                        'total' => 0,
                        'present' => 0,
                        'absent' => 0,
                        'late' => 0,
                        'undefined' => 0,
                        'rate' => 0,
                    ]
                ], 200);
            }

            // Fetch attendance records for given date
            $attendanceRecords = DB::table('staff_attendance')
                ->where('date', $request->date)
                ->whereIn('staff_id', $staff->pluck('staff_id'))
                ->get()
                ->keyBy('staff_id');

            $attendanceExists = $attendanceRecords->isNotEmpty();

            // Map staff with attendance data
            $staffAttendance = $staff->map(function ($s) use ($attendanceRecords) {
                $attendance = $attendanceRecords->get($s->staff_id);

                return [
                    'staff_id' => $s->staff_id,
                    'name' => $s->name,
                    'position' => $s->position ?? 'Staff',
                    'department_id' => $s->department_id,
                    'department_name' => $s->department_name ?? 'General Staff',
                    'photo' => $s->photo ?? null,
                    'status' => $attendance->status ?? 'Undefined',
                    'time_in' => $attendance->time_in ?? null,
                    'time_out' => $attendance->time_out ?? null,
                ];
            });

            // Calculate aggregate statistics
            $total = $staffAttendance->count();
            $present = $staffAttendance->where('status', 'Present')->count();
            $absent = $staffAttendance->where('status', 'Absent')->count();
            $late = $staffAttendance->where('status', 'Late')->count();
            $undefined = $total - ($present + $absent + $late);
            $rate = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;

            return response()->json([
                'staff' => $staffAttendance,
                'attendance_exists' => $attendanceExists,
                'summary' => [
                    'total' => $total,
                    'present' => $present,
                    'absent' => $absent,
                    'late' => $late,
                    'undefined' => $undefined,
                    'rate' => $rate,
                ]
            ], 200);
        } catch (\Exception $e) {
            \Log::error('Error fetching staff attendance:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error: ' . $e->getMessage()], 500);
        }
    }

    public function saveAttendance(Request $request)
    {
        // Validate the attendance data
        $validator = \Validator::make($request->all(), [
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|string',
            'attendance.*.time_in' => 'nullable|string',
            'attendance.*.time_out' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
            }
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attendanceData = $request->attendance;

        foreach ($attendanceData as $staffId => $data) {
            $status = $data['status'] ?? 'Undefined';

            // Skip or clear if undefined
            if ($status === 'Undefined') {
                DB::table('staff_attendance')
                    ->where('staff_id', $staffId)
                    ->where('date', $request->date)
                    ->delete();
                continue;
            }

            // Convert time to 24-hour format if Present or Late
            $timeIn = in_array($status, ['Present', 'Late']) ? convertTo24HourFormat($data['time_in'] ?? null) : null;
            $timeOut = in_array($status, ['Present', 'Late']) ? convertTo24HourFormat($data['time_out'] ?? null) : null;

            // Save or update attendance
            DB::table('staff_attendance')->updateOrInsert(
                [
                    'staff_id' => $staffId,
                    'date' => $request->date,
                ],
                [
                    'status' => $status,
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'updated_at' => now(),
                ]
            );
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff attendance saved successfully.'
            ]);
        }

        return redirect()->back()->with('success', 'Staff attendance saved successfully.');
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StaffAttendanceModel $staffAttendanceModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StaffAttendanceModel $staffAttendanceModel)
    {
        //
    }

    public function view($date, Request $request)
    {
        return redirect()->route('staffAttendance.index', ['date' => $date, 'tab' => 'report']);
    }

    public function attendancePDF($date, Request $request)
    {
        $department_id = $request->query('department_id');

        $query = DB::table('staff')
            ->leftJoin('department', 'staff.department_id', '=', 'department.id')
            ->leftJoin('staff_attendance', function ($join) use ($date) {
                $join->on('staff.staff_id', '=', 'staff_attendance.staff_id')
                    ->where('staff_attendance.date', '=', $date);
            })
            ->select(
                'staff.staff_id',
                'staff.name as staff_name',
                'staff.position',
                'department.name as department_name',
                'staff_attendance.status',
                'staff_attendance.time_in',
                'staff_attendance.time_out'
            );

        if ($department_id && $department_id !== 'all') {
            $query->where('staff.department_id', $department_id);
            $department = DB::table('department')->where('id', $department_id)->first();
            $departmentName = $department->name ?? 'All Departments';
        } else {
            $departmentName = 'All Departments';
        }

        $records = $query->orderBy('staff.name', 'asc')->get();

        $total = $records->count();
        $present = $records->where('status', 'Present')->count();
        $absent = $records->where('status', 'Absent')->count();
        $late = $records->where('status', 'Late')->count();
        $undefined = $total - ($present + $absent + $late);
        $rate = $total > 0 ? round((($present + $late) / $total) * 100, 1) : 0;

        $customize = DB::table('customize')->first();
        $schoolName = $customize->brand_title ?? config('app.name', 'School Management System');

        $pdf = PDF::loadView('staff.staff_attendance_pdf', compact(
            'records', 'date', 'departmentName', 'total', 'present', 'absent', 'late', 'undefined', 'rate', 'schoolName'
        ));

        return $pdf->download("Staff_Attendance_Report_{$date}.pdf");
    }



    public function assignAttendance(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,staff_id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent',
            'time_in' => 'nullable|date_format:H:i',
            'time_out' => 'nullable|date_format:H:i',
        ]);

        // Get the current attendance record for this staff and date
        $currentAttendance = DB::table('staff_attendance')
            ->where('staff_id', $validated['staff_id'])
            ->where('date', $validated['date'])
            ->first();

        // Determine new values
        $timeIn = $validated['status'] === 'Present'
            ? ($validated['time_in'] ?? ($currentAttendance->time_in ?? null))
            : null;

        $timeOut = $validated['status'] === 'Present'
            ? ($validated['time_out'] ?? ($currentAttendance->time_out ?? null))
            : null;

        // Perform the update or insert
        DB::table('staff_attendance')->updateOrInsert(
            [
                'staff_id' => $validated['staff_id'],
                'date' => $validated['date'],
            ],
            [
                'status' => $validated['status'],
                'time_in' => $timeIn,
                'time_out' => $timeOut,
                'updated_at' => now(),
            ]
        );

        return redirect()->back()->with('success', 'Attendance assigned successfully!');
    }




    /**
     * Update the specified resource in storage.
     */
    // Save or update staff attendance
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'date' => 'required|date',
            'attendance.*.status' => 'required|in:Present,Absent',
            'attendance.*.time_in' => 'nullable|date_format:H:i',
            'attendance.*.time_out' => 'nullable|date_format:H:i',
        ]);

        $date = $validatedData['date'];

        foreach ($validatedData['attendance'] as $staffId => $attendanceData) {
            // Ensure time-in and time-out are only saved for Present status
            $timeIn = $attendanceData['status'] === 'Present' ? $attendanceData['time_in'] : null;
            $timeOut = $attendanceData['status'] === 'Present' ? $attendanceData['time_out'] : null;

            DB::table('staff_attendance')->updateOrInsert(
                [
                    'staff_id' => $staffId,
                    'date' => $date,
                ],
                [
                    'status' => $attendanceData['status'],
                    'time_in' => $timeIn,
                    'time_out' => $timeOut,
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Staff attendance updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StaffAttendanceModel $staffAttendanceModel)
    {
        //
    }
}
