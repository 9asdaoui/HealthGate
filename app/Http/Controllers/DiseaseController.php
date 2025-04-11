<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiseasesAssignRequest;
use App\Models\Disease;
use App\Http\Requests\StoreDiseaseRequest;
use App\Http\Requests\UpdateDiseaseRequest;
use App\Models\Patient;
use App\Models\User;

class DiseaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $allDiseases = Disease::all();
        
        $query = Disease::query();

        if (request()->has('category') && request('category') != 'all') {
            $query->where('category', request('category'));
        }
        
        if (request()->has('search') && !empty(request('search'))) {
            $query->where('name', 'like', '%' . request('search') . '%')
                  ->orWhere('description', 'like', '%' . request('search') . '%');
        }
        
        $diseases = $query->paginate(10);

        $doctor = auth()->user()->doctor;
        $patients = $doctor->getPatients();
        $user = auth()->user();

        return view('doctor.disease.index', compact('diseases', 'allDiseases', 'patients', 'user'));
    }
    public function getDisease(Disease $disease)
    {
        return response()->json([
                    'disease' => $disease,
                ]);
    }

    public function diseasesAssign(DiseasesAssignRequest $request)
    {
        // dd($request->all());
        $validated = $request->validated();
        $patient = Patient::findOrFail($validated['patient_id']);
        $disease = Disease::findOrFail($validated['disease_id']);
        $doctor = auth()->user()->doctor;

        // Attach the disease to the patient with doctor ID and optional duration
        $patient->diseases()->attach($disease->id, [
            'doctor_id' => $doctor->id,
            'duration' => $validated['duration'] ?? null,
        ]);

        return redirect()->route('doctor.patients.medical-records', ['patient' => $patient])
        ->with('success', 'success', $disease->name . ' has been assigned to the patient successfully.');
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
    public function store(StoreDiseaseRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Disease $disease)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Disease $disease)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $disease)
    {
        //
    }
}
