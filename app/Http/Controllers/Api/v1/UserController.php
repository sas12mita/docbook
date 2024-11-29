<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
     $users=User::query()->get();
     return response()->json(
        [
            'message'=>'Fetehed Successfully',
            'data'=>$users,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
   
     public function store(Request $request)
     {
         // Validate the input
         $validatedData = $request->validate([
             'name' => ['required', 'string', 'max:255'],
             'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
             'password' => ['required', 'confirmed', Rules\Password::defaults()],
             'role' => ['required', 'in:doctor,patient'],
             'phone' => ['required', 'digits:10'],
             'address' => ['nullable', 'string'],
         ]);
     
         // Create the user
         $user = User::create([
             'name' => $validatedData['name'],
             'email' => $validatedData['email'],
             'password' => Hash::make($validatedData['password']),
             'role' => $validatedData['role'],
             'address' => $validatedData['address'] ?? null,
             'phone' => $validatedData['phone'],
         ]);
     
         // Trigger the Registered event
         event(new Registered($user));
     
         // Role-based logic
         if ($validatedData['role'] === 'patient') {
             Patient::create(['user_id' => $user->id]);
         } elseif ($validatedData['role'] === 'doctor') {
             // Add specialization logic here if necessary
         }
     
         // Generate a Sanctum token for the new user
         $token = $user->createToken('API Token')->plainTextToken;
     
         // Return a JSON response
         return response()->json([
             'message' => 'User registered successfully.',
             'user' => $user,
             'token' => $token,
         ], 201);
     }
     

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
