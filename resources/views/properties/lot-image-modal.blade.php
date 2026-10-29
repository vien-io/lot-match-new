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