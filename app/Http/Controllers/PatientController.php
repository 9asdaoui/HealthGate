<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function dashboard()
    { 
        $user = User::find(auth()->id());
        return view('patient.dashboard', compact('user'));
    }

    public function profile()
    {
        $user = User::find(auth()->id());
        $patient = $user->patient;
        return view('patient.profile', compact('user', 'patient'));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'gender' => 'required|string|in:male,female',
            'date_of_birth' => 'required|date',
            'image' => 'nullable|max:2048',
        ]);
        
        /**
         * @var App\Models\User $user
         */
        $user = auth()->user();
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];
        
        if ($request->hasFile('image')) {
                
                $imagePath = $request->file('image')->store('profiles', 'public');
                $user->image = '/storage/' . $imagePath;
            }
            
        $patient = $user->patient;
        $patient->date_of_birth = $validated['date_of_birth'];
        $patient->save();
        $user->save();
        
        return redirect()->route('patient.profile')->with('success', 'Profile updated successfully');
    }

}
