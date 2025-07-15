<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factor;

class FactorController extends Controller
{
    
  public function index(){
        $factors = Factor::all();
        return view('factors.index', compact('factors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'examples' => 'string',
        ]);

        $factor = Factor::findOrFail($id);
        $factor->name = $request->input('name');
        $factor->description = $request->input('description');
        $factor->example = $request->input('examples');
        $factor->save();

        return redirect()->back()->with('success', 'Factor updated successfully.');
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'examples' => 'string',
        ]);

        Factor::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'example' => $request->input('examples'),
        ]);

        return redirect()->back()->with('success', 'Factor created successfully.');
    }


    public function destroy($id)
    {
        $factor = Factor::findOrFail($id);
        $factor->questions()->detach();
        $factor->delete();

        return redirect()->back()->with('success', 'Factor deleted successfully.');
    }
}
