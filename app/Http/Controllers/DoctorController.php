<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use App\Repositories\Interfaces\PatientRepositoryInterface;

class DoctorController extends Controller
{

    protected $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }


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
        $patient = Patient::with('user')->findOrFail($patient->id);
        $medicalRecords = $patient->medicals()->latest()->paginate(10);
        $allDiseases = \App\Models\Disease::all();
        $diseases = $patient->diseases;

        // if ($diseases->count() > 0) {
            
        //     $firstDisease = $diseases->load('doctors')->first();
        //     $firstDisease = $firstDisease->doctors->load('user')->first();
        //     $firstDisease = $firstDisease->user;
        //     dd($firstDisease);
        // }
        $appointments = \App\Models\Appointment::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest()
            ->paginate(5);

         $healthMetrics = $this->patientRepository->getHealthMetrics($patient);
         $latestBloodPressure = $this->patientRepository->getlatestBloodPressure($patient);
         $latestBloodSugar = $this->patientRepository->getlatestBloodSugar($patient);
         $latestHeartRate = $this->patientRepository->getlatestHeartRate($patient);
         $bloodPressureChartData = $this->patientRepository->getbloodPressureChartData($patient);
         $bloodSugarChartData = $this->patientRepository->getbloodSugarChartData($patient);
         $heartRateChartData = $this->patientRepository->getheartRateChartData($patient);


        return view('doctor.patient_recordes', compact(
            'patient',
            'allDiseases',
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
