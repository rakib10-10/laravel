<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLER IMPORTS ---
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;

// --- ROLE-SPECIFIC APPOINTMENT CONTROLLERS (FIXED) ---
// These now correctly point to the controllers inside their respective folders (namespaces)
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Doctor\DoctorAppointmentController;
use App\Http\Controllers\Patient\PatientAppointmentController;

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

    // APPOINTMENTS: View and Create/Book
    Route::get('/appointments', [PatientAppointmentController::class, 'index'])->name('appointments.index');
    Route::post('/appointments', [PatientAppointmentController::class, 'store'])->name('appointments.store');

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
    
    // Correctly defined AdminAppointmentController resource
    Route::resource('appointments', AdminAppointmentController::class); 
    
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

    // APPOINTMENTS: View and Update Status
    // DoctorAppointmentController is now imported from App\Http\Controllers\Doctor\DoctorAppointmentController
    Route::get('/appointments', [DoctorAppointmentController::class, 'index'])->name('appointments.index');
    Route::put('/appointments/{appointment}', [DoctorAppointmentController::class, 'updateStatus'])->name('appointments.update');
});

// --- LOGOUT ROUTE FIX ---
// The original Auth::routes() handles /logout, but this is often added for clarity or custom force-logout links.
Route::get('/logout', function () {
    Auth::logout();
    return redirect('/')->with('status', 'You have been logged out.');
})->name('logout.force');

// REMOVED: Redundant and misplaced Route::resource('appointments', ...) line that was here.
// Example routes/web.php setup for Patient access

use App\Models\Doctor;

Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    Route::resource('appointments', PatientAppointmentController::class)->only(['index', 'create', 'store']);
    
    // Route for AJAX schedule fetching
    Route::get('/doctors/{doctor}/schedules', [PatientAppointmentController::class, 'getSchedules'])->name('doctors.schedules');
});

// IMPORTANT: The {doctor} parameter in the route above assumes Route Model Binding works 
// for the mock Doctor model using its ID.
Route::middleware(['auth', 'role:patient'])->prefix('patient')->name('patient.')->group(function () {
    // Existing Appointment Routes
    Route::resource('appointments', PatientAppointmentController::class);

    // NEW AJAX ROUTE: Fetch schedules for a specific doctor
    // The {doctor} parameter will automatically resolve to a Doctor model instance (Route Model Binding)
    Route::get('/doctors/{doctor}/schedules', [PatientAppointmentController::class, 'getSchedules'])
        ->name('doctors.schedules');
});