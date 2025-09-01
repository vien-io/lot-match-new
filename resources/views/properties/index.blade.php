@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
<div class="tw-p-6">
    <!-- Header -->
    <h1 class="tw-text-2xl tw-font-bold tw-text-center tw-mb-2">Property Management</h1>
    <p class="tw-text-center tw-text-gray-500 tw-mb-6">
        Add, edit, and manage subdivision properties in one place.
    </p>

    <div class="tw-bg-white tw-shadow-md tw-rounded-lg tw-overflow-hidden">
        <!-- Toolbar -->
        <div class="tw-flex tw-justify-between tw-items-center tw-p-4 tw-border-b">
            <div class="tw-flex tw-gap-2">
                <!-- Filter -->
                <div class="tw-flex tw-items-center tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input placeholder="Filter properties by..." class="tw-bg-transparent tw-outline-none tw-text-sm" />
                </div>
                <button class="tw-px-3 tw-py-1 tw-text-sm tw-border tw-rounded-lg tw-hover:tw-bg-gray-100">Block</button>
                <button class="tw-px-3 tw-py-1 tw-text-sm tw-border tw-rounded-lg tw-hover:tw-bg-gray-100">Lot</button>
            </div>

            <div class="tw-flex tw-gap-2">
               {{--  <button class="tw-px-3 tw-py-1 tw-text-sm tw-border tw-rounded-lg tw-hover:tw-bg-gray-100">Export</button> --}}
                <button 
                    class="tw-px-3 tw-py-1 tw-text-sm tw-rounded-lg tw-bg-emerald-800 tw-hover:tw-bg-green-700 tw-text-white "
                    onclick="document.getElementById('addPropertyModal').classList.remove('tw-hidden')">
                    + Add Property
                </button>
            </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="tw-p-3 tw-bg-green-100 tw-text-green-700 tw-text-sm tw-border-b">
                {{ session('success') }}
            </div>
        @endif

        <!-- Table -->
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm">
                <thead class="tw-bg-emerald-800 tw-text-left">
                    <tr>
                        <th class="tw-p-2 tw-text-white">Block</th>
                        <th class="tw-p-2 tw-text-white">Lot</th>
                        <th class="tw-p-2 tw-text-white">Lot Area</th>
                        <th class="tw-p-2 tw-text-white">Floor Area</th>
                        <th class="tw-p-2 tw-text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($properties as $property)
                        <tr class="tw-border-b hover:tw-bg-[#d1fae5] tw-transition-colors">
                            <td class="tw-p-2">{{ $property->block?->name ?? 'N/A' }}</td>
                            <td class="tw-p-2">{{ $property->name }}</td>
                            <td class="tw-p-2">{{ $property->lot_area }} sqm</td>
                            <td class="tw-p-2">{{ $property->floor_area }} sqm</td>
                            <td class="tw-p-2 tw-flex tw-gap-2">
                            {{-- Prepare image URLs --}}
                            @php
                                $imagesArray = $property->interiorImages->map(fn($i) => [
                                    'id' => $i->id,
                                    'url' => asset($i->image_path)
                                ]);
                            @endphp

                            <!-- View Interior / House Icon -->
                            <button type="button"
                                onclick='openInteriorGallery({{ $property->id }}, @json($imagesArray->pluck("url")))'
                                class="tw-p-2 tw-rounded tw-hover:tw-bg-blue-100 tw-text-blue-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M4 12v8h16v-8" />
                                </svg>
                            </button>

                            <!-- Edit -->
                            <a href="#"
                                onclick='openEditModal(
                                    {{ $property->id }},
                                    @json($property->name),
                                    {{ $property->lot_area }},
                                    {{ $property->floor_area }},
                                    {{ $property->block_id }},
                                    @json($imagesArray)
                                )'
                                class="tw-p-2 tw-rounded tw-hover:tw-bg-green-100 tw-text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                </svg>
                            </a>

                            <!-- Delete  -->
                            <form method="POST" action="{{ route('properties.destroy', $property->id) }}" onsubmit="return confirm('Delete this property?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="tw-p-2 tw-rounded tw-hover:tw-bg-red-100 tw-text-red-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </form>
                        </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="tw-text-center tw-p-4 tw-text-gray-500">No properties found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="tw-p-4 tw-border-t tw-flex tw-justify-between tw-items-center tw-text-sm tw-text-gray-500">
            <span>Rows per page: 10</span>
            {{ $properties->links() }}
        </div>
    </div>
</div>

{{-- Add Property Modal --}}
<div id="addPropertyModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
  <div class="tw-bg-white tw-rounded-[12px] tw-shadow tw-w-full sm:tw-w-[500px] tw-p-6">
    <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Add Property</h2>
    <form method="POST" action="{{ route('properties.store') }}" class="tw-space-y-4" enctype="multipart/form-data">
      @csrf
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Block</label>
        <select name="block_id" class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
          @foreach($blocks as $block)
            <option value="{{ $block->id }}">{{ $block->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="tw-mb-4">
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Numbers</label>
        <input type="text" name="lot_numbers" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" placeholder="e.g., 1,3,5,6,...">
        <small class="tw-text-[#6b7280]">Type numbers only, system will save them as "Lot (number)"</small>
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Area (sqm)</label>
        <input type="number" name="lot_area" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Floor Area (sqm)</label>
        <input type="number" name="floor_area" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Interior Images</label>
        <input type="file" name="interior_images[]" multiple class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
        <small class="tw-text-[#6b7280]">You can upload multiple images.</small>
      </div>
      <div class="tw-flex tw-justify-end tw-gap-3">
        <button type="button" onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')" class="tw-px-4 tw-py-2 tw-border tw-rounded-[12px] hover:tw-bg-gray-100">Cancel</button>
        <button type="submit" class="tw-px-4 tw-py-2 tw-bg-[#22c55e] hover:tw-bg-green-600 tw-text-white tw-rounded-[12px]">Save</button>
      </div>
    </form>
  </div>
</div>

{{-- Edit Property Modal --}}
<div id="editPropertyModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
  <div class="tw-bg-white tw-rounded-[12px] tw-shadow tw-w-full sm:tw-w-[500px] tw-p-6">
    <h2 class="tw-text-xl tw-font-semibold tw-mb-4">Edit Property</h2>
    <form id="editPropertyForm" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" id="editPropertyId" name="property_id">

      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Block</label>
        <select name="block_id" id="editBlockId" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
          @foreach($blocks as $block)
            <option value="{{ $block->id }}">{{ $block->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="tw-mb-4">
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Numbers</label>
        <input type="text" name="lot_numbers" id="editLotNumbers" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" placeholder="e.g., 1,3,5,...">
        <small class="tw-text-[#6b7280]">Type numbers only, system will save them as "Lot (number)"</small>
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Area (sqm)</label>
        <input type="number" name="lot_area" id="editLotArea" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Floor Area (sqm)</label>
        <input type="number" name="floor_area" id="editFloorArea" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
      </div>
      <div>
        <label class="tw-block tw-text-[#1f2937] tw-font-medium">Interior Images</label>
        <input type="file" name="interior_images[]" multiple class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
        <small class="tw-text-[#6b7280]">You can upload multiple images.</small>
      </div>
      <div class="tw-mb-4">
        <label class="tw-block tw-text-[#1f2937] tw-font-medium tw-mt-6">Existing Interior Images</label>
        <div class="tw-flex tw-gap-2 tw-flex-wrap" id="existingImagesContainer">
        </div>
      </div>
      <div class="tw-flex tw-justify-end tw-gap-3 tw-mt-4">
        <button type="button" onclick="closeEditModal()" class="tw-px-4 tw-py-2 tw-border tw-rounded-[12px] hover:tw-bg-gray-100">Cancel</button>
        <button type="submit" class="tw-px-4 tw-py-2 tw-bg-[#22c55e] hover:tw-bg-green-600 tw-text-white tw-rounded-[12px]">Update</button>
      </div>
    </form>
  </div>
</div>

{{-- interior modal --}}
<div id="interiorModal" class="tw-fixed tw-inset-0 tw-bg-black/40 tw-flex tw-items-center tw-justify-center tw-hidden tw-z-50">
  <div class="tw-bg-[#f5f7fa] tw-rounded-[12px] tw-shadow-lg tw-max-w-3xl tw-w-full tw-p-6 tw-relative">
      
      {{-- header --}}
      <div class="tw-flex tw-justify-between tw-items-center tw-border-b tw-border-gray-200 tw-pb-3">
          <h2 class="tw-text-xl tw-font-bold tw-text-[#1f2937]">Interior View</h2>
          <button onclick="closeInteriorModal()" 
                  class="tw-text-gray-500 hover:tw-text-[#22c55e] tw-text-2xl tw-transition-colors">&#10005;</button>
      </div>

      {{-- gallery --}}
      <div id="interiorGallery" class="tw-relative tw-mt-4 tw-h-[800px] tw-flex tw-items-center tw-justify-center tw-bg-white tw-rounded-[12px] tw-shadow-inner">
        
        {{-- image / alt fallback --}}
        <img 
          id="interiorImage" 
          src="" 
          alt="Interior Image"
          class="tw-max-h-full tw-w-full tw-object-contain tw-rounded-[12px] tw-hidden">
        <span id="interiorFallback" class="tw-text-gray-400 tw-text-lg">No image available</span>

        {{-- controls --}}
        <button onclick="prevInteriorImage()" 
                class="tw-absolute tw-top-1/2 tw-left-3 -tw-translate-y-1/2 tw-bg-[#22c55e] tw-text-white tw-rounded-full tw-p-3 hover:tw-bg-green-600 tw-shadow-md tw-transition-colors">
            &#8592;
        </button>
        <button onclick="nextInteriorImage()" 
                class="tw-absolute tw-top-1/2 tw-right-3 -tw-translate-y-1/2 tw-bg-[#22c55e] tw-text-white tw-rounded-full tw-p-3 hover:tw-bg-green-600 tw-shadow-md tw-transition-colors">
            &#8594;
        </button>
      </div>
  </div>
</div>
@endsection


@section('scripts')
  @vite('resources/js/properties.js')
@endsection