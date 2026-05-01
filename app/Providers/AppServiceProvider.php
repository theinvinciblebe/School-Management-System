<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

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

        $classes = DB::table('class')->get(); // Fetch classes
        view()->share('classes', $classes); // Share to all views


        $defaultClassId = $classes->first()->class_id ?? null; // Get the first class or null
        view()->share('defaultClassId', $defaultClassId);

        $users = DB::table('users')->get();
        view()->share('username', $users); // Share to all views

        $customizes = DB::table('customize')->first(); // Fetch single row
        view()->share('customizes', $customizes); // Share to all views

    }

}
