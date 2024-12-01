<?php

namespace App\Http\Controllers;

use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SpecializationController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $userId = $request->query('user');

        // Find the user or fail (throws 404 if not found)
        $user = User::findOrFail($userId);
    
        if (Auth::id() !== $user->id || $user->role !== 'doctor') {
            abort(403, 'Unauthorized access');
        }
        $specializations=Specialization::all();
        return view('specializations.index', compact('specializations'));
    }
    public function display()
    {
        $specializations=Specialization::all();
        return view('specializations.show', compact('specializations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('specializations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
 
        public function store(Request $request)
        {
            // Validate the input
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            // Create the specialization
            Specialization::create([
                'name' => $request->name,
            ]);
    
            // Redirect back to the list of specializations
            return redirect()->route('specializations.create');
        }
    
  

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
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
