<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 0) {
            abort(403); // or redirect
        }

        $logs = ActivityLog::with('user')->orderBy('timestamp', 'desc')->get();
        $log = \App\Models\ActivityLog::with('user')->first();
        $log->user; // Should return the associated user
        return view('activity_logs.index', compact('logs'));
    }
}
