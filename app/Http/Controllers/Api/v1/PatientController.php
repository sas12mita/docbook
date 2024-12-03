<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use AuthorizesRequests;
    public function index()
    {

        $patients = Patient::with('user')->get();
        if ($patients) {
            return response()->json([
                'success' => true,
                'data' => $patients,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No patients found',

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

    public function show($id)
    {
        // Find the patient by ID
        $patient = Patient::with('user')->find($id);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found',
            ], 404);
        }

        // Return patient details with related user data
        return response()->json([
            'success' => true,
            'patient' => $patient
        ], 200);
    }

    public function update(Request $request, $id)
            {
                $request->validate([
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'role' => 'nullable|string',
                    'address' => 'nullable|string',
                    'phone' => 'nullable|string',
                ]);
            
                $patient = Patient::find($id);
                $this->authorize('update', $patient);

                if (!$patient) {
                    return response()->json(['message' => 'Patient not found'], 404);
                }
            
                // Update the associated user's information
                $user = $patient->user;
                $user->name = $request->input('name');
                $user->email = $request->input('email');
                $user->role = $request->input('role');
                $user->address = $request->input('address');
                $user->phone = $request->input('phone');
                $user->save();
            
                return response()->json(['message' => 'Patient updated successfully', 'patient' => $patient], 200);
            }
 
         
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return response()->json([
                'success' => false,
                'message' => 'Patient not found',
            ], 404);
        }

        $patient->delete();

        return response()->json([
            'success' => true,
            'message' => 'Patient deleted successfully',
        ], 200);
    }
}
