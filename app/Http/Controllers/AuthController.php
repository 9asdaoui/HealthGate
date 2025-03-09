<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'patient':
                    return redirect()->route('patient.dashboard');
                default:
                    return redirect()->route('doctor.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match.',
        ])->onlyInput('email');
    }


    public function register(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'gender' => 'required|in:male,female',
            'height' => 'required_if:role,patient|numeric|nullable',
            'weight' => 'required_if:role,patient|numeric|nullable',
            'date_of_birth' => 'required_if:role,patient|date|nullable',
            'role' => 'in:admin,doctor,patient',
        ]);

        $role = $validated['role'] ?? 'patient';

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'gender' => $validated['gender'],
            'role' => $role,
        ]);
        $user->patient()->create([
            'height' => $validated['height'],
            'weight' => $validated['weight'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }

}
