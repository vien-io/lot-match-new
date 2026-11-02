<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Block;
use App\Models\Lot;
use Illuminate\Support\Facades\Storage;
use App\Models\LotImage;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    // show list of properties
    public function index(Request $request)
    {
        $query = Lot::with(['images', 'block'])
            ->join('blocks', 'lots.block_id', '=', 'blocks.id')
            ->orderBy('blocks.name', 'asc')
            ->orderByRaw("
                            CASE
                                WHEN SPLIT_PART(lots.name, ' ', 2) ~ '^[0-9]+$'
                                THEN CAST(SPLIT_PART(lots.name, ' ', 2) AS INTEGER)
                                ELSE NULL
                            END ASC NULLS LAST
                        ")
            ->select('lots.*');

        // Search by lot, block, or status.
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('lots.name', 'ilike', "%{$search}%")
                    ->orWhere('lots.status', 'ilike', "%{$search}%")
                    ->orWhere('blocks.name', 'ilike', "%{$search}%");
            });
        }

        // Status filter.
        if (in_array($request->status, ['available', 'sold'], true)) {
            $query->whereRaw(
                'LOWER(status) = ?',
                [$request->status]
            );
        }

        // Block filter.
        if ($request->filled('block')) {
            $query->where('block_id', $request->block);
        }

        $properties = $query->paginate(10)->withQueryString();

        $blocks = Block::query()
            ->whereHas('lots')
            ->orderByRaw("CAST(SPLIT_PART(name, ' ', 2) AS INTEGER) ASC")
            ->get();

        // Return only the table when the request is AJAX.
        if ($request->ajax()) {
            return response()->json([
                'html' => view('properties.property-results', compact('properties'))->render(),
            ]);
        }

        return view('properties.index', compact('properties', 'blocks'));
    }

    // store a new property
    public function store(Request $request)
    {
        $validated = $request->validate([
            'block_id' => 'required|integer|min:1',
            'lot_number' => 'required|string',
            'lot_area' => 'required|numeric',
            'floor_area' => 'required|numeric',
            'price' => 'required|numeric|min:1|max:999999999999999.99',
            'status' => 'required|in:available,sold',
            'orientation' => 'nullable|string',
            'sunlight' => 'nullable|string',
            'flood_risk' => 'nullable|string',
            'lot_images.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        DB::transaction(function () use ($request, $validated) {

            $blockId = (int) $validated['block_id'];

            // Find existing block or create a new one.
            $block = Block::find($blockId);

            if (!$block) {
                $block = new Block();
                $block->id = $blockId;
                $block->name = 'Block ' . $blockId;
                $block->save();

                // Synchronize PostgreSQL's auto-increment sequence.
                DB::statement("
                SELECT setval(
                    pg_get_serial_sequence('blocks', 'id'),
                    (SELECT MAX(id) FROM blocks)
                )
            ");
            }

            // Create property.
            $lot = Lot::create([
                'block_id' => $block->id,
                'name' => 'Lot ' . trim($validated['lot_number']),
                'lot_area' => $validated['lot_area'],
                'floor_area' => $validated['floor_area'],
                'price' => $validated['price'],
                'status' => $validated['status'],
                'orientation' => $validated['orientation'] ?? null,
                'sunlight' => $validated['sunlight'] ?? null,
                'flood_risk' => $validated['flood_risk'] ?? null,
            ]);

            // Handle lot images.
            if ($request->hasFile('lot_images')) {
                foreach ($request->file('lot_images') as $file) {
                    $path = $file->store('lot_images', 'public');

                    $lot->images()->create([
                        'path' => 'storage/' . $path,
                    ]);
                }
            }
        });

        return redirect()->route('properties.index')
            ->with('success', 'Property added successfully!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'block_id' => 'required|exists:blocks,id',
            'lot_numbers' => 'required|string',
            'lot_area' => 'required|numeric',
            'floor_area' => 'required|numeric',
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
            'block_id' => $request->block_id,
            'name' => 'Lot ' . $lotNumber,
            'lot_area' => $request->lot_area,
            'floor_area' => $request->floor_area,
            'price' => $request->price,
            'status' => $request->status,
            'orientation' => $request->orientation,
            'sunlight' => $request->sunlight,
            'flood_risk' => $request->flood_risk,
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



    public function addImage(Request $request)
    {
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
