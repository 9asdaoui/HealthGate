<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{

    public function dashboard()
    {
        return view('patient.dashboard');
    }

    public function profile()
    {
        return view('patient.profile');
    }

}
