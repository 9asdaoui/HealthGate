<?php

namespace App\Http\Controllers;

use App\Http\Requests\updateProfilePatientRequest;
use App\Models\Appointment;
use App\Models\Disease;
use App\Models\Medical;
use App\Models\Patient;
use App\Models\User;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Exception;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    protected $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function dashboard()
    { 
        
        $user = User::find(auth()->id());
        $patient = $user->patient;

        $appointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $latestBloodPressure = $this->patientRepository->getlatestBloodPressure($patient);
        $latestBloodSugar = $this->patientRepository->getlatestBloodSugar($patient);
        $latestHeartRate = $this->patientRepository->getlatestHeartRate($patient);
        $healthMetrics = $this->patientRepository->getHealthMetrics($patient);
        $latestAppointments = Appointment::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $latestPrescriptions = Medical::where('patient_id', $patient->id)
            ->with(['doctor.user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        $latestDiseases = $patient->diseases()
            ->with(['doctors.user'])
            ->orderBy('patient_doctor_disease.created_at', 'desc')
            ->take(5)
            ->get();
        return view('patient.dashboard', compact('user', 'patient', 'appointments', 'latestBloodPressure', 'latestBloodSugar', 'latestHeartRate', 'healthMetrics', 'latestAppointments', 'latestPrescriptions', 'latestDiseases'));
    }

    public function profile()
    {
        $user = User::find(auth()->id());
        $patient = $user->patient;
        return view('patient.profile', compact('user', 'patient'));
    }

    public function updateProfile(updateProfilePatientRequest $request)
    {
        $validated = $request->validated();
        
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

    public function getmedications(Medical $medical)
    {
     
        return response()->json([
            'medical' => $medical,
        ]);
    }

    public function gitDisease(Disease $disease)
    {
        return response()->json([
            'disease' => $disease,
        ]);
    }

    public function  healthMetrics()
    {
        $patient = auth()->user()->patient;
        $user = auth()->user(); 

        $healthMetrics = $this->patientRepository->getHealthMetrics($patient);
        $latestBloodPressure = $this->patientRepository->getlatestBloodPressure($patient);
        $latestBloodSugar = $this->patientRepository->getlatestBloodSugar($patient);
        $latestHeartRate = $this->patientRepository->getlatestHeartRate($patient);
        $bloodPressureChartData = $this->patientRepository->getbloodPressureChartData($patient);
        $bloodSugarChartData = $this->patientRepository->getbloodSugarChartData($patient);
        $heartRateChartData = $this->patientRepository->getheartRateChartData($patient);


        return view('patient.health-metrics', compact(
            'user',
            'patient',
            'healthMetrics',
            'latestBloodPressure',
            'latestBloodSugar',
            'latestHeartRate',
            'bloodPressureChartData',
            'bloodSugarChartData',
            'heartRateChartData'
        ));
    }

    public function showPatient(Patient $patient)
    {
        $userData = $patient->user;
        $patientData = [
            'id' => $userData->id,
            'height' => $patient->height,
            'weight' => $patient->weight,
            'date_of_birth' => $patient->date_of_birth,
            'first_name' => $userData->first_name,
            'last_name' => $userData->last_name,
            'email' => $userData->email,
            'gender' => $userData->gender,
            'image' => $userData->image,
            
        ];
        
        return response()->json($patientData);
    }
}
