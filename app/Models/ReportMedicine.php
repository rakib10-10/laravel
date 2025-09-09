<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportMedicine extends Model
{
    protected $fillable = [
        'report_id', 'medicine_id', 'dosage', 'notes'
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
