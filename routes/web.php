<?php


use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\AppointmentController;

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
})->name('dashboard')->middleware(['auth']);


Route::prefix('admin')->name('admin.')->group(function () {
    // Static views
    Route::view('/home', 'admin.home')->name('home')->middleware(['auth', 'role:admin']);
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard')->middleware(['auth', 'role:admin']);
    Route::view('/patient', 'admin.patient')->name('patient')->middleware(['auth', 'role:admin']);
    Route::view('/appointment', 'admin.appointment')->name('appointment')->middleware(['auth', 'role:admin']);
    Route::view('/doctor-details', 'admin.doctor-details')->name('doctor-details')->middleware(['auth', 'role:admin']);
    Route::resource('doctors', DoctorController::class);

    // Use a resource route for appointments for RESTful actions (index, create, store, etc.)
    Route::resource('appointments', AppointmentController::class);
    
    

    Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment');
// or
   

    // Specific route to fetch doctor schedules
    Route::get('/appointments/schedules/{doctor}', [AppointmentController::class, 'getSchedules'])->name('appointments.schedules');
   


    // Routes with Controllers
    Route::resource('doctors', DoctorController::class)->middleware(['auth', 'role:admin']);
    Route::resource('medicines', MedicineController::class);
    Route::resource('reports', ReportController::class);

    // Other specific routes
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');

   
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
