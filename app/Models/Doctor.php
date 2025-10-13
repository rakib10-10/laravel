<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'doctor_id',
        'name',
        'contact',
        'address',
        'country',
        'date_of_birth',
        'blood_group',
        'specialization',
        'designation',
        'department',
        'license_number',
        'date_of_joining',
        'work_experience',
        'email',
        'profile_image',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($doctor) {
            // Auto-generate doctor_id if not set
            if (empty($doctor->doctor_id)) {
                $lastDoctor = static::orderBy('id', 'desc')->first();
                $nextNumber = $lastDoctor ? (int) str_replace('DOC', '', $lastDoctor->doctor_id) + 1 : 1;
                $doctor->doctor_id = 'DOC' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
            }

            // Auto-generate email if not set
            if (empty($doctor->email)) {
                $baseEmail = strtolower(str_replace(' ', '.', $doctor->name));
                $doctor->email = $baseEmail . '.' . $doctor->doctor_id . '@hospital.com';
                
                // Ensure email is unique
                $counter = 1;
                $originalEmail = $doctor->email;
                while (static::where('email', $doctor->email)->exists()) {
                    $doctor->email = $baseEmail . '.' . $doctor->doctor_id . $counter . '@hospital.com';
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

    public function schedules()
    {
        return $this->hasMany(DoctorSchedule::class);
    }

    public function getProfileImageUrlAttribute()
    {
        if ($this->profile_image && file_exists(public_path('images/' . $this->profile_image))) {
            return asset('images/' . $this->profile_image);
        }
        
        // Return a default avatar if no image exists
        return asset('images/default-avatar.png');
    }

    // Accessor for profile image path
    public function getProfileImagePathAttribute()
    {
        if ($this->profile_image) {
            return public_path('images/' . $this->profile_image);
        }
        return null;
    }
}