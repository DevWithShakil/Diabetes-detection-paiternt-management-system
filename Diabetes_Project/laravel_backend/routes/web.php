<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [PatientController::class, 'create']);
Route::post('/predict', [PatientController::class, 'predict']);
