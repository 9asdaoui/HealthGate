<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Http\Requests\StoreMedicalRequest;
use App\Http\Requests\UpdateMedicalRequest;
use App\Models\Patient;

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

    public function edit(Patient $patient, Medical $medical)
    {
        // Check if the authenticated user is allowed to edit this record
        if (auth()->user()->doctor->id !== $medical->doctor_id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Return the medical record as JSON for the modal to populate
        return response()->json([
            'id' => $medical->id,
            'name' => $medical->name,
            'description' => $medical->description,
            'dosage' => $medical->dosage,
            'frequency' => $medical->frequency,
            'start_date' => $medical->start_date,
            'end_date' => $medical->end_date
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRequest $request, Medical $medical)
    {
        // Check if the authenticated user is allowed to edit this record
        if (auth()->user()->doctor->id !== $medical->doctor_id) {
            return redirect()->back()->with('error', 'You are not authorized to update this medical record.');
        }

        $validatedData = $request->validated();

        // Update the medical record with validated data
        $medical->name = $validatedData['name'];
        $medical->description = $validatedData['description'];
        $medical->dosage = $validatedData['dosage'];
        $medical->frequency = $validatedData['frequency'];
        $medical->start_date = $validatedData['start_date'];
        $medical->end_date = $validatedData['end_date'];
        $medical->save();
        // Return to the medical records page with a success message
        return redirect()->route('doctor.patients.medical-records', ['patient' => $medical->patient_id])
            ->with('success', 'Medical record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Medical $medical)
    {
        //
    }
}
