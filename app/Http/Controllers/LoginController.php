<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        $intended_url = $request->session()->get('url.intended');
        session()->put('intended_url', $intended_url);

        if (Auth::check()) {
            return redirect('/dashboard');
        } else {
            return view('login');
        }
    }

    public function do_login(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:100',
            'password' => 'required|max:100',
        ]);

        if ($validator->fails()) {
            return redirect('/login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 0: // Admin
                    return redirect()->route('dashboard');
                case 1: // Teacher
                    return redirect()->route('dashboard');
                case 2: // Student
                    return redirect()->route('dashboard');
                case 3: // Accountant
                    return redirect()->route('dashboard');
                case 4: // Receptionist
                    return redirect()->route('dashboard');
                default:
                    Auth::logout();
                    return redirect('/login')->with('status', 'Unauthorized role.');
            }
        }

        // ❗ Add this line for incorrect credentials
        return redirect('/login')->with('status', 'Incorrect email or password!')->withInput();
    }


    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
