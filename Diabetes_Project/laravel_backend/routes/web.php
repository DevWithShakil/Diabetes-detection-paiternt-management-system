<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    ProfileController,
    AdminController,
    DoctorController,
    PatientController,
    ReportController,
    UserController,
    AppointmentController
};

// 🔹 Public Route
Route::get('/', function () {
    return view('welcome');
});

// 🔹 Common Authenticated Routes (Everyone logged in)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        // Redirect based on user role
        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'doctor') {
            return redirect()->route('doctor.dashboard');
        } else {
            return redirect()->route('patient.dashboard');
        }
    })->name('dashboard');

    // 🔸 Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// ======================================================
// 🔹 ADMIN ROUTES
// ======================================================
Route::middleware(['auth', 'can:admin'])->group(function () {

    // Dashboard
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Doctor Management
    Route::resource('doctors', DoctorController::class);

    // ✅ Patient Management (Full CRUD for admin)
    Route::get('patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
    Route::get('patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
    Route::delete('patients/{patient}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // ✅ Report & Download
    Route::get('patients/{patient}/report', [AdminController::class, 'downloadReport'])->name('patients.report');
    Route::get('patients/{patient}/download', [PatientController::class, 'downloadReport'])->name('patients.download');

    // Appointments
    Route::resource('appointments', AppointmentController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus'])->name('appointments.updateStatus');

    // Reports
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::delete('reports/{patient}', [ReportController::class, 'destroy'])->name('reports.destroy');

    // User Role Management
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::put('users/{user}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
});



// ======================================================
// 🔹 DOCTOR ROUTES
// ======================================================
Route::middleware(['auth', 'can:doctor'])->group(function () {

    Route::get('/doctor/dashboard', [DoctorController::class, 'dashboard'])->name('doctor.dashboard');
    Route::post('/doctor/appointments/{appointment}/approve', [DoctorController::class, 'approve'])->name('doctor.appointments.approve');
    Route::post('/doctor/appointments/{appointment}/cancel', [DoctorController::class, 'cancel'])->name('doctor.appointments.cancel');
    Route::get('/doctor/patients/{patient}/report', [DoctorController::class, 'viewReport'])->name('doctor.patients.report');
    Route::post('/doctor/appointments/{appointment}/notes', [DoctorController::class, 'storeNote'])->name('doctor.notes.store');
});


// ======================================================
// 🔹 PATIENT ROUTES (Clean, Final)
// ======================================================
Route::middleware(['auth', 'can:patient'])->group(function () {

    // Dashboard
    Route::get('/patient/dashboard', [PatientController::class, 'dashboard'])->name('patient.dashboard');

    // 🧪 Disease Detection (ML)
    Route::get('/patient/detection', [PatientController::class, 'showDetectionForm'])->name('patient.detection');
    Route::post('/patient/detection', [PatientController::class, 'storeDetection'])->name('patient.detection.store');

    // 📅 Appointments
    Route::get('/patient/appointments', [PatientController::class, 'appointments'])->name('patient.appointments');
    Route::get('/patient/appointments/create', [PatientController::class, 'createAppointment'])->name('patient.appointments.create');
    Route::post('/patient/appointments/store', [PatientController::class, 'storeAppointment'])->name('patient.appointments.store');
    Route::get('/patient/appointments/{appointment}', [PatientController::class, 'showAppointment'])->name('patient.appointments.show');

    // 📄 Reports
    Route::get('/patient/report/{patient}', [PatientController::class, 'report'])->name('patient.report');
    Route::get('/patient/report/{patient}/download', [PatientController::class, 'downloadReport'])->name('patient.report.download');
});


// ======================================================
// 🔹 LOGOUT
// ======================================================
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


// ======================================================
// 🔹 AUTH ROUTES
// ======================================================
require __DIR__ . '/auth.php';
