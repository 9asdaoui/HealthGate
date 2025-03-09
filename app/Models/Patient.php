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
}
