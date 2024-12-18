<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use app\Models\Appointment;
use Illuminate\Http\Request;
use App\Models\Patient;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {           
        $user = Auth::user();
        // Pass the user and recent appointments to the view
        return view('patients.dashboard', compact('user'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }
    public function dashboard()
     {
    //  $user = Auth::user();
    // // Use compact to pass the data to the view
    //      return view('patients.dashboard', compact('user'));
    return "hey";
    
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $patient = Patient::find($id);

        if (!$patient) {
            return redirect()->back()->with('error', 'Patient not found.');
        }

        // Delete the patient
        $patient->delete();

        // Redirect with a success message
        return redirect()->route('admins.patient')->with('success', 'Patient deleted successfully.');
   
    }
}
