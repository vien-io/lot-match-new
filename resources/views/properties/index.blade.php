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
        <button
            type="button"
            onclick="document.getElementById('addPropertyModal').classList.remove('tw-hidden')"
            class="tw-inline-flex tw-w-fit tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06100D] focus-visible:tw-ring-offset-2">
            <span class="tw-text-lg tw-leading-none" aria-hidden="true">+</span>
            Add Property
        </button>
    </div>


    {{-- Property Table Panel --}}
    <section class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white">

        @include('properties.toolbar')

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

        @include('properties.printable-table')

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

@section('scripts')
@vite('resources/js/properties.js')
@endsection