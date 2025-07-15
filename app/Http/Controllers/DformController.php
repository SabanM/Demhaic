<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dform;
use App\Models\User;
use App\Models\Entry;
use App\Models\Factor;
use App\Models\Question;
use App\Models\Identifier;
use App\Exports\EntriesExport;
use Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Excel as ExcelFormat;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use App\Jobs\GenerateInsights;


use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class DformController extends Controller
{
    public function index()
    {

            URL::forceRootUrl('https://det.gsic.uva.es'); // Ensure Laravel always uses correct base
        Paginator::currentPathResolver(function () {
            return 'https://det.gsic.uva.es' . request()->getPathInfo();
        });

        $users = User::where('admin',0)->get();
        $dforms = Dform::with('users')->paginate(10); // 
        $identifiers = Identifier::all(); 
        $factors = Factor::all();
        return view('forms.index', compact('dforms','users','factors','identifiers'));
    }

    public function initialForm(){
        return "ok";
    }

    public function edit($id)
    {
        $form = Dform::findOrFail($id);
        $dforms = Dform::with('users')->get();
        $factors = Factor::all(); 
        $identifiers = Identifier::all(); 

        return view('forms.edit', compact('form', 'dforms','factors','identifiers')); // A view to edit the form
    }

    public function destroy($id)
    {
        // Find the form or fail
        $form = Dform::findOrFail($id);
    
        // Detach related questions from the pivot table
        $questionIds = $form->questions()->pluck('questions.id')->toArray(); // Get associated question IDs
        $form->questions()->detach();
    
        // Check and delete questions only if they are not linked to other dforms
        foreach ($questionIds as $questionId) {
            $isLinkedToOtherForms = DB::table('dform_questions')->where('question_id', $questionId)->exists();
            if (!$isLinkedToOtherForms) {
                Question::findOrFail($questionId)->delete(); // Delete question if no other links
            }
        }
    
        // Delete the form
        $form->delete();
    
        return redirect()->route('forms.index')->with('success', 'Form deleted successfully.');
    }
    

    /**public function create(Request $request)
    {

        // Validate the incoming request
        $validatedData = $request->validate([
            'formName' => 'required|string|max:255',
            'formType' => 'required|string|max:255',
            'questions' => 'required|array|min:1',
            'questions.*' => 'required|string|max:255',
            'placeholders' => 'array|nullable',
            'placeholders.*' => 'nullable|string|max:255',
            'questionTypes' => 'required|array|min:1',
            'questionTypes.*' => 'required|string|in:number,yes_no,text,scale,large_text,checkboxes,multiple_choice',
            'scales' => 'array|nullable',
            'scales.*' => 'nullable|integer',
            'scalemins' => 'array|nullable',
            'scalemins.*' => 'nullable|string|max:255',
            'scalemaxs' => 'array|nullable',
            'scalemaxs.*' => 'nullable|string|max:255',
            'rows' => 'array|nullable',
            'rows.*' => 'nullable|integer',
            'radio' => 'array|nullable', // Handle multiple choice options
            'checkbox' => 'array|nullable', // Handle multiple choice options
        
        ]);

        // Create the form
        $dform = new Dform();
        $dform->name = $validatedData['formName'];
        $dform->type = $validatedData['formType'];
        $dform->user_id = Auth::user()->id; 
        $dform->save();

        $totalQuestions = count($validatedData['questions']);
        $scaleIndex = 0;
        $placeholderIndex = 0;
        $rowIndex = 0;

        for ($i = 0; $i < $totalQuestions; $i++) {
            $question = new Question();
            $question->question = $validatedData['questions'][$i];
            $question->type = $validatedData['questionTypes'][$i];

            // Only set placeholder if the question type supports it
            if (!in_array($question->type, ['checkboxes', 'multiple_choice', 'yes_no', 'scale'])) {
                $question->placeholder = $validatedData['placeholders'][$placeholderIndex] ?? null;
                $placeholderIndex++;
            } else {
                $question->placeholder = null;
            }

            // Handle scale-specific fields
            if ($question->type === 'scale') {
                $question->scale = $validatedData['scales'][$scaleIndex] ?? null;
                $question->scalemin = $validatedData['scalemins'][$scaleIndex] ?? null;
                $question->scalemax = $validatedData['scalemaxs'][$scaleIndex] ?? null;
                $scaleIndex++;
            } else {
                $question->scale = null;
                $question->scalemin = null;
                $question->scalemax = null;
            }

            if ($question->type === 'scale') {
                $question->rows = $validatedData['rows'][$rowIndex] ?? null;
                $rowIndex++;
            }
            else {
                $question->rows = null;
            }
        
        
            // Handle multiple choice or checkbox options checkboxes
            if (in_array($question->type, ['multiple_choice'])) {
                $optionsKey = $question->type; // Either 'multiple_choice' or 'checkboxes'
                $question->options = $validatedData['radio'] ?? []; // Store the options as an array
            }
            else if (in_array($question->type, ['checkboxes'])) {
                $optionsKey = $question->type; // Either 'multiple_choice' or 'checkboxes'
                $question->options = $validatedData['checkbox'] ?? []; // Store the options as an array
            }
            else {
                $question->options = null; // Ensure no options for other types
            }

            // Save the question
            $question->save();
            $dform->questions()->attach($question->id);

        }

        return redirect()->route('forms.index')->with('success', 'Form created successfully!');
    }*/

    public function createw(Request $request)
    {

       
        return $request;
    }

    public function create(Request $request)
    {
        // Create the form record
        $dform = new Dform();
        $dform->name = $request->input('formName');
        $dform->type = $request->input('formType');
        $dform->user_id = Auth::user()->id;
        $dform->save();

        // Extract input arrays with fallback empty arrays
        $questions      = $request->input('questions', []);
        $questionTypes  = $request->input('questionTypes', []);
        $placeholders   = $request->input('placeholders', []);
        $scales         = $request->input('scales', []);
        $scalemins      = $request->input('scalemins', []);
        $scalemaxs      = $request->input('scalemaxs', []);
        $rows           = $request->input('rows', []);
        $radioOptions   = $request->input('radio', []);
        $checkboxOptions= $request->input('checkbox', []);

        $selectedFactorName = $request->input('factor'); // e.g., "Motivation"
        $selectedFactor = Factor::where('name', $selectedFactorName)->first();
    
        // Counters for inputs that do not apply to every question
        $placeholderIndex = 0;
        $scaleIndex       = 0;
        $rowIndex         = 0;
    
        // Loop through each question
        foreach ($questions as $i => $qText) {

            $question = new Question();
            $question->question = $qText;
            $type = $questionTypes[$i] ?? null;
            $question->type = $type;
    
            // Set placeholder if applicable (skipping types that handle their own options)
            if (!in_array($type, ['checkboxes', 'multiple_choice', 'yes_no', 'scale'])) {
                $question->placeholder = $placeholders[$placeholderIndex] ?? null;
                $placeholderIndex++;
            } else {
                $question->placeholder = null;
            }
    
            // Process scale-specific fields
            if ($type === 'scale') {
                $question->scale    = $scales[$scaleIndex] ?? null;
                $question->scalemin = $scalemins[$scaleIndex] ?? null;
                $question->scalemax = $scalemaxs[$scaleIndex] ?? null;
                $scaleIndex++;
            } else {
                $question->scale = $question->scalemin = $question->scalemax = null;
            }
    
            // Process rows for large_text type
            if ($type === 'large_text') {
                $question->rows = $rows[$rowIndex] ?? null;
                $rowIndex++;
            } else {
                $question->rows = null;
            }
    
            // Handle options for multiple_choice and checkboxes.
            // Note: The key for the options arrays is based on the question number (i+1) since your view names them using that index.
            if ($type === 'multiple_choice') {
                $question->options = $radioOptions[$i + 1] ?? [];
            } elseif ($type === 'checkboxes') {
                $question->options = $checkboxOptions[$i + 1] ?? [];
            } else {
                $question->options = null;
            }
    
            // Save the question and attach it to the form
            $question->save();
            $dform->questions()->attach($question->id);
            if ($selectedFactor) {
                $question->factors()->attach($selectedFactor->id);
            }
        }
    
        return redirect()->route('forms.index')->with('success', 'Form created successfully!');
    }
    
    public function update(Request $request, $form)
    {
        // Retrieve and update the form record
        $dform = Dform::findOrFail($form);
        $dform->name = $request->input('formName');
        $dform->type = $request->input('formType');
        $dform->user_id = Auth::user()->id;
        $dform->save();

        $dform->questions()->detach();

        // Extract input arrays with fallback empty arrays
        $questions        = $request->input('questions', []);
        $questionTypes    = $request->input('questionTypes', []);
        $placeholders     = $request->input('placeholders', []);
        $scales           = $request->input('scales', []);
        $scalemins        = $request->input('scalemins', []);
        $scalemaxs        = $request->input('scalemaxs', []);
        $rows             = $request->input('rows', []);
        $radioOptions     = $request->input('radio', []);
        $checkboxOptions  = $request->input('checkbox', []);
        $selectedFactors  = $request->input('factors', []);



        $placeholderIndex = 0;
        $scaleIndex       = 0;
        $rowIndex         = 0;

        foreach ($questions as $i => $qText) {
            // Try to find the question first, or create a new instance
            $question = Question::where('question', $qText)->first();

            if (!$question) {
                $question = new Question();
            }

            $question->question = $qText;
            $type = $questionTypes[$i] ?? null;
            $question->type = $type;

            // Set placeholder if applicable
            if (!in_array($type, ['checkboxes', 'multiple_choice', 'yes_no', 'scale'])) {
                $question->placeholder = $placeholders[$placeholderIndex] ?? null;
                $placeholderIndex++;
            } else {
                $question->placeholder = null;
            }

            // Process scale-specific fields
            if ($type === 'scale') {
                $question->scale    = $scales[$scaleIndex] ?? null;
                $question->scalemin = $scalemins[$scaleIndex] ?? null;
                $question->scalemax = $scalemaxs[$scaleIndex] ?? null;
                $scaleIndex++;
            } else {
                $question->scale = $question->scalemin = $question->scalemax = null;
            }

            // Process rows for large_text type
            if ($type === 'large_text') {
                $question->rows = $rows[$rowIndex] ?? null;
                $rowIndex++;
            } else {
                $question->rows = null;
            }

            // Handle options for multiple_choice and checkboxes using (i+1) as the key
            if ($type === 'multiple_choice') {
                $question->options = $radioOptions[$i + 1] ?? [];
            } elseif ($type === 'checkboxes') {
                $question->options = $checkboxOptions[$i + 1] ?? [];
            } else {
                $question->options = null;
            }

            // Save the question (new or updated)
            $question->save();

            // Attach factor if not already linked
            $selectedFactor = Factor::where('name', $selectedFactors[$i])->first();
            if ($selectedFactor && !$question->factors->contains($selectedFactor->id)) {
                $question->factors()->attach($selectedFactor->id);
            }

            // Attach to the form if not already attached
            if (!$dform->questions->contains($question->id)) {
                $dform->questions()->attach($question->id);
            }
        }

        return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
    }

    public function update100(Request $request, $form)
    {

        // Retrieve and update the form record
        $dform = Dform::findOrFail($form);
        $dform->name = $request->input('formName');
        $dform->type = $request->input('formType');
        $dform->user_id = Auth::user()->id;
        $dform->save();

       
      
    
        // Detach the form's current questions and delete any that are no longer used elsewhere
        $questionIds = $dform->questions()->pluck('questions.id')->toArray();
        $dform->questions()->detach();
    
        foreach ($questionIds as $questionId) {
            $isLinkedToOtherForms = DB::table('dform_questions')->where('question_id', $questionId)->exists();
            if (!$isLinkedToOtherForms) {
                Question::findOrFail($questionId)->delete();
            }
        }
    
        // Extract input arrays with fallback empty arrays
        $questions      = $request->input('questions', []);
        $questionTypes  = $request->input('questionTypes', []);
        $placeholders   = $request->input('placeholders', []);
        $scales         = $request->input('scales', []);
        $scalemins      = $request->input('scalemins', []);
        $scalemaxs      = $request->input('scalemaxs', []);
        $rows           = $request->input('rows', []);
        $radioOptions   = $request->input('radio', []);
        $checkboxOptions= $request->input('checkbox', []);
        $selectedFactors = $request->input('factors', []);
    
        $placeholderIndex = 0;
        $scaleIndex       = 0;
        $rowIndex         = 0;
    
        // Recreate the questions for the updated form
        foreach ($questions as $i => $qText) {
            $question = Question::where('question',$qText)->first();
            
            $question->question = $qText;
            $type = $questionTypes[$i] ?? null;
            $question->type = $type;
    
            // Set placeholder if applicable
            if (!in_array($type, ['checkboxes', 'multiple_choice', 'yes_no', 'scale'])) {
                $question->placeholder = $placeholders[$placeholderIndex] ?? null;
                $placeholderIndex++;
            } else {
                $question->placeholder = null;
            }
    
            // Process scale-specific fields
            if ($type === 'scale') {
                $question->scale    = $scales[$scaleIndex] ?? null;
                $question->scalemin = $scalemins[$scaleIndex] ?? null;
                $question->scalemax = $scalemaxs[$scaleIndex] ?? null;
                $scaleIndex++;
            } else {
                $question->scale = $question->scalemin = $question->scalemax = null;
            }
    
            // Process rows for large_text type
            if ($type === 'large_text') {
                $question->rows = $rows[$rowIndex] ?? null;
                $rowIndex++;
            } else {
                $question->rows = null;
            }
    
            // Handle options for multiple_choice and checkboxes using (i+1) as the key
            if ($type === 'multiple_choice') {
                $question->options = $radioOptions[$i + 1] ?? [];
            } elseif ($type === 'checkboxes') {
                $question->options = $checkboxOptions[$i + 1] ?? [];
            } else {
                $question->options = null;
            }
    
            // Save the new question and attach it to the form
            $question->save();

            $selectedFactor = Factor::where('name', $selectedFactors[$i])->first();
            if ($selectedFactor) {
                $question->factors()->attach($selectedFactor->id);
            }

           if (!$dform->questions->contains($question->id)) {
                $dform->questions()->attach($question->id);
            }

            
        }
    
        return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
    }
    

    public function update2(Request $request, $form)
    {

        // Create the form
        $dform = Dform::findOrFail($form);
        $dform->name = $validatedData['formName'];
        $dform->type = $validatedData['formType'];
        $dform->user_id = Auth::user()->id; 
        $dform->save();

        $questionIds = $dform->questions()->pluck('questions.id')->toArray(); // Get associated question IDs
        $dform->questions()->detach();
    
        // Check and delete questions only if they are not linked to other dforms
        foreach ($questionIds as $questionId) {
            $isLinkedToOtherForms = DB::table('dform_questions')->where('question_id', $questionId)->exists();
            if (!$isLinkedToOtherForms) {
                Question::findOrFail($questionId)->delete(); // Delete question if no other links
            }
        }

        $totalQuestions = count($validatedData['questions']);
        $scaleIndex = 0;
        $placeholderIndex = 0;
        $rowIndex = 0;

        for ($i = 0; $i < $totalQuestions; $i++) {
            $question = new Question();
            $question->question = $validatedData['questions'][$i];
            $question->type = $validatedData['questionTypes'][$i];

            // Only set placeholder if the question type supports it
            if (!in_array($question->type, ['checkboxes', 'multiple_choice', 'yes_no', 'scale'])) {
                $question->placeholder = $validatedData['placeholders'][$placeholderIndex] ?? null;
                $placeholderIndex++;
            } else {
                $question->placeholder = null;
            }

            // Handle scale-specific fields
            if ($question->type === 'scale') {
                $question->scale = $validatedData['scales'][$scaleIndex] ?? null;
                $question->scalemin = $validatedData['scalemins'][$scaleIndex] ?? null;
                $question->scalemax = $validatedData['scalemaxs'][$scaleIndex] ?? null;
                $scaleIndex++;
            } else {
                $question->scale = null;
                $question->scalemin = null;
                $question->scalemax = null;
            }

            if ($question->type === 'scale') {
                $question->rows = $validatedData['rows'][$rowIndex] ?? null;
                $rowIndex++;
            }
            else {
                $question->rows = null;
            }
        
        
            // Handle multiple choice or checkbox options checkboxes
            if (in_array($question->type, ['multiple_choice'])) {
                $optionsKey = $question->type; // Either 'multiple_choice' or 'checkboxes'
                $question->options = $validatedData['radio'] ?? []; // Store the options as an array
            }
            else if (in_array($question->type, ['checkboxes'])) {
                $optionsKey = $question->type; // Either 'multiple_choice' or 'checkboxes'
                $question->options = $validatedData['checkbox'] ?? []; // Store the options as an array
            }
            else {
                $question->options = null; // Ensure no options for other types
            }

            // Save the question
            $question->save();
            $dform->questions()->attach($question->id);

        }

      

        return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
    }




    public function duplicate($form)
    {
        // Find the original form
        $form = Dform::findOrFail($form);
    
        // Create a new form based on the original one (without questions)
        $newForm =  $dform = new Dform();
        $newForm->name = $form->name. ' (Copy)';
        $newForm->type = $form->type;
        $dform->user_id = Auth::user()->id; 
        $newForm->save(); 
    
        // Get associated questions for the original form
        $questions = $form->questions; // Assuming `questions()` is a relationship method
        
        // Copy each question to the new form
        foreach ($questions as $question) {
            $newQuestion = new Question;
         
            $newQuestion->question = $question->question;
            $newQuestion->type = $question->type;
            $newQuestion->scale =  $question->scale;
            $newQuestion->rows = $question->rows;
            $newQuestion->placeholder =  $question->placeholder; 
            $newQuestion->scalemax =  $question->scalemax;
            $newQuestion->scalemin =  $question->scalemin;
            $newQuestion->options = $question->options;
            $newQuestion->save();

            $newForm->questions()->attach($newQuestion->id);
            
        }
    
        // Redirect to the forms index with a success message
        return redirect()->route('forms.index')->with('success', 'Form duplicated successfully!');
    }


   

    public function attachUser(Request $request, $formId, $userId)
{
    $form = Dform::findOrFail($formId);
    $user = User::findOrFail($userId);

    // Check if this specific form is already attached to the user
    $attached = $form->users()->where('user_id', $userId)->exists();

    if ($attached) {
        $form->users()->detach($userId);
        return response()->json([
            'message' => 'User detached successfully',
            'attached' => false
        ]);
    }

    // Check if user has another form of the same type
    $existingForm = $user->dforms()->where('type', $form->type)->first();
    if ($existingForm) {
        $existingForm->users()->detach($userId);
    }

    // Now attach the new form
    try {
        $form->users()->attach($userId);
        return response()->json([
            'message' => 'User attached successfully',
            'attached' => true
        ]);
    } catch (\Illuminate\Database\QueryException $e) {
        return response()->json([
            'message' => 'Failed to attach user: ' . $e->getMessage(),
            'attached' => false
        ], 500);
    }
}

    public function makeDefault($id)
    {
    

        // Retrieve the form to make default
        $form = Dform::findOrFail($id);

        // Check the type of the form
        $formType = $form->type;

        // Remove 'is_default' from the current default form(s) with the same type
        Dform::where('type', $formType)->where('is_default', true)->update(['is_default' => false]);

        // Set the new form as default
        $form->is_default = true;

        // Save the updated form
        if ($form->save()) {
            return response()->json(['success' => true, 'message' => 'Form set as default successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to set form as default.'], 500);
        }
    }

    public function store(Request $request)
    {

        // Validate the request
        $validatedData = $request->validate([
            'dformId'   => 'required|exists:dforms,id', // Ensure the form exists
            'responses' => 'required|array',           // Ensure responses are provided as an array
        ]);

        // Create and save the new entry
        $entry = new Entry();
        $entry->dform_id = $validatedData['dformId'];
        $entry->user_id  = Auth::id(); // Associate entry with the logged-in user
        $entry->entry    = json_encode($validatedData['responses']); // Store responses as JSON
        $entry->save();

        // Update the pivot table to mark the form as completed for the current user
        DB::table('dform_user')
            ->where('dform_id', $validatedData['dformId'])
            ->where('user_id', Auth::id())
            ->update(['completed' => true]);



        GenerateInsights::dispatch(Auth::id());
        // Return success response as JSON
        return response()->json([
            'status'   => 'success',
            'message'  => 'Entry saved successfully!',
            'entry_id' => $entry->id,
        ]);
    }

     

    public function generateSummary($summaries)
    {
        // Combine the summaries using "==== " as the delimiter.
        $summariesText = implode('==== ', $summaries);
        
        // Build the prompt by concatenating strings.
        $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below are the interpretations of a series of diagrams and models of a doctoral student's daily satisfaction with their own progress.\n" .
                  "Task: Please provide a summary of these insights in the form of 2-3 bullet points. Choose a few of the more coherent and interesting insights from the original material, rather than trying to summarize them all. End each bullet point with a short question about how the insight can be used to improve the student's progress in the future.\n" .
                  "Style:\n" .
                  "Talk directly to 'you' (use second person singular) with personalized, brief insights. Use a measured tone; don't use extreme, exaggerated, or overblown expressions.\n" .
                  "Exemplify with specific split values ('threshold') and progress scores ('value'), but don't include technical details or mention models. Don't include any introductory sentence; go directly to the bullet points.\n" .
                  "Talk specifically about \"satisfaction with progress\"; don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n" .
                  "Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n" .
                  "Output language: American English\n" .
                  "Text to summarize, each graph/model separated by \"====\":\n" .
                  $summariesText;
        
        // Prepare the data for the API request.
        $data = [
            'model'  => 'llama3.2',
            'prompt' => $prompt,
            'stream' => false,
        ];
        
        // External API endpoint.
        $url = 'http://ares.gsic.uva.es:11434/api/generate';
        
        // Make the API request.
        $response = Http::post($url, $data);
        
        // Check if the response was successful.
        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json([
                'response' => $responseData['response'] ?? null,
            ]);
        } else {
            return response()->json([
                'error'   => 'Invalid response from API.',
                'details' => $response->body(),
            ], 500);
        }
    }

    public function generateResponse2($typeChart, $chart)
    {
        // Retrieve the chart data from the incoming JSON payload

        // Convert the chart data to a JSON string
        $chartJson = json_encode($chart);
        
        switch ($typeChart) {
            case 'daily_progress':
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a time series plot (with overall linear trend) for a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific dates and data points or values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'factor_predictors':
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing the predictors in a linear model of a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling. Predictors range from the number of hours slept or spent working on thesis and non-thesis work, to subjective scores of how much emotions or anxiety interfered with the student's activities (a positive coefficient means that paradoxically more progress is perceived when more interference is experienced).\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Focus especially on the significant predictors (those with the errors NOT crossing the zero) and on those with larger coefficients. If no predictor is significant, make the first bullet-point insight about this (the fact that the model is still not stable or clear due to a lack of data points).\n
                        End the synthesis with an open question to help the doctoral student reflect on these predictors and their positive/negative values, why they may be so, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret these insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'weekly_progress':
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing the data points for a boxplot for a doctoral student's daily satisfaction with their progress (especially, on their thesis), by week, as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Consider both the average and the spread of the weeks in the insights.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific weeks and average/spread, but don't use specific average/spread values or technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'regression_tree':
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a regression tree model of a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling. Predictors range from the number of hours slept or spent working on thesis and non-thesis work, to subjective scores of how much emotions or anxiety interfered with the student's activities (a positive relationship means that paradoxically more progress is perceived when more interference is experienced). 'Left' branches are those with predictor values less than or equal to the 'threshold' in the concerning variable. 'Right' branches have predictor values higher than the 'threshold' in each split.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Focus especially on the most important predictors (non-leaf nodes higher in the tree) and on explaining the splits/branches ('threshold') leading to the leaf nodes with best and worst progress scores ('value').\n
                        End the synthesis with an open question to help the doctoral student reflect on these predictors and their positive/negative values, why they may be so, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret these insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific split values ('threshold') and progress scores ('value'), but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            default:
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a time series plot (with overall linear trend) for a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific dates and data points or values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
        }
        
        // Prepare the data for the API request
        $data = [
            'model'  => 'llama3.2',
            'prompt' => $prompt,
            'stream' => false,
        ];
        
        // External API endpoint
        $url = 'http://ares.gsic.uva.es:11434/api/generate';
        
        // Make the API request
        $response = Http::post($url, $data);
        
        // Check if the response was successful
        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json([
                'response' => $responseData['response'] ?? null,
            ]);
        } else {
            return response()->json([
                'error'   => 'Invalid response from API.',
                'details' => $response->body(),
            ], 500);
        }
    }

    public function generateResponse($typeChart, $chart)
    {
        // Retrieve the chart data from the incoming JSON payload

        // Convert the chart data to a JSON string
        $chartJson = json_encode($chart);
        
        switch ($typeChart) {
            case 'daily_progress':
                //$p = 'what is the capital of spain ?';
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a time series plot (with overall linear trend) for a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific dates and data points or values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'factor_predictors':
                //$p = 'what is the capital of Morocco ?';
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing the predictors in a linear model of a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling. Predictors range from the number of hours slept or spent working on thesis and non-thesis work, to subjective scores of how much emotions or anxiety interfered with the student's activities (a positive coefficient means that paradoxically more progress is perceived when more interference is experienced).\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Focus especially on the significant predictors (those with the errors NOT crossing the zero) and on those with larger coefficients. If no predictor is significant, make the first bullet-point insight about this (the fact that the model is still not stable or clear due to a lack of data points).\n
                        End the synthesis with an open question to help the doctoral student reflect on these predictors and their positive/negative values, why they may be so, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret these insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'weekly_progress':
                //$p = 'what is the capital of France ?';
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing the data points for a boxplot for a doctoral student's daily satisfaction with their progress (especially, on their thesis), by week, as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Consider both the average and the spread of the weeks in the insights.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific weeks and average/spread, but don't use specific average/spread values or technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            case 'regression_tree':
                //$p = 'what is the capital of Germany ?';
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a regression tree model of a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling. Predictors range from the number of hours slept or spent working on thesis and non-thesis work, to subjective scores of how much emotions or anxiety interfered with the student's activities (a positive relationship means that paradoxically more progress is perceived when more interference is experienced). 'Left' branches are those with predictor values less than or equal to the 'threshold' in the concerning variable. 'Right' branches have predictor values higher than the 'threshold' in each split.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points. Focus especially on the most important predictors (non-leaf nodes higher in the tree) and on explaining the splits/branches ('threshold') leading to the leaf nodes with best and worst progress scores ('value').\n
                        End the synthesis with an open question to help the doctoral student reflect on these predictors and their positive/negative values, why they may be so, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret these insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific split values ('threshold') and progress scores ('value'), but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
                break;
            default:
                $prompt = "You are an expert data scientist with a knack for providing clear, everyday insights about complex datasets. You are also a psychotherapist specializing in Acceptance and Commitment Therapy. Below is a JSON object representing a time series plot (with overall linear trend) for a doctoral student's daily satisfaction with their progress (especially, on their thesis), as registered by their own journaling.\n
                        Task:\n
                        Please synthesize the data in 2-3 very brief bullet points. Take your time to double-check that the insights really are aligned with the data points.\n
                        End the synthesis with an open question to help the doctoral student reflect on what was happening, be attentive to their experiences as they unfold, and how to turn all this into lessons or ideas for changing how they work by taking actions that align with what they consider important.\n
                        Remind them to use the narrative diary they have to further interpret the series and the insights.\n
                        Style:\n
                        Talk directly to \"you\" (use second person singular) with personalized, brief insights.\n
                        Use a measured tone, don't use extreme, exaggerated or overblown expressions.\n
                        Exemplify with specific dates and data points or values, but don't use technical details, nor mention of models.\n
                        Don't include any introductory sentence, go directly to the bullet points.\n
                        Talk specifically about \"satisfaction with progress\", don't use synonyms like \"motivation\", \"energy\", or \"optimism\".\n
                        Don't assume or hallucinate specific thesis activities in the data insights, but you can provide such example activities in the open question at the end.\n
                        Output language: American English\n
                        Data:\n" . $chartJson;
        }
        
        // Prepare the data for the API request
        $data = [
            'model'  => 'llama3.2',
            'prompt' => $prompt,
            'stream' => false,
        ];

        Log::info("Prompt for the llama {$prompt}");
        
        // External API endpoint
        $url = 'http://ares.gsic.uva.es:11434/api/generate';
        
        // Make the API request
        $response = Http::post($url, $data);
        
        // Check if the response was successful
        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json([
                'response' => $responseData['response'] ?? null,
            ]);
        } else {
            return response()->json([
                'error'   => 'Invalid response from API.',
                'details' => $response->body(),
            ], 500);
        }
    }


    /**public function insights()
    {
        $userId = Auth::user()->id;
        $entries = Entry::where('user_id', $userId)->get();

        if (count($entries) >= 10) {
            $questions = Question::all();
            $fileName = "temp_data_{$userId}.xlsx";
            Excel::store(new EntriesExport($entries, $questions), $fileName, 'public');
            $tempFile = storage_path("/app/public/{$fileName}");

            $python = escapeshellcmd('/opt/homebrew/bin/python3');
            $script = base_path('storage/app/public/prueba.py');
            $command = "$python " . escapeshellarg($script)
                . " --input " . escapeshellarg($tempFile)
                . " --user " . escapeshellarg($userId) . " 2>&1";

            Log::info("Running command: " . $command);
            $output = shell_exec($command);
            Log::info("Python output: " . $output);
            unlink($tempFile);

            $jc = json_decode($output);
            $charts = [
                'daily_progress'    => $jc->progress_over_time,
                'weekly_progress'   => $jc->progress_by_week,
                'regression_tree'   => $jc->decision_tree,
                'factor_predictors' => $jc->forest_plot,
            ];



            $insightSummaries = [];

            foreach ($charts as $key => $chartData) {
                $response = $this->generateResponse($chartData);
              

                if ($response) {
                     $insightSummaries[$key] =  $response->original['response'];
                } 
                else {
                     $insightSummaries[$key] =  "failed";
                }

            }

            $response2 = $this->generateSummary($insightSummaries);

            if ($response2) {
                    $insightsresume = $response2->original['response'];
                } else {
                    $insightsresume= 'Insight generation failed.';
                }

            DB::table('insights')->insert([
                'user_id'           => $userId,
                'daily_progress'    => $insightSummaries['daily_progress'],
                'weekly_progress'   => $insightSummaries['weekly_progress'],
                'regression_tree'   => $insightSummaries['regression_tree'],
                'factor_predictors' => $insightSummaries['factor_predictors'],
                'insight'           => $insightsresume, // Combined insights text
            ]);

            //return redirect()->back()->with('success', 'Insights generated and saved.');
            return "Insights generated and saved";
        }

        return redirect()->back()->with('error', 'Not enough entries.');
    }*/


    public function store2(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'dformId' => 'required|exists:dforms,id', // Ensure the form exists
            'responses' => 'required|array', // Ensure responses are provided in an array
            
        ]);

        // Save the entry
        $entry = new Entry();
        $entry->dform_id = $validatedData['dformId'];
        $entry->user_id = Auth::id(); // Associate with the logged-in user
        $entry->entry = json_encode($validatedData['responses']); // Save responses as JSON
   
        $entry->save();


        DB::table('dform_user')->where('dform_id', $validatedData['dformId'])->update(['completed' => true]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Entry saved successfully!',
            'entry_id' => $entry->id,
        ]);
       
    }


    

}


