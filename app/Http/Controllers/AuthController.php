<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            
            switch($user->role->name){
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'doctor':
                    return redirect()->route('doctor.dashboard');
                case 'patient':
                    return redirect()->route('patient.dashboard');
                default:
                    return redirect()->route('login');
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
            'height' => 'required|numeric|nullable',
            'weight' => 'required|numeric|nullable',
            'date_of_birth' => 'required|date|nullable',
            'role_id' => 'integer|exists:roles,id',
        ]);

        $roleId = Role::where('name', 'patient')->first()->id;
        // dd($roleId);
        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'gender' => $validated['gender'],
            'role_id' => $roleId,
        ]);
        $user->patient()->create([
            'height' => $validated['height'],
            'weight' => $validated['weight'],
            'date_of_birth' => $validated['date_of_birth'],
        ]);

        Auth::login($user);

        return redirect()->route('patient.dashboard');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|min:8|confirmed',
                'new_password_confirmation' => 'required'
            ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = $request->new_password;
        $user->update;

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

        return back()->with('success', 'Password changed successfully');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }

}
