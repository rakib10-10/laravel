<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
// Import the necessary models
use App\Models\Appointment; 
use App\Models\Patient; // Assuming Patient records are associated with the doctor's patients
use Carbon\Carbon;

class DoctorHomeController extends Controller
{
    /**
     * Display the doctor dashboard.
     */
    public function index()
    {
        $doctorId = Auth::id();

        // 1. Fetch Dashboard Metrics
        
        // Count of confirmed appointments for today
        $todayAppointmentsCount = Appointment::where('doctor_id', $doctorId)
            ->whereDate('appointment_date', Carbon::today())
            ->where('status', 'confirmed')
            ->count();

        // Count of all patients associated with this doctor (requires a join or separate Patient model logic)
        // For simplicity now, let's count unique patient IDs in appointments
        $totalPatientCount = Appointment::where('doctor_id', $doctorId)
            ->distinct('patient_id')
            ->count('patient_id');

        // Count of appointments awaiting confirmation
        $pendingAppointmentsCount = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'pending')
            ->count();
        
        
        // 2. Fetch Upcoming Appointments (Next 10)
        
        $upcomingAppointments = Appointment::with('patient') // Eager load the patient details
            ->where('doctor_id', $doctorId)
            ->where('appointment_date', '>=', Carbon::now()) // Appointments from now onwards
            ->whereIn('status', ['confirmed', 'pending']) // Only confirmed and pending ones
            ->limit(10) // Limit to the next 10
            ->orderBy('appointment_date', 'asc')
            ->get();
        
        // Passing all required variables to the view
        return view('doctor.dashboard', compact(
            'todayAppointmentsCount', 
            'totalPatientCount', 
            'pendingAppointmentsCount', 
            'upcomingAppointments'
        )); 
    }
}
