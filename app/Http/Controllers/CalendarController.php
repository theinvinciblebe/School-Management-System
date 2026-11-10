<?php

namespace App\Http\Controllers;

use App\Models\CalendarEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CalendarController extends Controller
{
    /**
     * Display the Modern Calendar Dashboard.
     */
    public function index(Request $request)
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Count of events for the current month
        $monthEventsCount = CalendarEvent::where(function ($query) use ($startOfMonth, $endOfMonth) {
            $query->whereBetween('start_date', [$startOfMonth, $endOfMonth])
                  ->orWhereBetween('end_date', [$startOfMonth, $endOfMonth]);
        })->count();

        // Upcoming Exams
        $upcomingExamsCount = 0;
        try {
            $upcomingExamsCount = DB::table('exam')
                ->where('date', '>=', $now->toDateString())
                ->count();
        } catch (\Throwable $e) {}

        // Total Holidays in System
        $holidaysCount = CalendarEvent::where('category', 'holiday')->count();

        // Total Events for the year
        $totalEventsCount = CalendarEvent::count() + $upcomingExamsCount;

        return view('calendar', compact(
            'monthEventsCount',
            'upcomingExamsCount',
            'holidaysCount',
            'totalEventsCount'
        ));
    }

    /**
     * Return JSON events for FullCalendar (merges custom events, exams, and academic sessions).
     */
    public function events(Request $request)
    {
        $start = $request->query('start');
        $end = $request->query('end');

        $query = CalendarEvent::query();

        if ($start && $end) {
            $query->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_date', [Carbon::parse($start), Carbon::parse($end)])
                  ->orWhereBetween('end_date', [Carbon::parse($start), Carbon::parse($end)])
                  ->orWhere(function ($sub) use ($start, $end) {
                      $sub->where('start_date', '<=', Carbon::parse($start))
                          ->where('end_date', '>=', Carbon::parse($end));
                  });
            });
        }

        $calendarEvents = $query->get();

        $formattedEvents = [];

        // 1. Process custom calendar events
        foreach ($calendarEvents as $event) {
            $isAllDay = (bool) $event->all_day;
            $startStr = $isAllDay ? $event->start_date->format('Y-m-d') : $event->start_date->toIso8601String();
            
            $endStr = null;
            if ($event->end_date) {
                if ($isAllDay) {
                    // FullCalendar allDay end date is exclusive, so add 1 day for proper multi-day span
                    $endStr = $event->end_date->copy()->addDay()->format('Y-m-d');
                } else {
                    $endStr = $event->end_date->toIso8601String();
                }
            }

            $formattedEvents[] = [
                'id'              => (string) $event->id,
                'title'           => $event->title,
                'start'           => $startStr,
                'end'             => $endStr,
                'allDay'          => $isAllDay,
                'backgroundColor' => $event->bg_color ?: '#3b82f6',
                'borderColor'     => $event->border_color ?: ($event->bg_color ?: '#2563eb'),
                'textColor'       => $event->text_color ?: '#ffffff',
                'extendedProps'   => [
                    'id'          => $event->id,
                    'category'    => $event->category ?: 'activity',
                    'description' => $event->description ?: '',
                    'is_system'   => false,
                    'can_edit'    => true,
                    'raw_start'   => $event->start_date->format('Y-m-d' . ($isAllDay ? '' : ' H:i')),
                    'raw_end'     => $event->end_date ? $event->end_date->format('Y-m-d' . ($isAllDay ? '' : ' H:i')) : '',
                ],
            ];
        }

        // 2. Process system exams from 'exam' table
        try {
            $exams = DB::table('exam')->get();
            foreach ($exams as $exam) {
                if (!empty($exam->date)) {
                    $formattedEvents[] = [
                        'id'              => 'exam_' . $exam->exam_id,
                        'title'           => __('Exam') . ': ' . $exam->name,
                        'start'           => Carbon::parse($exam->date)->format('Y-m-d'),
                        'allDay'          => true,
                        'backgroundColor' => '#ef4444',
                        'borderColor'     => '#dc2626',
                        'textColor'       => '#ffffff',
                        'extendedProps'   => [
                            'id'          => 'exam_' . $exam->exam_id,
                            'category'    => 'exam',
                            'description' => $exam->comment ?: __('Official School Examination'),
                            'is_system'   => true,
                            'can_edit'    => false,
                            'raw_start'   => Carbon::parse($exam->date)->format('Y-m-d'),
                            'raw_end'     => '',
                        ],
                    ];
                }
            }
        } catch (\Throwable $e) {}

        // 3. Process academic sessions from 'section' table if start_date and end_date exist
        try {
            $sections = DB::table('section')
                ->whereNotNull('start_date')
                ->whereNotNull('end_date')
                ->get();

            foreach ($sections as $section) {
                $formattedEvents[] = [
                    'id'              => 'sec_' . $section->section_id,
                    'title'           => __('Section Term') . ': ' . $section->name,
                    'start'           => Carbon::parse($section->start_date)->format('Y-m-d'),
                    'end'             => Carbon::parse($section->end_date)->addDay()->format('Y-m-d'),
                    'allDay'          => true,
                    'backgroundColor' => '#6366f1',
                    'borderColor'     => '#4f46e5',
                    'textColor'       => '#ffffff',
                    'extendedProps'   => [
                        'id'          => 'sec_' . $section->section_id,
                        'category'    => 'academic',
                        'description' => __('Academic Section Duration') . ': ' . $section->name,
                        'is_system'   => true,
                        'can_edit'    => false,
                        'raw_start'   => Carbon::parse($section->start_date)->format('Y-m-d'),
                        'raw_end'     => Carbon::parse($section->end_date)->format('Y-m-d'),
                    ],
                ];
            }
        } catch (\Throwable $e) {}

        return response()->json($formattedEvents);
    }

    /**
     * Store a newly created calendar event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'       => 'required|string|max:255',
            'category'    => 'nullable|string|max:50',
            'start_date'  => 'required|string',
            'end_date'    => 'nullable|string',
            'all_day'     => 'nullable',
            'bg_color'    => 'nullable|string|max:30',
            'description' => 'nullable|string|max:1000',
        ]);

        $isAllDay = filter_var($request->input('all_day', true), FILTER_VALIDATE_BOOLEAN);

        $startDate = Carbon::parse($validated['start_date']);
        $endDate = !empty($validated['end_date']) ? Carbon::parse($validated['end_date']) : null;

        // If end date is earlier than start date, normalize it
        if ($endDate && $endDate->lt($startDate)) {
            $endDate = $startDate->copy();
        }

        $bgColor = $validated['bg_color'] ?: '#3b82f6';

        $event = CalendarEvent::create([
            'user_id'      => Auth::id(),
            'title'        => $validated['title'],
            'description'  => $validated['description'] ?? null,
            'category'     => $validated['category'] ?: 'activity',
            'start_date'   => $startDate,
            'end_date'     => $endDate,
            'all_day'      => $isAllDay,
            'bg_color'     => $bgColor,
            'border_color' => $bgColor,
            'text_color'   => '#ffffff',
        ]);

        return response()->json([
            'success' => true,
            'message' => __('Event created successfully.'),
            'event'   => [
                'id'              => (string) $event->id,
                'title'           => $event->title,
                'start'           => $isAllDay ? $event->start_date->format('Y-m-d') : $event->start_date->toIso8601String(),
                'end'             => $event->end_date ? ($isAllDay ? $event->end_date->copy()->addDay()->format('Y-m-d') : $event->end_date->toIso8601String()) : null,
                'allDay'          => $isAllDay,
                'backgroundColor' => $event->bg_color,
                'borderColor'     => $event->border_color,
                'textColor'       => '#ffffff',
                'extendedProps'   => [
                    'id'          => $event->id,
                    'category'    => $event->category,
                    'description' => $event->description,
                    'is_system'   => false,
                    'can_edit'    => true,
                ],
            ],
        ]);
    }

    /**
     * Update an existing calendar event (e.g., date drag, drop, or edit modal).
     */
    public function update(Request $request, $id)
    {
        $event = CalendarEvent::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => __('Event not found or cannot be edited.'),
            ], 404);
        }

        $validated = $request->validate([
            'title'       => 'sometimes|required|string|max:255',
            'category'    => 'nullable|string|max:50',
            'start_date'  => 'sometimes|required|string',
            'end_date'    => 'nullable|string',
            'all_day'     => 'nullable',
            'bg_color'    => 'nullable|string|max:30',
            'description' => 'nullable|string|max:1000',
        ]);

        if (isset($validated['title'])) {
            $event->title = $validated['title'];
        }

        if (isset($validated['category'])) {
            $event->category = $validated['category'];
        }

        if (isset($validated['description'])) {
            $event->description = $validated['description'];
        }

        if (isset($validated['bg_color'])) {
            $event->bg_color = $validated['bg_color'];
            $event->border_color = $validated['bg_color'];
        }

        if ($request->has('all_day')) {
            $event->all_day = filter_var($request->input('all_day'), FILTER_VALIDATE_BOOLEAN);
        }

        if (!empty($validated['start_date'])) {
            $event->start_date = Carbon::parse($validated['start_date']);
        }

        if ($request->has('end_date')) {
            $event->end_date = !empty($validated['end_date']) ? Carbon::parse($validated['end_date']) : null;
        }

        $event->save();

        return response()->json([
            'success' => true,
            'message' => __('Event updated successfully.'),
            'event'   => $event,
        ]);
    }

    /**
     * Delete a calendar event.
     */
    public function destroy($id)
    {
        $event = CalendarEvent::find($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => __('Event not found.'),
            ], 404);
        }

        $event->delete();

        return response()->json([
            'success' => true,
            'message' => __('Event deleted successfully.'),
        ]);
    }
}

