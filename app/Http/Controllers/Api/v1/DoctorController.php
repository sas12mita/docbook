<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class DoctorController extends Controller
{
    use AuthorizesRequests;
    /**
     * view all doctor by admin
     */
    public function index()
    {
        $doctors = Doctor::with(['user', 'specialization'])->get();
        if ($doctors) {
            return response()->json([
                'success' => true,
                'data' => $doctors,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No doctors found',
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified doctor.
     */

    public function show($id)
    {
        // Find the doctor by ID, include related user and specialization data
        $doctor = Doctor::with(['user', 'specialization'])->find($id);

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor not found',
            ], 404);
        }

        // Return doctor details along with user and specialization data
        return response()->json([
            'success' => true,
            'doctor' => $doctor
        ], 200);
    }

    /**
     * Update the doctor resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'role' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:15',
            'specialization_id' => 'nullable|exists:specializations,id', // Ensure specialization exists
        ]);

        // Find the doctor by ID
        $doctor = Doctor::find($id);
        

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        // Authorization to ensure only authorized users can update
        $this->authorize('update', $doctor);

        // Update the associated user's information
        $user = $doctor->user;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->save();

        // Update the doctor's information (specialization)
        $doctor->specialization_id = $request->input('specialization_id');
        $doctor->save();

        return response()->json([
            'message' => 'Doctor updated successfully',
            'doctor' => $doctor->load('user'),
        ], 200);
    }

    /**
     * Remove the specified doctor from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return response()->json([
                'success' => false,
                'message' => 'Doctor not found',
            ], 404);
        }
        $doctor->delete();
        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully',
        ], 200);
    }
}
