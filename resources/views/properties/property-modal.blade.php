{{-- Add Property Modal --}}
<div id="addPropertyModal"
    class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-3 sm:tw-p-5"
    role="dialog" aria-modal="true" aria-labelledby="addPropertyTitle" aria-describedby="addPropertyDescription">

    <div
        class="tw-flex tw-max-h-[94vh] tw-w-full tw-max-w-3xl tw-flex-col tw-overflow-hidden tw-rounded-2xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-shadow-[0_24px_80px_rgba(6,16,13,0.18)]">

        {{-- Header --}}
        <div class="tw-flex tw-shrink-0 tw-items-center tw-justify-between
    tw-border-b tw-border-[#C4C4C4]/50
    tw-px-5 tw-py-5 sm:tw-px-7">


            {{-- Title --}}
            <div class=" tw-min-w-0">
                <h2 id="addPropertyTitle" class="tw-text-xl tw-font-semibold tw-tracking-tight tw-text-[#111111]">
                    Add Property
                </h2>

                <p id="addPropertyDescription" class="tw-text-xs tw-leading-relaxed tw-text-[#666666] sm:tw-text-sm">
                    Add a new lot and configure its property details.
                </p>
            </div>

            {{-- Close --}}
            <button type="button" aria-label="Close add property dialog"
                onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')" class="tw-ml-3 tw-flex tw-h-9 tw-w-9 tw-shrink-0
           tw-items-center tw-justify-center
           tw-rounded-xl tw-border tw-border-[#C4C4C4]/60
           tw-bg-white tw-text-[#666666]
           tw-transition-all tw-duration-200 tw-ease-out
           hover:tw-border-[#FCA5A5]
           hover:tw-bg-[#FEF2F2]
           hover:tw-text-[#DC2626]
           hover:tw-shadow-sm hover:tw-scale-105
           active:tw-scale-95
           focus:tw-outline-none focus:tw-ring-2
           focus:tw-ring-[#eb0606] focus:tw-ring-offset-2">

                <i class="fa-solid fa-xmark tw-text-sm" aria-hidden="true"></i>
            </button>


        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('properties.store') }}" enctype="multipart/form-data"
            class="tw-flex tw-min-h-0 tw-flex-1 tw-flex-col tw-mx-2">

            @csrf

            {{-- Scrollable Content --}}
            <div class="tw-flex-1 tw-space-y-7 tw-overflow-y-auto tw-px-5 tw-py-6 sm:tw-px-7 tw-mb-5">

                {{-- Section 01: Lot Information --}}
                <section class="tw-space-y-4">

                    <div class="tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-7 tw-w-7 tw-items-center tw-justify-center tw-rounded-lg tw-bg-black tw-text-xs tw-font-bold tw-text-[#06EBB6]/75">
                            01
                        </span>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                Lot Information
                            </h3>
                            <p class="tw-mt-0.5 tw-text-xs tw-text-[#666666]">
                                Identify the lot and its physical dimensions.
                            </p>
                        </div>
                    </div>

                    <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 tw-mx-3">

                        {{-- Block --}}
                        <div>
                            <label for="addBlockId"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Block <span class="tw-text-red-500">*</span>
                            </label>

                            <input type="number" id="addBlockId" name="block_id" value="{{ old('block_id') }}" min="1"
                                step="1"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                placeholder="Enter block number" required>
                        </div>

                        {{-- Lot Numbers --}}
                        <div>
                            <label for="addLotNumber"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Lot Number <span class="tw-text-red-500">*</span>
                            </label>

                            <input id="addLotNumber" type="text" name="lot_number" value="{{ old('lot_number') }}"
                                placeholder="Enter lot number"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all placeholder:tw-text-[#999999] focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                required>
                        </div>

                        {{-- Lot Area --}}
                        <div>
                            <label for="addLotArea"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Lot Area <span class="tw-text-red-500">*</span>
                            </label>

                            <div class="tw-relative">
                                <input id="addLotArea" type="number" name="lot_area" step="0.01" min="0.01"
                                    value="{{ old('lot_area') }}" placeholder="0.00"
                                    class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-pr-14 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all placeholder:tw-text-[#999999] focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                    required>

                                <span
                                    class="tw-pointer-events-none tw-absolute tw-right-3 tw-top-1/2 tw--translate-y-1/2 tw-text-xs tw-text-[#888888]">
                                    sqm
                                </span>
                            </div>
                        </div>

                        {{-- Floor Area --}}
                        <div>
                            <label for="addFloorArea"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Floor Area <span class="tw-text-red-500">*</span>
                            </label>

                            <div class="tw-relative">
                                <input id="addFloorArea" type="number" name="floor_area" step="0.01" min="0"
                                    value="{{ old('floor_area') }}" placeholder="0.00"
                                    class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-pr-14 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all placeholder:tw-text-[#999999] focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                    required>

                                <span
                                    class="tw-pointer-events-none tw-absolute tw-right-3 tw-top-1/2 tw--translate-y-1/2 tw-text-xs tw-text-[#888888]">
                                    sqm
                                </span>
                            </div>
                        </div>

                        {{-- Price --}}
                        <div class="sm:tw-col-span-2">
                            <label for="price" class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Property Price <span class="tw-text-red-500">*</span>
                            </label>

                            <div class="tw-relative">
                                <span
                                    class="tw-pointer-events-none tw-absolute tw-left-3 tw-top-1/2 tw--translate-y-1/2 tw-text-sm tw-font-medium tw-text-[#666666]">
                                    ₱
                                </span>

                                <input type="number" name="price" id="price" step="0.01" min="0"
                                    max="999999999999999.99" value="{{ old('price') }}" placeholder="0.00"
                                    class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-pl-8 tw-pr-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all placeholder:tw-text-[#999999] focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                    required>
                            </div>

                            <div id="priceError" class="tw-mt-1 tw-text-xs tw-text-red-600" role="alert"></div>
                        </div>

                    </div>
                </section>

                <div class="tw-border-t tw-border-[#C4C4C4]/50"></div>

                {{-- Section 02: Property Characteristics --}}
                <section class="tw-space-y-4">

                    <div class="tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-7 tw-w-7 tw-items-center tw-justify-center tw-rounded-lg tw-bg-black tw-text-xs tw-font-bold tw-text-[#06EBB6]/75">
                            02
                        </span>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                Property Characteristics
                            </h3>
                            <p class="tw-mt-0.5 tw-text-xs tw-text-[#666666]">
                                Define the property's availability and environmental attributes.
                            </p>
                        </div>
                    </div>

                    <div class="tw-grid tw-grid-cols-1 tw-gap-4 sm:tw-grid-cols-2 tw-mx-3">

                        {{-- Status --}}
                        <div>
                            <label for="addStatus"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Availability Status <span class="tw-text-red-500">*</span>
                            </label>

                            <select id="addStatus" name="status"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                required>

                                <option value="available" @selected(old('status', 'available') === 'available')>
                                    Available
                                </option>

                                <option value="sold" @selected(old('status') === 'sold')>
                                    Sold
                                </option>

                            </select>
                        </div>

                        {{-- Orientation --}}
                        <div>
                            <label for="addOrientation"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Orientation
                            </label>

                            <select id="addOrientation" name="orientation"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">

                                @foreach(['north' => 'North', 'south' => 'South', 'east' => 'East', 'west' => 'West', 'northeast' => 'Northeast', 'northwest' => 'Northwest', 'southeast' => 'Southeast', 'southwest' => 'Southwest'] as $value => $label)

                                    <option value="{{ $value }}" @selected(old('orientation', 'north') === $value)>
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Sunlight --}}
                        <div>
                            <label for="addSunlight"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Sunlight Exposure
                            </label>

                            <select id="addSunlight" name="sunlight"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">

                                @foreach(['morning sun' => 'Morning sun', 'afternoon sun' => 'Afternoon sun', 'full day sun' => 'Full day sun', 'shade' => 'Shade', 'partial shade' => 'Partial shade'] as $value => $label)

                                    <option value="{{ $value }}" @selected(old('sunlight', 'morning sun') === $value)>
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                        {{-- Flood Risk --}}
                        <div>
                            <label for="addFloodRisk"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#333333]">
                                Flood Risk
                            </label>

                            <select id="addFloodRisk" name="flood_risk"
                                class="tw-h-11 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-all focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">

                                @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)

                                    <option value="{{ $value }}" @selected(old('flood_risk', 'low') === $value)>
                                        {{ $label }}
                                    </option>

                                @endforeach

                            </select>
                        </div>

                    </div>
                </section>

                <div class="tw-border-t tw-border-[#C4C4C4]/50"></div>

                {{-- Section 03: Property Images --}}
                <section class="tw-space-y-4">

                    <div class="tw-flex tw-items-center tw-gap-3">
                        <span
                            class="tw-flex tw-h-7 tw-w-7 tw-items-center tw-justify-center tw-rounded-lg tw-bg-black tw-text-xs tw-font-bold tw-text-[#06EBB6]/75">
                            03
                        </span>

                        <div>
                            <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                Property Images
                            </h3>
                            <p class="tw-mt-0.5 tw-text-xs tw-text-[#666666]">
                                Upload photos to showcase the property.
                            </p>
                        </div>
                    </div>

                    <div
                        class="tw-rounded-xl tw-border tw-border-dashed tw-border-[#C4C4C4] tw-bg-[#D9D9D9]/15 tw-p-4 tw-transition-colors hover:tw-border-[#06EBB6] hover:tw-bg-[#06EBB6]/5 tw-mx-3">

                        <div class="tw-flex tw-flex-col tw-items-center tw-gap-3 tw-py-3 tw-text-center">

                            <div
                                class="tw-flex tw-h-11 tw-w-11 tw-items-center tw-justify-center tw-rounded-xl tw-bg-white tw-text-[#06100D] tw-shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 16V4m0 0L7 9m5-5l5 5M5 16v3a1 1 0 001 1h12a1 1 0 001-1v-3" />
                                </svg>
                            </div>

                            <div>
                                <p class="tw-text-sm tw-font-medium tw-text-[#111111]">
                                    Select property images
                                </p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                                    Upload one or multiple image files.
                                </p>
                            </div>

                            <div class="tw-flex tw-w-full tw-justify-center">
                                <input id="addLotImages" type="file" name="lot_images[]" multiple accept="image/*"
                                    class="tw-block tw-w-fit tw-max-w-full tw-text-xs tw-text-[#666666] file:tw-mr-3 file:tw-cursor-pointer file:tw-rounded-lg file:tw-border-0 file:tw-bg-[#06100D] file:tw-px-4 file:tw-py-2 file:tw-text-xs file:tw-font-medium file:tw-text-white file:tw-transition-colors hover:file:tw-bg-[#1A302A]">
                            </div>

                        </div>
                    </div>

                </section>

            </div>

            {{-- Footer --}}
            <div
                class="tw-flex tw-shrink-0 tw-flex-col-reverse tw-gap-2 tw-border-t tw-border-[#C4C4C4]/50 tw-bg-white tw-px-5 tw-py-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between sm:tw-px-7">

                <p class="tw-hidden tw-text-[11px] tw-text-[#888888] sm:tw-block">
                    <span class="tw-text-red-500">*</span> Required fields
                </p>

                <div class="tw-flex tw-flex-col-reverse tw-gap-2 sm:tw-flex-row sm:tw-items-center">

                    <button type="button"
                        onclick="document.getElementById('addPropertyModal').classList.add('tw-hidden')"
                        class="tw-h-10 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-5 tw-text-sm tw-font-medium tw-text-[#333333] tw-transition-all hover:tw-bg-[#D9D9D9]/30 hover:tw-text-[#111111] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/30">
                        Cancel
                    </button>

                    <button type="submit"
                        class="tw-inline-flex tw-h-10 tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-6 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-shadow-sm tw-transition-all hover:tw-bg-[#1ED9D7] hover:tw-shadow-md focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2 active:tw-scale-[0.98]">

                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12l4 4L19 6" />
                        </svg>

                        Save Property
                    </button>

                </div>
            </div>

        </form>
    </div>
</div>