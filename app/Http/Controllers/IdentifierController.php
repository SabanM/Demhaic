<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Identifier;

class IdentifierController extends Controller
{
    public function index(){
        $identifiers = Identifier::all();
        return view('identifiers.index', compact('identifiers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
          
        ]);

        $identifier = Identifier::findOrFail($id);
        $identifier->name = $request->input('name');
        $identifier->description = $request->input('description');
        $identifier->save();

        return redirect()->back()->with('success', 'Identifier updated successfully.');
    }

    public function store(Request $request)
    {
     
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        Identifier::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        return redirect()->back()->with('success', 'Identifier created successfully.');
    }


    public function destroy($id)
    {
        $identifier = Identifier::findOrFail($id);
        foreach ($identifier->questions as $question) {
            $question->identifier_id = null;
            $question->save();
        }

        // Delete the identifier
        $identifier->delete();
            return redirect()->back()->with('success', 'Identifier deleted successfully.');
        }
}
