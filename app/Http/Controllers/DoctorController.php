<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDoctorRequest;
use App\Mail\DoctorCredentials;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;

class DoctorController extends Controller
{

    protected $patientRepository;

    public function __construct(PatientRepositoryInterface $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function createDoctor()
    {
        $user = auth()->user();
        $departments = Department::all();
        return view('admin.users.create_doctor', compact('user', 'departments'));
    }

    public function storeDoctor(StoreDoctorRequest $request)
    {
        $userData = $request->validated();
        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('profiles', 'public');
                $userData['image'] = '/storage/' . $imagePath;
            }

            $doctorRoleId = Role::where('name', 'doctor')->first()->id;
            $userData['role_id'] = $doctorRoleId;

            $user = User::create($userData);
            $doctor = Doctor::create([
                'user_id' => $user->id,
                'speciality' => $userData['speciality'],
                'experience' => $userData['experience'],
                'department_id' => $userData['department_id'],
            ]);

            if (isset($userData['send_credentials']) && $userData['send_credentials']) {
                $credentials = [
                    'email' => $user->email,
                    'password' => $userData['password'],
                ];
                Mail::to($user->email)->send(new DoctorCredentials($credentials));
               
            }

            return redirect()->route('admin.users.showDoctor', $user->id )->with('success', 'Doctor created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('Failed to create doctor: ' . $e->getMessage());
        }
    }


    public function showDoctor(User $user)
    {
        $doctor = $user->doctor;
        $doctor->load('user');
        $doctor->load('appointments');
        
        $doctor->load('patients');
        $doctor->load('diseases');

        $user = auth()->user();
        return view('admin.users.show_doctor', compact('doctor', 'user'));
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
        if (! Gate::allows('update-profile', auth()->user())) {
            abort(403, 'You are not authorized to update this profile.');
        }

        $user = auth()->user();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
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

    public function updateDoctor(Doctor $doctor, \Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $doctor->user->id,
            'gender' => 'required|in:male,female,other',
            'speciality' => 'required|string|max:255',
            'experience' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $user = $doctor->user;

        $user->first_name = $validated['first_name'];
        $user->last_name = $validated['last_name'];
        $user->email = $validated['email'];
        $user->gender = $validated['gender'];

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profiles', 'public');
            $user->image = '/storage/' . $imagePath;
        }

        $user->save();

        $doctor->speciality = $validated['speciality'];
        $doctor->experience = $validated['experience'];
        $doctor->save();

        return redirect()->back()->with('success', 'Doctor profile updated successfully');
    }

    public function updateDepartment(Doctor $doctor, \Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
        ]);

        $doctor->department_id = $validated['department_id'];
        $doctor->save();

        return redirect()->back()->with('success', 'Doctor department updated successfully');
    }

    public function destroy(Doctor $doctor)
    {
        $user = $doctor->user;

        $doctor->delete();

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Doctor deleted successfully');
    }
}
