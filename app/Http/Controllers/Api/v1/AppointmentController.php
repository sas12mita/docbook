<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Schedule;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use LDAP\Result;

class AppointmentController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $user=Auth::user();
        if($user->role==="patient")
        {
        $appointments = Appointment::with('doctor.specialization')
        ->where('patient_id', $user->patient->id)
        ->get();
        }elseif($user->role==="doctor")
        {
            $appointments = Appointment::with('doctor.specialization')->where('doctor_id',$user->doctor->id)->get();
        }
        elseif($user->role==="admin")
        {
            $appointments = Appointment::with('doctor.specialization');

        }else{
            return response()->json(['message'=>'You are not authorized to access this resource'],401);
        }
       
        $formattedAppointment = $appointments->map(function ($appointment) {
            return [
                'date' => $appointment->appointment_date,
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'doctor_name' => $appointment->doctor->user->name, // Accessing doctor's name
                'specialization' => $appointment->doctor->specialization->name ?? 'N/A', // Accessing specialization name

            ];
        });
        return response()->json([
            'success' => true,
            'data' => $formattedAppointment,
            'message' => 'Appointment with doctor and specialization details retrieved successfully.',
        ], 200);
    }
    public function store(Request $request)
    {

        $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
        $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');


        $user = Auth::user();
        $patient = $user->patient;
        $doctorSchedule = Schedule::where('doctor_id', $request->doctor_id)
            ->where('date', $request->appointment_date)
            ->where(function ($query) use ($start_time_24, $end_time_24) {

                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->first();

        if (!$doctorSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor does not have a schedule for the selected date and time.',
            ], 400);
        }

        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where(function ($query) use ($start_time_24, $end_time_24) {
                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->exists();

        // If there is a conflict, return error message
        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'The selected time slot is not available.',
            ], 400);
        }

        // Create the appointment if there are no conflicts
        $appointment = new Appointment();
        $appointment->patient_id = $patient->id;
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->start_time = $start_time_24;  // Store in 24-hour format
        $appointment->end_time = $end_time_24;      // Store in 24-hour format
        $appointment->save();

        return response()->json([
            'success' => true,
            'data' => $appointment,
            'message' => 'Appointment booked successfully.',
        ], 201);
    }


    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {

        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json([
                'success' => false,
                'message' => 'Appointment not found.',
            ], 404);
        }

        $this->authorize('update', $appointment);

        $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
        $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');


        $doctorSchedule = Schedule::where('doctor_id', $request->doctor_id)
            ->where('date', $request->appointment_date)
            ->where(function ($query) use ($start_time_24, $end_time_24) {
                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->first();

        if (!$doctorSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'The doctor does not have a schedule for the selected date and time.',
            ], 400);
        }

        // Check for conflicting appointments
        $conflict = Appointment::where('doctor_id', $request->doctor_id)
            ->where('appointment_date', $request->appointment_date)
            ->where('id', '!=', $appointment->id) // Exclude the current appointment from conflict check
            ->where(function ($query) use ($start_time_24, $end_time_24) {
                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'The selected time slot is not available.',
            ], 400);
        }

        // Update the appointment
        $appointment->doctor_id = $request->doctor_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->start_time = $start_time_24; // Store in 24-hour format
        $appointment->end_time = $end_time_24;    // Store in 24-hour format
        $appointment->save();

        return response()->json([
            'success' => true,
            'data' => $appointment,
            'message' => 'Appointment updated successfully.',
        ], 200);
    }

    public function destroy(string $id)
    {
        $appointment = Appointment::findOrFail($id);

        $this->authorize('delete', $appointment);

        $appointment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Appointment deleted successfully.',
        ], 200);
    }
    public function approveAppointment($id){
        $appointment= Appointment::findOrFail($id);

        $this->authorize('approve', $appointment);
        if(!$appointment)
        {
          return response()->json(['message'=>"no appointment found"]);
        }
        $appointment->status='approved';
        $appointment->save();
        return response()->json(['message'=>"Successfully approved status",'data'=>$appointment]);
    }
}
