<?php

namespace App\Http\Controllers;

use App\Models\Medical;
use App\Http\Requests\StoreMedicalRequest;
use App\Http\Requests\UpdateMedicalRequest;
use App\Models\Patient;
use Illuminate\Support\Facades\Gate;

class MedicalController extends Controller
{
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
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalRequest $request, Medical $medical)
    {

        if (!Gate::allows('medical_record_update', $medical)) {
            return redirect()->back()->with('error', 'You are not authorized to update this medical record.');
        }

        $validatedData = $request->validated();

        $medical->name = $validatedData['name'];
        $medical->description = $validatedData['description'];
        $medical->dosage = $validatedData['dosage'];
        $medical->frequency = $validatedData['frequency'];
        $medical->start_date = $validatedData['start_date'];
        $medical->end_date = $validatedData['end_date'];
        $medical->save();

        return redirect()->route('doctor.patients.medical-records', ['patient' => $medical->patient_id])
            ->with('success', 'Medical record updated successfully.');
    }

    public function showPrescription()
    {
        $user = auth()->user();
        $patient = Patient::where('user_id', $user->id)->firstOrFail();
        
        $medicals = Medical::where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest()
            ->get();
            // dd($medicals);
        $diseases = $patient->diseases()
            ->with('doctors.user')
            ->get();
            
        return view('patient.prescription', compact('user', 'medicals', 'diseases'));
    }
}
