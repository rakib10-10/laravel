<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Get counts for dashboard cards
        $totalAppointments = Appointment::count();
        $totalPatients = Patient::count();
        $totalDoctors = Doctor::count();
        
        $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
        $pendingAppointments = Appointment::where('status', 'pending')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        
        // Get recent appointments with enhanced schedule data
        $recentAppointments = Appointment::with(['patient', 'doctor.schedules'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function($appointment) {
                // Get all schedules for this doctor
                $schedules = $appointment->doctor->schedules;
                
                // Try to find schedule that matches the appointment's available_day
                $matchingSchedule = $schedules->where('available_day', $appointment->available_day)->first();
                
                if ($matchingSchedule) {
                    // Use the matching schedule
                    $appointment->schedule_day = $matchingSchedule->available_day;
                    $appointment->start_time = $matchingSchedule->start_time;
                    $appointment->end_time = $matchingSchedule->end_time;
                    $appointment->schedule_source = 'Matched Day';
                } elseif ($schedules->isNotEmpty()) {
                    // Use first available schedule
                    $firstSchedule = $schedules->first();
                    $appointment->schedule_day = $firstSchedule->available_day;
                    $appointment->start_time = $firstSchedule->start_time;
                    $appointment->end_time = $firstSchedule->end_time;
                    $appointment->schedule_source = 'First Available';
                } else {
                    // No schedules found
                    $appointment->schedule_day = $appointment->available_day ?? 'Not Scheduled';
                    $appointment->start_time = $appointment->start_time ?? 'N/A';
                    $appointment->end_time = $appointment->end_time ?? 'N/A';
                    $appointment->schedule_source = 'Appointment Data';
                }
                
                return $appointment;
            });

        return view('admin.dashboard', [
            'totalAppointments' => $totalAppointments,
            'totalPatients' => $totalPatients,
            'totalDoctors' => $totalDoctors,
            'todayAppointments' => $todayAppointments,
            'pendingAppointments' => $pendingAppointments,
            'completedAppointments' => $completedAppointments,
            'recentAppointments' => $recentAppointments
        ]);
    }
}