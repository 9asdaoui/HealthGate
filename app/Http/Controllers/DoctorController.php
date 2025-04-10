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



        // Prepare chart data
        $bloodPressureChartData = $patient->bloodPressures()->orderBy('measured_at')->get()->map(function ($item) {
            return [
                'date' => \Carbon\Carbon::parse($item->measured_at)->format('Y-m-d'),
                'systolic' => $item->systolic,
                'diastolic' => $item->diastolic
            ];
        });

        // Prepare blood sugar chart data
        $bloodSugarChartData = $patient->bloodSugars()->orderBy('measured_at')->get()->map(function ($item) {
            return [
                'date' => \Carbon\Carbon::parse($item->measured_at)->format('Y-m-d'),
                'value' => $item->value
            ];
        });

        // Prepare heart rate chart data
        $heartRateChartData = $patient->hearthRates()->orderBy('measured_at')->get()->map(function ($item) {
            return [
                'date' => \Carbon\Carbon::parse($item->measured_at)->format('Y-m-d'),
                'value' => $item->value
            ];
        });
        // Get latest readings for health metrics
        $latestBloodPressure = $patient->bloodPressures()->latest('measured_at')->first();
        $latestBloodSugar = $patient->bloodSugars()->latest('measured_at')->first();
        $latestHeartRate = $patient->hearthRates()->latest('measured_at')->first();
        
        // Get all health metrics for the table display
        $bloodPressures = $patient->bloodPressures()->latest('measured_at')->get();
        $bloodSugars = $patient->bloodSugars()->latest('measured_at')->get();
        $hearthRates = $patient->hearthRates()->latest('measured_at')->get();
        
        // Format the health metrics data for the table
        $healthMetrics = collect();
        
        foreach ($bloodPressures as $bp) {
            $healthMetrics->push([
            'id' => $bp->id,
            'type' => 'Blood Pressure',
            'value' => $bp->systolic . '/' . $bp->diastolic . ' mmHg',
            'date' => $bp->measured_at,
            'recorded_by' => $bp->doctor ? $bp->doctor->user->first_name . ' ' . $bp->doctor->user->last_name : 'Self-recorded'
            ]);
        }
        
        foreach ($bloodSugars as $bs) {
            $healthMetrics->push([
            'id' => $bs->id,
            'type' => 'Blood Sugar',
            'value' => $bs->value . ' ' . $bs->unit,
            'date' => $bs->measured_at,
            'recorded_by' => $bs->doctor ? $bs->doctor->user->first_name . ' ' . $bs->doctor->user->last_name : 'Self-recorded'
            ]);
        }
        
        foreach ($hearthRates as $hr) {
            $healthMetrics->push([
            'id' => $hr->id,
            'type' => 'Heart Rate',
            'value' => $hr->value . ' bpm',
            'date' => $hr->measured_at,
            'recorded_by' => $hr->doctor ? $hr->doctor->user->first_name . ' ' . $hr->doctor->user->last_name : 'Self-recorded'
            ]);
        }
        
        // Sort all metrics by date, newest first
        $healthMetrics = $healthMetrics->sortByDesc('date')->values();


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
            'bloodSugarChartData',
            'heartRateChartData',
            'user'
        ));
    }
}
