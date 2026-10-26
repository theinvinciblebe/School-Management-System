<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        if (app()->environment('production') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
        if (DB::getDriverName() === 'sqlite') {
            try {
                $pdo = DB::connection()->getPdo();
                if ($pdo instanceof \PDO) {
                    $pdo->sqliteCreateFunction('YEAR', function ($date) {
                        return $date ? (int) date('Y', strtotime($date)) : null;
                    });
                    $pdo->sqliteCreateFunction('MONTH', function ($date) {
                        return $date ? (int) date('m', strtotime($date)) : null;
                    });
                    $pdo->sqliteCreateFunction('DAY', function ($date) {
                        return $date ? (int) date('d', strtotime($date)) : null;
                    });
                }
            } catch (\Throwable $e) {
                // Ignore if DB connection not established yet
            }
        }
        //this for subject sidebar (select only class that contain subject)
//        $classes = DB::table('class')
//            ->join('subject', 'class.class_id', '=', 'subject.class_id')
//            ->select('class.class_id', 'class.name')
//            ->distinct()
//            ->get();
//        view()->share('classes', $classes); // Share to all views

        View::composer('layout.main', function ($view) {
            $user = Auth::user();
            $classes = [];

            if ($user) {
                if ($user->role == 1) {
                    // Teacher
                    $classes = DB::table('class')
                        ->join('teacher', 'class.teacher_id', '=', 'teacher.teacher_id')
                        ->where('teacher.user_id', $user->id)
                        ->select('class.class_id', 'class.name')
                        ->get();
                } elseif ($user->role == 2) {
                    // Student
                    $classes = DB::table('class')
                        ->join('student_classes', 'class.class_id', '=', 'student_classes.class_id')
                        ->join('student', 'student_classes.student_id', '=', 'student.student_id')
                        ->where('student.user_id', $user->id)
                        ->select('class.class_id', 'class.name')
                        ->distinct()
                        ->get();
                } else {
                    // Other authenticated users
                    $classes = DB::table('class')
                        ->select('class_id', 'name')
                        ->get();
                }
            }

            $view->with('classes', $classes);
        });

        if (!app()->runningInConsole()) {
            try {
                $classes = DB::table('class')->get(); // Fetch classes
                view()->share('classes', $classes); // Share to all views

                $defaultClassId = $classes->first()->class_id ?? null; // Get the first class or null
                view()->share('defaultClassId', $defaultClassId);

                $users = DB::table('users')->get();
                view()->share('username', $users); // Share to all views

                $customizes = DB::table('customize')->first(); // Fetch single row
                view()->share('customizes', $customizes); // Share to all views
            } catch (\Throwable $e) {
                // Database or tables might not exist yet during setup
            }
        }
    }

}
