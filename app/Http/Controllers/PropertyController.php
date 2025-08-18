<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Lot;

class PropertyController extends Controller
{
    // show list of properties
    public function index()
    {
        $properties = Lot::latest()->paginate(12);
        return view('properties.index', compact('properties'));
    }

    // store a new property
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block' => 'required|string|max:255',
            'lot' => 'required|string|max:255',
            'lot_area' => 'required|numeric',
            'floor_area' => 'required|numeric',
        ]);

        Lot::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }
}
