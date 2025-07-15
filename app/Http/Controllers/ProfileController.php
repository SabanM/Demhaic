<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Entry;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $initialForm = Entry::where('user_id', Auth::user()->id)->whereHas('dform', function ($query) {
          //  $query->where('type', 'Initial');
        })->get();

        
        return view('profile.edit', [
            'user' => $request->user(),
            'initialForm' => $initialForm
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
    
        // Update user attributes from validated request data
        $user->fill($request->validated());
    
        // Explicitly update the username and email
        $user->username = $request->input('username');
        $user->email = $request->input('email');
    
        // If the email has been changed, mark it as unverified
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // Save the changes to the user
        $user->save();
    
        // Optionally send the verification email if email has been changed and is unverified
        if ($user->isDirty('email') && !$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }
    
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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
