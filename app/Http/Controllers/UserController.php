<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\Obstacle;
use App\Models\Fuel;
use App\Models\Dform;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function index(){
        
        $users = User::all();
       
        return view('users.index', compact('users'));
    }

    public function edit($id){
        
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function destroy($id)
    {
        try {
            // Find the user by ID
            $user = User::findOrFail($id);
    
            // Delete the user
            $user->delete();
    
            // Redirect back with a success message
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (ModelNotFoundException $e) {
            // Redirect back with an error message if the user was not found
            return redirect()->route('users.index')->with('error', 'User not found.');
        } catch (\Exception $e) {
            // Redirect back with a generic error message for any other issues
            return redirect()->route('users.index')->with('error', 'An error occurred while trying to delete the user.');
        }
    }

    public function update(Request $request, $id)
{
    // Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255',
        'email' => 'nullable|email|max:255',
        'admin' => 'required|boolean',
        'password' => 'nullable|string|min:8', // Password
        'password_confirmation' => 'nullable|string|min:8', // Password confirmation
    ]);

    // Find the user
    $user = User::findOrFail($id);

    // Update user details
    $user->name = $request->input('name');
    $user->username = $request->input('username');
    $user->email = $request->input('email');
    $user->admin = $request->input('admin');

    // Check if password fields are not empty and match
    $password = $request->input('password');
    $passwordConfirmation = $request->input('password_confirmation');

    if (!empty($password) && !empty($passwordConfirmation)) {
        if ($password === $passwordConfirmation) {
            $user->password = Hash::make($password); // Hash and save the new password
        } else {
            return redirect()->back()->withErrors(['password' => 'Passwords do not match.']);
        }
    }

    // Save changes
    $user->save();

    return redirect()->route('users.index')->with('success', 'User updated successfully.');
}

    
}
