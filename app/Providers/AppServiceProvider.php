<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share dashboard data with admin.dashboard view
        View::composer('admin.dashboard', function ($view) {
            $totalAppointments = Appointment::count();
            $totalPatients = Patient::count();
            $totalDoctors = Doctor::count();
            $todayAppointments = Appointment::whereDate('appointment_date', Carbon::today())->count();
            $pendingAppointments = Appointment::where('status', 'pending')->count();
            $completedAppointments = Appointment::where('status', 'completed')->count();
            $recentAppointments = Appointment::with(['patient', 'doctor'])
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();

            $view->with([
                'totalAppointments' => $totalAppointments,
                'totalPatients' => $totalPatients,
                'totalDoctors' => $totalDoctors,
                'todayAppointments' => $todayAppointments,
                'pendingAppointments' => $pendingAppointments,
                'completedAppointments' => $completedAppointments,
                'recentAppointments' => $recentAppointments
            ]);
        });
    }
}