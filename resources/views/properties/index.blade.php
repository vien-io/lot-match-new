
@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
@vite('resources/css/print.css')

<div class="tw-min-h-screen tw-bg-[#D9D9D9]/40 tw-text-[#111111]">
    <main class="tw-mx-auto tw-w-full tw-max-w-[1800px] tw-px-4 tw-py-6 sm:tw-px-6 lg:tw-px-8 lg:tw-py-8">

        {{-- Page Header --}}
        <header class="tw-mb-7">
            <div class="tw-flex tw-flex-col tw-gap-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                <div>
                    <p class="tw-mb-1 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-[0.14em] tw-text-[#666666]">
                        Property Administration
                    </p>

                    <h1 class="tw-text-2xl tw-font-semibold tw-tracking-tight tw-text-[#111111] sm:tw-text-3xl">
                        Property Management
                    </h1>

                    <p class="tw-mt-2 tw-text-sm tw-leading-6 tw-text-[#666666]">
                        Add, edit, and manage subdivision properties in one place.
                    </p>
                </div>

                <button
                    type="button"
                    onclick="document.getElementById('addPropertyModal').classList.remove('tw-hidden')"
                    class="tw-inline-flex tw-w-fit tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2">
                    <span class="tw-text-lg tw-leading-none" aria-hidden="true">+</span>
                    Add Property
                </button>
            </div>
        </header>

        {{-- Property Table Panel --}}
        <section class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

            {{-- Toolbar --}}
            <div class="tw-flex tw-flex-col tw-gap-4 tw-border-b tw-border-[#C4C4C4]/60 tw-p-4 sm:tw-p-5 lg:tw-flex-row lg:tw-items-center lg:tw-justify-between">

                <div>
                    <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                        Property inventory
                    </h2>
                    <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                        Review lot details, availability, and property characteristics.
                    </p>
                </div>

                <div class="tw-flex tw-flex-col tw-gap-2 sm:tw-flex-row sm:tw-items-center">

                    {{-- Search --}}
                    <form method="GET"
                          action="{{ route('properties.index') }}"
                          class="tw-flex tw-min-w-0 tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-transition focus-within:tw-border-[#06100D] focus-within:tw-ring-2 focus-within:tw-ring-[#06EBB6]/40 sm:tw-w-[320px]">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="tw-h-4 tw-w-4 tw-shrink-0 tw-text-[#666666]"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>

                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Search properties..."
                            aria-label="Search by block, lot, or status"
                            class="tw-min-w-0 tw-flex-1 tw-bg-transparent tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none placeholder:tw-text-[#999999]"
                        />

                        @if(request('search'))
                            <a href="{{ route('properties.index') }}"
                               class="tw-shrink-0 tw-text-xs tw-font-medium tw-text-[#666666] hover:tw-text-[#111111]">
                                Clear
                            </a>
                        @endif
                    </form>

                    {{-- Print --}}
                    <button
                        type="button"
                        onclick="window.print()"
                        class="tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-py-2.5 tw-text-sm tw-font-medium tw-text-[#111111] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="tw-h-4 tw-w-4"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor"
                             aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2m-4 0v4m0 0h4m-4 0H8" />
                        </svg>
                        Print
                    </button>
                </div>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="tw-flex tw-items-start tw-gap-3 tw-border-b tw-border-[#06EBB6]/30 tw-bg-[#06EBB6]/10 tw-px-5 tw-py-3.5"
                     role="status">
                    <span class="tw-font-semibold tw-text-[#06100D]" aria-hidden="true">✓</span>
                    <p class="tw-text-sm tw-text-[#06100D]">{{ session('success') }}</p>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="tw-border-b tw-border-red-200 tw-bg-red-50 tw-px-5 tw-py-3.5"
                     role="alert">
                    <p class="tw-text-sm tw-font-semibold tw-text-red-800">
                        Please check the submitted information.
                    </p>
                    <ul class="tw-mt-1 tw-list-inside tw-list-disc tw-text-sm tw-text-red-700">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Printable Table --}}
            <div id="printable">
                <div class="tw-overflow-x-auto">
                    <table class="tw-w-full tw-whitespace-nowrap tw-text-left tw-text-sm">
                        <thead class="tw-bg-[#06100D] tw-text-white">
                            <tr>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Block</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Lot</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Lot Area</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Floor Area</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Price</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Status</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Orientation</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Sunlight</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Flood Risk</th>
                                <th scope="col" class="tw-px-4 tw-py-3.5 tw-text-center tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="tw-divide-y tw-divide-[#C4C4C4]/50">
                            @forelse($properties as $property)
                                <tr class="tw-transition-colors hover:tw-bg-[#D9D9D9]/20">

                                    <td class="tw-px-4 tw-py-4 tw-font-medium tw-text-[#111111]">
                                        {{ $property->block?->name ?? 'N/A' }}
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-font-medium tw-text-[#111111]">
                                        {{ $property->name }}
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-text-[#444444]">
                                        {{ $property->lot_area }} sqm
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-text-[#444444]">
                                        {{ $property->floor_area }} sqm
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-font-medium tw-tabular-nums tw-text-[#111111]">
                                        {{ $property->price !== null ? '₱' . number_format($property->price, 2) : '—' }}
                                    </td>

                                    <td class="tw-px-4 tw-py-4">
                                        @if($property->status === 'available')
                                            <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-md tw-bg-[#06EBB6]/20 tw-px-2.5 tw-py-1 tw-text-xs tw-font-semibold tw-text-[#06100D]">
                                                <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#087F5B]"></span>
                                                Available
                                            </span>
                                        @else
                                            <span class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-md tw-bg-[#D9D9D9]/60 tw-px-2.5 tw-py-1 tw-text-xs tw-font-semibold tw-text-[#444444]">
                                                <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#666666]"></span>
                                                {{ ucfirst($property->status) }}
                                            </span>
                                        @endif
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-text-[#444444]">
                                        {{ $property->orientation ? ucfirst($property->orientation) : '—' }}
                                    </td>

                                    <td class="tw-px-4 tw-py-4 tw-text-[#444444]">
                                        {{ $property->sunlight ? ucfirst($property->sunlight) : '—' }}
                                    </td>

                                    <td class="tw-px-4 tw-py-4">
                                        @if($property->flood_risk === 'high')
                                            <span class="tw-font-medium tw-text-red-700">High</span>
                                        @elseif($property->flood_risk === 'medium')
                                            <span class="tw-font-medium tw-text-[#8A5A00]">Medium</span>
                                        @elseif($property->flood_risk === 'low')
                                            <span class="tw-text-[#087F5B]">Low</span>
                                        @else
                                            <span class="tw-text-[#666666]">—</span>
                                        @endif
                                    </td>

                                    <td class="tw-px-4 tw-py-4">
                                        <div class="tw-flex tw-items-center tw-justify-center tw-gap-1">

                                            @php
                                                $imagesArray = $property->images->map(fn($i) => [
                                                    'id' => $i->id,
                                                    'url' => asset($i->path)
                                                ]);
                                            @endphp

                                            {{-- View Images --}}
                                            <button type="button"
                                                aria-label="View images for {{ $property->name }}"
                                                title="View images"
                                                onclick='openLotImageGallery({{ $property->id }}, @json($imagesArray->pluck("url")))'
                                                class="tw-rounded-lg tw-p-2 tw-text-[#444444] tw-transition-colors hover:tw-bg-[#06EBB6]/20 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l9-9 9 9M4 12v8h16v-8" />
                                                </svg>
                                            </button>

                                            {{-- Edit --}}
                                            <button type="button"
                                                aria-label="Edit {{ $property->name }}"
                                                title="Edit property"
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
                                                class="tw-rounded-lg tw-p-2 tw-text-[#444444] tw-transition-colors hover:tw-bg-[#06EBB6]/20 hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                                </svg>
                                            </button>

                                            {{-- Delete --}}
                                            <form method="POST"
                                                  action="{{ route('properties.destroy', $property->id) }}"
                                                  onsubmit="return confirm('Delete this property?')">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                    aria-label="Delete {{ $property->name }}"
                                                    title="Delete property"
                                                    class="tw-rounded-lg tw-p-2 tw-text-[#666666] tw-transition-colors hover:tw-bg-red-50 hover:tw-text-red-700 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-red-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="tw-px-6 tw-py-16 tw-text-center">
                                        <div class="tw-mx-auto tw-flex tw-max-w-sm tw-flex-col tw-items-center">
                                            <div class="tw-flex tw-h-12 tw-w-12 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#D9D9D9]/50 tw-text-xl tw-text-[#666666]" aria-hidden="true">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-6 tw-w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M3 10l9-7 9 7M5 9v11h14V9M9 20v-7h6v7" />
                                                </svg>
                                            </div>

                                            <h3 class="tw-mt-4 tw-text-sm tw-font-semibold tw-text-[#111111]">
                                                No properties found
                                            </h3>

                                            <p class="tw-mt-1 tw-text-sm tw-leading-6 tw-text-[#666666]">
                                                @if(request('search'))
                                                    Try a different search term or clear your search.
                                                @else
                                                    Add a property to start managing your subdivision inventory.
                                                @endif
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Pagination --}}
            <div class="tw-flex tw-flex-col tw-gap-3 tw-border-t tw-border-[#C4C4C4]/60 tw-p-4 tw-text-sm tw-text-[#666666] sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                <span>
                    Showing {{ $properties->firstItem() ?? 0 }}–{{ $properties->lastItem() ?? 0 }}
                    of {{ $properties->total() }} properties
                </span>

                <div class="tw-overflow-x-auto">
                    {{ $properties->links('vendor.pagination.custom') }}
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="tw-mt-8 tw-border-t tw-border-[#C4C4C4]/70 tw-py-5">
            <p class="tw-text-center tw-text-xs tw-leading-5 tw-text-[#666666]">
                © {{ date('Y') }} LotMatch. All rights reserved.
            </p>
        </footer>
    </main>
</div>

{{-- Shared Form Control Styling --}}
@php
    $fieldClass = 'tw-mt-1 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40';
    $labelClass = 'tw-block tw-text-sm tw-font-medium tw-text-[#111111]';
    $hintClass = 'tw-mt-1 tw-block tw-text-xs tw-leading-5 tw-text-[#666666]';
    $primaryButtonClass = 'tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2';
    $secondaryButtonClass = 'tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-py-2.5 tw-text-sm tw-font-medium tw-text-[#111111] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]';
@endphp

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
                            <option value="{{ $block->id }}" @selected(old('block_id') == $block->id)>
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
                        <option value="available" @selected(old('status', 'available') === 'available')>Available</option>
                        <option value="sold" @selected(old('status') === 'sold')>Sold</option>
                    </select>
                </div>

                <div>
                    <label for="addOrientation" class="{{ $labelClass }}">Orientation</label>
                    <select id="addOrientation" name="orientation" class="{{ $fieldClass }}">
                        @foreach(['north' => 'North', 'south' => 'South', 'east' => 'East', 'west' => 'West', 'northeast' => 'Northeast', 'northwest' => 'Northwest', 'southeast' => 'Southeast', 'southwest' => 'Southwest'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('orientation', 'north') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addSunlight" class="{{ $labelClass }}">Sunlight</label>
                    <select id="addSunlight" name="sunlight" class="{{ $fieldClass }}">
                        @foreach(['morning sun' => 'Morning sun', 'afternoon sun' => 'Afternoon sun', 'full day sun' => 'Full day sun', 'shade' => 'Shade', 'partial shade' => 'Partial shade'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('sunlight', 'morning sun') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="addFloodRisk" class="{{ $labelClass }}">Flood risk</label>
                    <select id="addFloodRisk" name="flood_risk" class="{{ $fieldClass }}">
                        @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('flood_risk', 'low') === $value)>{{ $label }}</option>
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

{{-- Lot Images Modal --}}
<div id="lotImageModal"
     class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/70 tw-p-4"
     role="dialog"
     aria-modal="true"
     aria-labelledby="lotImageTitle">

    <div class="tw-flex tw-max-h-[90vh] tw-w-full tw-max-w-5xl tw-flex-col tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-shadow-2xl">

        <div class="tw-flex tw-items-center tw-justify-between tw-border-b tw-border-[#C4C4C4]/60 tw-px-5 tw-py-4 sm:tw-px-6">
            <div>
                <h2 id="lotImageTitle" class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                    Lot images
                </h2>
                <p class="tw-mt-1 tw-text-sm tw-text-[#666666]">
                    View property photos.
                </p>
            </div>

            <button type="button"
                    onclick="closeLotImageModal()"
                    aria-label="Close lot image gallery"
                    class="tw-rounded-lg tw-p-2 tw-text-[#666666] hover:tw-bg-[#D9D9D9]/50 hover:tw-text-[#111111]">
                <span aria-hidden="true" class="tw-text-xl">×</span>
            </button>
        </div>

        <div id="lotImageGallery"
             class="tw-relative tw-flex tw-min-h-[260px] tw-flex-1 tw-items-center tw-justify-center tw-overflow-hidden tw-bg-[#D9D9D9]/20 tw-p-4 sm:tw-min-h-[400px]">

            <img id="lotImage"
                 src=""
                 alt="Lot image"
                 class="tw-hidden tw-max-h-[65vh] tw-w-full tw-rounded-lg tw-object-contain">

            <span id="lotImageFallback"
                  class="tw-text-sm tw-text-[#666666]">
                No image available
            </span>

            <button type="button"
                    onclick="prevLotImage()"
                    aria-label="Previous image"
                    class="tw-absolute tw-left-3 tw-top-1/2 tw-flex tw-h-10 tw-w-10 -tw-translate-y-1/2 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-text-lg tw-text-[#111111] tw-shadow-sm tw-transition-colors hover:tw-bg-[#06EBB6] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                ←
            </button>

            <button type="button"
                    onclick="nextLotImage()"
                    aria-label="Next image"
                    class="tw-absolute tw-right-3 tw-top-1/2 tw-flex tw-h-10 tw-w-10 -tw-translate-y-1/2 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-text-lg tw-text-[#111111] tw-shadow-sm tw-transition-colors hover:tw-bg-[#06EBB6] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">
                →
            </button>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @vite('resources/js/properties.js')
@endsection
