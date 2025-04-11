<?php

namespace App\Repositories\Interfaces;

use App\Models\Patient;


interface PatientRepositoryInterface
{

    public function getHealthMetrics(Patient $patient): array;
    public function getlatestBloodPressure(Patient $patient): array;
    public function getlatestBloodSugar(Patient $patient): array;
    public function getlatestHeartRate(Patient $patient): array;
    public function getbloodPressureChartData(Patient $patient): array;
    public function getbloodSugarChartData(Patient $patient): array;
    public function getheartRateChartData(Patient $patient): array;
}
