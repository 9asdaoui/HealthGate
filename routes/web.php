<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BloodPressureController;
use App\Http\Controllers\BloodSugarController;
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

Route::prefix('patient')->group(function(){
    Route::get('/dashboard',[PatientController::class,'dashboard'])->name('patient.dashboard')->middleware('auth');
    Route::get('/profile',[PatientController::class,'profile'])->name('patient.profile')->middleware('auth');
    Route::put('/profile',[PatientController::class,'updateProfile'])->name('patient.updateProfile')->middleware('auth');
    Route::get('/appointments',[AppointmentController::class,'patientAppointments'])->name('patient.appointments')->middleware('auth');
    Route::get('/appointments/create',[AppointmentController::class,'create'])->name('patient.appointments.create')->middleware('auth');
    Route::post('/appointments',[AppointmentController::class,'store'])->name('patient.appointments.store')->middleware('auth');
    Route::get('/appointments/show/{appointment}',[AppointmentController::class,'show'])->name('patient.appointments.show')->middleware('auth');
    Route::put('/appointments/cancel/{appointment}',[AppointmentController::class,'cancel'])->name('patient.appointments.cancel')->middleware('auth');
});

Route::prefix('doctor')->group(function(){
    Route::get('/dashboard',[DoctorController::class,'dashboard'])->name('doctor.dashboard')->middleware('auth');

    Route::get('/appointments', [AppointmentController::class, 'doctorAppointments'])->name('doctor.appointments')->middleware('auth');
    Route::post('/appointments/confirm/{appointment}', [AppointmentController::class, 'markAsUpcoming'])->name('doctor.appointments.confirm')->middleware('auth');
    Route::post('/appointments/complete/{appointment}', [AppointmentController::class, 'markAsCompleted'])->name('doctor.appointments.complete')->middleware('auth');
    Route::post('/appointments/reject/{appointment}', [AppointmentController::class, 'cancel'])->name('doctor.appointments.reject')->middleware('auth');
    Route::get('/appointments/view/{appointment}', [AppointmentController::class, 'viewAppointment'])->name('doctor.appointments.view')->middleware('auth');

    Route::get('/patients', [DoctorController::class, 'patients'])->name('doctor.patients')->middleware('auth');
    Route::get('/patients/medical-records/{patient}', [DoctorController::class, 'viewPatientMedicalRecords'])->name('doctor.patients.medical-records')->middleware('auth');
    Route::post('/medical/store', [MedicalController::class, 'store'])->name('doctor.medical.store')->middleware('auth');
    Route::get('/patients/medical-records/{patient}/edit/{medical}', [MedicalController::class, 'edit'])->name('doctor.patients.medical-records.edit')->middleware('auth');
    Route::put('/medical/{medical}', [MedicalController::class, 'update'])->name('doctor.medical.update')->middleware('auth');  
    Route::get('/patients/medical-records',[DoctorController::class,'editProfile'])->name('doctor.health-metrics')->middleware('auth');

    Route::post('/blood-sugar', [BloodSugarController::class, 'store'])->name('doctor.blood-sugar.store')->middleware('auth');
    Route::post('/blood-pressure', [BloodPressureController::class, 'store'])->name('doctor.blood-pressure.store')->middleware('auth');
    Route::post('/hearth-rate', [HearthRateController::class, 'store'])->name('doctor.hearth-rate.store')->middleware('auth');

  





    
    Route::get('/profile',[DoctorController::class,'profile'])->name('doctor.profile')->middleware('auth');
    Route::get('/diseases', [DoctorController::class, 'diseases'])->name('doctor.diseases')->middleware('auth');
    Route::post('/diseases', [DoctorController::class, 'diseases'])->name('doctor.diseases.assign')->middleware('auth');


    Route::get('/settings', [DoctorController::class, 'settings'])->name('doctor.settings')->middleware('auth');
}
);
