<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\Patient;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:doctor,patient'], // Ensure the role is either 'doctor' or 'patient'
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role, // Assuming `role` is a column in the `users` table
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        // Trigger the Registered event
        event(new Registered($user));

        // Log the user in
        Auth::login($user);

        if ($request->role === 'patient') {
            Patient::create([
                'user_id' => $user->id,
            ]);
            return redirect()->route('patients.index');
        }
        elseif ($request->role === 'doctor') {
            // Redirect to the doctor's specification page
            return redirect(route('specializations.index', ['user' => $user->id]));
        }
        else{
            return redirect()->route('admin.dashboard');
  
        }

        // Default redirect (fallback)
       // return redirect(route('dashboard'));
    }
}
// }
