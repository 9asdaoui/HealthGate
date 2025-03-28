<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
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
    
    Route::get('/profile',[DoctorController::class,'profile'])->name('doctor.profile')->middleware('auth');
    Route::get('/patients', [DoctorController::class, 'patients'])->name('doctor.patients')->middleware('auth');
    Route::get('/medical-records', [DoctorController::class, 'medicalRecords'])->name('doctor.medical-records')->middleware('auth');
    Route::get('/prescriptions', [DoctorController::class, 'prescriptions'])->name('doctor.prescriptions')->middleware('auth');
    Route::get('/diseases', [DoctorController::class, 'diseases'])->name('doctor.diseases')->middleware('auth');
    Route::get('/health-metrics', [DoctorController::class, 'healthMetrics'])->name('doctor.health-metrics')->middleware('auth');
    Route::get('/schedule', [DoctorController::class, 'schedule'])->name('doctor.schedule')->middleware('auth');
    Route::get('/settings', [DoctorController::class, 'settings'])->name('doctor.settings')->middleware('auth');
}
);
