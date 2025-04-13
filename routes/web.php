<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloodPressureController;
use App\Http\Controllers\BloodSugarController;
use App\Http\Controllers\DiseaseController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HearthRateController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\PatientController;
use App\Models\Medical;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {return view('visitor.index');});


Route::prefix('auth')->group(function(){
    Route::post('/login',[AuthController::class,'login'])->name('login');
    Route::post('/register',[AuthController::class,'register'])->name('register');
    Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
    Route::get('/register',[AuthController::class,'showRegistrationForm'])->name('register');
    Route::get('/logout',[AuthController::class,'logout'])->name('logout')->middleware('auth');
    Route::post('/change-password',[AuthController::class,'changePassword'])->name('change-password')->middleware('auth');
}
);

Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard')->middleware('auth');
    Route::get('/doctors',[AdminController::class,'doctors'])->name('admin.doctors')->middleware('auth');
    Route::get('/patients',[AdminController::class,'patients'])->name('admin.patients')->middleware('auth');
    Route::get('/appointments',[AdminController::class,'appointments'])->name('admin.appointments')->middleware('auth');
}
);

Route::prefix('patient')->middleware('auth')->group(function(){
    // Dashboard
    Route::get('/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');
    
    // Profile Management
    Route::get('/profile', [PatientController::class, 'profile'])->name('patient.profile');
    Route::put('/profile', [PatientController::class, 'updateProfile'])->name('patient.updateProfile');
    
    // Appointments Management
    Route::get('/appointments', [AppointmentController::class, 'patientAppointments'])->name('patient.appointments');
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('patient.appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('patient.appointments.store');
    Route::get('/appointments/show/{appointment}', [AppointmentController::class, 'show'])->name('patient.appointments.show');
    Route::put('/appointments/cancel/{appointment}', [AppointmentController::class, 'cancel'])->name('patient.appointments.cancel');
    
    // Add route for viewing prescriptions based on what I saw in the blade file
    Route::get('/prescription', [MedicalController::class, 'showPrescription'])->name('patient.prescription');

    Route::get('/medication/{medical}', [PatientController::class, 'getmedications'])->name('patient.medications');
    Route::get('/disease/{disease}', [PatientController::class, 'gitDisease'])->name('patient.disease');

    // Health Metrics
    Route::get('/patient/healthMetrics', [PatientController::class, 'healthMetrics'])->name('patient.healthMetrics');
});

Route::prefix('doctor')->middleware('auth')->group(function(){
    // Dashboard
    Route::get('/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    
    // Profile Management
    Route::get('/profile', [DoctorController::class, 'profile'])->name('doctor.profile');
    Route::put('/profile', [DoctorController::class, 'updateProfile'])->name('doctor.updateProfile');
    
    // Appointments Management
    Route::get('/appointments', [AppointmentController::class, 'doctorAppointments'])->name('doctor.appointments');
    Route::get('/appointments/view/{appointment}', [AppointmentController::class, 'viewAppointment'])->name('doctor.appointments.view');
    Route::post('/appointments/confirm/{appointment}', [AppointmentController::class, 'markAsUpcoming'])->name('doctor.appointments.confirm');
    Route::post('/appointments/complete/{appointment}', [AppointmentController::class, 'markAsCompleted'])->name('doctor.appointments.complete');
    Route::post('/appointments/reject/{appointment}', [AppointmentController::class, 'cancel'])->name('doctor.appointments.reject');
    
    // Patients Management
    Route::get('/patients', [DoctorController::class, 'patients'])->name('doctor.patients');
    Route::get('/patients/medical-records/{patient}', [DoctorController::class, 'viewPatientMedicalRecords'])->name('doctor.patients.medical-records');
    Route::get('/patients/medical-records/{patient}/edit/{medical}', [MedicalController::class, 'edit'])->name('doctor.patients.medical-records.edit');
    Route::get('/patients/medical-records', [DoctorController::class, 'editProfile'])->name('doctor.health-metrics');
    
    // Medical Records
    Route::post('/medical/store', [MedicalController::class, 'store'])->name('doctor.medical.store');
    Route::put('/medical/{medical}', [MedicalController::class, 'update'])->name('doctor.medical.update');
    
    // Health Metrics
    Route::post('/blood-sugar', [BloodSugarController::class, 'store'])->name('doctor.blood-sugar.store');
    Route::post('/blood-pressure', [BloodPressureController::class, 'store'])->name('doctor.blood-pressure.store');
    Route::post('/hearth-rate', [HearthRateController::class, 'store'])->name('doctor.hearth-rate.store');
    
    // Diseases Library
    Route::get('/diseases', [DiseaseController::class, 'index'])->name('doctor.diseases');
    Route::get('/diseases/{disease}', [DiseaseController::class, 'getDisease'])->name('doctor.disease.show');
    Route::post('/diseases', [DiseaseController::class, 'diseasesAssign'])->name('doctor.diseases.assign');

});
