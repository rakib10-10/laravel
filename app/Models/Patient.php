<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
class Patient extends Model
{
    use Hasfactory;
    protected $table = 'patients';   // if your table name is patients
    protected $fillable = [
        'user_id', 'name', 'date_of_birth', 'gender', 
        'blood_type', 'address', 'emergency_contact'
    ];
}


