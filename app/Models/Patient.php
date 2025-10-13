<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Patient
 * Represents a patient record in the system.
 */
class Patient extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'phone',
        'date_of_birth',
        'address',
    ];

    /**
     * Get the user (authentication) record associated with the patient.
     */
    public function user()
    {
        // Assuming a User model exists
        return $this->belongsTo(\App\Models\User::class);
    }
    
    /**
     * Get the appointments for the patient.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
