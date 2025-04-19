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

    /**
     * Display a listing of the resource for Admin.
     */
    public function adminIndex()
    {
        $user = auth()->user();

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

        return view('admin.disease', compact('diseases', 'allDiseases', 'user'));
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
     * Store a newly created resource in storage.
     */
    public function store(StoreDiseaseRequest $request)
    {
        $validated = $request->validated();

        try {
            $disease = Disease::create([
                'name' => $validated['name'],
                'category' => $validated['category'],
                'description' => $validated['description'],
                'symptoms' => $validated['symptoms'],
                'prevention' => $validated['prevention'] ?? null,
                'treatment' => $validated['treatment'] ?? null,
                'image' => $validated['image'] ?? null,
            ]);

            return redirect()->route('admin.diseases')
                ->with('success', 'Disease created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to create disease: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Disease $disease)
    {
        return response()->json([
            'disease' => $disease,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiseaseRequest $request, Disease $disease)
    {
        $validated = $request->validated();

        $disease->update([
            'name' => $validated['name'],
            'category' => $validated['category'],
            'description' => $validated['description'],
            'symptoms' => $validated['symptoms'],
            'prevention' => $validated['prevention'] ?? null,
            'treatment' => $validated['treatment'] ?? null,
        ]);

        if (isset($validated['image']) && !empty($validated['image'])) {
            $disease->image = $validated['image'];
            $disease->save();
        }

        return redirect()->route('admin.diseases')
            ->with('success', 'Disease updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Disease $disease)
    {
        $inUse = $disease->patients()->exists();

        if ($inUse) {
            return redirect()->route('admin.diseases')
                ->with('error', 'Cannot delete disease as it is associated with patient records.');
        }

        $disease->delete();

        return redirect()->route('admin.diseases')
            ->with('success', 'Disease deleted successfully.');
    }
}
