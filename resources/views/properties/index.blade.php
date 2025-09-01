@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
<div class="tw-bg-[#e9f3ec] tw-min-h-screen tw-p-8 font-sans text-[#1f2937]">

  {{-- Header --}}
  <div class="tw-flex tw-items-center tw-justify-between tw-mb-6">
    <div>
      <h1 class="tw-text-3xl tw-font-bold">Property Management</h1>
      <p class="tw-text-[#6b7280]">Add, edit, and manage subdivision properties.</p>
    </div>
    <button 
      class="tw-bg-[#22c55e] hover:tw-bg-green-600 tw-text-white tw-font-semibold tw-px-6 tw-py-3 tw-rounded-[12px] tw-shadow"
      onclick="document.getElementById('addPropertyModal').classList.remove('tw-hidden')">
      + Add Property
    </button>
  </div>

  {{-- Flash message --}}
  @if(session('success'))
    <div class="tw-mb-4 tw-p-3 tw-bg-[#d1fae5] tw-text-[#065f46] tw-rounded-[12px]">
      {{ session('success') }}
    </div>
  @endif

  {{-- Property Table --}}
  <div class="tw-bg-white tw-rounded-[12px] tw-shadow tw-overflow-hidden">
    <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
      <thead class="tw-bg-[#f5f7fa]">
        <tr>
          <th class="tw-px-6 tw-py-3 tw-text-left tw-font-medium tw-text-[#6b7280]">Block</th>
          <th class="tw-px-6 tw-py-3 tw-text-left tw-font-medium tw-text-[#6b7280]">Lot</th>
          <th class="tw-px-6 tw-py-3 tw-text-left tw-font-medium tw-text-[#6b7280]">Lot Area</th>
          <th class="tw-px-6 tw-py-3 tw-text-left tw-font-medium tw-text-[#6b7280]">Floor Area</th>
          <th class="tw-px-6 tw-py-3 tw-text-left tw-font-medium tw-text-[#6b7280]">Actions</th>
        </tr>
      </thead>
      <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
        @forelse($properties as $property)
        <tr class="hover:tw-bg-[#d1fae5] tw-transition-colors">
            <td class="tw-px-6 tw-py-4">{{ $property->block?->name ?? 'N/A' }}</td>
            <td class="tw-px-6 tw-py-4">{{ $property->name }}</td>
            <td class="tw-px-6 tw-py-4">{{ $property->lot_area }} sqm</td>
            <td class="tw-px-6 tw-py-4">{{ $property->floor_area }} sqm</td>
            <td class="tw-px-6 tw-py-4 tw-flex tw-gap-4">
                {{-- Prepare image URLs --}}
                @php
                    $imagesArray = $property->interiorImages->map(fn($i) => [
                        'id' => $i->id,
                        'url' => asset($i->image_path)
                    ]);
                @endphp

                {{-- View Interior --}}
                <button type="button"
                    onclick='openInteriorGallery({{ $property->id }}, @json($imagesArray->pluck("url")))'
                    class="tw-text-blue-500 hover:tw-underline tw-font-medium">
                    View Interior
                </button>

                {{-- Edit Property --}}
                <a href="#"
                  onclick='openEditModal(
                      {{ $property->id }},
                      @json($property->name),
                      {{ $property->lot_area }},
                      {{ $property->floor_area }},
                      {{ $property->block_id }},
                      @json($imagesArray)
                  )'
                  class="tw-text-[#22c55e] hover:tw-underline tw-font-medium">
                  Edit
                </a>

                {{-- Delete Property --}}
                <form method="POST" action="{{ route('properties.destroy', $property->id) }}" onsubmit="return confirm('Delete this property?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="tw-text-red-500 hover:tw-underline tw-font-medium">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5" class="tw-text-center tw-py-4 tw-text-[#6b7280]">No properties found.</td>
        </tr>
        @endforelse
        </tbody>

    </table>
  </div>

  {{-- Pagination --}}
  <div class="tw-mt-6">
    {{ $properties->links() }}
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


<script>
// edit modal
function openEditModal(id, name, lotArea, floorArea, blockId, images = []) {
    document.getElementById('editPropertyId').value = id;
    let lotNumber = name.replace(/Lot\s*/i, '');
    document.getElementById('editLotNumbers').value = lotNumber;
    document.getElementById('editLotArea').value = lotArea;
    document.getElementById('editFloorArea').value = floorArea;
    document.getElementById('editBlockId').value = blockId;
    document.getElementById('editPropertyForm').action = '/properties/' + id;

    // populate existing images
    const container = document.getElementById('existingImagesContainer');
    container.innerHTML = ''; // clear previous
    images.forEach(img => {
        const div = document.createElement('div');
        div.className = 'tw-relative';
        div.innerHTML = `
            <img src="${img.url}" class="tw-w-20 tw-h-20 tw-object-cover tw-rounded">
            <button type="button" class="tw-absolute tw-top-0 tw-right-0 tw-bg-red-500 tw-text-white tw-rounded-full tw-w-5 tw-h-5 tw-flex tw-items-center tw-justify-center hover:tw-bg-red-600" onclick="removeExistingImage(${img.id}, this)">×</button>
        `;
        container.appendChild(div);
    });

    document.getElementById('editPropertyModal').classList.remove('tw-hidden');
}

function removeExistingImage(imageId, btn) {
    // mark the image for deletion
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    input.value = imageId;
    document.getElementById('editPropertyForm').appendChild(input);

    // remove from UI
    btn.parentElement.remove();
}

function closeEditModal() {
    document.getElementById('editPropertyModal').classList.add('tw-hidden');
}


// interior modal
    let currentPropertyId = null;
    let currentImageIndex = 0;
    let currentImages = [];

    function openInteriorGallery(propertyId, images) {
        currentImages = images || [];
        currentPropertyId = propertyId;
        currentImageIndex = 0;
        showInteriorImage();
        document.getElementById('interiorModal').classList.remove('tw-hidden');
    }

    function closeInteriorModal() {
        document.getElementById('interiorModal').classList.add('tw-hidden');
    }

    function showInteriorImage() {
      const imgEl = document.getElementById('interiorImage');
      const fallback = document.getElementById('interiorFallback');

      if (currentImages.length > 0) {
          imgEl.src = currentImages[currentImageIndex];
          imgEl.classList.remove('tw-hidden');   
          fallback.classList.add('tw-hidden');    
      } else {
          imgEl.src = "";
          imgEl.classList.add('tw-hidden');    
          fallback.classList.remove('tw-hidden'); 
      }
    }

    function prevInteriorImage() {
        if (!currentImages.length) return;
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        showInteriorImage();
    }

    function nextInteriorImage() {
        if (!currentImages) return;
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        showInteriorImage();
    }
</script>
@endsection
