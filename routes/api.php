<?php

use App\Http\Controllers\Api\v1\AdminController;
use App\Http\Controllers\Api\v1\AppointmentController;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\DoctorController;
use App\Http\Controllers\Api\v1\PatientController;
use App\Http\Controllers\Api\v1\ScheduleController;
use App\Http\Controllers\Api\v1\SpecializationController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Middleware\AdminMiddleware;
use GuzzleHttp\Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Sanctum;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::prefix('v1')->group(function () {
    Route::group(['middleware' => "auth:sanctum"], function () {

        // Authenticated routes
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        // Admin Routes
        Route::get('admins', [AdminController::class, 'index'])->middleware('role:admin'); // List all admins
        Route::post('admins', [AdminController::class, 'store'])->name('admins.store'); // Create a new admin
        Route::put('admins/{admin}', [AdminController::class, 'update'])->name('admins.update'); // Update a specific admin
        Route::delete('admins/{admin}', [AdminController::class, 'destroy'])->name('admins.destroy'); // Delete a specific admin
    
        // Doctor Routes
        Route::get('doctors', [DoctorController::class, 'index'])->middleware('role:admin,patient');
        Route::get('doctor/{id}', [DoctorController::class, 'show'])->middleware('role:admin,doctor,patient');
        Route::put('doctors/{id}', [DoctorController::class, 'update'])->middleware('role:doctor');
        Route::delete('doctors/{id}', [DoctorController::class, 'destroy'])->middleware('role:admin');
        
        // Patient Routes
        Route::get('patients', [PatientController::class, 'index'])->middleware('role:admin');
        Route::get('patient/{id}', [PatientController::class, 'show'])->middleware('role:admin');
        Route::put('patients/{id}', [PatientController::class, 'update'])->middleware('role:patient');
        Route::delete('patients/{id}', [PatientController::class, 'destroy'])->middleware('role:patient');

        // Specialization Routes
        Route::get('specializations', [SpecializationController::class, 'index']); // List all specializations
        Route::post('specializations', [SpecializationController::class, 'store'])->middleware('role:admin'); // Create a new specialization
        Route::get('specializations/{id}', [SpecializationController::class, 'show']);
        Route::put('specializations/{id}', [SpecializationController::class, 'update'])->middleware('role:admin'); // Update a specialization
        Route::delete('specializations/{id}', [SpecializationController::class, 'destroy'])->middleware('role:admin'); // Delete a specialization
    
        // Schedule Routes
        Route::get('schedules', [ScheduleController::class, 'index']);
        Route::get('schedules/{id}', [ScheduleController::class, 'show'])->middleware('role:admin,patient');
        Route::post('schedules', [ScheduleController::class, 'store'])->middleware('role:doctor');
        Route::put('schedules/{id}', [ScheduleController::class, 'update'])->middleware('role:doctor');
        Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->middleware('role:doctor');

        // Appointment Routes
        Route::get('appointments', [AppointmentController::class, 'index']);
        Route::get('appointments/{id}', [AppointmentController::class, 'show'])->middleware('role:admin');
        Route::post('appointments/', [AppointmentController::class, 'store'])->middleware('role:patient');
        Route::put('appointments/{id}', [AppointmentController::class, 'update'])->middleware('role:patient');
        Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->middleware('role:patient');
        Route::patch('appointments/{id}/approve', [AppointmentController::class, 'approveAppointment'])->middleware('role:doctor');

    });
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
