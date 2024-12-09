<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    use AuthorizesRequests;
    /**
     * View all admin user
     */
    public function index()
    {
        $admins = User::where('role', 'admin')->get();
        return response()->json([
            'success' => true,
            'admins' => $admins,
        ]);
    }
    /**
     * create new admin register
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
            'role' => ['required', 'in:admin,doctor,patient'], // Explicitly allow 'admin'
            'phone' => ['required', 'min:10', 'max:10'],
         ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
            'address'=>$request->address,
            'phone' => $request->phone,
        ]);

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;

        if ($request->role === 'admin') {

                return response()->json([
                    'token' => $token,
                    'message' => 'Admin registered successfully',
                ], 201);
            }
            else{
                return response()->json(['message'=>'Role must be admin'], 422);
            }
        }

        return response()->json(['message' => 'Registration failed'], 400);
    }


    /**
     * view user
     */
    

    /**
     * Update the specified admin in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $admin = User::findOrFail($id);
        $this->authorize('update',$admin);
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
        ]);

        $admin->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully',
            'data' => $admin,
        ]);
    }




    /**
     * Remove the specified admin from storage.
     */
    public function destroy(string $id)
    {
        $admin = User::findOrFail($id);
        $this->authorize('update',$admin);

        $admin->delete();
        return response()->json([
            'success' => true,
            'message' => 'admin deleted successfully',
        ]);
    }
}
