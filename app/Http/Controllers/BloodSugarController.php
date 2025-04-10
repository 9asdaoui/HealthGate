<?php

namespace App\Http\Controllers;

use App\Models\BloodSugar;
use App\Http\Requests\StoreBloodSugarRequest;
use App\Http\Requests\UpdateBloodSugarRequest;

class BloodSugarController extends Controller
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
    public function store(StoreBloodSugarRequest $request)
    {
        $validated = $request->validated();
        // Create a new BloodSugar record
        BloodSugar::create([
            'patient_id' => $validated['patient_id'],
            'doctor_id' => $validated['doctor_id'],
            'measured_at' => $validated['measured_at'],
            'value' => $validated['value'],
            'unit' => $validated['unit'],
        ]);

        return redirect()->back()->with('success', 'Blood sugar record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BloodSugar $bloodSugar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BloodSugar $bloodSugar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBloodSugarRequest $request, BloodSugar $bloodSugar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BloodSugar $bloodSugar)
    {
        //
    }
}
