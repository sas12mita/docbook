<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ScheduleController extends Controller
{
    use AuthorizesRequests;
     /**
     * display all schedule
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === "admin" || $user->role === "patient") {
            $schedules = Schedule::with('doctor.specialization')->get();
        } elseif ($user->role === "doctor") {
            $schedules = Schedule::with('doctor.specialization')->where('doctor_id', $user->doctor->id)->get();
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $formattedSchedules = $schedules->map(function ($schedule) {
            return [
                'date' => $schedule->date,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'doctor_name' => $schedule->doctor->user->name, // Accessing doctor's name
                'specialization' => $schedule->doctor->specialization->name ?? 'N/A', // Accessing specialization name
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedSchedules,
            'message' => 'Schedules with doctor and specialization details retrieved successfully.',
        ], 200);
    }
     /**
     *   create schedule by doctor
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Check if the user is a doctor
        if (!$user->doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Only doctors can create schedules.',
            ], 403);
        }

        $doctorId = $user->doctor->id;

        // Validate request
        $request->validate([
            'date' => 'required|date',
            'day' => 'required|string',
            'start_time' => 'required|date_format:h:i A',
            'end_time' => 'required|date_format:h:i A',
            'status' => 'nullable|in:available,unavailable',
        ]);

        // Convert times to 24-hour format
        try {
            $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
            $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid time format. Use "h:i A" format (e.g., "7:00 AM").',
            ], 400);
        }

        // Check for overlapping schedules
        $overlappingSchedule = Schedule::where('doctor_id', $doctorId)
            ->where('date', $request->date)
            ->where(function ($query) use ($start_time_24, $end_time_24) {
                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->exists();

        if ($overlappingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'This schedule overlaps with an existing schedule.',
            ], 400);
        }

        // Create the schedule
        $schedule = new Schedule();
        $schedule->doctor_id = $doctorId;
        $schedule->date = $request->date;
        $schedule->start_time = $start_time_24;
        $schedule->end_time = $end_time_24;
        $schedule->day = $request->day;
        $schedule->status = $request->status ?? 'available';
        $schedule->save();

        return response()->json([
            'success' => true,
            'data' => $schedule,
            'message' => 'Schedule created successfully.',
        ], 201);
    }

 /**
     *   show specified schedule
     */
    public function show(string $id)
    {
        // Attempt to find the schedule by ID
        $schedule = Schedule::find($id);
    
        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found.',
            ], 404);
        }
    
        // Return the schedule data
        return response()->json([
            'success' => true,
            'data' => $schedule,
            'message' => 'Schedule retrieved successfully.',
        ], 200);
    }
    
 /**
     *   update specific schedule
     */
    public function update(Request $request, $id)
    {

        $schedule = Schedule::findOrFail($id);
        $this->authorize('update', $schedule);
        // Validate incoming request with AM/PM format
        $request->validate([
            'date' => 'required|date',
            'day' => 'required|string',
            'status' => 'nullable|in:available,unavailable',
        ]);

        // Check if the user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized, please login.',
            ], 401);
        }

        // Get the authenticated user
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();

        // Find the schedule to be updated
        $schedule = Schedule::findOrFail($id);
        $this->authorize('update', $schedule);

        // Check if the authenticated user is the doctor who owns this schedule
        if ($schedule->doctor_id !== $doctor->id) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this schedule.',
            ], 403);
        }

        // Check for overlapping schedules (same as store method)
        $overlappingSchedule = Schedule::where('doctor_id', $doctor->id)
            ->where('date', $request->date)
            ->where('id', '!=', $schedule->id)  // Exclude the current schedule from overlap check
            ->where(function ($query) use ($request) {
                // Convert 12-hour AM/PM time to 24-hour format for comparison
                $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
                $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');

                $query->whereBetween('start_time', [$start_time_24, $end_time_24])
                    ->orWhereBetween('end_time', [$start_time_24, $end_time_24])
                    ->orWhere(function ($query) use ($start_time_24, $end_time_24) {
                        $query->where('start_time', '<=', $start_time_24)
                            ->where('end_time', '>=', $end_time_24);
                    });
            })
            ->exists();

        if ($overlappingSchedule) {
            return response()->json([
                'success' => false,
                'message' => 'This schedule overlaps with an existing schedule.',
            ], 400);
        }

        // Convert the 12-hour AM/PM format to 24-hour format for storage
        $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
        $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');


        $schedule->date = $request->date;
        $schedule->start_time = $start_time_24;  // Store in 24-hour format
        $schedule->end_time = $end_time_24;      // Store in 24-hour format
        $schedule->day = $request->day;
        $schedule->status = $request->status ?? $schedule->status;  // Keep previous status if not provided
        $schedule->save();

        return response()->json([
            'success' => true,
            'data' => $schedule,
            'message' => 'Schedule updated successfully.',
        ], 200);
    }

    /**
     * Remove the specified Schedule from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::find($id);
        $this->authorize('delete', $schedule);
        if (!$schedule) {
            return response()->json(['message' => 'No schedule available'], 404);
        }
    

        $schedule->delete();

        return response()->json(['message' => 'Schedule deleted successfully'], 200);
    }
}
