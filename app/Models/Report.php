<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory; // 👈 important

protected $fillable = [
    'patient_id',
    'doctor_id',
    'visit_date',
    'diagnosis',
    'medicines',
    'tests',
    'additional_notes',
];

protected $casts = [
    'medicines' => 'array',
    'tests' => 'array',
    'visit_date' => 'datetime',
];

    public function medicines()
    {
        return $this->hasMany(ReportMedicine::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
