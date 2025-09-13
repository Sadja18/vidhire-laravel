<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login'); // create resources/views/auth/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect based on role
            $role = Auth::user()->role;
            return match($role) {
                'admin' => redirect()->route('admin.dashboard'),
                'reviewer' => redirect()->route('reviewer.dashboard'),
                'candidate' => redirect()->route('candidate.dashboard'),
                default => redirect('/dashboard'),
            };
        }

        return back()->withErrors([
            'email' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function dashboard()
    {
        $role = Auth::user()->role;
        return match($role) {
            'admin' => redirect()->route('admin.dashboard'),
            'reviewer' => redirect()->route('reviewer.dashboard'),
            'candidate' => redirect()->route('candidate.dashboard'),
            default => redirect('/dashboard'),
        };
    }
}
