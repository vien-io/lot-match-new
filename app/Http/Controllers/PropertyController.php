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
        $properties = Lot::with('interiorImages')->latest()->paginate(12);
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
            'interior_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $numbers = array_map('trim', explode(',', $request->lot_numbers));

        foreach($numbers as $num) {
            $lot = Lot::create([
                'block_id'  => $request->block_id,
                'name'      => 'Lot ' . $num,
                'lot_area'  => $request->lot_area,
                'floor_area' => $request->floor_area ?? 1,
                'size'       => $request->lot_area ?? 1, 
                'price'     => 0,
                'description' => '',
            ]);

            // handle interior images
            if($request->hasFile('interior_images')) {
                foreach($request->file('interior_images') as $file) {
                    $path = $file->store('uploads/interiors', 'public');
                    $lot->interiorImages()->create(['image_path' => 'storage/' . $path]);
                }
            }
        }
        

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'block_id'    => 'required|exists:blocks,id',
            'lot_numbers' => 'required|string',
            'lot_area'    => 'required|numeric',
            'floor_area'  => 'required|numeric',
            'interior_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $numbers = array_map('trim', explode(',', $request->lot_numbers));
        $lotNumber = $numbers[0]; 
        $property = Lot::findOrFail($id);

        // Update property fields
        $property->update([
            'block_id'   => $request->block_id,
            'name'       => 'Lot ' . $lotNumber,
            'lot_area'   => $request->lot_area,
            'floor_area' => $request->floor_area,
            'size'       => $request->lot_area,
        ]);

        // Delete selected interior images (DB + physical file)
        if ($request->has('delete_images')) {
            $images = \App\Models\InteriorImage::whereIn('id', $request->delete_images)->get();
            foreach ($images as $img) {
                // Delete physical file
                \Storage::disk('public')->delete(str_replace('storage/', '', $img->image_path));
                // Delete DB record
                $img->delete();
            }
        }

        // Handle new uploads
        if ($request->hasFile('interior_images')) {
            foreach ($request->file('interior_images') as $file) {
                $path = $file->store('uploads/interiors', 'public');
                $property->interiorImages()->create([
                    'image_path' => 'storage/' . $path
                ]);
            }
        }

        return redirect()->route('properties.index')
                        ->with('success', 'Property updated successfully!');
    }


    public function destroy($id)
    {
        $property = Lot::findOrFail($id);
        $property->delete();

        return redirect()->route('properties.index')
                        ->with('success', 'Property deleted successfully!');
    }



    public function addImage(Request $request) {
        $request->validate([
            'lot_id' => 'required|exists:lots,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $lot = Lot::find($request->lot_id);
        $path = $request->file('image')->store('uploads/lots', 'public');

        $lot->interiorImages()->create(['image_path' => 'storage/' . $path]);

        return response()->json(['success' => true, 'path' => 'storage/' . $path]);
    }
}
