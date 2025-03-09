<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function dashboard()
    {
        $user = auth()->user();
        
        $patient = $user->patient;
        $upcomingAppointments = Appointment::where('patient_id', $patient->id)
                                    ->where('appointment_date', '>=', now())
                                    ->orderBy('appointment_date', 'asc')
                                    ->take(5)
                                    ->get();
        
        return view('patient.dashboard', compact('patient', 'upcomingAppointments'));
    }
    public function profile()
    {
        return view('patient.profile');
    }

}
