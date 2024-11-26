<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Doctor;
use App\Models\Specialization;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('doctors.dashboard');
    }
    public function home()
    {
        $doctors = Doctor::with('specialization', 'user')->get();
        return view('welcome', compact('doctors')); // Home page view
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $doctor = new Doctor();
        $doctor->user_id = Auth::id(); // Correct method to get authenticated user's ID
        $doctor->specialization_id = $request->specialization_id;
        $doctor->save();
        return view('doctors.dashboard');
    }
    public function showDoctors(Request $request)
    {
        $request->validate([
            'specialization_id' => 'required|exists:specializations,id',
        ]);
    
        $specialization = Specialization::find($request->specialization_id);
        $doctors = Doctor::where('specialization_id', $specialization->id)->get();
    
        return view('doctors.show', compact('doctors', 'specialization'));
    }

    public function getSchedule($doctorId)
{
    // Retrieve the doctor's schedule based on doctor ID
    $doctor = Doctor::find($doctorId);
    
    if (!$doctor) {
        return response()->json(['error' => 'Doctor not found'], 404);
    }

    $schedules = $doctor->schedules()->get(['date', 'start_time', 'end_time', 'day']);

    return response()->json(['schedules' => $schedules]);
}

    
    /**
     * Display the specified resource.
     */
   
    public function show(string $id)
    {
        return view('doctors.dashboard');
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
