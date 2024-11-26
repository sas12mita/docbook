<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('appointments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);
    
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();
    
        if ($conflict) {
            return back()->withErrors(['message' => 'The selected time slot is already taken.']);
        }
    
        Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => Auth::id(),
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
        ]);
    
        return redirect()->route('welcome')->with('success', 'Appointment booked successfully!');
    }
    


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    public function patientAppointments()
{
    // Get the authenticated user (patient)
    $patient = Auth::user();

    // Fetch appointments for the patient
    $appointments = Appointment::where('patient_id', $patient->id)
        ->with(['doctor.user']) // Eager load doctor details and their user information
        ->orderBy('appointment_date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();

    // Return a view to display the appointments
    return view('appointments.patient', compact('appointments'));
}public function doctorAppointments()
{
    // Get the authenticated doctor
    $doctor = Auth::user()->doctor;

    if (!$doctor) {
        abort(403, 'Access denied');
    }

    // Fetch appointments for the doctor
    $appointments = Appointment::where('doctor_id', $doctor->id)
        ->with('patient') // Eager load patient
        ->orderBy('appointment_date', 'asc')
        ->orderBy('start_time', 'asc')
        ->get();

    // Return a view to display the doctor's appointments
    return view('appointments.doctor', compact('appointments'));
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
