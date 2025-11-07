<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Lot;
use Illuminate\Support\Facades\Storage;
use App\Models\LotImage;
use Illuminate\Support\Facades\Log;

class PropertyController extends Controller
{
    // show list of properties
    public function index(Request $request)
    {
        $query = Lot::with(['images', 'block'])->latest();

        // search filter (matches block name, lot name, or status)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhereHas('block', fn($b) => $b->where('name', 'like', "%{$search}%"));
            });
        }

        // fetch filtered + paginated properties
        $properties = $query->paginate(12);
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
            'price' => 'required|numeric',
            'status' => 'required|in:available,sold',
            'orientation' => 'nullable|string',
            'sunlight' => 'nullable|string',
            'flood_risk' => 'nullable|string',
            'lot_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $numbers = array_map('trim', explode(',', $request->lot_numbers));

        foreach($numbers as $num) {
            $lot = Lot::create([
                'block_id'  => $request->block_id,
                'name'      => 'Lot ' . $num,
                'lot_area'  => $request->lot_area,
                'floor_area' => $request->floor_area ?? 1,
                'price' => $request->price,
                'status' => $request->status,
                'orientation' => $request->orientation,
                'sunlight' => $request->sunlight,
                'flood_risk' => $request->flood_risk,
            ]);

            // handle lot images
            if($request->hasFile('lot_images')) {
                foreach($request->file('lot_images') as $file) {
                    $path = $file->store('lot_images', 'public');
                    $lot->images()->create([
                        'path' => 'storage/' . $path,
                    ]);
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
            'price' => 'required|numeric',
            'status' => 'required|in:available,sold',
            'orientation' => 'required|string',
            'sunlight' => 'required|string',
            'flood_risk' => 'required|string',
            'lot_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        $numbers = array_map('trim', explode(',', $request->lot_numbers));
        $lotNumber = $numbers[0]; 
        $property = Lot::findOrFail($id);

        // Update property fields
        $property->update([
            'block_id'    => $request->block_id,
            'name'        => 'Lot ' . $lotNumber,
            'lot_area'    => $request->lot_area,
            'floor_area'  => $request->floor_area,
            'price'       => $request->price,
            'status'      => $request->status,
            'orientation' => $request->orientation,
            'sunlight'    => $request->sunlight,
            'flood_risk'  => $request->flood_risk,
        ]);

        // Delete selected interior images (DB + physical file)
        if ($request->has('delete_images')) {
            $images = LotImage::whereIn('id', $request->delete_images)->get();
            foreach ($images as $img) {
                // Delete physical file
                Storage::disk('public')->delete(str_replace('storage/', '', $img->path));
                // Delete DB record
                $img->delete();
            }
        }

        // Handle new uploads
        if ($request->hasFile('lot_images')) {
            foreach ($request->file('lot_images') as $file) {
                $path = $file->store('lot_images', 'public');
                $property->images()->create([
                    'path' => 'storage/' . $path,
                ]);
            }
        }

        return redirect()->route('properties.index')
                        ->with('success', 'Property updated successfully!');
    }


    public function destroy($id)
    {
        $property = Lot::findOrFail($id);

        // Delete all related image files from storage
        foreach ($property->images as $image) {
            $path = str_replace('storage/', '', $image->path); 

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }
        }

        $property->images()->delete();
        $property->delete();

        return redirect()->route('properties.index')
                        ->with('success', 'Property and its images deleted successfully!');
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
