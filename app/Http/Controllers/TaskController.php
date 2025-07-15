<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return view('tasks', compact('tasks'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'deadline' => 'required',
            
        ]);

        $user_id = Auth::user()->id;

        Task::create([
            'user_id' => $user_id,
            'title' => $request->title,
            'deadline' => $request->deadline
           
        ]);

        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return view('tasks', compact('tasks'));
    }

    public function edit(Request $request)
    {
        $request->validate([
            'task_id' => 'required|string|max:255',
            'deadline' => 'required',
            'title'=> 'required',
            
        ]);

        $user_id = Auth::user()->id;
        $task = Task::where('user_id',$user_id)->where('id',$request->task_id)->first();

        $task->title =  $request->title;
        $task->deadline =  $request->deadline;
        $task->save();

        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return view('tasks', compact('tasks'))->with('message', 'Task successfully updated');

    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->route('tasks');
    }

    public function markAsCompleted(Task $task)
    {
        $task->completed = true;
        $task->save();

        $tasks = Task::where('user_id',Auth::user()->id)->get();
        return view('tasks', compact('tasks'))->with('success', 'Task marked as completed!');
    }
}
