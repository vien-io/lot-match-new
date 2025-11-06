<div id="addImageModal" 
    class="modal tw-fixed tw-inset-0 tw-flex tw-items-center tw-justify-center tw-bg-black/50 tw-z-50 tw-hidden tw-animate-[modal-pop_0.25s_ease-out]">

    <div class="modal-content tw-w-11/12 sm:tw-w-[400px] tw-p-6 tw-relative
        tw-rounded-2xl tw-text-white tw-font-sans
        tw-flex tw-flex-col tw-gap-6
        tw-border-2 tw-border-solid
        tw-bg-[#212121]
        tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">

        <!-- Header -->
        <div class="tw-flex tw-justify-between tw-items-center">
            <h2 class="tw-text-xl tw-font-semibold tw-text-[#ffffff]">Add Lot Image</h2>
            <span 
                class="close-btn tw-text-2xl tw-cursor-pointer tw-text-[#22C55E]
                [text-shadow:0_0_8px_#22C55E]
                hover:[text-shadow:0_0_18px_#22C55E]
                hover:tw-text-[#84ffb1]
                hover:tw-scale-150
                tw-inline-block tw-transition-transform tw-duration-300 tw-ease-out"
                onclick="closeAddImageModal()">&times;</span>
        </div>

        <!-- Form -->
        <form id="addImageForm" method="POST" enctype="multipart/form-data" class="tw-space-y-4">
            @csrf
            <input type="hidden" name="lot_id" id="lot_id_input">

            <div class="tw-flex tw-flex-col tw-gap-2">
                <label class="tw-text-sm tw-text-gray-300">Select Image</label>
                <input type="file" name="image" accept="image/*" id="lotImageInput" 
                    class="tw-w-full tw-bg-[#1c1c1c] tw-border tw-border-[#414141] tw-rounded-lg tw-px-3 tw-py-2 tw-text-white focus:tw-border-[#84ffb1] focus:tw-outline-none">
                <p id="selectedImageName" class="tw-text-sm tw-text-gray-400 tw-mt-1"></p>
            </div>

            <!-- Buttons -->
            <div class="tw-flex tw-justify-end tw-gap-2">
                <button type="button" 
                        class="tw-bg-[#333] tw-text-gray-300 tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200 hover:tw-bg-[#444]"
                        onclick="closeAddImageModal()">Cancel</button>

                <button type="submit" 
                        class="tw-bg-emerald-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg tw-transition tw-duration-200 hover:tw-bg-emerald-700">
                    Upload
                </button>
            </div>
        </form>
    </div>
</div>
