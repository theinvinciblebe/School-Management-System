<?php

namespace App\Http\Controllers;

use App\Models\DashboardModel;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers_count = DB::table('teacher')->count();
        $students_count = DB::table('student')->count();
        $parents_count = DB::table('parent')->count();
        $classes_count = DB::table('class')->count();


        $today = now()->toDateString(); // Gets current date in YYYY-MM-DD format
        $today_atd = DB::table('attendance')
            ->where('status', 1)
            ->whereDate('date', $today) // or whatever your date column is named
            ->count();

        $absent_atd = DB::table('attendance')
            ->where('status', 2)
            ->whereDate('date', $today) // or whatever your date column is named
            ->count();


        // Get unique years for the dropdown
        $years = DB::table('transactions')
            ->selectRaw('YEAR(date) as year')
            ->groupByRaw('YEAR(date)')
            ->orderByDesc('year')
            ->pluck('year');

        // Example: Monthly profit & expenses from a transactions table
        $data = DB::table('transactions')
            ->selectRaw('YEAR(date) as year, MONTH(date) as month_num')
            ->selectRaw('SUM(CASE WHEN type = "profit" THEN amount ELSE 0 END) as profit')
            ->selectRaw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            ->groupByRaw('YEAR(date), MONTH(date)')
            ->orderByRaw('YEAR(date), MONTH(date)')
            ->get();



        $labels = $data->map(function ($item) {
            $monthName = \Carbon\Carbon::create()->month($item->month_num)->format('M');
            return $monthName . ' ' . $item->year;
        });
        $profits = $data->pluck('profit');
        $expenses = $data->pluck('expense');

        $expenseBreakdown = DB::table('transactions')
            ->select('category', DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->groupBy('category')
            ->get();

        $expenseLabels = $expenseBreakdown->pluck('category');
        $expenseData = $expenseBreakdown->pluck('total');

        return view('dashboard.index', compact('years','expenseLabels','expenseData','labels','profits','expenses','teachers_count','students_count','parents_count','classes_count','today_atd','absent_atd'));
    }

    public function chartData(Request $request)
    {
        $year = $request->input('year', now()->year);

        $data = DB::table('transactions')
            ->selectRaw('YEAR(date) as year, MONTH(date) as month_num')
            ->selectRaw('SUM(CASE WHEN type = "profit" THEN amount ELSE 0 END) as profit')
            ->selectRaw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
            ->whereYear('date', $year)
            ->groupByRaw('YEAR(date), MONTH(date)')
            ->orderByRaw('YEAR(date), MONTH(date)')
            ->get();

        $labels = $data->map(function ($item) {
            return Carbon::create()->month($item->month_num)->format('M') . ' ' . $item->year;
        });

        $profits = $data->pluck('profit');
        $expenses = $data->pluck('expense');

        return response()->json([
            'labels' => $labels,
            'profits' => $profits,
            'expenses' => $expenses
        ]);
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
    public function show(DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DashboardModel $dashboardModel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DashboardModel $dashboardModel)
    {
        //
    }
}
