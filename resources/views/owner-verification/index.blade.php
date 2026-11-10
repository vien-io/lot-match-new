{{-- resources/views/owner-verification/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Owner Verification')

@section('content')
    <div class="tw-mx-auto tw-w-full tw-max-w-[1600px]">

        {{-- Page Header --}}
        <header class="lm-heading">
            <div>
                <span class="lm-eyebrow">Management / Owner Verification</span>
                <h1>Owner Verification</h1>
                <p>Review and manage property ownership verification submissions.</p>
            </div>
        </header>

        {{-- Success Alert --}}
        @if(session('success'))
            <div
                class="tw-mb-6 tw-flex tw-items-center tw-gap-3 tw-rounded-xl tw-border tw-border-[#06EBB6]/40 tw-bg-white tw-p-4">
                <div
                    class="tw-flex tw-h-9 tw-w-9 tw-shrink-0 tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6]/15">
                    <svg class="tw-h-5 tw-w-5 tw-text-[#087B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>

                <div class="tw-min-w-0">
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        Request processed successfully
                    </p>
                    <p class="tw-mt-0.5 tw-text-xs tw-text-[#666666]">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        {{-- Main Content --}}
        <div class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/60 tw-bg-white tw-shadow-sm">

            {{-- Section Header --}}
            <div
                class="tw-flex tw-flex-col tw-gap-4 tw-border-b tw-border-[#C4C4C4]/50 tw-bg-white tw-px-6 tw-py-5 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                <div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-h-5 tw-w-5 tw-text-[#087B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                        </svg>

                        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                            Verification Requests
                        </h2>
                    </div>

                    <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                        Submitted ownership documents and their verification status.
                    </p>
                </div>

                <div
                    class="tw-inline-flex tw-w-fit tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/60 tw-bg-[#F8F9F9] tw-px-3 tw-py-2">
                    <span class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#06EBB6]"></span>
                    <span class="tw-text-xs tw-font-medium tw-text-[#111111]">
                        {{ $requests->count() }} {{ Str::plural('request', $requests->count()) }}
                    </span>
                </div>
            </div>

            {{-- Table --}}
            <div class="tw-overflow-x-auto">
                <table class="tw-w-full tw-text-left tw-text-sm">

                    <thead class="tw-bg-[#06100D] tw-text-left">
                        <tr class="tw-text-[11px] tw-font-semibold tw-uppercase tw-tracking-wider tw-text-white">
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4">Request ID</th>
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4">Applicant</th>
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4">Property</th>
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4">Proof Document</th>
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4">Status</th>
                            <th class="tw-whitespace-nowrap tw-px-6 tw-py-4 tw-text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="tw-divide-y tw-divide-[#C4C4C4]/40">

                        @forelse($requests as $request)
                            <tr class="tw-transition-colors hover:tw-bg-[#F8FAF9]">

                                {{-- Request ID --}}
                                <td class="tw-whitespace-nowrap tw-px-6 tw-py-5">
                                    <span class="tw-font-semibold tw-tabular-nums tw-text-[#111111]">
                                        #{{ $request->id }}
                                    </span>
                                </td>

                                {{-- Applicant --}}
                                <td class="tw-min-w-[190px] tw-px-6 tw-py-5">
                                    <p class="tw-font-semibold tw-text-[#111111]">
                                        {{ $request->user->name }}
                                    </p>
                                    <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                                        {{ $request->user->email }}
                                    </p>
                                </td>

                                {{-- Property --}}
                                <td class="tw-whitespace-nowrap tw-px-6 tw-py-5">
                                    <p class="tw-font-semibold tw-text-[#111111]">
                                        {{ $request->lot->block->name }}
                                    </p>
                                    <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                                        Lot #{{ $request->lot->id }}
                                    </p>
                                </td>

                                {{-- Proof Document --}}
                                <td class="tw-whitespace-nowrap tw-px-6 tw-py-5">
                                    <a href="{{ asset('storage/' . $request->proof_document) }}" target="_blank"
                                        rel="noopener noreferrer"
                                        class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-lg tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-px-3 tw-py-2 tw-text-xs tw-font-semibold tw-text-[#111111] tw-transition-colors hover:tw-border-[#06EBB6] hover:tw-bg-[#06EBB6]/10 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6]">

                                        <svg class="tw-h-4 tw-w-4 tw-text-[#087B60]" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                                d="M12 16V4m0 0L8 8m4-4l4 4M4 16v3a1 1 0 001 1h14a1 1 0 001-1v-3" />
                                        </svg>

                                        View Document
                                    </a>
                                </td>

                                {{-- Status --}}
                                <td class="tw-whitespace-nowrap tw-px-6 tw-py-5">
                                    @if($request->status === 'approved')
                                        <span
                                            class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-md tw-bg-[#06EBB6]/15 tw-px-2.5 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-[#087B60]">
                                            <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#087B60]"></span>
                                            Approved
                                        </span>

                                    @elseif($request->status === 'rejected')
                                        <span
                                            class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-md tw-bg-red-50 tw-px-2.5 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-red-700">
                                            <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-red-500"></span>
                                            Rejected
                                        </span>

                                    @else
                                        <span
                                            class="tw-inline-flex tw-items-center tw-gap-2 tw-rounded-md tw-bg-amber-50 tw-px-2.5 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-amber-700">
                                            <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-amber-500"></span>
                                            Pending
                                        </span>
                                    @endif
                                </td>

                                {{-- Actions --}}
                                <td class="tw-whitespace-nowrap tw-px-6 tw-py-5">
                                    <div class="tw-flex tw-items-center tw-justify-center tw-gap-2">

                                        @if($request->status === 'pending')

                                            <form action="{{ route('owner-verification.approve', $request->id) }}" method="POST">
                                                @csrf

                                                <button type="submit"
                                                    class="tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-bg-[#06EBB6] tw-px-3.5 tw-py-2 tw-text-xs tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6] focus-visible:tw-ring-offset-2">
                                                    Approve
                                                </button>
                                            </form>

                                            <form action="{{ route('owner-verification.reject', $request->id) }}" method="POST">
                                                @csrf

                                                <button type="submit"
                                                    class="tw-inline-flex tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3.5 tw-py-2 tw-text-xs tw-font-semibold tw-text-[#666666] tw-transition-colors hover:tw-border-red-300 hover:tw-bg-red-50 hover:tw-text-red-600 focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-red-400 focus-visible:tw-ring-offset-2">
                                                    Reject
                                                </button>
                                            </form>

                                        @else
                                            <span class="tw-text-xs tw-text-[#999999]">
                                                No actions available
                                            </span>
                                        @endif

                                    </div>
                                </td>

                            </tr>

                        @empty

                            {{-- Empty State --}}
                            <tr>
                                <td colspan="6" class="tw-px-6 tw-py-40">
                                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-text-center">

                                        <div
                                            class="tw-mb-4 tw-flex tw-h-14 tw-w-14 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#F3F5F4]">
                                            <svg class="tw-h-7 tw-w-7 tw-text-[#999999]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5l5 5v11a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>

                                        <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                            No verification requests
                                        </h3>

                                        <p class="tw-mt-1 tw-max-w-sm tw-text-xs tw-text-[#666666]">
                                            There are currently no ownership verification submissions to review.
                                        </p>

                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Footer --}}
            @if($requests->count() > 0)
                <div
                    class="tw-flex tw-flex-col tw-gap-2 tw-border-t tw-border-[#C4C4C4]/50 tw-bg-white tw-px-6 tw-py-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                    <p class="tw-text-xs tw-text-[#666666]">
                        Showing <span class="tw-font-semibold tw-text-[#111111]">{{ $requests->count() }}</span>
                        verification {{ Str::plural('request', $requests->count()) }}
                    </p>
                </div>
            @endif

        </div>
    </div>
@endsection