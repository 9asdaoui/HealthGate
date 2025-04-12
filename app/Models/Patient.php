<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'height',
        'weight',
        'date_of_birth',
    ];
    
    protected $casts = [
        'height' => 'float',
        'weight' => 'float',
        'date_of_birth' => 'date',
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

    public function hearthRates()
    {
        return $this->hasMany(HearthRate::class);
    }

    public function medicals()
    {
        return $this->hasMany(Medical::class);
    }
    
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function doctors()
    {
        return $this->belongsToMany(Doctor::class, 'patient_doctor_disease')->withPivot('duration');
    }

    public function diseases()
    {
        return $this->belongsToMany(Disease::class, 'patient_doctor_disease')->withPivot('duration');
    }

}
