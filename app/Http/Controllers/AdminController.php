<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admins.dashboard'); // This is the view for the admin panel's main page
    }

    // This method handles the custom route for the dashboard



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }
    public function patient(Request $request)
    {
        $patients = Patient::with('user')->get(); // Eager load the user relationship
        return view('admins.patient', compact('patients'));
    }
    public function doctor(Request $request)
    {

        $doctors = Doctor::with('user')->get(); // Eager load the user relationship
        return view('admins.doctor', compact('doctors'));
    }
    public function appointment(Request $request)
    {
        $appointments = Appointment::with(['doctor', 'patient'])->get();
        return view('admins.appointment', compact('appointments'));
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
