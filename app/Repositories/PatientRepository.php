<?php

namespace App\Repositories;

use App\Models\Patient;
use App\Repositories\Interfaces\PatientRepositoryInterface;


class PatientRepository implements PatientRepositoryInterface
{
public function getHealthMetrics(Patient $patient): array
{
    $bloodPressures = $patient->bloodPressures()->orderBy('created_at', 'desc')->take(10)->get();
    $bloodSugars = $patient->bloodSugars()->orderBy('created_at', 'desc')->take(10)->get();
    $hearthRates = $patient->hearthRates()->orderBy('created_at', 'desc')->take(10)->get();
    
    $metrics = [];
    // dd($bloodPressures);
    foreach ($bloodPressures as $bp) {
        $metrics[] = [
            'type' => 'Blood Pressure',
            'value' => $bp->systolic . '/' . $bp->diastolic . ' mmHg',
            'created_at' => $bp->created_at,
            'recorded_by' => $bp->doctor->user->first_name . ' ' . $bp->doctor->user->last_name,
            'date' => $bp->created_at->format('M d')
        ];
    }
    
    foreach ($bloodSugars as $bs) {
        $metrics[] = [
            'type' => 'Blood Sugar',
            'value' => $bs->value . ' mg/dL',
            'created_at' => $bs->created_at,
            'recorded_by' => $bp->doctor->user->first_name . ' ' . $bp->doctor->user->last_name,
            'date' => $bs->created_at->format('M d')
        ];
    }
    
    foreach ($hearthRates as $hr) {
        $metrics[] = [
            'type' => 'Heart Rate',
            'value' => $hr->value . ' bpm',
            'created_at' => $hr->created_at,
            'recorded_by' => $bp->doctor->user->first_name . ' ' . $bp->doctor->user->last_name,
            'date' => $hr->created_at->format('M d')
        ];
    }

    return $metrics;
}

public function getlatestBloodPressure(Patient $patient): array
{
    $latest = $patient->bloodPressures()->latest()->first();
    
    return $latest ? [
        'systolic' => $latest->systolic,
        'diastolic' => $latest->diastolic,
        'date' => $latest->created_at->format('M d, Y'),
        'exists' => true
    ] : [
        'exists' => false
    ];
}

public function getlatestBloodSugar(Patient $patient): array
{
    $latest = $patient->bloodSugars()->latest()->first();
    
    return $latest ? [
        'value' => $latest->value,
        'date' => $latest->created_at->format('M d, Y'),
        'exists' => true
    ] : [
        'exists' => false
    ];
}

public function getlatestHeartRate(Patient $patient): array
{
    $latest = $patient->hearthRates()->latest()->first();
    
    return $latest ? [
        'value' => $latest->value,
        'date' => $latest->created_at->format('M d, Y'),
        'exists' => true
    ] : [
        'exists' => false
    ];
}

public function getbloodPressureChartData(Patient $patient): array
{
    $bloodPressures = $patient->bloodPressures()
        ->orderBy('created_at', 'asc')
        ->take(15)
        ->get();
    
    $labels = [];
    $systolicData = [];
    $diastolicData = [];
    
    foreach ($bloodPressures as $bp) {
        $labels[] = $bp->created_at->format('M d');
        $systolicData[] = $bp->systolic;
        $diastolicData[] = $bp->diastolic;
    }
    
    return [
        'labels' => $labels,
        'systolic' => $systolicData,
        'diastolic' => $diastolicData
    ];
}

public function getbloodSugarChartData(Patient $patient): array
{
    $bloodSugars = $patient->bloodSugars()
        ->orderBy('created_at', 'asc')
        ->take(15)
        ->get();
    
    $labels = [];
    $values = [];
    
    foreach ($bloodSugars as $bs) {
        $labels[] = $bs->created_at->format('M d');
        $values[] = $bs->value;
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}

public function getheartRateChartData(Patient $patient): array
{
    $hearthRates = $patient->hearthRates()
        ->orderBy('created_at', 'asc')
        ->take(15)
        ->get();
    
    $labels = [];
    $values = [];
    
    foreach ($hearthRates as $hr) {
        $labels[] = $hr->created_at->format('M d');
        $values[] = $hr->value;
    }
    
    return [
        'labels' => $labels,
        'values' => $values
    ];
}
}