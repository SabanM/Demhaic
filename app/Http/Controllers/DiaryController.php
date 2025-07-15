<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Entry;
use App\Models\Dform;
use Illuminate\Support\Facades\Auth;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class DiaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $entries = Entry::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')
        ->whereHas('dform', function ($query) {
            $query->where('type', 'Diary');
        })
        ->get();
     
        $diaryForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Diary')->first() : null;
        if($diaryForm){
            $diaryFormQuestions = $diaryForm->questions()->get();
        }else{
            $diaryForm = Dform::where('type','Diary')->where('is_default', true)->first();
            $diaryFormQuestions = $diaryForm->questions()->get();

            DB::table('dform_user')->insert([
                'dform_id' => $diaryForm->id,
                'user_id' => Auth::user()->id,
            ]);

        }
       // return  $diaryFormQuestions;
    
        return view('diary.index', compact('entries', 'diaryForm', 'diaryFormQuestions'));
    
    }

    public function index_reflections()
    {
        
        $entries = Entry::where('user_id', Auth::user()->id)->orderBy('created_at','DESC')
        ->whereHas('dform', function ($query) {
            $query->where('type', 'Weekly');
        })
        ->get();
     
        $weeklyForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Weekly')->first() : null;
        if($weeklyForm){
            $weeklyFormQuestions = $weeklyForm->questions()->get();
        }else{
            $weeklyForm = Dform::where('type','Weekly')->where('is_default', true)->first();
            $weeklyFormQuestions = $weeklyForm->questions()->get();

            DB::table('dform_user')->insert([
                'dform_id' => $weeklyForm->id,
                'user_id' => Auth::user()->id,
            ]);

        }
       // return  $diaryFormQuestions;
    
        return view('reflections.index', compact('entries', 'weeklyForm', 'weeklyFormQuestions'));
    
    }

    public function update(Request $request, $id)
    {
        $entry = Entry::findOrFail($id);
    
        // Decode the existing entry details
        $existingDetails = json_decode($entry->entry, true);
    
        // Update details with the submitted data
        $updatedDetails = $request->input('details');
        foreach ($updatedDetails as $key => $value) {
            $existingDetails[$key] = $value;
        }
    
        // Save updated details back to the entry
        $entry->entry = json_encode($existingDetails);
        $entry->save();
    
        return redirect()->back()->with('message', 'Diary entry updated successfully.');
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Retrieve the entry by its ID
        $entry = Entry::find($id);
    
        // Return the view with the entry data
        return view('diary.edit', compact('entry'));
    }
    /**
     * Update the specified resource in storage.
     */
  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the diary entry by ID
        $entry = Entry::find($id);
    
        // Check if the entry exists
        if (!$entry) {
            return redirect()->back()->with('error', 'Entry not found.');
        }
    
        // Check if the user is authorized to delete this entry
        if ($entry->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'You are not authorized to delete this entry.');
        }
    
        // Delete the entry
        $entry->delete();
    
        // Redirect with success message
        return redirect()->back()->with('success', 'Entry deleted successfully.');
    }
    
}
