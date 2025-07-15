<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Milestone;
use App\Models\Factor;
use App\Models\Obstacle;
use App\Models\Fuel;
use App\Models\Insight;
use App\Models\Entry;
use App\Models\Dform;
use App\Models\User;
use App\Models\Question;
use App\Exports\EntriesExport;
use GuzzleHttp\Client;
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


class HomeController extends Controller
{
    public function entries(){

        URL::forceRootUrl('https://det.gsic.uva.es'); // Ensure Laravel always uses correct base
        Paginator::currentPathResolver(function () {
            return 'https://det.gsic.uva.es' . request()->getPathInfo();
        });

        $entries = Entry::with(['user', 'dform'])->paginate(20);
        $questions = Question::all();
        return view('entries.index', compact('entries','questions'));
    }

    public function legal(){
        return view('legal');
    }

    public function test001(){
        $messages = [];

        // Get user IDs with more than 6 entries
        $userIds = DB::table('entries')
            ->select('user_id')
            ->groupBy('user_id')
            ->havingRaw('COUNT(*) > 7')
            ->pluck('user_id');

        //$userIds = [8,30,32,42,45];
    
        foreach ($userIds as $userId) {
            // Dispatch the job to generate insights
            GenerateInsights::dispatch($userId);
    
            // Log the message
           
        }
        $messages = "Insight successfully generated for {$userIds}";
        return $messages;
    }

    public function test(){
        $userId = 80;
        $u = User::where('id', $userId)->first();
        GenerateInsights::dispatch($userId);

        return "Insight succesfully generated for {$u->name}";

       /*$entries = Entry::where('user_id', 22)->whereHas('dform', function ($query) {
            $query->where('type', 'Diary')->latest();
        })->get();

        return $entries;
        */
    
    }


    public function test3()
    {

        $userId = 22;
        // Retrieve entries and questions from the database
        $entries = Entry::where('user_id', $userId)->get(); // 22 inmaho9
        $questions = Question::all();

        $fileName = "temp_data_{$userId}.xlsx";
        // Export Excel file using Laravel Excel and store it in storage/app/public
        Excel::store(new EntriesExport($entries, $questions), $fileName, 'public');
        
        // Build the full path to the Excel file
        $tempFile = storage_path("/app/public/{$fileName}");
        
        // Verify the file exists
        /*if (!file_exists($tempFile)) {
             Log::error("Excel file not found at: $tempFile");
             return response()->json(['error' => 'Excel file not n found'], 500);
        }*/
        
        // Build the command to run your Python script with the Excel file as input,
        // appending "2>&1" to capture any error messages.
        $python = escapeshellcmd('/opt/homebrew/bin/python3');
        $script = base_path('storage/app/public/prueba.py'); // Adjust this path as needed

        $command = "$python " . escapeshellarg($script)
             . " --input " . escapeshellarg($tempFile)
             . " --user " . escapeshellarg($userId) . " 2>&1";
        Log::info("Running command: " . $command);
        
        // Run the Python script and capture its output (including errors)
        $output = shell_exec($command);
        Log::info("Python output: " . $output);

        
        // Optionally, remove the temporary file if you don't need it anymore
        unlink($tempFile);
            
        // Return the Python script output as a JSON response
        return response($output, 200)->header('Content-Type', 'application/json');
    }


    public function exportEntries($type)
    {
        $entries = Entry::all();
        $questions = Question::all();

        if ($type === "excel") {
            return Excel::download(new EntriesExport($entries, $questions), 'entries.xlsx');
        }

        if ($type === "csv") { // Fixed condition
            return Excel::download(new EntriesExport($entries, $questions), 'entries.csv', ExcelFormat::CSV);
        }

        // Corrected abort statement
        abort(400, 'Invalid export type');
    }

    public function welcome(){
        if(!Auth::user()){
            Session::put('applocale', 'en');
            return view('auth.login');
        }
        else{
            return $this->dashboard();
        }
    }

    public function switchLang($lang)
    {
        if (array_key_exists($lang, Config::get('languages'))) {
            Session::put('applocale', $lang);
     
            if(Auth::user()){
                Auth::user()->language = $lang;
                Auth::user()->save();
                return redirect()->back();
            }
        }
        //return Redirect::back();
        return redirect()->route('dashboard');
    }

    public function generateResponse(Request $request)
    {
        // Retrieve the chart data from the incoming JSON payload
        $chart = $request->input('chart');
        
        // Convert the chart data to a JSON string
        $chartJson = json_encode($chart);
        
        // Create the prompt with the chart JSON appended
        $prompt = 'You are an expert data scientist with a knack for providing clear, everyday insights. Based on your data about daily progress and work habits, explain what you can learn in plain language. Talk directly to "you" with personalized, brief insights—no technical details, no mention of models or numbers, just human advice.' . "\n" . $chartJson;
        
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



    public function testLlama($question) {
        
        
        $url = 'http://ares.gsic.uva.es:11434/api/generate';

        // Prepare the data
        $data = [
            'model' => 'llama3.2',
            'prompt' => $question,
            'stream' => false,
        ];

        // Make the API request
        $response = Http::post($url, $data);

        // Check if the response is successful
        if ($response->successful()) {
            // Return the response from the API
            $responseData = $response->json();
            /*return response()->json([
                'response' => $responseData['response'] ?? null,
            ]);*/
            return $responseData['response'];
        } else {
            // Return an error if the request failed
            return response()->json([
                'error' => 'Invalid response from API.',
                'details' => $response->body(),
            ], 500);
        }
        
    }


  
    public function dashboard(){

        $chartsDataJson = null;
        $insights = null;
        $diaries = Entry::where('user_id', Auth::user()->id)->whereHas('dform', function ($query) {
            $query->where('type', 'Diary');
        })->get();

        $tasks = Task::where('user_id', Auth::user()->id)->where('completed',false)->get();
        $completedTasks = Task::where('user_id', Auth::user()->id)->where('completed',true)->get();
        $lastMilestone = Milestone::where('user_id', Auth::user()->id)->orderBy('name', 'asc')->where('finished_at', null)->first();
      
        $diaryForm = Auth::check() ? Auth::user()->dforms()->where('type', 'Diary')->first() : null;

        if($diaryForm){
            $diaryFormQuestions = $diaryForm->questions()->get();
        }else{
            $diaryForm = Dform::where('is_default', true)->first();
            $diaryFormQuestions = $diaryForm->questions()->get();
        }
     

        $entries = DB::table('entries')
            ->where('user_id', Auth::user()->id)
            ->pluck('entry'); // Get all JSON entries

        $totalHours = 0;

        foreach ($entries as $entry) {
            $decoded = json_decode($entry, true); // Convert JSON to array

            foreach ($decoded as $key => $value) {
                if (stripos($key, 'THESIS') !== false && stripos($key, 'hours') !== false && stripos($key, 'contribute') ) {
                    $totalHours += (float) $value; // Sum matched values
                }

                if (stripos($key, 'TESIS') !== false && stripos($key, 'horas') !== false && stripos($key, 'contribuyen') ) {
                    $totalHours += (float) $value; // Sum matched values
                }
            }
        }
        
        $countMilestones = count(Milestone::where('user_id', Auth::user()->id)->where('finished_at', '!=', null)->get());

        // Return the Python script output as a JSON response
        //return response($output, 200)->header('Content-Type', 'application/json');
        $insights = DB::table('insights')->where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->first();
        if($insights){
            $chartsDataJson = $insights->chartsDataJson;
        }

        //return $insights->insight_es;
        
        //return $totalHours;
        return view('dashboard', compact('tasks','lastMilestone','diaries','completedTasks', 'totalHours', 'countMilestones','chartsDataJson', 'insights'));
        //return $this->generateResponse($progress_over_time);
        
    }

    public function progress(){

        $chartsDataJson = null;
        $userId = Auth::user()->id;
        // Retrieve entries and questions from the database
        $entries = Entry::where('user_id', $userId)->get(); // 22 inmaho9
        $diaries = Entry::where('user_id', Auth::user()->id)->whereHas('dform', function ($query) {
            $query->where('type', 'Diary');
        })->get();

        $insights = Insight::where('user_id', $userId)->orderBy('created_at','DESC')->first();
        if($insights){
            $chartsDataJson = $insights->chartsDataJson;
        }

        

        return view('progress.index', compact('diaries','chartsDataJson','insights','diaries'));
    }

    public function progress_old(){


        $userId = Auth::user()->id;
        // Retrieve entries and questions from the database
        $entries = Entry::where('user_id', $userId)->get(); // 22 inmaho9
        if(count($entries) >= 10){
            $questions = Question::all();

            $fileName = "temp_data_{$userId}.xlsx";
            // Export Excel file using Laravel Excel and store it in storage/app/public
            Excel::store(new EntriesExport($entries, $questions), $fileName, 'public');
            
            // Build the full path to the Excel file
            $tempFile = storage_path("/app/public/{$fileName}");
            
            // Verify the file exists
            /*if (!file_exists($tempFile)) {
                 Log::error("Excel file not found at: $tempFile");
                 return response()->json(['error' => 'Excel file not n found'], 500);
            }*/
            
            // Build the command to run your Python script with the Excel file as input,
            // appending "2>&1" to capture any error messages.
            $python = escapeshellcmd('/opt/homebrew/bin/python3');
            $script = base_path('storage/app/public/prueba.py'); // Adjust this path as needed

            $command = "$python " . escapeshellarg($script)
                 . " --input " . escapeshellarg($tempFile)
                 . " --user " . escapeshellarg($userId) . " 2>&1";
            Log::info("Running command: " . $command);
            
            // Run the Python script and capture its output (including errors)
            $output = shell_exec($command);
            Log::info("Python output: " . $output);

            
            // Optionally, remove the temporary file if you don't need it anymore
            unlink($tempFile);
            $chartsDataJson = $output;
            $jc = json_decode($chartsDataJson);
            $progress_over_time = $jc->progress_over_time;
            $progress_by_week = $jc->progress_by_week;
            $decision_tree = $jc->decision_tree;
            $forest_plot = $jc->forest_plot;

        }

        $diaries = Entry::where('user_id', Auth::user()->id)->whereHas('dform', function ($query) {
            $query->where('type', 'Diary');
        })->get();

        return view('progress.index', compact('diaries','chartsDataJson'));
    }


    public function insights(){
        ///// GETTING THE CHARTS 

        $userId = Auth::user()->id;
        // Retrieve entries and questions from the database
        $entries = Entry::where('user_id', $userId)->get(); // 22 inmaho9
        if(count($entries) >= 10){
            $questions = Question::all();

            $fileName = "temp_data_{$userId}.xlsx";
            // Export Excel file using Laravel Excel and store it in storage/app/public
            Excel::store(new EntriesExport($entries, $questions), $fileName, 'public');
            
            // Build the full path to the Excel file
            $tempFile = storage_path("/app/public/{$fileName}");
            
            // Verify the file exists
            /*if (!file_exists($tempFile)) {
                 Log::error("Excel file not found at: $tempFile");
                 return response()->json(['error' => 'Excel file not n found'], 500);
            }*/
            
            // Build the command to run your Python script with the Excel file as input,
            // appending "2>&1" to capture any error messages.
            $python = escapeshellcmd('/opt/homebrew/bin/python3');
            $script = base_path('storage/app/public/prueba.py'); // Adjust this path as needed

            $command = "$python " . escapeshellarg($script)
                 . " --input " . escapeshellarg($tempFile)
                 . " --user " . escapeshellarg($userId) . " 2>&1";
            Log::info("Running command: " . $command);
            
            // Run the Python script and capture its output (including errors)
            $output = shell_exec($command);
            Log::info("Python output: " . $output);

            // Optionally, remove the temporary file if you don't need it anymore
            unlink($tempFile);
            $chartsDataJson = $output;
            $jc = json_decode($chartsDataJson);
            $progress_over_time = $jc->progress_over_time;
            $progress_by_week = $jc->progress_by_week;
            $decision_tree = $jc->decision_tree;
            $forest_plot = $jc->forest_plot;
        }
        else{
            return "Data not enough";
        }


    }

    public function milestones()
    {
        $milestones = Milestone::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('milestones', compact('milestones'));
    }

    public function thesismap(){
        $milestones = Milestone::where('user_id', Auth::user()->id)
        //->orderBy('name', 'asc')
        ->orderByRaw("CAST(SUBSTRING_INDEX(name, '-', -1) AS UNSIGNED) ASC")
        ->get(); 
        $obstacles = Obstacle::where('user_id', Auth::user()->id)
        ->orderByRaw("CAST(SUBSTRING_INDEX(obstacle, '-', -1) AS UNSIGNED) ASC")
        //->orderBy('obstacle', 'asc')
        ->get(); 
        $fuels = Fuel::where('user_id', Auth::user()->id)
        ->orderByRaw("CAST(SUBSTRING_INDEX(fuel, '-', -1) AS UNSIGNED) ASC")
        //->orderBy('fuel', 'asc')
        ->get();
       
        //return $milestones;
        return view('map', compact('milestones','obstacles','fuels'));
    }
    
    public function store_milestone(Request $request)
    {
        $milestoneCounter = $request->input('milestoneCounter');
        $mname = 'milestone-'.$milestoneCounter;
        // Validate the request data
        $validatedData = $request->validate([
            'milestone' => 'required|string|max:255', // Validate milestone text
            'user_id' => 'required|exists:users,id',  
        ]);

        $lastMilestone = Milestone::where('user_id', $validatedData['user_id'])
                              ->orderBy('created_at', 'desc')
                              ->first();

        $x_position = $request->input('x_position');
        $y_position = $request->input('y_position');

        $x_position = ($x_position !== null && $x_position >= 20 && $x_position <= 1230) ? $x_position : 600;
        $y_position = ($y_position !== null && $y_position >= 20 && $y_position <= 500) ? $y_position : 250;

        // Create a new milestone
        if($request->input('x_position') === null){
            if($lastMilestone){
                $x_position = min(max(intval($lastMilestone->x_position) + 10, 20), 1230);
                $y_position = min(max(intval($lastMilestone->y_position) + 10, 20), 500);


                preg_match('/\d+$/', $lastMilestone->name, $matches);
                $number = isset($matches[0]) ? intval($matches[0]) + 1 : 1;
                $mname = 'milestone-'.$number;

            }else{
                $x_position = 100;
                $y_position = 100;
                $mname = 'milestone-1';
            }
        }

        Milestone::create([
            'milestone' => $validatedData['milestone'],
            'user_id' => $validatedData['user_id'],
            'x_position' => $x_position,
            'y_position' => $y_position,
            'name' => $mname,
            'finished_at' => null, // Default to null if not provided
        ]);

        if ($request->ajax()) {
            // Return JSON response for AJAX requests
            return response()->json([
                'success' => true,
                'message' => 'Milestone saved successfully!',
            ]);
        }
    
        // Return a view for standard requests
        return redirect()->route('thesismap', [
            'success' => true,
            'message' => 'Milestone saved successfully!',
        ]);
    }

    public function update_milestone(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'position_x' => 'required',
            'position_y' => 'required',
        ]);

        // Ensure x_position and y_position are within limits
        $position_x = (int) $validatedData['position_x'];
        $position_y = (int) $validatedData['position_y'];

        // Apply the limits for position_x and position_y
        $position_x = ($position_x >= 20 && $position_x <= 1230) ? $position_x : 600;  // Default to 100 if out of bounds
        $position_y = ($position_y >= 20 && $position_y <= 500) ? $position_y : 250;  // Default to 100 if out of bounds


        $milestone = Milestone::where('name',$validatedData['id'])->where('user_id',Auth::user()->id)->first();
        $milestone->x_position =  $position_x;
        $milestone->y_position =  $position_y;
        $milestone->save();

        return response()->json(['success' => true, 'message' => 'Position updated successfully.']);
    
    }

    public function edit_milestone(Request $request){
        $validatedData = $request->validate([
            'milestone_id' => 'required',
            'milestone' => 'required',
           
        ]);

        $milestone = Milestone::where('id',$validatedData['milestone_id'])->where('user_id',Auth::user()->id)->first();
        if($request->input('edit-milestone-finish')){
            $milestone->finished_at = $request->input('edit-milestone-finish');
        }
        $milestone->milestone = $validatedData['milestone'];
        $milestone->save();

        return redirect()->back()->with(['success' => true, 'message' => 'milestone updated successfully.']);
    
    }


    public function edit_obstacle(Request $request){
        $validatedData = $request->validate([
            'obstacle_id' => 'required',
            'description' => 'required',
           
        ]);

        $obstacle = Obstacle::where('id',$validatedData['obstacle_id'])->where('user_id',Auth::user()->id)->first();

        if($request->input('edit-obstacle-finish')){
            $obstacle->finished_at = $request->input('edit-obstacle-finish');
        }

        $obstacle->description = $validatedData['description'];
        $obstacle->save();

        return redirect()->back()->with(['obstacle_updated' => true, 'message' => 'obstacle updated successfully.']);
    
    }

    public function edit_fuel(Request $request){
        $validatedData = $request->validate([
            'fuel_id' => 'required',
            'description' => 'required',
           
        ]);

        $fuel = Fuel::where('id',$validatedData['fuel_id'])->where('user_id',Auth::user()->id)->first();
        $fuel->description = $validatedData['description'];
        $fuel->save();

        return redirect()->back()->with(['fuel_updated' => true, 'message' => 'fuel updated successfully.']);
    
    }

    public function reorder_milestone(Request $request)
   
    {
        $order = $request->input('order'); // Array of milestone names in the new order (e.g., ['milestone-3', 'milestone-1'])
        $count = 1;
        foreach ($order as $o) {
            // Find the milestone by its current name
            $milestone = Milestone::where('user_id', Auth::user()->id)->where('id', $o)->first();

            if ($milestone) {
                // Update the name to reflect the new order
                $milestone->name = 'milestone-'.$count;
                $milestone->save();

                $count++;
            }
        }

        return response()->json(['message' => $count]);
    }


    public function reorder_obstacle(Request $request)
   
    {
        $order = $request->input('order'); // Array of milestone names in the new order (e.g., ['milestone-3', 'milestone-1'])
        $count = 1;
        foreach ($order as $o) {
            // Find the milestone by its current name
            $obstacle = Obstacle::where('user_id', Auth::user()->id)->where('id', $o)->first();

            if ($obstacle) {
                // Update the name to reflect the new order
                $obstacle->obstacle = 'obstacle-'.$count;
                $obstacle->save();

                $count++;
            }
        }

        return response()->json(['message' => $count]);
    }

    public function reorder_fuel(Request $request)
   
    {
        $order = $request->input('order'); // Array of milestone names in the new order (e.g., ['milestone-3', 'milestone-1'])
        $count = 1;
        foreach ($order as $o) {
            // Find the milestone by its current name
            $fuel = Fuel::where('user_id', Auth::user()->id)->where('id', $o)->first();

            if ($fuel) {
                // Update the name to reflect the new order
                $fuel->fuel = 'obstacle-'.$count;
                $fuel->save();

                $count++;
            }
        }

        return response()->json(['message' => $count]);
    }

    public function finish_milestone($id, Request $request)
    {
        // Find the milestone
        $milestone = Milestone::find($id);

        if (!$milestone) {
            return response()->json(['error' => 'Milestone not found'], 404);
        }

        // Update the finished_at column
        $milestone->finished_at = now();
        $milestone->save();

        return response()->json(['message' => 'Milestone marked as finished successfully.']);
    }

    public function finish_obstacle($id, Request $request)
    {
        // Find the milestone
        $obstacle = Obstacle::find($id);

        if (!$obstacle) {
            return response()->json(['error' => 'Obstacle not found'], 404);
        }

        // Update the finished_at column
        $obstacle->finished_at = now();
        $obstacle->save();

        return response()->json(['message' => 'Obstacle marked as finished successfully.']);
    }

    


    public function remove_milestone($id)
    {
        try {
            // Find the milestone by ID and check the user's ownership
            $milestone = Milestone::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Extract the number from the milestone name
            $parts = explode('-', $milestone->name);
            $number = (int) end($parts);

            // Delete the milestone
            $milestone->delete();

            // Retrieve higher numbered milestones for the user
            $higherMilestones = Milestone::where('user_id', Auth::user()->id)
                ->whereRaw('CAST(SUBSTRING_INDEX(name, "-", -1) AS UNSIGNED) > ?', [$number])
                ->get();

            // If higher numbered milestones exist, decrease their numbers
            if ($higherMilestones->isNotEmpty()) {
                // Loop through each milestone and decrease the number by 1
                foreach ($higherMilestones as $higherMilestone) {
                    // Extract the current number from the milestone name
                    $parts = explode('-', $higherMilestone->name);
                    $currentNumber = (int) end($parts); // Ensure it's treated as an integer

                    // Decrease the number by 1
                    $newNumber = $currentNumber - 1;

                    // Update the milestone name with the new number
                    $higherMilestone->name = implode('-', array_slice($parts, 0, -1)) . '-' . $newNumber;

                    // Save the updated milestone
                    $higherMilestone->save();
                }

                // Store a success message
                session()->flash('success', 'Milestone deleted and higher numbered milestones updated successfully.');
            } else {
                // If no higher numbered milestones are found
                session()->flash('info', 'Milestone deleted but no higher numbered milestones were found.');
            }

            // Return success response
            return redirect()->back();

        } catch (\Exception $e) {
            // Handle any error that occurs during the process
            session()->flash('error', 'Failed to delete milestone. Please try again later.');
            return redirect()->back();
        }
    }


    public function update_obstacle(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'position_x' => 'required',
            'position_y' => 'required',
        ]);

        $position_x = (int) $validatedData['position_x'];
        $position_y = (int) $validatedData['position_y'];
    
        // Apply the limits for position_x and position_y
        $position_x = ($position_x >= 50 && $position_x <= 1200) ? $position_x : 600;  // Default to 100 if out of bounds
        $position_y = ($position_y >= 50 && $position_y <= 470) ? $position_y : 250;  // Default to 100 if out of bounds
    

        $obstacle = Obstacle::where('obstacle',$validatedData['id'])->where('user_id',Auth::user()->id)->first();
        $obstacle->position_x =  $position_x;
        $obstacle->position_y = $position_y;
        $obstacle->save();

        return response()->json(['success' => true, 'message' => 'Position updated successfully.']);
    
    }

    public function remove_obstacle($id)
    {
        try {
            // Find the milestone by ID and check the user's ownership
            $obstacle = Obstacle::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Extract the number from the milestone name
            $parts = explode('-', $obstacle->name);
            $number = (int) end($parts);

            // Delete the milestone
            $obstacle->delete();

            // Retrieve higher numbered milestones for the user
            $higherMilestones = Obstacle::where('user_id', Auth::user()->id)
                ->whereRaw('CAST(SUBSTRING_INDEX(name, "-", -1) AS UNSIGNED) > ?', [$number])
                ->get();

            // If higher numbered milestones exist, decrease their numbers
            if ($higherMilestones->isNotEmpty()) {
                // Loop through each milestone and decrease the number by 1
                foreach ($higherMilestones as $higherMilestone) {
                    // Extract the current number from the milestone name
                    $parts = explode('-', $higherMilestone->name);
                    $currentNumber = (int) end($parts); // Ensure it's treated as an integer

                    // Decrease the number by 1
                    $newNumber = $currentNumber - 1;

                    // Update the milestone name with the new number
                    $higherMilestone->name = implode('-', array_slice($parts, 0, -1)) . '-' . $newNumber;

                    // Save the updated milestone
                    $higherMilestone->save();
                }

                // Store a success message
                //session()->flash('success', 'Obstacle deleted and higher numbered milestones updated successfully.');
            } else {
                // If no higher numbered milestones are found
                //session()->flash('info', 'Obstacle deleted but no higher numbered milestones were found.');
            }

            // Return success response
            return redirect()->back()->with(['obstacle_updated' => true, 'message' => 'obstacle updated successfully.']);

        } catch (\Exception $e) {
            // Handle any error that occurs during the process
            session()->flash('error', 'Failed to delete obstacle. Please try again later.');
            return redirect()->back()->with(['obstacle_updated' => true, 'message' => 'obstacle updated successfully.']);
        }

      
    }

    public function store_obstacle(Request $request)
    {
        $obstacleCounter = $request->input('obstacleCounter');
        $mname = 'obstacle-'.$obstacleCounter;
        // Validate the request data
        $validatedData = $request->validate([
            'obstacle' => 'required|string|max:255', // Validate milestone text
            'user_id' => 'required|exists:users,id',  
        ]);

        $lastObstacle = Obstacle::where('user_id', $validatedData['user_id'])
                              ->orderBy('created_at', 'desc')
                              ->first();

        // If there is a last milestone, update its 'finished_at' timestamp with the current time
       /* if ($lastObstacle) {
            $lastObstacle->update([
                'finished_at' => now(),
            ]);
        }*/
        // Create a new milestone
        Obstacle::create([
            'description' => $validatedData['obstacle'],
            'user_id' => $validatedData['user_id'],
            'position_x' => $request->input('x_position'),
            'position_y' => $request->input('y_position'),
            'obstacle' => $mname,
            'finished_at' => null, // Default to null if not provided
        ]);

        // Redirect back with a success message
        //return redirect()->back()->with('success', 'Milestone added successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Obstacle saved successfully!',
           
        ]);
    }


    public function store_fuel(Request $request)
    {
        $fuelCounter = $request->input('fuelCounter');
        $mname = 'fuel-'.$fuelCounter;
        // Validate the request data
        $validatedData = $request->validate([
          
            'user_id' => 'required|exists:users,id',  
        ]);

        $lastFuel = Fuel::where('user_id', $validatedData['user_id'])
                              ->orderBy('created_at', 'desc')
                              ->first();

        // If there is a last milestone, update its 'finished_at' timestamp with the current time
        /*if ($lastFuel) {
            $lastFuel->update([
                'finished_at' => now(),
            ]);
        }*/
        // Create a new milestone
        Fuel::create([
            'description' => $request->input('fuel'),
            'user_id' => $validatedData['user_id'],
            'fuel' => $mname,
            'finished_at' => null, // Default to null if not provided
        ]);

        // Redirect back with a success message
        //return redirect()->back()->with('success', 'Fuel added successfully!');
        return response()->json([
            'success' => true,
            'message' => 'Fuel saved successfully!',
           
        ]);
    }


    public function remove_fuel($id)
    {
        try {
            // Find the milestone by ID and check the user's ownership
            $fuel = Fuel::where('id', $id)
                ->where('user_id', Auth::user()->id)
                ->firstOrFail();

            // Extract the number from the milestone name
            $parts = explode('-', $fuel->name);
            $number = (int) end($parts);

            // Delete the milestone
            $fuel->delete();

            // Retrieve higher numbered milestones for the user
            $higherMilestones = Fuel::where('user_id', Auth::user()->id)
                ->whereRaw('CAST(SUBSTRING_INDEX(name, "-", -1) AS UNSIGNED) > ?', [$number])
                ->get();

            // If higher numbered milestones exist, decrease their numbers
            if ($higherMilestones->isNotEmpty()) {
                // Loop through each milestone and decrease the number by 1
                foreach ($higherMilestones as $higherMilestone) {
                    // Extract the current number from the milestone name
                    $parts = explode('-', $higherMilestone->name);
                    $currentNumber = (int) end($parts); // Ensure it's treated as an integer

                    // Decrease the number by 1
                    $newNumber = $currentNumber - 1;

                    // Update the milestone name with the new number
                    $higherMilestone->name = implode('-', array_slice($parts, 0, -1)) . '-' . $newNumber;

                    // Save the updated milestone
                    $higherMilestone->save();
                }

                // Store a success message
              //  session()->flash('success', 'Fuel deleted and higher numbered milestones updated successfully.');
            
            } else {
                // If no higher numbered milestones are found
               // session()->flash('info', 'Fuel deleted but no higher numbered milestones were found.');
            }

            // Return success response
            return redirect()->back()->with(['fuel_updated' => true, 'message' => 'fuel updated successfully.']);

        } catch (\Exception $e) {
            // Handle any error that occurs during the process
            session()->flash('error', 'Failed to delete Fuel. Please try again later.');
            //return redirect()->back();
            return redirect()->back()->with(['fuel_updated' => true, 'message' => 'fuel updated successfully.']);
        }
    }


    

    public function fetchMilestonesData(){
        $milestones = Milestone::where('user_id', Auth::user()->id)
        ->orderByRaw("CAST(SUBSTRING_INDEX(name, '-', -1) AS UNSIGNED) ASC")
        //->orderBy('name')
        ->get();
        return response()->json($milestones);
    }

    public function fetchObstaclesData(){

        $obstacles = Obstacle::where('user_id', Auth::user()->id)
        //->orderBy('obstacle')
        ->orderByRaw("CAST(SUBSTRING_INDEX(obstacle, '-', -1) AS UNSIGNED) ASC")
        ->get();
        return response()->json($obstacles);
        
    }

    public function fetchFuelsData(){

        $fuels = Fuel::where('user_id', Auth::user()->id)
        ->orderByRaw("CAST(SUBSTRING_INDEX(fuel, '-', -1) AS UNSIGNED) ASC")
        //->orderBy('fuel')
        ->get();
        return response()->json($fuels);
        
    }

    

}
