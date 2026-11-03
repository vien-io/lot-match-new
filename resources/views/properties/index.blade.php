@extends('layouts.app')

@section('title', 'Manage Properties')

@section('content')
    @vite('resources/css/print.css')
    <main class="tw-mx-auto tw-w-full tw-max-w-[1600px]">
        {{-- Page Header --}}
        <div class="tw-flex tw-flex-col tw-gap-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
            <header class="lm-heading">
                <div>
                    <span class="lm-eyebrow">Property Administration</span>
                    <h1>Property Management</h1>
                    <p>Add, edit, and manage subdivision properties in one place.</p>
                </div>

            </header>
            <button type="button" id="addPropertyButton"
                class="tw-inline-flex tw-w-fit tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2">
                <span class="tw-text-lg tw-leading-none" aria-hidden="true">+</span>
                Add Property
            </button>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="tw-mb-5 tw-rounded-lg tw-border
                        tw-border-[#06EBB6]/40 tw-bg-[#06EBB6]/10 tw-p-4" role="status">

                <div class="tw-flex tw-items-center tw-gap-2">
                    <i class="fa-solid fa-circle-check
                              tw-text-sm tw-text-[#059669]" aria-hidden="true"></i>

                    <p class="tw-text-sm tw-font-semibold tw-text-[#065F46]">
                        Property saved successfully
                    </p>
                </div>

                <p class="tw-mt-1 tw-text-xs tw-text-[#047857]">
                    {{ session('success') }}
                </p>
            </div>
        @endif

        {{-- Validation Errors --}}
        @if($errors->any())
            <div class="tw-mb-5 tw-rounded-lg tw-border
                                        tw-border-red-200 tw-bg-red-50/70 tw-p-4" role="alert">

                <div class="tw-flex tw-items-center tw-gap-2">
                    <i class="fa-solid fa-circle-exclamation
                                              tw-text-sm tw-text-red-600" aria-hidden="true"></i>

                    <p class="tw-text-sm tw-font-semibold tw-text-red-800">
                        Unable to save property
                    </p>

                    <span class="tw-ml-auto tw-rounded-md
                                                 tw-bg-red-100 tw-px-2 tw-py-0.5
                                                 tw-text-xs tw-font-medium tw-text-red-700">
                        {{ $errors->count() }}
                        {{ Str::plural('error', $errors->count()) }}
                    </span>
                </div>

                <p class="tw-mt-1 tw-text-xs tw-text-red-700/60">
                    Please correct the following information and try again.
                </p>

                <ul class="tw-mt-3 tw-mx-2 tw-space-y-2 tw-border-t tw-border-red-200 tw-pt-3">
                    @foreach($errors->all() as $error)
                        <li class="tw-flex tw-items-center tw-gap-2
                                                               tw-text-sm tw-text-red-700">

                            <i class="fa-regular fa-circle-xmark tw-mt-0.5
                                                                  tw-shrink-0 tw-text-xs" aria-hidden="true"></i>

                            <span class="tw-text-xs">{{ $error }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- Property Table Panel --}}
        <section class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

            @include('properties.toolbar')
            @include('properties.property-results')

        </section>

        {{-- Footer --}}
        <footer class="tw-mt-8 tw-border-t tw-border-[#C4C4C4]/70 tw-py-5">
            <p class="tw-text-center tw-text-xs tw-leading-5 tw-text-[#666666]">
                © {{ date('Y') }} LotMatch. All rights reserved.
            </p>
        </footer>
    </main>

    {{-- Shared Form Control Styling --}}
    @php
        $fieldClass = 'tw-mt-1 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition focus:tw-border-[#06100D] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40';
        $labelClass = 'tw-block tw-text-sm tw-font-medium tw-text-[#111111]';
        $hintClass = 'tw-mt-1 tw-block tw-text-xs tw-leading-5 tw-text-[#666666]';
        $primaryButtonClass = 'tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2';
        $secondaryButtonClass = 'tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-py-2.5 tw-text-sm tw-font-medium tw-text-[#111111] tw-transition-colors hover:tw-bg-[#D9D9D9]/40 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]';
    @endphp

    @include('properties.property-modal')
    @include('properties.edit-property-modal')
    @include('properties.lot-image-modal')

@endsection

@push('scripts')
    @vite('resources/js/properties.js')
@endpush