@extends('layouts.auth')

@section('title', 'Email Verified')

@section('content')
<div class="tw-w-full tw-max-w-md tw-rounded-2xl tw-border tw-border-gray-200 tw-bg-white tw-p-8 tw-text-center tw-shadow-sm">

    {{-- Success icon --}}
    <div class="tw-mx-auto tw-mb-6 tw-flex tw-h-16 tw-w-16 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#E6FBF4]">
        <svg
            class="tw-h-8 tw-w-8 tw-text-[#087F5B]"
            xmlns="http://www.w3.org/2000/svg"
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
    </div>

    {{-- Success message --}}
    <h1 class="tw-mb-3 tw-text-2xl tw-font-semibold tw-tracking-tight tw-text-[#111111]">
        Email verified successfully
    </h1>

    <p class="tw-mb-6 tw-text-sm tw-leading-6 tw-text-[#666666]">
        Your email is verified. Redirecting you to your dashboard...
    </p>

    {{-- Progress indicator --}}
    <div class="tw-mb-4 tw-h-1 tw-overflow-hidden tw-rounded-full tw-bg-gray-100">
        <div
            id="redirect-progress"
            class="tw-h-full tw-w-0 tw-rounded-full tw-bg-[#06EBB6]"
            style="transition: width 3s linear;"
        ></div>
    </div>

    <p class="tw-mb-5 tw-text-xs tw-text-[#666666]">
        Redirecting in <span id="redirect-countdown">3</span> seconds
    </p>

    {{-- Manual fallback --}}
    <a
        href="{{ route('dashboard') }}"
        class="tw-inline-flex tw-w-full tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#06EBB6] tw-px-5 tw-py-3 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition hover:tw-bg-[#1ED9D7] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2"
    >
        Continue to dashboard
    </a>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdown = document.getElementById('redirect-countdown');
        const progress = document.getElementById('redirect-progress');

        let seconds = 3;

        // Start the animation after the browser renders the initial width.
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                progress.style.width = '100%';
            });
        });

        const timer = setInterval(function () {
            seconds--;
            countdown.textContent = seconds;

            if (seconds <= 0) {
                clearInterval(timer);
                window.location.href = @json(route('dashboard'));
            }
        }, 1000);
    });
</script>
@endsection
