<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ConfirmablePasswordController extends Controller
{
    /**
     * Show the confirm password view.
     */
    public function show(): View
    {
        return view('auth.confirm-password');
    }

    /**
     * Confirm the user's password.
     */
    public function store(Request $request): RedirectResponse
    {
        // Validate the incoming request to ensure the password field is provided
        $request->validate([
            'password' => ['required'],
        ]);

        // Attempt to validate the user's credentials
        if (! Auth::guard('web')->validate([
            'username' => $request->user()->username, // Ensure the user's username is retrieved correctly
            'password' => $request->password,        // Check the provided password
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'), // Return a localized error message for invalid password
            ]);
        }

        // Store the password confirmation time in the session
        $request->session()->put('auth.password_confirmed_at', time());

        // Redirect to the intended route or fallback to the dashboard
        return redirect()->intended(route('dashboard'));
    }

}
