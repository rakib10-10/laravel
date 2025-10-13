<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorSchedule extends Model
{
    protected $fillable = [
        'doctor_id',
        'available_day',
        'start_time',
        'end_time',
    ];
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
