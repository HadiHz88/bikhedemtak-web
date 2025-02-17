<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate user attributes
        $userAttributes = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        // Create the user
        $user = User::create([
            'name' => $userAttributes['name'],
            'email' => $userAttributes['email'],
            'password' => bcrypt($userAttributes['password']), // Hash the password
        ]);

        // Log in the user
        Auth::login($user);

        // Redirect to homepage
        return redirect('/');
    }

    public function show()
    {
        $user = Auth::user();
        return view('profile.show', [
            'user' => $user,
        ]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(6)],
            'profile_pic' => ['nullable', 'image', 'max:1024'], // Ensure profile picture is optional
        ]);

        // Update user details
        $user->name = $request->name;
        $user->password = bcrypt($request->password);

        // Handle profile picture upload
        if ($request->hasFile('profile_pic')) {
            // Delete the old profile picture if it exists
            if ($user->profile_pic && Storage::disk('public')->exists($user->profile_pic)) {
                Storage::disk('public')->delete($user->profile_pic);
            }

            // Store the new profile picture in 'profile-pictures' directory on the 'public' disk
            $path = $request->file('profile_pic')->store('profile-pictures', 'public');
            $user->profile_pic = $path; // Store the path in the `profile_pic` column
        }

        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

}
