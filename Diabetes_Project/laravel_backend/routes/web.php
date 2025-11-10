<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PatientController::class, 'create']);
Route::post('/predict', [PatientController::class, 'predict']);

Route::get('/', function(){ return redirect()->route('patients.index'); });

Route::middleware(['auth'])->group(function(){
    Route::resource('patients', PatientController::class);
    Route::get('patients/{patient}/download', [PatientController::class,'downloadReport'])->name('patients.download');
    Route::resource('doctors', DoctorController::class);
    Route::resource('appointments', AppointmentController::class)->only(['index','store','destroy']);
    Route::get('dashboard', [AdminController::class,'index'])->name('dashboard');
});
require __DIR__.'/auth.php';
