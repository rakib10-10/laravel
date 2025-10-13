<?php

use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\PatientController as AdminPatientController;
use App\Http\Controllers\Doctor\DoctorAppointmentController;
use App\Http\Controllers\Doctor\DoctorHomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\Patient\PatientAppointmentController;
use App\Http\Controllers\Patient\PatientHomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// --- AUTH ROUTES ---
Auth::routes();

// --- ROOT REDIRECTION ---
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        if ($role === 'doctor') {
            return redirect()->route('doctor.dashboard');
        }
        if ($role === 'patient') {
            return redirect()->route('patient.dashboard');
        }
    }

    return view('welcome');
})->name('root');

// --- PATIENT ROUTES ---
Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [PatientHomeController::class, 'index'])->name('dashboard');

    // Appointments: index, create, store
    Route::resource('appointments', PatientAppointmentController::class)
        ->only(['index', 'create', 'store', 'show', 'destroy']);

    // AJAX route to fetch doctor schedules
    Route::get('/doctors/{doctor}/schedules', [PatientAppointmentController::class, 'getSchedules'])
        ->name('doctors.schedules');

    // Medical History
    Route::get('/my-history', fn () => view('patient.history'))->name('history');

    // Optional search patients
    Route::get('/search', [PatientController::class, 'search'])->name('search');
});

// --- ADMIN ROUTES ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/home', 'admin.home')->name('home');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Use resource routes - this automatically creates all CRUD routes including show
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AdminAppointmentController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('reports', ReportController::class);
    Route::resource('patients', AdminPatientController::class);



    Route::view('/patients/search', 'admin.patients.index')->name('patients.search');
    

    // ✅ Doctor schedule fetch route
    Route::get('/appointments/schedules/{doctorId}', [AdminAppointmentController::class, 'getSchedules'])
        ->name('appointments.schedules');

    Route::get('/doctors/{doctor}/schedules', [DoctorController::class, 'getSchedules'])->name('doctors.schedules');
    Route::get('/patients/search', [AdminPatientController::class, 'search'])->name('patients.search');
});

// --- DOCTOR ROUTES ---
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DoctorHomeController::class, 'index'])->name('dashboard');
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{appointment}', [DoctorAppointmentController::class, 'updateStatus'])->name('appointments.update');
});

// --- LOGOUT ROUTE ---
Route::get('/logout', function () {
    Auth::logout();

    return redirect('/')->with('status', 'You have been logged out.');
})->name('logout.force');




// Add this temporary route to your web.php
Route::get('/debug-dashboard', function () {
    $data = [
        'totalAppointments' => \App\Models\Appointment::count(),
        'totalPatients' => \App\Models\Patient::count(),
        'totalDoctors' => \App\Models\Doctor::count(),
        'todayAppointments' => \App\Models\Appointment::whereDate('appointment_date', \Carbon\Carbon::today())->count(),
        'pendingAppointments' => \App\Models\Appointment::where('status', 'pending')->count(),
        'completedAppointments' => \App\Models\Appointment::where('status', 'completed')->count(),
        'recentAppointments' => \App\Models\Appointment::with(['patient', 'doctor'])->orderBy('created_at', 'desc')->take(10)->get()
    ];
    
    dd($data);
});

// Add this to your web.php file temporarily



Route::get('/check-current-route', function () {
    // Check what happens when we visit the admin dashboard
    $response = app()->handle(
        Illuminate\Http\Request::create('/admin/dashboard', 'GET')
    );
    
    dd([
        'status' => $response->getStatusCode(),
        'content' => $response->getContent()
    ]);
});