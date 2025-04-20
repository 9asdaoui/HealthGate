<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\StoreloginRequest;
use App\Http\Requests\StoreRegisterRequest;
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

    public function login(StoreloginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            switch ($user->role->name) {
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


    public function register(StoreRegisterRequest $request)
    {
        $validated = $request->validated();

        $roleId = Role::where('name', 'patient')->first()->id;

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

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $validated = $request->validated();

            $user = Auth::user();

            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Current password is incorrect']);
            }

            $user->password = $validated['new_password'];
            /**
             * @var User $user
             */
            $user->update();
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
