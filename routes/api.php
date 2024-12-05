<?php

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

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);
        Route::apiResource('users', UserController::class)->middleware('role:admin');
        Route::get('doctors', [DoctorController::class, 'index'])->Middleware('role:admin,patient');
        Route::get('patients', [PatientController::class, 'index'])->Middleware('role:admin');
        Route::delete('doctors/{id}', [DoctorController::class, 'destroy'])->Middleware('role:admin,doctor');
        Route::delete('patients/{id}', [PatientController::class, 'destroy'])->Middleware('role:admin,patient');
        Route::put('doctors/{id}', [DoctorController::class, 'update'])->Middleware('role:doctor');
        Route::put('patients/{id}', [PatientController::class, 'update'])->Middleware('role:patient');
        Route::get('doctor/{id}', [DoctorController::class, 'show'])->middleware('role:admin,doctor');
        Route::get('patient/{id}', [PatientController::class, 'show'])->middleware('role:admin,patient');
        Route::apiResource('specializations', SpecializationController::class)->middleware('role:admin');
        Route::get('schedules', [ScheduleController::class, 'index']);
        Route::get('schedules/{id}', [ScheduleController::class, 'show']);
        Route::post('schedules/', [ScheduleController::class, 'store'])->middleware('role:doctor');
        Route::put('schedules/{id}', [ScheduleController::class, 'update'])->middleware('role:doctor');
        Route::delete('schedules/{id}', [ScheduleController::class, 'destroy'])->middleware('role:doctor');
        Route::get('appointments', [AppointmentController::class, 'index']);
        Route::get('appointments/{id}', [AppointmentController::class, 'show']);
        Route::post('appointments/', [AppointmentController::class, 'store'])->middleware('role:patient');
        Route::put('appointments/{id}', [AppointmentController::class, 'update'])->middleware('role:patient');
        Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->middleware('role:patient');
        Route::patch('appointments/{id}/approve', [AppointmentController::class, 'approveAppointment'])->middleware('role:doctor');
    });
});
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
