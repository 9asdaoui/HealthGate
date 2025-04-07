<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function dashboard()
    {
        $user = User::find(auth()->user()->id);

        return view('doctor.dashboard', compact('user'));
    }

    public function profile()
    {
        return view('doctor.profile');
    }

    public function patients()
    {

        $user = auth()->user();
        $doctor = $user->doctor;
        
            $patientIds = \App\Models\Appointment::where('doctor_id', $doctor->id)
            ->pluck('patient_id')
            ->unique();
            
            $patients = User::whereIn('id', $patientIds)
            ->get();
        return view('doctor.patients', compact('patients', 'user'));
    }

    public function viewPatientMedicalRecords(Patient $patient)
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        // Get the patient with related user data
        $patient = Patient::with('user')->findOrFail($patient->id);

        // Get the patient's medical records with pagination
        $medicalRecords = $patient->medicals()->latest()->paginate(10);

        // Get the patient's diseases
        $diseases = $patient->diseases;

        // Get appointments for this patient
        $appointments = \App\Models\Appointment::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest()
            ->paginate(5);


        $healthMetrics = collect(); // Empty collection as fallback

        // Get latest readings for health metrics
        $latestBloodPressure = $patient->bloodPressures()->latest('measured_at')->first();
        $latestBloodSugar = $patient->bloodSugars()->latest('measured_at')->first();
        $latestHeartRate = $patient->hearthRates()->latest('measured_at')->first();

        // Prepare chart data
        $bloodPressureChartData = $patient->bloodPressures()->orderBy('measured_at')->get()->map(function($item) {
            return [
                'date' => $item->measured_at->format('Y-m-d'),
                'systolic' => $item->systolic,
                'diastolic' => $item->diastolic
            ];
        });

        return view('doctor.patient_recordes', compact(
            'patient',
            'medicalRecords',
            'diseases',
            'appointments',
            'healthMetrics',
            'latestBloodPressure',
            'latestBloodSugar',
            'latestHeartRate',
            'bloodPressureChartData',
            'user'
        ));
        
    }

}
