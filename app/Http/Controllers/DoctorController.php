<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{

    public function dashboard()
    {
        return view('doctor.dashboard');
    }

    public function profile()
    {
        return view('doctor.profile');
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Doctor $doctor)
    {
        //
    }

    public function edit(Doctor $doctor)
    {
        //
    }

    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    public function destroy(Doctor $doctor)
    {
        //
    }
}
