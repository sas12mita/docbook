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
    public function index()
    {
        $schedules = Schedule::with('doctor.specialization')->get();
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
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:h:i A',  // Accepts 12-hour format with AM/PM
            'end_time' => 'required|date_format:h:i A|after:start_time',  // Accepts 12-hour format with AM/PM
            'day' => 'required|string',
            'status' => 'nullable|in:available,unavailable',
        ]);
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized, please login.',
            ], 401);
        }
        $user = Auth::user();
        $doctor = Doctor::where('user_id', $user->id)->first();
        $this->authorize('update', $doctor);

        $overlappingSchedule = Schedule::where('doctor_id', $doctor->id)
            ->where('date', $request->date)
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

        // Convert the 12-hour AM/PM format to 24-hour format
        $start_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->start_time)->format('H:i');
        $end_time_24 = \Carbon\Carbon::createFromFormat('h:i A', $request->end_time)->format('H:i');

        
        $schedule = new Schedule();
        $schedule->doctor_id = $doctor->id; // Assign the authenticated doctor's ID
        $schedule->date = $request->date;
        $schedule->start_time = $start_time_24;  // Store in 24-hour format
        $schedule->end_time = $end_time_24;      // Store in 24-hour format
        $schedule->day = $request->day;
        $schedule->status = $request->status ?? 'available';
        $schedule->save();

        return response()->json([
            'success' => true,
            'data' => $schedule,
            'message' => 'Schedule created successfully.',
        ], 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, $id)
    {

        $schedule = Schedule::findOrFail($id);
        $this->authorize('update', $schedule);
        // Validate incoming request with AM/PM format
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:h:i A',  // Accepts 12-hour format with AM/PM
            'end_time' => 'required|date_format:h:i A|after:start_time',  // Accepts 12-hour format with AM/PM
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::find($id);
    
        if (!$schedule) {
            return response()->json(['message' => 'No schedule available'], 404);
        }
        $this->authorize('delete', $schedule);
    
        $schedule->delete();
    
        return response()->json(['message' => 'Schedule deleted successfully'], 200);
    }
    
}
