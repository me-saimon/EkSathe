<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
{
    $request->validate([
        'full_name' => ['required', 'string', 'max:255'],
        'phone' => ['nullable', 'string', 'max:20'],
        'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        'is_volunteer' => ['nullable', 'boolean'],
    ]);

    $user = $request->user();

    $user->full_name = $request->full_name;
    $user->phone = $request->phone;

    // Handle Volunteer Toggle
    $user->is_volunteer = $request->has('is_volunteer') ? 1 : 0;

    // Handle Avatar Upload
    if ($request->hasFile('avatar')) {
        $path = $request->file('avatar')->store('avatars', 'public');
        $user->avatar = $path;
    }

    $user->save();

    return redirect()->route('profile.edit')->with('status', 'profile-updated');
}


public function donations()
{
    $donations = Auth::user()->donations()
        ->with('campaign')
        ->latest()
        ->paginate(10);

    $totalDonated = Auth::user()->donations()->where('status', 'verified')->sum('amount');

    return view('profile.donations', compact('donations', 'totalDonated'));
}



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
