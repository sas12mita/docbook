<?php

use App\Http\Controllers\PatientController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminController;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Route;

// Home route for the welcome page
Route::get('/', function () {
    return view('welcome');
});
Route::get('/doctorlist',[DoctorController::class, 'doctorlist'])->name('doctors.list');
// Dashboard route for authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // // Doctor-related routes
    // Route::post('/doctors/by-specialization', [DoctorController::class, 'showDoctors'])->name('doctors.bySpecialization');
    // Route::resource('doctors', DoctorController::class);
    // Route::get('/doctors/dashboard', [DoctorController::class, 'dashboard'])->name('doctors.dashboard');
    // Doctor-related routes
    Route::get('/doctors', [DoctorController::class, 'index'])->name('doctors.index'); // List all doctors
    Route::get('/doctors/create', [DoctorController::class, 'create'])->name('doctors.create'); // Show form to create a doctor
    Route::post('/doctors', [DoctorController::class, 'store'])->name('doctors.store'); // Store a newly created doctor
    Route::get('/doctors/{doctor}', [DoctorController::class, 'show'])->name('doctors.show'); // Show a specific doctor
    Route::get('/doctors/{doctor}/edit', [DoctorController::class, 'edit'])->name('doctors.edit'); // Show form to edit a doctor
    Route::put('/doctors/{doctor}', [DoctorController::class, 'update'])->name('doctors.update'); // Update a specific doctor
    Route::delete('/doctors/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy'); // Delete a specific doctor

    // Custom route for doctors by specialization
    Route::post('/doctors/by-specialization', [DoctorController::class, 'showDoctors'])->name('doctors.bySpecialization');
    Route::get('/doctors/{doctorId}/schedule', [DoctorController::class, 'getSchedule'])->name('doctors.schedule');



    // Patient-related routes
    Route::resource('patients', PatientController::class);
    Route::get('/patients/dashboard', [PatientController::class, 'dashboard'])->name('patients.dashboard');
    Route::delete('/patients/{id}', [PatientController::class, 'destroy'])->name('patients.destroy');

    // Specializations resource routes
    // Route::resource('specializations', SpecializationController::class);
    // Replace the resource route with individual routes


    // Show the list of specializations (for doctors)
    Route::get('/specializations', [SpecializationController::class, 'index'])->name('specializations.index');

    // Show the details of a single specialization (for patients)
    Route::get('/specializations/{specialization}', [SpecializationController::class, 'show'])->name('specializations.show');

    // Create a new specialization (if needed, for admin or authorized users)
   // Route::get('/specializations/create', [SpecializationController::class, 'create'])->name('specializations.create');
   // Route::post('/specializations', [SpecializationController::class, 'store'])->name('specializations.store');

    // Edit an existing specialization (for admin or authorized users)
    Route::get('/specializations/{specialization}/edit', [SpecializationController::class, 'edit'])->name('specializations.edit');
    Route::put('/specializations/{specialization}', [SpecializationController::class, 'update'])->name('specializations.update');

    // Delete a specialization (for admin or authorized users)
    Route::delete('/specializations/{specialization}', [SpecializationController::class, 'destroy'])->name('specializations.destroy');

    //for displaying to patient 
    Route::get('/special/patient', [SpecializationController::class, 'display'])->name('specializations.patient');


    // Schedules resource routes
    Route::resource('schedules', ScheduleController::class);
    // Route::resource('appointments', controller: AppointmentController::class);

    Route::get('appointments', [AppointmentController::class, 'index'])->name('appointments.index'); // List all appointments
    Route::get('appointments/create/{id}', [AppointmentController::class, 'create'])->name('appointments.create'); // Show form for creating a new appointment
    Route::post('appointments', [AppointmentController::class, 'store'])->name('appointments.store'); // Save a new appointment
    Route::get('appointments/{appointment}', [AppointmentController::class, 'show'])->name('appointments.show'); // Show a single appointment
    Route::get('appointments/{id}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit'); // Show form to edit an appointment
    Route::put('appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update'); // Update an appointment
    Route::delete('appointments/{id}', [AppointmentController::class, 'destroy'])->name('appointments.destroy'); // Delete an appointment
    Route::get('appoint/patient', [AppointmentController::class, 'patientAppointments'])->name('appointments.patient');
    Route::get('appointdoctor/doctor', [AppointmentController::class, 'doctorAppointments'])->name('appointments.doctor');
    Route::post('appoint/status', [AppointmentController::class, 'statusAppointment'])->name('appointments.status');

    // Admin resource routes (you can add more resources if needed)

    Route::resource('admins', AdminController::class);
    Route::get('ad/patient', [AdminController::class, 'patient'])->name('admins.patient');
    Route::get('ad/doctor', [AdminController::class, 'doctor'])->name('admins.doctor');
    Route::get('ad/appointment', [AdminController::class, 'appointment'])->name('admins.appointment');
    Route::get('ad/specialization', [AdminController::class, 'specialization'])->name('admins.specialization');
    Route::get('ad/Specializationcreate',[SpecializationController::class, 'create'])->name('specializations.create');
    Route::post('ad/specializationstore',[SpecializationController::class, 'store'])->name('specializations.store');


});

require __DIR__ . '/auth.php';
