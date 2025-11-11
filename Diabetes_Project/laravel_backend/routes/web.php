<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AppointmentController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/admin/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth', 'can:admin'])
    ->name('admin.dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/patients/{patient}/report', [AdminController::class, 'downloadReport'])->name('patients.report');
});

Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('doctors', DoctorController::class);
});


// Admin-only group
Route::middleware(['auth', 'can:admin'])->group(function () {
    // Patients (index, destroy already in your PatientController)
    Route::resource('patients', PatientController::class)->only(['index','destroy','show']);
    Route::get('patients/{patient}/download', [PatientController::class, 'downloadReport'])->name('patients.download');

    // Reports (view & delete reports) - using ReportController
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('reports/{patient}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // User Role management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});

// Doctor appointments
Route::middleware(['auth', 'can:admin'])->group(function () {
    Route::resource('appointments', AppointmentController::class)->only(['index','create','store','destroy']);
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');
});



require __DIR__.'/auth.php';
