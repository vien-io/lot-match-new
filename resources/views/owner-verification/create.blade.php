
{{-- resources/views/owner-verification/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Request Property Ownership')

@section('content')
    <div class="tw-min-h-screen tw-bg-[#F4F7F5] tw-flex tw-items-start tw-justify-center tw-p-6">
        <div class="tw-w-full tw-max-w-xl tw-mx-auto tw-py-8">

            {{-- Page Header --}}
            <div class="tw-mb-8">
                <h1 class="tw-text-2xl tw-font-bold tw-text-[#17211C]">
                    Request Property Ownership
                </h1>

                <p class="tw-text-sm tw-text-[#7A8780] tw-mt-2">
                    Submit your property details and supporting documents for verification.
                </p>
            </div>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="tw-flex tw-items-start tw-gap-3 tw-bg-[#F0F8F5] tw-border tw-border-[#C5E9DB] tw-text-[#087F62] tw-p-4 tw-rounded-xl tw-mb-6">
                    <span class="tw-font-semibold">&#10003;</span>

                    <p class="tw-text-sm">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="tw-bg-[#FFF5F5] tw-border tw-border-[#F2D0D0] tw-text-[#B42318] tw-p-4 tw-rounded-xl tw-mb-6">
                    <p class="tw-font-semibold tw-text-sm tw-mb-2">
                        Please correct the following errors:
                    </p>

                    <ul class="tw-list-disc tw-pl-5 tw-text-sm tw-space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Form Card --}}
            <div class="tw-bg-white tw-rounded-2xl tw-border tw-border-[#E2E8E4] tw-shadow-[0_4px_20px_rgba(0,0,0,0.04)] tw-overflow-hidden">
                <div class="tw-p-6 sm:tw-p-8">

                    {{-- Form Header --}}
                    <div class="tw-mb-7">
                        <h2 class="tw-text-base tw-font-semibold tw-text-[#17211C]">
                            Ownership Details
                        </h2>

                        <p class="tw-text-xs tw-text-[#89958E] tw-mt-1">
                            Fields marked as required must be completed.
                        </p>
                    </div>

                    <form
                        id="owner-verification-form"
                        action="{{ route('owner-verification.store') }}"
                        method="POST"
                        enctype="multipart/form-data"
                        data-lots="{{ $lots->map(fn($lot) => [
                            'id' => $lot->id,
                            'name' => $lot->name,
                            'block_id' => $lot->block_id,
                        ])->toJson() }}"
                        data-old-block="{{ old('block_id', '') }}"
                        data-old-lot="{{ old('lot_id', '') }}"
                    >
                        @csrf

                        {{-- Select Block --}}
                        <div class="tw-mb-5">
                            <label for="block_id" class="tw-block tw-text-sm tw-font-medium tw-text-[#344139] tw-mb-2">
                                Select Block
                                <span class="tw-text-[#DC5959]">*</span>
                            </label>

                            <select
                                name="block_id"
                                id="block_id"
                                required
                                class="tw-w-full tw-bg-white tw-border tw-border-[#D5DED8] tw-rounded-lg tw-px-3 tw-py-3 tw-text-sm tw-text-[#344139] focus:tw-outline-none focus:tw-border-[#06B88F] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                            >
                                <option value="" disabled {{ old('block_id') ? '' : 'selected' }}>
                                    Choose a block
                                </option>

                                @foreach($lots->pluck('block')->unique('id')->sortBy('name') as $block)
                                    <option
                                        value="{{ $block->id }}"
                                        {{ old('block_id') == $block->id ? 'selected' : '' }}
                                    >
                                        {{ $block->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Select Lot --}}
                        <div class="tw-mb-5">
                            <label for="lot_id" class="tw-block tw-text-sm tw-font-medium tw-text-[#344139] tw-mb-2">
                                Select Lot
                                <span class="tw-text-[#DC5959]">*</span>
                            </label>

                            <select
                                name="lot_id"
                                id="lot_id"
                                required
                                disabled
                                class="tw-w-full tw-bg-white tw-border tw-border-[#D5DED8] tw-rounded-lg tw-px-3 tw-py-3 tw-text-sm tw-text-[#344139] focus:tw-outline-none focus:tw-border-[#06B88F] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20 disabled:tw-bg-[#F4F7F5] disabled:tw-text-[#A0AAA4]"
                            >
                                <option value="" selected>
                                    Choose a block first
                                </option>
                            </select>
                        </div>

                        {{-- Proof Document --}}
                        <div class="tw-mb-5">
                            <label for="proof_document" class="tw-block tw-text-sm tw-font-medium tw-text-[#344139] tw-mb-2">
                                Proof of Ownership
                                <span class="tw-text-[#DC5959]">*</span>
                            </label>

                            <div class="tw-border tw-border-dashed tw-border-[#C4CEC8] tw-rounded-xl tw-bg-[#FAFCFB] tw-p-5 hover:tw-border-[#06B88F] tw-transition-colors">
                                <input
                                    type="file"
                                    name="proof_document"
                                    id="proof_document"
                                    accept=".pdf,.jpg,.jpeg,.png"
                                    required
                                    class="tw-block tw-w-full tw-text-sm tw-text-[#536159] file:tw-mr-4 file:tw-px-4 file:tw-py-2 file:tw-rounded-lg file:tw-border-0 file:tw-bg-[#E8F8F2] file:tw-text-[#087F62] file:tw-font-semibold hover:file:tw-bg-[#D8F3E9] file:tw-cursor-pointer file:tw-transition-colors"
                                >

                                <p class="tw-text-xs tw-text-[#89958E] tw-mt-3">
                                    Upload a document proving your ownership of the selected property.
                                </p>

                                <p class="tw-text-xs tw-text-[#A0AAA4] tw-mt-1">
                                    Accepted formats: PDF, JPG, JPEG, PNG
                                </p>
                            </div>

                            @error('proof_document')
                                <p class="tw-text-xs tw-text-[#DC5959] tw-mt-2">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="tw-pt-2">
                            <button
                                type="submit"
                                class="tw-w-full tw-flex tw-items-center tw-justify-center tw-gap-2 tw-bg-[#06EBB6] tw-text-[#06100D] tw-font-semibold tw-text-sm tw-px-5 tw-py-3 tw-rounded-lg hover:tw-bg-[#1ED9D7] tw-transition-colors tw-duration-200 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40"
                            >
                                Submit Verification Request
                            </button>

                            <p class="tw-text-center tw-text-xs tw-text-[#89958E] tw-mt-4">
                                Your submitted documents will be reviewed before ownership is verified.
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Footer --}}
            <p class="tw-text-center tw-text-xs tw-text-[#A0AAA4] tw-mt-6">
                LotMatch Property Verification
            </p>

        </div>
    </div>
@endsection

@push('scripts')
    @vite('resources/js/pages/owner-verification/select-lot.js')
@endpush
