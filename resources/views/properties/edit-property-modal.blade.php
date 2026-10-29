{{-- Edit Property Modal --}}
<div id="editPropertyModal"
    class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="editPropertyTitle">

    <div class="tw-flex tw-max-h-[90vh] tw-w-full tw-max-w-xl tw-flex-col tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-shadow-2xl">

        <div class="tw-flex tw-items-center tw-justify-between tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-px-6">
            <div>
                <h2 id="editPropertyTitle" class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    Edit property
                </h2>
                <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                    Update the lot details and property characteristics.
                </p>
            </div>

            <button type="button"
                aria-label="Close edit property dialog"
                onclick="closeEditModal()"
                class="tw-rounded-lg tw-p-2 tw-text-[#666666] hover:tw-bg-[#D9D9D9]/50 hover:tw-text-[#111111]">
                <span aria-hidden="true" class="tw-text-xl">×</span>
            </button>
        </div>

        <form id="editPropertyForm" method="POST" enctype="multipart/form-data"
            class="tw-flex min-h-0 tw-flex-1 tw-flex-col">
            @csrf
            @method('PUT')
            <input type="hidden" id="editPropertyId" name="property_id">

            <div class="tw-flex-1 tw-space-y-5 tw-overflow-y-auto tw-p-5 sm:tw-px-6">

                <div>
                    <label for="editBlockId" class="{{ $labelClass }}">Block</label>
                    <select name="block_id" id="editBlockId" class="{{ $fieldClass }}" required>
                        @foreach($blocks as $block)
                        <option value="{{ $block->id }}">{{ $block->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="editLotNumbers" class="{{ $labelClass }}">Lot numbers</label>
                    <input type="text" name="lot_numbers" id="editLotNumbers"
                        class="{{ $fieldClass }}" placeholder="e.g., 1, 3, 5" required>
                    <span class="{{ $hintClass }}">Enter lot numbers separated by commas.</span>
                </div>

                <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2">
                    <div>
                        <label for="editLotArea" class="{{ $labelClass }}">Lot area (sqm)</label>
                        <input type="number" name="lot_area" id="editLotArea" step="0.01" min="0.01"
                            class="{{ $fieldClass }}" required>
                    </div>

                    <div>
                        <label for="editFloorArea" class="{{ $labelClass }}">Floor area (sqm)</label>
                        <input type="number" name="floor_area" id="editFloorArea" step="0.01"
                            max="999999999999999.99" min="0"
                            class="{{ $fieldClass }}" required>
                    </div>
                </div>

                <div>
                    <label for="editPrice" class="{{ $labelClass }}">Price (₱)</label>
                    <input type="number" name="price" id="editPrice" step="0.01"
                        min="0" max="999999999999999.99"
                        class="{{ $fieldClass }}" required>
                    <div id="editPriceError" class="tw-mt-1 tw-text-sm tw-text-red-600" role="alert"></div>
                </div>

                <div>
                    <label for="editStatus" class="{{ $labelClass }}">Status</label>
                    <select name="status" id="editStatus" class="{{ $fieldClass }}" required>
                        <option value="available">Available</option>
                        <option value="sold">Sold</option>
                    </select>
                </div>

                <div>
                    <label for="editOrientation" class="{{ $labelClass }}">Orientation</label>
                    <select name="orientation" id="editOrientation" class="{{ $fieldClass }}">
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

                <div>
                    <label for="editSunlight" class="{{ $labelClass }}">Sunlight</label>
                    <select name="sunlight" id="editSunlight" class="{{ $fieldClass }}">
                        <option value="morning sun">Morning sun</option>
                        <option value="afternoon sun">Afternoon sun</option>
                        <option value="full day sun">Full day sun</option>
                        <option value="shade">Shade</option>
                        <option value="partial shade">Partial shade</option>
                    </select>
                </div>

                <div>
                    <label for="editFloodRisk" class="{{ $labelClass }}">Flood risk</label>
                    <select name="flood_risk" id="editFloodRisk" class="{{ $fieldClass }}">
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                    </select>
                </div>

                <div>
                    <label for="editLotImages" class="{{ $labelClass }}">Add more images</label>
                    <input type="file" name="lot_images[]" id="editLotImages" multiple accept="image/*"
                        class="{{ $fieldClass }} file:tw-mr-3 file:tw-rounded-md file:tw-border-0 file:tw-bg-[#D9D9D9]/40 file:tw-px-3 file:tw-py-1.5 file:tw-text-xs file:tw-font-medium file:tw-text-[#111111]">
                    <span class="{{ $hintClass }}">New images will be submitted with the property update.</span>
                </div>

                <div>
                    <label class="tw-mb-2 tw-block tw-text-sm tw-font-medium tw-text-[#111111]">
                        Existing images
                    </label>
                    <div id="existingImagesContainer" class="tw-flex tw-flex-wrap tw-gap-3"></div>
                </div>
            </div>

            <div class="tw-flex tw-flex-col-reverse tw-gap-2 tw-border-t tw-border-[#C4C4C4]/60 tw-bg-white tw-p-4 sm:tw-flex-row sm:tw-justify-end sm:tw-px-6">
                <button type="button" onclick="closeEditModal()" class="{{ $secondaryButtonClass }}">
                    Cancel
                </button>
                <button type="submit" form="editPropertyForm" class="{{ $primaryButtonClass }}">
                    Update property
                </button>
            </div>
        </form>
    </div>
</div>