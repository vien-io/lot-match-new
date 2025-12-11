@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
@vite('resources/css/print.css')

<div class="tw-p-6">
    <!-- Header -->
    <h1 class="tw-text-2xl tw-font-bold tw-text-center tw-mb-2">Property Management</h1>
    <p class="tw-text-center tw-text-gray-500 tw-mb-6">
        Add, edit, and manage subdivision properties in one place.
    </p>

    <div class="tw-bg-white tw-shadow-md tw-rounded-lg tw-overflow-hidden">
        <!-- Toolbar -->
        <div class="tw-flex tw-justify-between tw-items-center tw-p-4 tw-border-b">
          <!-- Filter -->
          <div class="tw-flex tw-gap-2">
              <form method="GET" action="{{ route('properties.index') }}" class="tw-flex tw-items-center tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by block, lot, or status..."
                    class="tw-bg-transparent tw-outline-none tw-text-sm tw-w-full tw-min-w-[200px]"
                />
            </form>
          </div>

          {{-- buttons: print n add --}}
          <div class="tw-flex tw-gap-2">
            <button 
                class="tw-px-3 tw-py-1 tw-text-sm tw-rounded-lg tw-bg-emerald-800 tw-hover:tw-bg-green-700 tw-text-white tw-flex tw-items-center tw-gap-1"
                onclick="window.print()">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-4 0v4m0 0h4m-4 0H8" />
                </svg> 
                Print
            </button>

            <div class="tw-flex tw-gap-2">
                <button 
                    class="tw-px-3 tw-py-1 tw-text-sm tw-rounded-lg tw-bg-emerald-800 tw-hover:tw-bg-green-700 tw-text-white "
                    onclick="document.getElementById('addPropertyModal').classList.remove('tw-hidden')">
                    + Add Property
                </button>
            </div>
          </div>
        </div>

        <!-- Flash Message -->
        @if(session('success'))
            <div class="tw-p-3 tw-bg-green-100 tw-text-green-700 tw-text-sm tw-border-b">
                {{ session('success') }}
            </div>
        @endif

        <div id="printable">
          <!-- Table -->
          <div class="tw-overflow-x-auto">
              <table class="tw-w-full tw-text-sm">
                  <thead class="tw-bg-emerald-800 tw-text-left">
                      <tr>
                          <th class="tw-p-2 tw-text-white">Block</th>
                          <th class="tw-p-2 tw-text-white">Lot</th>
                          <th class="tw-p-2 tw-text-white">Lot Area</th>
                          <th class="tw-p-2 tw-text-white">Floor Area</th>
                          <th class="tw-p-2 tw-text-white">Price</th>
                          <th class="tw-p-2 tw-text-white">Status</th>
                          <th class="tw-p-2 tw-text-white">Orientation</th>
                          <th class="tw-p-2 tw-text-white">Sunlight</th>
                          <th class="tw-p-2 tw-text-white">Flood Risk</th>
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
                              <td class="tw-p-2">{{ $property->price ? '₱' . number_format($property->price, 2) : '—' }}</td>
                              <td class="tw-p-2">
                                  <span class="{{ $property->status === 'available' ? 'tw-bg-green-100 tw-text-green-700' : 'tw-bg-red-100 tw-text-red-700' }} tw-px-2 tw-py-1 tw-rounded">
                                      {{ ucfirst($property->status) }}
                                  </span>
                              </td>
                              <td class="tw-p-2 capitalize">{{ $property->orientation }}</td>
                              <td class="tw-p-2 capitalize">{{ $property->sunlight }}</td>
                              <td class="tw-p-2 capitalize">{{ $property->flood_risk }}</td>

                              <td class="tw-p-2 tw-flex tw-gap-2">
                                  {{-- Prepare image URLs --}}
                                  @php
                                      $imagesArray = $property->images->map(fn($i) => [
                                          'id' => $i->id,
                                          'url' => asset($i->path)
                                      ]);
                                  @endphp

                                  <!-- View Lot Images -->
                                  <button type="button"
                                      onclick='openLotImageGallery({{ $property->id }}, @json($imagesArray->pluck("url")))'
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
                                          {{ $property->price ?? "null" }},
                                          @json($property->status),
                                          @json($property->orientation),
                                          @json($property->sunlight),
                                          @json($property->flood_risk),
                                          @json($imagesArray)
                                      )'
                                      class="tw-p-2 tw-rounded tw-hover:tw-bg-green-100 tw-text-green-600">
                                      <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                      </svg>
                                  </a>

                                  <!-- Delete -->
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
                              <td colspan="10" class="tw-text-center tw-p-4 tw-text-gray-500">No properties found.</td>
                          </tr>
                      @endforelse
                  </tbody>
              </table>
          </div>
        </div>

        

        <!-- Pagination -->
        <div class="tw-p-4 tw-border-t tw-flex tw-justify-between tw-items-center tw-text-sm tw-text-gray-500">
            <span>Rows per page: 10</span>
            {{ $properties->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

{{-- Add Property Modal --}}
<div id="addPropertyModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
  <div class="tw-bg-white tw-rounded-[12px] tw-shadow tw-w-full sm:tw-w-[500px] tw-p-6 tw-max-h-[90vh] tw-flex tw-flex-col">

    {{-- Header --}}
    <h2 class="tw-text-xl tw-font-semibold tw-p-4 tw-border-b">Add Property</h2>


    {{-- Scrollable Content --}}
    <div class='tw-flex-1 tw-overflow-y-auto tw-px-6 tw-py-4 tw-space-y-4'>
      <form method="POST" action="{{ route('properties.store') }}" class="tw-space-y-4" enctype="multipart/form-data">
        @csrf
          <!-- Block -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Block</label>
            <select name="block_id" class="tw-bg-white tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
              @foreach($blocks as $block)
                <option value="{{ $block->id }}">{{ $block->name }}</option>
              @endforeach
            </select>
          </div>

          <!-- Lot Numbers -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Numbers</label>
            <input type="text" name="lot_numbers" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" placeholder="e.g., 1,3,5,6,..." required>
            <small class="tw-text-[#6b7280]">Type numbers only, system will save them as "Lot (number)"</small>
          </div>

          <!-- Lot Area -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Area (sqm)</label>
            <input type="number" name="lot_area" step="0.01" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
          </div>

          <!-- Floor Area -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Floor Area (sqm)</label>
            <input type="number" name="floor_area" step="0.01" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
          </div>

          <!-- Price -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Price</label>
            <input type="number" name="price" id="price" step="0.01" max="999999999999999.99" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
            <div id="priceError" class="tw-text-red-500 tw-text-sm tw-mt-1"></div>
          </div>

          <!-- Status -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Status</label>
            <select name="status" class="tw-bg-white tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
              <option value="available">Available</option>
              <option value="sold">Sold</option>
            </select>
          </div>

          <!-- Orientation -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Orientation</label>
            <select name="orientation" class="tw-bg-white tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
              <option value="north">North</option>
              <option value="south">South</option>
              <option value="east">East</option>
              <option value="west">West</option>
              <option value="northeast">Northeast</option>
              <option value="northwest">Northwest</option>
              <option value="southeast">Southeast</option>
              <option value="southwest">Southwest</option>
            </select>
          </div>

          <!-- Sunlight -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Sunlight</label>
            <select name="sunlight" class="tw-bg-white tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
              <option value="morning sun">Morning Sun</option>
              <option value="afternoon sun">Afternoon Sun</option>
              <option value="full day sun">Full Day Sun</option>
              <option value="shade">Shade</option>
              <option value="partial shade">Partial Shade</option>
            </select>
          </div>

          <!-- Flood Risk -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Flood Risk</label>
            <select name="flood_risk" class="tw-bg-white tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
              <option value="low">Low</option>
              <option value="medium">Medium</option>
              <option value="high">High</option>
            </select>
          </div>

          <!-- Lot Images -->
          <div>
            <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Images</label>
            <input type="file" name="lot_images[]" multiple class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            <small class="tw-text-[#6b7280]">You can upload multiple images.</small>
          </div>
        </div>

        <!-- Submit / Cancel -->
        <div class="tw-border-t tw-p-4 tw-flex tw-justify-end tw-gap-3 tw-bg-white tw-sticky tw-bottom-0">
          <button type="button" onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')" class="tw-px-4 tw-py-2 tw-border tw-rounded-[12px] hover:tw-bg-gray-100">Cancel</button>
          <button type="submit" class="tw-px-4 tw-py-2 tw-bg-[#22c55e] hover:tw-bg-green-600 tw-text-white tw-rounded-[12px]">Save</button>
        </div>
      </form>
    </div>

    
  </div>
</div>

{{-- Edit Property Modal --}}
<div id="editPropertyModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
  <div class="tw-bg-white tw-rounded-[12px] tw-shadow tw-w-full sm:tw-w-[500px] tw-max-h-[90vh] tw-flex tw-flex-col">

    {{-- Header --}}
    <h2 class="tw-text-xl tw-font-semibold tw-p-4 tw-border-b">Edit Property</h2>

    {{-- Scrollable Content --}}
    <div class="tw-flex-1 tw-overflow-y-auto tw-px-6 tw-py-4 tw-space-y-4">
      <form id="editPropertyForm" method="POST" enctype="multipart/form-data" class="tw-space-y-4">
        @csrf
        @method('PUT')
        <input type="hidden" id="editPropertyId" name="property_id">

        <!-- Block -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Block</label>
          <select name="block_id" id="editBlockId" class="tw-bg-white tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            @foreach($blocks as $block)
              <option value="{{ $block->id }}">{{ $block->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Lot Numbers -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Numbers</label>
          <input type="text" name="lot_numbers" id="editLotNumbers" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" placeholder="e.g., 1,3,5,..." required>
          <small class="tw-text-[#6b7280]">Type numbers only, system will save them as "Lot (number)"</small>
        </div>

        <!-- Lot Area -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Area (sqm)</label>
          <input type="number" name="lot_area" id="editLotArea" step="0.01" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
        </div>

        <!-- Floor Area -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Floor Area (sqm)</label>
          <input type="number" name="floor_area" id="editFloorArea" step="0.01" max="999999999999999.99" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
        </div>

        <!-- Price -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Price</label>
          <input type="number" name="price" id="editPrice" step="0.01" class="tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2" required>
          <div id="editPriceError" class="tw-text-red-500 tw-text-sm tw-mt-1"></div>
        </div>

        <!-- Status -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Status</label>
          <select name="status" id="editStatus" class="tw-bg-white tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            <option value="available">Available</option>
            <option value="sold">Sold</option>
          </select>
        </div>

        <!-- Orientation -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Orientation</label>
          <select name="orientation" id="editOrientation" class="tw-bg-white tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            <option value="north">North</option>
            <option value="south">South</option>
            <option value="east">East</option>
            <option value="west">West</option>
            <option value="northeast">Northeast</option>
            <option value="northwest">Northwest</option>
            <option value="southeast">Southeast</option>
            <option value="southwest">Southwest</option>
          </select>
        </div>

        <!-- Sunlight -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Sunlight</label>
          <select name="sunlight" id="editSunlight" class="tw-bg-white tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            <option value="morning sun">Morning Sun</option>
            <option value="afternoon sun">Afternoon Sun</option>
            <option value="full day sun">Full Day Sun</option>
            <option value="shade">Shade</option>
            <option value="partial shade">Partial Shade</option>
          </select>
        </div>

        <!-- Flood Risk -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Flood Risk</label>
          <select name="flood_risk" id="editFloodRisk" class="tw-bg-white tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </div>

        <!-- Lot Images -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium">Lot Images</label>
          <input type="file" name="lot_images[]" multiple class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-[12px] tw-p-2">
          <small class="tw-text-[#6b7280]">You can upload multiple images.</small>
        </div>

        <!-- Existing Images -->
        <div>
          <label class="tw-block tw-text-[#1f2937] tw-font-medium tw-mt-4">Existing Images</label>
          <div id="existingImagesContainer" class="tw-flex tw-gap-2 tw-flex-wrap"></div>
        </div>
        <!-- Sticky Footer -->
        <div class="tw-border-t tw-p-4 tw-flex tw-justify-end tw-gap-3 tw-bg-white tw-sticky tw-bottom-0">
          <button type="button" onclick="closeEditModal()" class="tw-px-4 tw-py-2 tw-border tw-rounded-[12px] hover:tw-bg-gray-100">Cancel</button>
          <button type="submit" form="editPropertyForm" class="tw-px-4 tw-py-2 tw-bg-[#22c55e] hover:tw-bg-green-600 tw-text-white tw-rounded-[12px]">Update</button>
        </div>
      </form>
    </div>

    
  </div>
</div>



{{-- lot images modal --}}
<div id="lotImageModal" class="tw-fixed tw-inset-0 tw-bg-black/40 tw-flex tw-items-center tw-justify-center tw-hidden tw-z-50">
  <div class="tw-bg-[#f5f7fa] tw-rounded-[12px] tw-shadow-lg tw-max-w-3xl tw-w-full tw-p-6 tw-relative">
      
      {{-- header --}}
      <div class="tw-flex tw-justify-between tw-items-center tw-border-b tw-border-gray-200 tw-pb-3">
          <h2 class="tw-text-xl tw-font-bold tw-text-[#1f2937]">Lot Images</h2>
          <button onclick="closeLotImageModal()" 
                  class="tw-text-gray-500 hover:tw-text-[#22c55e] tw-text-2xl tw-transition-colors">&#10005;</button>
      </div>

      {{-- gallery --}}
      <div id="lotImageGallery" class="tw-relative tw-mt-4 tw-h-[800px] tw-flex tw-items-center tw-justify-center tw-bg-white tw-rounded-[12px] tw-shadow-inner">
        
        {{-- image / alt fallback --}}
        <img 
          id="lotImage" 
          src="" 
          alt="Lot Image"
          class="tw-flex tw-justify-center tw-max-h-full tw-w-full tw-object-contain tw-rounded-[12px] tw-hidden">
        <span id="lotImageFallback" class="tw-text-gray-400 tw-text-lg">No image available</span>

        {{-- controls --}}
        <button onclick="prevLotImage()" 
                class="tw-absolute tw-top-1/2 tw-left-3 -tw-translate-y-1/2 tw-bg-[#22c55e] tw-text-white tw-rounded-full tw-p-3 hover:tw-bg-green-600 tw-shadow-md tw-transition-colors">
            &#8592;
        </button>
        <button onclick="nextLotImage()" 
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