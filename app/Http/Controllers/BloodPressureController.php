<?php

namespace App\Http\Controllers;

use App\Models\BloodPressure;
use App\Http\Requests\StoreBloodPressureRequest;
use App\Http\Requests\UpdateBloodPressureRequest;

class BloodPressureController extends Controller
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
    public function store(StoreBloodPressureRequest $request)
    {
        $validated = $request->validated();

        // Create a new BloodPressure record
        BloodPressure::create([
            'systolic' => $validated['systolic'],
            'diastolic' => $validated['diastolic'],
            'pulse' => $validated['pulse'],
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'measured_at' => $validated['measured_at'],
        ]);

        return redirect()->back()->with('success', 'Blood pressure record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BloodPressure $bloodPressure)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BloodPressure $bloodPressure)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBloodPressureRequest $request, BloodPressure $bloodPressure)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BloodPressure $bloodPressure)
    {
        //
    }
}
