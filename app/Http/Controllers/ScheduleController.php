<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Doctor;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Check if the logged-in user is an admin
        if (Auth::user()->is_admin) {
            // If admin, show all schedules
            $schedules = Schedule::all();
        } else {
            // If doctor, show only their own schedules
            $schedules = Schedule::where('user_id', Auth::id())->get();
        }

        // Return the view with the schedules
        return view('schedules.index', compact('schedules'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('schedules.create');
    }

    /**
     * Store a newly created resource in storage.
     */ public function store(Request $request)
    {
        // Check if the logged-in user is a doctor
        if (!Auth::user()->doctor) {
            return response()->json([
                'message' => 'You are not authorized to create schedules.',
            ], 403);
        }

        // Get the logged-in doctor's ID
        $doctorId = Auth::user()->doctor->id;

        // Validate the request
        $validated = $request->validate([
            'date' => 'required|date',
            function ($attribute, $start_time, $fail) {
                // Get the current time
                $currentTime = now()->format('H:i');

                // Compare the input start time with the current time
                if ($start_time < $currentTime) {
                    $fail('The ' . $attribute . ' must be a time after or equal to the current time.');
                }
            },
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'day' => 'required|string',
        ]);

        // Check for schedule conflicts
        $conflict = Schedule::where('doctor_id', $doctorId)
            ->where('date', $validated['date'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($query) use ($validated) {
                        $query->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'The selected time slot overlaps with an existing schedule.',
            ], 422);
        }

        // Create the schedule
        $schedule = Schedule::create([
            'doctor_id' => $doctorId,
            'date' => $validated['date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'day' => $validated['day'],
        ]);

        return view('doctors.dashboard');
    }

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // Find the schedule by ID
        $schedule = Schedule::findOrFail($id);

        // Pass the schedule to the edit view
        return view('schedules.edit', compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        // Validate the incoming request
        $request->validate([
            'day' => 'required|string|max:10',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ]);

        $schedule = Schedule::findOrFail($id);

        $schedule->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
