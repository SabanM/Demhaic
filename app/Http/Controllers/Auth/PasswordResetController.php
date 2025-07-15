<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SecurityQuestion;
use App\Http\Controllers\Controller;

class PasswordResetController extends Controller
{

    public function getSecurityQuestions(Request $request)
    {
        // Retrieve the username from the request input
        $username = $request->input('username');

        // Query the users table to check if the username exists
        $user = User::where('username', $username)->first();

        if ($user) {

            if($user->squestion1 && $user->squestion2){
                $sq1 =  json_decode($user->squestion1, true);
                $sq2 =  json_decode($user->squestion2, true);

                $question1 = SecurityQuestion::where('qid',ltrim($sq1[0]['id'],'q'))->pluck('question');
                $question2 = SecurityQuestion::where('qid',ltrim($sq2[0]['id'],'q'))->pluck('question');

                $question1= $question1[0];
                $question2= $question2[0];
                // If the user is found, return their security questions
                return view('auth.questions', compact('question1', 'question2','username'));
            }else{
                 return redirect()->back()->withErrors([
                    'username_not_found' => 'Username "'.$username.'" has no security questions, please contact the admin.'
            ]);
            }


        } else {
            // If the username is not found, return an error message
           /* return response()->json([
                'status' => 'error',
                'message' => 'Username not found'
            ], 404);*/
            return redirect()->back()->withErrors([
                'username_not_found' => 'Username "'.$username.'" not found in our database'
            ]);
        }
    }


    public function resetWithSecurityQuestions(Request $request)
    {
        // Validate the request inputs
        $request->validate([
            'username' => ['required'],
            'squestion1' => ['required'],
            'squestion2' => ['required'],
        ]);

        // Retrieve the user by their username
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['username' => __('The provided username does not exist.')]);
        }

        // Retrieve and decode the security questions from the user record
        $security_question1 = json_decode($user->squestion1, true);
        $security_question2 = json_decode($user->squestion2, true);
        //return  $user;
        // Verify the answers
        if (!Hash::check($request->squestion1, $security_question1[0]['answer']) || 
            !Hash::check($request->squestion2, $security_question2[0]['answer'])) {
            return back()->withErrors(['security_answer' => __('The provided security answers are incorrect.')]);
        }

        //$token = app('auth.password.broker')->createToken($user);

        // If security questions match, proceed to password reset form
        return view('auth.reset-password',  ['user' => $user]);
    }

    public function updateSecurityQuestions(Request $request)
    {
        // Validate the incoming request to ensure the password field is provided
        $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
          
        ]);

        $user = User::where('username', $request->username)->first();
        $user->password = Hash::make($request->password);
        $user->save();
       

        // Redirect to the intended route or fallback to the dashboard with a success message
        return redirect()->route('login')->with('status', __('Your password has been updated successfully.'));
    }
}

?>