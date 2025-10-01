<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;

class PatientHomeController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Authenticated user
        $patientId = $user->id; // Assuming patient_id = user_id

        // Next upcoming appointment
        $nextAppointment = Appointment::with('doctor')
            ->where('patient_id', $patientId)
            ->where('appointment_date', '>=', now())
            ->orderBy('appointment_date', 'asc')
            ->first();

        // Recent activities (latest 5 appointments)
        $recentActivities = Appointment::with('doctor')
            ->where('patient_id', $patientId)
            ->orderBy('appointment_date', 'desc')
            ->take(5)
            ->get();

        return view('patient.dashboard', compact('user', 'nextAppointment', 'recentActivities'));
    }
}
