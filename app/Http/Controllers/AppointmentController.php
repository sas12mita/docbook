<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Schedule;
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
    public function create(string $id)
{

    $doctor = Doctor::find($id);
    $appointments = Appointment::where('doctor_id', $doctor->id)->get();
    $schedule = Schedule::where('doctor_id', $doctor->id)->first();
    return view('appointments.create', compact('appointments', 'doctor', 'schedule'));
}

    /**
     * Store a newly created resource in storage.c
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $doctor_id = $request->doctor_id;
    
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']]);
            })
            ->exists();

    
        if ($conflict) {
            $appointments=Appointment::where('doctor_id',$validated['doctor_id']);
            return redirect()->route('appointments.create',$doctor_id)->withErrors([ 'The selected time is not available.']);

        }
    
        Appointment::create([
            'doctor_id' => $validated['doctor_id'],
            'patient_id' => Auth::id(),
            'appointment_date' => $validated['appointment_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'schedule_id'=>$request->schedule_id,
        ]);
        return view('patients.dashboard');
       }
    
    public function statusAppointment(Request $request)  {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
        ]);

        // Find the appointment by ID
        $appointment = Appointment::findOrFail($request->appointment_id);

        // Change the status to 'approved' or to a custom status
        $appointment->status = 'approved'; // Or 'pending', 'rejected', etc.
        $appointment->save();

        // Redirect back with a success message
        return redirect()->route('appointments.doctor')->with('success', 'Appointment status updated.');
    
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
}


public function doctorAppointments()
{
    {
        $doctor =Doctor::where('user_id',Auth::user()->id)->first();
        $appointmentsdoctor = Appointment::with('patient')
            ->where('doctor_id', $doctor->id) // Adjust for your doctor authentication
            ->get();
    
        return view('appointments.doctor', compact('appointmentsdoctor'));
    }
    
}



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
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
        $appointment = Appointment::find($id);

        // Check if the appointment exists
        if (!$appointment) {
            return redirect()->back()->with('error', 'Appointment not found.');
        }
    
        // Delete the appointment
        $appointment->delete();
    
        // Redirect with a success message
        return redirect()->route('appointments.patient')->with('success', 'Appointment deleted successfully.');
    
    }
}
