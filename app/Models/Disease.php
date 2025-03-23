<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disease extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'patient_doctor_disease')->withPivot('duration');
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'patient_doctor_disease')->withPivot('duration');
    }

    
}
