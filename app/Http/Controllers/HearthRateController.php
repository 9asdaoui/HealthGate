<?php

namespace App\Http\Controllers;

use App\Models\HearthRate;
use App\Http\Requests\StoreHearthRateRequest;
use App\Http\Requests\UpdateHearthRateRequest;

class HearthRateController extends Controller
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
    public function store(StoreHearthRateRequest $request)
    {
        $validatedData = $request->validated();

        // Create a new heart rate record
        HearthRate::create([
            'patient_id' => $validatedData['patient_id'],
            'doctor_id' => $validatedData['doctor_id'],
            'value' => $validatedData['value'],
            'measured_at' => $validatedData['measured_at'],
            'unit' => $validatedData['unit'],
        ]);
        return redirect()->back()->with('success', 'Heart rate recorded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(HearthRate $hearthRate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(HearthRate $hearthRate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHearthRateRequest $request, HearthRate $hearthRate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HearthRate $hearthRate)
    {
        //
    }
}
