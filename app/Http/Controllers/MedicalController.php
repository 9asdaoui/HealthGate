<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Http\Requests\StoreMedicalRequest;
use App\Http\Requests\UpdateMedicalRequest;

class MedicalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalRequest $request)
    {
        $validatedData = $request->validated();
        $medical = new Medical();
        $medical->patient_id = $validatedData['patient_id'];
        $medical->doctor_id = $validatedData['doctor_id'];
        $medical->name = $validatedData['name'];
        $medical->description = $validatedData['description'];
        $medical->dosage = $validatedData['dosage'];
        $medical->frequency = $validatedData['frequency'];
        $medical->start_date = $validatedData['start_date'];
        $medical->end_date = $validatedData['end_date'];
        $medical->save();

        if (isset($validatedData['appointment_id'])) {
            $appointment = \App\Models\Appointment::find($validatedData['appointment_id']);
            if ($appointment && $appointment->status === 'upcoming') {
                $appointment->status = 'completed';
                $appointment->save();
            }
        }

        
        return redirect()->route('doctor.patients.medical-records', ['patient' => $validatedData['patient_id']])
            ->with('success', 'Medical record created successfully, and appointment status updated.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Medical $medical)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Medical $medical)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRequest $request, Medical $medical)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medical $medical)
    {
        //
    }
}
