<?php

use App\Http\Controllers\AdminController;
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
    Route::get('/logout',[AuthController::class,'logout'])->name('logout');
    Route::post('/change-password',[AuthController::class,'changePassword'])->name('change-password');
}
);

Route::prefix('patient')->group(function(){
    Route::get('/dashboard',[PatientController::class,'dashboard'])->name('patient.dashboard');
    Route::get('/profile',[PatientController::class,'profile'])->name('patient.profile');
    Route::put('/profile',[PatientController::class,'updateProfile'])->name('patient.updateProfile');
}
);

Route::prefix('admin')->group(function(){
    Route::get('/dashboard',[AdminController::class,'dashboard'])->name('admin.dashboard');
}
);

Route::prefix('doctor')->group(function(){
    Route::get('/dashboard',[DoctorController::class,'dashboard'])->name('doctor.dashboard');
    Route::get('/profile',[DoctorController::class,'profile'])->name('doctor.profile');
}
);
