<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'patient_id',
        'name',
        'date_of_birth',
        'gender',
        'blood_type',
        'address',
        'phone',
        'email',
        'emergency_contact'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($patient) {
            // Auto-generate patient_id if not set
            if (empty($patient->patient_id)) {
                $lastPatient = static::orderBy('id', 'desc')->first();
                $nextNumber = $lastPatient ? (int) str_replace('PAT', '', $lastPatient->patient_id) + 1 : 1;
                $patient->patient_id = 'PAT' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            // Auto-generate email if not set
            if (empty($patient->email)) {
                $baseEmail = strtolower(str_replace(' ', '.', $patient->name));
                $patient->email = $baseEmail . '.' . $patient->patient_id . '@hospital.com';
                
                // Ensure email is unique
                $counter = 1;
                $originalEmail = $patient->email;
                while (static::where('email', $patient->email)->exists()) {
                    $patient->email = $baseEmail . '.' . $patient->patient_id . $counter . '@hospital.com';
                    $counter++;
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}