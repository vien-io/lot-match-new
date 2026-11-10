{{-- Floating lot assignment popover --}}
<template x-teleport="body">
    <div x-show="showLotPopover" x-cloak x-transition:enter="tw-transition tw-ease-out tw-duration-200"
        x-transition:enter-start="tw-opacity-0 tw-translate-y-1"
        x-transition:enter-end="tw-opacity-100 tw-translate-y-0"
        x-transition:leave="tw-transition tw-ease-in tw-duration-150" x-transition:leave-start="tw-opacity-100"
        x-transition:leave-end="tw-opacity-0" @click.outside="showLotPopover = false"
        @keydown.escape.window="showLotPopover = false"
        :style="`position:fixed; top:${popoverPosition.top}px; left:${popoverPosition.left}px;`"
        class="tw-z-[9999] tw-w-[320px] tw-max-w-[calc(100vw-24px)] tw-rounded-xl tw-border tw-border-[#DDE4E1] tw-bg-white tw-p-4 tw-shadow-xl">
        <div class="tw-mb-3 tw-flex tw-items-center tw-justify-between">
            <div>
                <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                    Assign Properties
                </h3>
                <p class="tw-mt-0.5 tw-text-xs tw-text-[#777777]">
                    Select blocks and lots
                </p>
            </div>

            <button type="button" @click="showLotPopover = false"
                class="tw-rounded-md tw-p-1 tw-text-gray-400 hover:tw-bg-gray-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Block selection --}}
        <div class="tw-mb-3">
            <label class="tw-mb-1 tw-block tw-text-xs tw-font-medium tw-text-[#555555]">
                Block
            </label>

            <select x-model="selectedBlock" @change="selectedLotId = ''"
                class="tw-w-full tw-rounded-md tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2 tw-text-xs focus:tw-border-[#06B995] focus:tw-outline-none">
                <option value="">Select a block</option>

                <template x-for="block in availableBlocks" :key="block">
                    <option :value="block" x-text="block"></option>
                </template>
            </select>
        </div>

        {{-- Lot selection --}}
        <div class="tw-mb-3">
            <label class="tw-mb-1 tw-block tw-text-xs tw-font-medium tw-text-[#555555]">
                Lot
            </label>

            <div class="tw-flex tw-gap-2">
                <select x-model="selectedLotId" :disabled="!selectedBlock"
                    class="tw-min-w-0 tw-flex-1 tw-rounded-md tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2 tw-text-xs disabled:tw-bg-gray-100">
                    <option value="">Select a lot</option>

                    <template x-for="lot in availableLots" :key="lot.id">
                        <option :value="String(lot.id)" x-text="lot.name"
                            :disabled="selectedLots.some(selected => selected.id == lot.id)">
                        </option>
                    </template>
                </select>

                <button type="button" @click="addSelectedLot()" :disabled="!selectedLotId"
                    class="tw-rounded-md tw-bg-[#06EBB6] tw-px-3 tw-text-xs tw-font-semibold tw-text-[#06100D] hover:tw-bg-[#1ED9D7] disabled:tw-cursor-not-allowed disabled:tw-opacity-40">
                    Add
                </button>
            </div>
        </div>

        <div class="tw-border-t tw-border-[#EEEEEE] tw-pt-3">
            <div class="tw-mb-2 tw-flex tw-items-center justify-between">
                <span class="tw-text-xs tw-font-semibold tw-text-[#333333]">
                    Assigned lots
                </span>
                <span class="tw-ml-auto tw-text-xs tw-text-[#777777]" x-text="selectedLots.length + ' selected'"></span>
            </div>

            <div class="tw-max-h-36 tw-space-y-1.5 tw-overflow-y-auto">
                <template x-for="(lot, index) in selectedLots" :key="lot.id">
                    <div
                        class="tw-flex tw-items-center justify-between tw-rounded-md tw-bg-[#F5F8F7] tw-px-2.5 tw-py-2">
                        <span class="tw-truncate tw-text-xs tw-text-[#333333]"
                            x-text="lot.name + ' (' + lot.block + ')'"></span>

                        <button type="button" @click="removeLot(index)"
                            class="tw-ml-2 tw-text-gray-400 hover:tw-text-red-500">
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </template>

                <p x-show="selectedLots.length === 0" class="tw-py-3 tw-text-center tw-text-xs tw-text-gray-400">
                    No lots assigned yet.
                </p>
            </div>
        </div>
    </div>
</template>