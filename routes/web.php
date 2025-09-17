<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    // Static views
    Route::view('/home', 'admin.home')->name('home');
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/patient', 'admin.patient')->name('patient');
    Route::view('/appointment', 'admin.appointment')->name('appointment');
    Route::view('/doctor-details', 'admin.doctor-details')->name('doctor-details');
    Route::resource('doctors', DoctorController::class);

    // Routes with Controllers
    Route::resource('doctors', DoctorController::class);
    Route::resource('medicines', MedicineController::class);
    Route::resource('reports', ReportController::class);

    // Other specific routes
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
});