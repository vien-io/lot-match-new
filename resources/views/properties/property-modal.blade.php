{{-- Add Property Modal --}}
<div id="addPropertyModal"
    class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="addPropertyTitle">

    <div class="tw-flex tw-max-h-[90vh] tw-w-full tw-max-w-xl tw-flex-col tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-shadow-2xl">

        <div class="tw-flex tw-items-center tw-justify-between tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-px-6">
            <div>
                <h2 id="addPropertyTitle" class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    Add property
                </h2>
                <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                    Enter the lot details and property characteristics.
                </p>
            </div>

            <button type="button"
                aria-label="Close add property dialog"
                onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')"
                class="tw-rounded-lg tw-p-2 tw-text-[#666666] hover:tw-bg-[#D9D9D9]/50 hover:tw-text-[#111111]">
                <span aria-hidden="true" class="tw-text-xl">×</span>
            </button>
        </div>

        <form method="POST"
            action="{{ route('properties.store') }}"
            enctype="multipart/form-data"
            class="tw-flex tw-min-h-0 tw-flex-1 tw-flex-col">
            @csrf

            <div class="tw-flex-1 tw-space-y-5 tw-overflow-y-auto tw-p-5 sm:tw-px-6">

                <div>
                    <label for="addBlockId" class="{{ $labelClass }}">Block</label>
                    <select id="addBlockId" name="block_id" class="{{ $fieldClass }}" required>
                        @foreach($blocks as $block)
                        <option value="{{ $block->id }}" @selected(old('block_id')==$block->id)>
                            {{ $block->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addLotNumbers" class="{{ $labelClass }}">Lot numbers</label>
                    <input id="addLotNumbers" type="text" name="lot_numbers"
                        value="{{ old('lot_numbers') }}"
                        class="{{ $fieldClass }}"
                        placeholder="e.g., 1, 3, 5, 6"
                        required>
                    <span class="{{ $hintClass }}">Enter lot numbers separated by commas.</span>
                </div>

                <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2">
                    <div>
                        <label for="addLotArea" class="{{ $labelClass }}">Lot area (sqm)</label>
                        <input id="addLotArea" type="number" name="lot_area" step="0.01" min="0.01"
                            value="{{ old('lot_area') }}" class="{{ $fieldClass }}" required>
                    </div>

                    <div>
                        <label for="addFloorArea" class="{{ $labelClass }}">Floor area (sqm)</label>
                        <input id="addFloorArea" type="number" name="floor_area" step="0.01" min="0"
                            value="{{ old('floor_area') }}" class="{{ $fieldClass }}" required>
                    </div>
                </div>

                <div>
                    <label for="price" class="{{ $labelClass }}">Price (₱)</label>
                    <input type="number" name="price" id="price" step="0.01"
                        min="0" max="999999999999999.99"
                        value="{{ old('price') }}" class="{{ $fieldClass }}" required>
                    <div id="priceError" class="tw-mt-1 tw-text-sm tw-text-red-600" role="alert"></div>
                </div>

                <div>
                    <label for="addStatus" class="{{ $labelClass }}">Status</label>
                    <select id="addStatus" name="status" class="{{ $fieldClass }}" required>
                        <option value="available" @selected(old('status', 'available' )==='available' )>Available</option>
                        <option value="sold" @selected(old('status')==='sold' )>Sold</option>
                    </select>
                </div>

                <div>
                    <label for="addOrientation" class="{{ $labelClass }}">Orientation</label>
                    <select id="addOrientation" name="orientation" class="{{ $fieldClass }}">
                        @foreach(['north' => 'North', 'south' => 'South', 'east' => 'East', 'west' => 'West', 'northeast' => 'Northeast', 'northwest' => 'Northwest', 'southeast' => 'Southeast', 'southwest' => 'Southwest'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('orientation', 'north' )===$value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addSunlight" class="{{ $labelClass }}">Sunlight</label>
                    <select id="addSunlight" name="sunlight" class="{{ $fieldClass }}">
                        @foreach(['morning sun' => 'Morning sun', 'afternoon sun' => 'Afternoon sun', 'full day sun' => 'Full day sun', 'shade' => 'Shade', 'partial shade' => 'Partial shade'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('sunlight', 'morning sun' )===$value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addFloodRisk" class="{{ $labelClass }}">Flood risk</label>
                    <select id="addFloodRisk" name="flood_risk" class="{{ $fieldClass }}">
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('flood_risk', 'low' )===$value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addLotImages" class="{{ $labelClass }}">Lot images</label>
                    <input id="addLotImages" type="file" name="lot_images[]" multiple accept="image/*"
                        class="{{ $fieldClass }} file:tw-mr-3 file:tw-rounded-md file:tw-border-0 file:tw-bg-[#D9D9D9]/40 file:tw-px-3 file:tw-py-1.5 file:tw-text-xs file:tw-font-medium file:tw-text-[#111111]">
                    <span class="{{ $hintClass }}">You can upload multiple images.</span>
                </div>
            </div>

            <div class="tw-flex tw-flex-col-reverse tw-gap-2 tw-border-t tw-border-[#C4C4C4]/60 tw-bg-white tw-p-4 sm:tw-flex-row sm:tw-justify-end sm:tw-px-6">
                <button type="button"
                    onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')"
                    class="{{ $secondaryButtonClass }}">
                    Cancel
                </button>
                <button type="submit" class="{{ $primaryButtonClass }}">
                    Save property
                </button>
            </div>
        </form>
    </div>
</div>