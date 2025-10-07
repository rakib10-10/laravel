<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Patient\PatientAppointmentController; // <-- IMPORTANT: Use your specific Controller path

// ... any existing routes ...

// Add this route to handle the AJAX request for schedules
Route::get('/doctors/{doctor}/schedules', [PatientAppointmentController::class, 'getSchedules']);
