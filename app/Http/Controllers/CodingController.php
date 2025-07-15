<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;

use App\Models\Question;

class CodingController extends Controller
{
    public function test(){

        $entries = Entry::where('user_id', 22)->get();
        $questions = Question::all();
        return view('codings.index', compact('entries','questions'));
    }
}
