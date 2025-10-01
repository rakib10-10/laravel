<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLER IMPORTS ---
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AppointmentController;


use App\Http\Controllers\Doctor\DoctorHomeController;
use App\Http\Controllers\Patient\PatientHomeController;

// Admin-specific controllers
use App\Http\Controllers\Admin\PatientController as AdminPatientController;

// Regular PatientController for patient actions
use App\Http\Controllers\PatientController;

// --- AUTH ROUTES ---
Auth::routes(); // login, register, password reset, logout

// --- ROOT REDIRECTION AFTER LOGIN ---
Route::get('/', function () {
    if (Auth::check()) {
        $role = Auth::user()->role;
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'doctor') {
            return redirect()->route('doctor.dashboard');
        } elseif ($role === 'patient') {
            return redirect()->route('patient.dashboard');
        }
    }
    return view('welcome');
})->name('root');

// --- PATIENT ROUTES ---
Route::prefix('patient')->name('patient.')->middleware(['auth', 'role:patient'])->group(function () {
    // Patient Dashboard
    Route::get('/dashboard', [PatientHomeController::class, 'index'])->name('dashboard');

    // Appointment submission (placeholder)
    Route::post('/appointment/store', function (\Illuminate\Http\Request $request) {
        return redirect()->route('patient.dashboard')->with('status', 'Appointment submitted.');
    })->name('appointment.store');

    // Patient Medical History
    Route::get('/my-history', fn() => view('patient.history'))->name('history');

    // Optional: search patients (if needed)
    Route::get('/search', [PatientController::class, 'search'])->name('search');
});

// --- ADMIN ROUTES ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/home', 'admin.home')->name('home');

    // Resource controllers
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('reports', ReportController::class);

    // Patient CRUD using Admin controller
    Route::resource('patients', AdminPatientController::class);

    // Extra admin routes
    Route::get('/doctors/{doctor}/schedules', [DoctorController::class, 'getSchedules'])->name('doctors.schedules');
    Route::get('/patients/search', [AdminPatientController::class, 'search'])->name('patients.search');
});

// --- DOCTOR ROUTES ---
Route::prefix('doctor')->name('doctor.')->middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/dashboard', [DoctorHomeController::class, 'index'])->name('dashboard');
    // Add more doctor-specific routes here
});

// --- LOGOUT ROUTE FIX ---
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('status', 'You have been logged out.');
})->name('logout.force');
