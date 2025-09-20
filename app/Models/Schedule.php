<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Schedule extends Model
{
    protected $table = 'doctor_schedules';

    protected $fillable = [
        'doctor_id', 
        'available_day', // <-- Add this line
        'start_time', 
        'end_time',
    ];
    //
    // app/Models/Schedule.php
public function doctor()
{

    
    return $this->belongsTo(Doctor::class);
}
}
