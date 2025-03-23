<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'department_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function bloodPressures()
    {
        return $this->hasMany(BloodPressure::class);
    }

    public function bloodSugars()
    {
        return $this->hasMany(BloodSugar::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class);
    }

    public function heartRates()
    {
        return $this->hasMany(HearthRate::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'patient_doctor_disease')
            ->withPivot('duration');
    }


    
}
