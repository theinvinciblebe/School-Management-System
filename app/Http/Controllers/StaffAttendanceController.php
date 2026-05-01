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
        $departments = DB::table('department')->get();

        return view('staff.staff_attendance', compact('departments'));
    }


    public function getAttendance(Request $request)
    {
        try {
            // Validate the input
            $request->validate([
                'date' => 'required|date',
                'department_id' => 'required',
            ]);

            // Fetch staff
            $staffQuery = DB::table('staff');
            if ($request->department_id !== 'all') {
                $staffQuery->where('department_id', $request->department_id);
            }
            $staff = $staffQuery->get();

            if ($staff->isEmpty()) {
                return response()->json(['staff' => []]);
            }

            // Fetch attendance records
            $attendanceRecords = DB::table('staff_attendance')
                ->where('date', $request->date)
                ->whereIn('staff_id', $staff->pluck('staff_id'))
                ->get()
                ->keyBy('staff_id');

            // Map staff with attendance data
            $staffAttendance = $staff->map(function ($staff) use ($attendanceRecords) {
                $attendance = $attendanceRecords->get($staff->staff_id);

                return [
                    'staff_id' => $staff->staff_id,
                    'name' => $staff->name,
                    'status' => $attendance->status ?? 'Undefined', // Defaults to 'Undefined'
                    'time_in' => $attendance->time_in ?? null,
                    'time_out' => $attendance->time_out ?? null,
                ];
            });

            return response()->json(['staff' => $staffAttendance], 200);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Error fetching attendance:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    public function saveAttendance(Request $request)
    {
        \Log::info('Submitted Attendance Data:', $request->all()); // Log submitted data

        // Validate the attendance data
        $validator = \Validator::make($request->all(), [
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:Present,Absent,Undefined',
            'attendance.*.time_in' => [
                'nullable',
                'date_format:H:i', // Validate 24-hour time format
                function ($attribute, $value, $fail) use ($request) {
                    $key = explode('.', $attribute)[1];
                    if ($request->attendance[$key]['status'] === 'Present' && !$value) {
                        $fail("The $attribute field is required when status is Present.");
                    }
                },
            ],
            'attendance.*.time_out' => [
                'nullable',
                'date_format:H:i', // Validate 24-hour time format
                function ($attribute, $value, $fail) use ($request) {
                    $key = explode('.', $attribute)[1];
                    if ($request->attendance[$key]['status'] === 'Present' && !$value) {
                        $fail("The $attribute field is required when status is Present.");
                    }
                    if ($request->attendance[$key]['status'] === 'Present' &&
                        isset($request->attendance[$key]['time_in']) &&
                        $value <= $request->attendance[$key]['time_in']
                    ) {
                        $fail("The $attribute field must be a time after time_in.");
                    }
                },
            ],
        ]);

        if ($validator->fails()) {
            \Log::error('Validation Errors:', $validator->errors()->toArray());
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $attendanceData = $request->attendance;

        foreach ($attendanceData as $staffId => $data) {
            // Skip saving if the status is "Undefined"
            if ($data['status'] === 'Undefined') {
                continue;
            }

            // Convert time to 24-hour format
            $data['time_in'] = convertTo24HourFormat($data['time_in'] ?? null);
            $data['time_out'] = convertTo24HourFormat($data['time_out'] ?? null);

            // Save or update attendance
            DB::table('staff_attendance')->updateOrInsert(
                [
                    'staff_id' => $staffId,
                    'date' => $request->date,
                ],
                [
                    'status' => $data['status'],
                    'time_in' => $data['status'] === 'Present' ? $data['time_in'] : null,
                    'time_out' => $data['status'] === 'Present' ? $data['time_out'] : null,
                    'updated_at' => now(),
                ]
            );
        }

        return redirect()->back()->with('success', 'Attendance saved successfully.');
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

    // View detailed attendance for a specific date

    public function view($date)
    {
        $attendance = DB::table('staff_attendance')
            ->join('staff', 'staff_attendance.staff_id', '=', 'staff.staff_id')
            ->where('staff_attendance.date', $date)
            ->select('staff.name', 'staff_attendance.*')
            ->orderBy('staff.name')
            ->get();

        return view('staff.staff_attendance_show', compact('attendance', 'date'));
    }
    public function attendancePDF($date)
    {
        $attendance = DB::table('staff_attendance')
            ->join('staff', 'staff_attendance.staff_id', '=', 'staff.staff_id')
            ->where('staff_attendance.date', $date)
            ->select('staff.name', 'staff_attendance.*')
            ->orderBy('staff.name')
            ->get();

        $pdf = PDF::loadView('staff.staff_attendance_pdf', compact('attendance', 'date'));

        return $pdf->stream('staff_attendance_' . $date . '.pdf');
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
