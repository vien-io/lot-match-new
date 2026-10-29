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

                    <td class="tw-px-4 tw-py-2 tw-font-medium tw-text-[#111111]">
                        {{ $property->block?->name ?? 'N/A' }}
                    </td>

                    <td class="tw-px-4 tw-py-2 tw-font-medium tw-text-[#111111]">
                        {{ $property->name }}
                    </td>

                    <td class="tw-px-4 tw-py-2 tw-text-[#444444] tw-text-right">
                        {{ $property->lot_area }} sqm
                    </td>

                    <td class="tw-px-4 tw-py-2 tw-text-[#444444] tw-text-right">
                        {{ $property->floor_area }} sqm
                    </td>

                    <td class="tw-px-4 tw-py-2 tw-font-medium tw-tabular-nums tw-text-[#111111] tw-text-right">
                        {{ $property->price !== null ? '₱' . number_format($property->price, 2) : '—' }}
                    </td>

                    <td class="tw-px-4 tw-py-2">
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

                    <td class="tw-px-4 tw-py-2 tw-text-[#444444]">
                        {{ $property->orientation ? ucfirst($property->orientation) : '—' }}
                    </td>

                    <td class="tw-px-4 tw-py-2 tw-text-[#444444]">
                        {{ $property->sunlight ? ucfirst($property->sunlight) : '—' }}
                    </td>

                    <td class="tw-px-4 tw-py-2">
                        {{ $property->flood_risk ? ucfirst($property->flood_risk) : '—' }}
                    </td>

                    <td class="tw-px-4 tw-py-2">
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
                                <i class="fa-regular fa-eye tw-h-5 tw-w-5" aria-hidden="true"></i>
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
                                <i class="fa-solid fa-pen"></i>
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
                                    <i class="fa-solid fa-trash"></i>
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