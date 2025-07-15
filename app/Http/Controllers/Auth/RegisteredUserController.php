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
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $questions = DB::table('security_questions')->get();
        return view('auth.register', compact('questions'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    /*public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }*/

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class], // Ensure unique username
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'security_question_1' => ['required', 'string'], // Validate security questions
            'security_answer_1' => ['required', 'string'],
            'security_question_2' => ['required', 'string'],
            'security_answer_2' => ['required', 'string'],
        ]);

        // Hash the answers to the security questions
        $security_question1 = [
            ['id' => $request->security_question_1, 'answer' => Hash::make($request->security_answer_1)]
        ];

        $security_question2 = [
            ['id' => $request->security_question_2, 'answer' => Hash::make($request->security_answer_2)]
        ];

        // Create the user with username and security questions
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username, // Store the username
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'squestion1' => json_encode($security_question1), // Store as JSON
            'squestion2' => json_encode($security_question2), // Store as JSON
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
