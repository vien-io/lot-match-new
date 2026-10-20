
@extends('layouts.auth')

@section('content')
<div class="tw-flex tw-items-start tw-justify-center tw-px-4 sm:tw-px-6">

    <div class="tw-w-full tw-max-w-lg tw-bg-white tw-rounded-2xl tw-shadow-xl tw-border tw-border-[#C4C4C4]/50 tw-p-6 sm:tw-p-10">

        <!-- Icon -->
        <div class="tw-flex tw-justify-center tw-mb-6">
            <div class="tw-flex tw-items-center tw-justify-center tw-w-16 tw-h-16 tw-rounded-2xl tw-bg-[#06EBB6]/10 tw-border tw-border-[#06EBB6]/20">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="tw-w-9 tw-h-9 tw-text-[#087F68]"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.7"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 8l8.1 5.4a1.6 1.6 0 001.8 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>
            </div>
        </div>

        <!-- Heading -->
        <div class="tw-text-center tw-mb-7">
            <h1 class="tw-text-2xl sm:tw-text-3xl tw-font-bold tw-tracking-tight tw-text-[#111111]">
                {{ __('Verify Your Email Address') }}
            </h1>

            <p class="tw-text-sm tw-leading-6 tw-text-[#666666] tw-mt-5">
                {{ __('Before proceeding, please check your email for a verification link. If you did not receive the email') }}, {{ __('you can request another below.') }}
            </p>
        </div>

        <!-- Success Message -->
        @if (session('resent'))
            <div
                class="tw-flex tw-items-start tw-gap-3 tw-bg-emerald-50 tw-text-emerald-800 tw-border tw-border-emerald-200 tw-rounded-xl tw-p-4 tw-mb-9"
                role="status"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="tw-w-5 tw-h-5 tw-shrink-0 tw-mt-0.5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                <p class="tw-text-sm">
                    {{ __('A fresh verification link has been sent to your email address.') }}
                </p>
            </div>
        @endif

        <!-- Resend Verification -->
        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf

            <button
                type="submit"
                class="tw-w-full tw-flex tw-items-center tw-justify-center tw-gap-2 tw-bg-[#06EBB6] hover:tw-bg-[#1ED9D7] tw-text-[#06100D] tw-font-semibold tw-text-sm tw-rounded-xl tw-py-3.5 tw-px-4 tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2 active:tw-scale-[0.99]"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="tw-w-4 tw-h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="1.8"
                    aria-hidden="true"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 8l8.1 5.4a1.6 1.6 0 001.8 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                </svg>

                {{ __('Resend Verification Email') }}
            </button>
        </form>

        <!-- Footer -->
        <div class="tw-border-t tw-border-[#C4C4C4]/50 tw-mt-7 tw-pt-6">
            <p class="tw-text-xs tw-text-center tw-text-[#888888]">
                &copy; {{ date('Y') }} LotMatch. All rights reserved.
            </p>
        </div>

    </div>
</div>
@endsection
