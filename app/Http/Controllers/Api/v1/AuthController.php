<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required'],
            'password' => ['required'],
           
        ]);
    
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'token_type'=>'Bearer' , 'message' => 'login successfully',], 200);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            'role' => ['required', 'in:admin,doctor,patient'], // Explicitly allow 'admin'
            'phone' => ['required', 'min:10', 'max:10'],
            'specialization_id' => ['required_if:role,doctor', 'exists:specializations,id'], // Required for doctors only
        ]);
    
        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
        ]);
    
        if ($user) {
            // Generate token for authentication
            $token = $user->createToken('auth_token')->plainTextToken;
    
            // Handle role-specific logic
            if ($request->role === 'doctor') {
                // Link doctor to a specialization
                $user->doctor()->create([
                    'specialization_id' => $request->specialization_id,
                ]);
    
                return response()->json([
                    'token' => $token,
                    'message' => 'Doctor registered successfully',
                ], 201);
    
            } elseif ($request->role === 'patient') {
                // Link patient to their profile
                $user->patient()->create();
    
                return response()->json([
                    'token' => $token,
                    'message' => 'Patient registered successfully',
                ], 201);
    
            } elseif ($request->role === 'admin') {
                // No additional fields required for admin registration
                return response()->json([
                    'token' => $token,
                    'message' => 'Admin registered successfully',
                ], 201);
            }
        }
    
        return response()->json(['message' => 'Registration failed'], 400);
    }
    

    public function profile(Request $request) {
       // dd($request->user());  // To see if the user is authenticated
        
        if ($request->user()) {
            return response()->json([
                'message' => 'Profile fetched',
                'data' => $request->user(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized user',
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        // Revoke the token for the currently authenticated user
        $request->user()->currentAccessToken()->delete();
    
        // Optionally, invalidate the session for web users
        // Auth::logout();  // Uncomment this line if using session-based login
    
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}
