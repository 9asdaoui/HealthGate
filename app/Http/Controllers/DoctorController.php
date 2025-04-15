<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use GuzzleHttp\Psr7\Request;

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
        $user = User::with('doctor')->find(auth()->user()->id);
        return view('doctor.profile', compact('user'));
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
    public function createDoctor()
    {
        $user = auth()->user();
        return view('admin.users.create_doctor', compact('user'));
    }
    public function showDoctor(Doctor $doctor)
    {
        return view('admin.users.show_doctor');
    }

    public function viewPatientMedicalRecords(Patient $patient)
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        $patient = Patient::with('user')->findOrFail($patient->id);
        $medicalRecords = $patient->medicals()->latest()->paginate(10);
        $allDiseases = \App\Models\Disease::all();
        $diseases = $patient->diseases;

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
    public function updateProfile(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'gender' => 'required|in:male,female,other',
            'speciality' => 'required|string|max:255',
            'experience' => 'required|numeric|min:0',
            'image' => 'nullable',
        ]);
        
        if ($request->hasFile('image')) {
                
            $imagePath = $request->file('image')->store('profiles', 'public');
            $user->image = '/storage/' . $imagePath;
        }
        /**
         * @var App\Models\User $user
         */
        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];
        $user->save();
        
        // Update doctor information
        $user->doctor->speciality = $validated['speciality'];
        $user->doctor->experience = $validated['experience'];
        $user->doctor->save();
        
        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function generatePatientReport(Patient $patient)
    {
        $user = auth()->user();
        $doctor = $user->doctor;
        $patient = Patient::with('user')->findOrFail($patient->id);
        $medicalRecords = $patient->medicals()->latest()->paginate(10);
        $allDiseases = \App\Models\Disease::all();
        $diseases = $patient->diseases;

        return view('doctor.patient_report', compact(
            'patient',
            'medicalRecords',
            'diseases',
            'user',
            'doctor'
        ));
    }
    
}
