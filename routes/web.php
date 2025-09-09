<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PatientController;


// Route::view('/dashboard','dashboard')



// Route::get('/greeting', [UserController::class,'index']);

// Route::get('/a/b/c/d', function () {
//     return 'Name Routing';
// })->name('second');//Named Routing 


// Route::prefix('blog')->group(function(){
//     Route::get('/view', function () {
//     return 'This is new blog page';
// });

// });

// web.php

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::view('/home', 'admin.home')->name('home');
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::view('/patient', 'admin.patient')->name('patient');
    Route::view('/doctors', 'admin.doctors')->name('doctors');
    Route::view('/medicines', 'admin.medicines')->name('medicines');
    Route::view('/reports', 'admin.reports')->name('reports');
    Route::view('/appointment', 'admin.appointment')->name('appointment');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/patients/search', [PatientController::class, 'search'])->name('patients.search');
});
Route::get('/doctor/details', function () {
    return view('admin.doctor-details');
});

Route::get('/admin/medicines', [MedicineController::class, 'index'])->name('admin.medicines.index');










