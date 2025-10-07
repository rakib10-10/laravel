<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * We need 'is_booked' to be fillable so the controller can update
     * the status after an appointment is successfully booked.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'doctor_id',
        'slot_date',
        'start_time',
        'end_time',
        'is_booked', // Added for mass assignment
    ];

    /**
     * Get the doctor that owns the slot.
     */
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
