@extends('layouts.app')

@section('title', 'User Management')

@section('content')
    <div class="tw-mx-auto tw-max-w-[1600px]">

        {{-- Page heading --}}
        <div class="tw-flex tw-flex-col tw-gap-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
            <header class="lm-heading">
                <div>
                    <span class="lm-eyebrow">Administration</span>
                    <h1>User Management</h1>
                    <p>Manage system accounts, roles, property assignments, and access.</p>
                </div>
            </header>

            <button type="button" x-data @click="$dispatch('open-add-user');"
                class="tw-inline-flex tw-w-full tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2 sm:tw-w-auto">
                <i class="fa-solid fa-plus tw-text-xs tw-leading-none" aria-hidden="true"></i>
                Add user
            </button>
        </div>

        {{-- Success feedback --}}
        @if(session('success'))
            <div class="tw-mb-5 tw-flex tw-items-start tw-gap-3 tw-rounded-lg tw-border tw-border-[#06EBB6]/40 tw-bg-[#06EBB6]/10 tw-p-4 tw-text-sm tw-text-[#06100D]"
                role="status">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-mt-0.5 tw-h-5 tw-w-5 tw-flex-shrink-0 tw-text-[#087A61]"
                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m5 12 4 4L19 6" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @include('usermanagement.partials.user-table')
    </div>

    {{-- Existing user modal components --}}
    @include('usermanagement.modals.user-form')
@endsection

@section('scripts')
    @vite([
        'resources/css/pages/user-management/user-management.css',
    ])
@endsection