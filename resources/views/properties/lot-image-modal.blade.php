{{-- Lot Images Modal --}}
<div id="lotImageModal"
    class="tw-fixed tw-inset-0 tw-z-50 tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/75 tw-p-3 sm:tw-p-6"
    role="dialog" aria-modal="true" aria-labelledby="lotImageTitle">

    {{-- Gallery Container --}}
    <div
        class="tw-flex tw-max-h-[94vh] tw-w-full tw-max-w-6xl tw-flex-col tw-overflow-hidden tw-rounded-2xl tw-bg-[#111111] tw-shadow-[0_30px_100px_rgba(0,0,0,0.45)] sm:tw-rounded-[24px]">

        {{-- Top Navigation --}}
        <div
            class="tw-flex tw-h-[68px] tw-shrink-0 tw-items-center tw-justify-between tw-px-5 sm:tw-h-[76px] sm:tw-px-8">

            {{-- Gallery Information --}}
            <div class="tw-flex tw-items-center tw-gap-3">

                <div
                    class="tw-flex tw-h-9 tw-w-9 tw-items-center tw-justify-center tw-rounded-xl tw-bg-white/[0.06] tw-text-white/70">
                    <i class="fa-regular fa-images tw-text-sm" aria-hidden="true"></i>
                </div>

                <div class="tw-flex tw-flex-col tw-gap-0.5">
                    <span class="tw-text-sm tw-font-semibold tw-text-white">
                        Property Gallery
                    </span>

                    <span id="lotImageCounter" class="tw-text-[11px] tw-font-medium tw-tabular-nums tw-text-white/45">
                        01 / 01
                    </span>
                </div>

            </div>

            {{-- Close Button --}}
            <button type="button" onclick="closeLotImageModal()" aria-label="Close lot image gallery"
                class="tw-flex tw-h-10 tw-w-10 tw-items-center tw-justify-center tw-rounded-xl tw-text-white/70 tw-transition-colors hover:tw-bg-white/10 hover:tw-text-white focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">

                <i class="fa-solid fa-xmark tw-text-xl" aria-hidden="true"></i>
            </button>

        </div>

        {{-- Main Gallery Content --}}
        <div
            class="tw-flex tw-min-h-0 tw-flex-1 tw-flex-col tw-gap-5 tw-overflow-y-auto tw-px-4 tw-pb-5 sm:tw-gap-7 sm:tw-px-8 sm:tw-pb-8">

            {{-- Main Image Stage --}}
            <div id="lotImageGallery"
                class="tw-group tw-relative tw-flex tw-min-h-[240px] tw-w-full tw-flex-1 tw-items-center tw-justify-center tw-overflow-hidden tw-rounded-xl tw-bg-[#1B1B1B] sm:tw-min-h-[350px]">

                {{-- Main Property Image --}}
                <img id="lotImage" src="" alt="Lot image"
                    class="tw-hidden tw-h-full tw-max-h-[58vh] tw-w-full tw-rounded-xl tw-object-cover tw-transition-opacity tw-duration-300">

                {{-- Empty State --}}
                <div id="lotImageFallback"
                    class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-gap-4 tw-p-8 tw-text-center">

                    <div
                        class="tw-flex tw-h-16 tw-w-16 tw-items-center tw-justify-center tw-rounded-2xl tw-bg-white/[0.06] tw-text-white/40">
                        <i class="fa-regular fa-image tw-text-3xl" aria-hidden="true"></i>
                    </div>

                    <div>
                        <p class="tw-text-sm tw-font-semibold tw-text-white">
                            No images available
                        </p>

                        <p class="tw-mt-1 tw-text-xs tw-text-white/45">
                            Photos for this property haven't been uploaded yet.
                        </p>
                    </div>
                </div>

                {{-- Previous Image --}}
                <button type="button" onclick="prevLotImage()" aria-label="Previous image"
                    class="tw-absolute tw-left-3 tw-top-1/2 tw-flex tw-h-10 tw-w-10 -tw-translate-y-1/2 tw-items-center tw-justify-center tw-rounded-full tw-border tw-border-white/15 tw-bg-black/40 tw-text-white tw-opacity-100 tw-backdrop-blur-md tw-transition-all hover:tw-border-[#06EBB6] hover:tw-bg-[#06EBB6] hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6] sm:tw-left-5 sm:tw-h-12 sm:tw-w-12 sm:tw-opacity-0 sm:group-hover:tw-opacity-100 sm:group-focus-within:tw-opacity-100">

                    <i class="fa-solid fa-chevron-left tw-text-xs" aria-hidden="true"></i>
                </button>

                {{-- Next Image --}}
                <button type="button" onclick="nextLotImage()" aria-label="Next image"
                    class="tw-absolute tw-right-3 tw-top-1/2 tw-flex tw-h-10 tw-w-10 -tw-translate-y-1/2 tw-items-center tw-justify-center tw-rounded-full tw-border tw-border-white/15 tw-bg-black/40 tw-text-white tw-opacity-100 tw-backdrop-blur-md tw-transition-all hover:tw-border-[#06EBB6] hover:tw-bg-[#06EBB6] hover:tw-text-[#06100D] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6] sm:tw-right-5 sm:tw-h-12 sm:tw-w-12 sm:tw-opacity-0 sm:group-hover:tw-opacity-100 sm:group-focus-within:tw-opacity-100">

                    <i class="fa-solid fa-chevron-right tw-text-xs" aria-hidden="true"></i>
                </button>

                {{-- Delete Current Image --}}
                <button type="button" id="deleteLotImageButton"
                    aria-label="Delete current image"
                    class="tw-absolute tw-right-3 tw-top-3 tw-z-10 tw-flex tw-h-10 tw-items-center tw-gap-2 tw-rounded-xl tw-border tw-border-red-400/20 tw-bg-black/50 tw-px-3 tw-text-xs tw-font-medium tw-text-red-400 tw-backdrop-blur-md tw-transition-all hover:tw-border-red-400/50 hover:tw-bg-red-500 hover:tw-text-white focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-red-400">

                    <i class="fa-regular fa-trash-can" aria-hidden="true"></i>
                </button>

            </div>

            {{-- Thumbnail Gallery --}}
            <div id="lotImageThumbnails" class="tw-grid tw-grid-cols-3 tw-gap-3 sm:tw-gap-4"></div>

        </div>
    </div>
</div>