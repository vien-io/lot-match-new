<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Lot;

class PropertyController extends Controller
{
    // show list of properties
    public function index()
    {
        $properties = Lot::latest()->paginate(12);
        $blocks = Block::all();

        return view('properties.index', compact('properties', 'blocks'));
    }

    // store a new property
    public function store(Request $request)
    {
        $request->validate([
            'block_id'  => 'required|exists:blocks,id',
            'lot_numbers' => 'required|string',
            'lot_area'  => 'required|numeric',
            'floor_area' => 'required|numeric',
        ]);

        $numbers = array_map('trim', explode(',', $request->lot_numbers));

        foreach($numbers as $num) {
            Lot::create([
                'block_id'  => $request->block_id,
                'name'      => 'Lot ' . $num,
                'lot_area'  => $request->lot_area,
                'floor_area' => $request->floor_area ?? 1,
                'size'       => $request->lot_area ?? 1, 
                'price'     => 0,
                'description' => '',
            ]);
        }
        

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'block_id'   => 'required|exists:blocks,id',
            'name'       => 'required|string',
            'lot_area'   => 'required|numeric',
            'floor_area' => 'required|numeric',
        ]);

        $property = Lot::findOrFail($id);

        $property->update([
            'block_id'   => $request->block_id,
            'name'       => $request->name,
            'lot_area'   => $request->lot_area,
            'floor_area' => $request->floor_area,
            'size'       => $request->lot_area, // if size = lot_area
        ]);

        return redirect()->route('properties.index')->with('success', 'Property updated successfully!');
    }
}
