<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'contact',
        'address',
        'country',
        'date_of_birth',
        'blood_group',
        'specialist',
        'specialization',
        'designation',
        'department',
        'license_number',
        'date_of_joining',
        'work_experience',
        'email',
    ];

    /**
     * Get the user that owns the doctor.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function edit($id)
{
    $doctor = Doctor::findOrFail($id); // This will find the doctor or fail with a 404.
    return view('admin.doctors.edit', compact('doctor'));
}
}