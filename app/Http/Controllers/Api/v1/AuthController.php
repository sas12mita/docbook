<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    /**
   * User Login
    */
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
     /**
   * User Register
    */
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
            $token = $user->createToken('auth_token')->plainTextToken;
    
            if ($request->role === 'doctor') {
                $user->doctor()->create([
                    'specialization_id' => $request->specialization_id,
                ]);
    
                return response()->json([
                    'token' => $token,
                    'message' => 'Doctor registered successfully',
                ], 201);
    
            } elseif ($request->role === 'patient') {
  
                $user->patient()->create();
    
                return response()->json([
                    'token' => $token,
                    'message' => 'Patient registered successfully',
                ], 201);
    
            } elseif ($request->role === 'admin') {
                
                return response()->json([
                    'token' => $token,
                    'message' => 'Admin registered successfully',
                ], 201);
            }
        }
    
        return response()->json(['message' => 'Registration failed'], 400);
    }
     /**
   * View user Profile
    */
    public function profile(Request $request) {
        $user = Auth::user();
        if (Auth::check()) {
            return response()->json([
                'message' => 'Profile fetched',
                'data' => Auth::user(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Unauthorized user',
            ], 401);
        }
    }
     /**
   * User Logout
    */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logged out successfully',
        ], 200);
    }
}
