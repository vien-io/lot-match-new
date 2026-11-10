@extends('layouts.app')

@section('content')
<div class="tw-min-h-[calc(100vh-4rem)] tw-w-full tw-flex tw-items-center tw-justify-center tw-px-4 sm:tw-px-6 tw-py-10">

    <div class="tw-w-full tw-max-w-xl tw-bg-white tw-rounded-2xl tw-border tw-border-[#C4C4C4]/60 tw-shadow-sm tw-overflow-hidden">

        {{-- Header --}}
        <div class="tw-p-6 sm:tw-p-8 tw-border-b tw-border-[#C4C4C4]/50">
            <div class="tw-flex tw-items-center tw-gap-3">
                <div class="tw-w-11 tw-h-11 tw-rounded-xl tw-bg-[#06EBB6]/15 tw-flex tw-items-center tw-justify-center tw-text-[#06100D]">
                    <i class="fas fa-user-edit tw-text-lg"></i>
                </div>

                <div>
                    <h2 class="tw-text-xl tw-font-bold tw-text-[#111111]">
                        Edit Profile
                    </h2>
                    <p class="tw-text-sm tw-text-[#666666] tw-mt-0.5">
                        Update your account information
                    </p>
                </div>
            </div>
        </div>

        <div class="tw-p-6 sm:tw-p-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="tw-flex tw-items-start tw-gap-3 tw-p-4 tw-mb-5 tw-rounded-xl tw-border tw-border-[#06EBB6]/40 tw-bg-[#06EBB6]/10 tw-text-[#06100D]"
                    role="alert">
                    <i class="fas fa-check-circle tw-mt-0.5"></i>
                    <p class="tw-text-sm tw-font-medium">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="tw-p-4 tw-mb-5 tw-rounded-xl tw-border tw-border-red-200 tw-bg-red-50 tw-text-red-700"
                    role="alert">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-exclamation-circle"></i>
                        <p class="tw-text-sm tw-font-semibold">
                            Please review the following errors:
                        </p>
                    </div>

                    <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="tw-text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Edit Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="tw-space-y-5">
                @csrf

                {{-- Personal Information --}}
                <div>
                    <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        Personal Information
                    </h3>
                    <p class="tw-text-xs tw-text-[#666666] tw-mt-1">
                        Update the details associated with your account
                    </p>
                </div>

                {{-- First Name --}}
                <div>
                    <label for="first_name" class="tw-block tw-text-sm tw-font-medium tw-text-[#111111] tw-mb-2">
                        First Name
                    </label>

                    <div class="tw-relative">
                        <i class="fas fa-user tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] tw-text-sm"></i>
                        <input
                            type="text"
                            id="first_name"
                            name="name"
                            value="{{ old('name', $user->first_name) }}"
                            placeholder="Enter your first name"
                            class="tw-w-full tw-pl-11 tw-pr-4 tw-py-3 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20 tw-transition"
                        >
                    </div>
                </div>

                {{-- Last Name --}}
                <div>
                    <label for="last_name" class="tw-block tw-text-sm tw-font-medium tw-text-[#111111] tw-mb-2">
                        Last Name
                    </label>

                    <div class="tw-relative">
                        <i class="fas fa-user tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] tw-text-sm"></i>
                        <input
                            type="text"
                            id="last_name"
                            name="name"
                            value="{{ old('name', $user->last_name) }}"
                            placeholder="Enter your last name"
                            class="tw-w-full tw-pl-11 tw-pr-4 tw-py-3 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20 tw-transition"
                        >
                    </div>
                </div>

                {{-- Username --}}
                <div>
                    <label for="username" class="tw-block tw-text-sm tw-font-medium tw-text-[#111111] tw-mb-2">
                        Username
                    </label>

                    <div class="tw-relative">
                        <i class="fas fa-id-badge tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] tw-text-sm"></i>
                        <input
                            type="text"
                            id="username"
                            name="username"
                            value="{{ old('username', $user->username) }}"
                            placeholder="Enter your username"
                            class="tw-w-full tw-pl-11 tw-pr-4 tw-py-3 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20 tw-transition"
                        >
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="tw-block tw-text-sm tw-font-medium tw-text-[#111111] tw-mb-2">
                        Email Address
                    </label>

                    <div class="tw-relative">
                        <i class="fas fa-envelope tw-absolute tw-left-4 tw-top-1/2 -tw-translate-y-1/2 tw-text-[#666666] tw-text-sm"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email', $user->email) }}"
                            placeholder="Enter your email address"
                            class="tw-w-full tw-pl-11 tw-pr-4 tw-py-3 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-outline-none focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20 tw-transition"
                        >
                    </div>
                </div>

                {{-- Actions --}}
                <div class="tw-flex tw-flex-col-reverse sm:tw-flex-row tw-gap-3 tw-pt-6 tw-mt-6 tw-border-t tw-border-[#C4C4C4]/50">
                    <a
                        href="{{ route('profile') }}"
                        class="tw-flex-1 tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-px-5 tw-py-2.5 tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-text-[#111111] tw-text-sm tw-font-semibold hover:tw-bg-gray-50 tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#C4C4C4] focus:tw-ring-offset-2"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="tw-flex-1 tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-px-5 tw-py-2.5 tw-rounded-lg tw-bg-[#06EBB6] hover:tw-bg-[#1ED9D7] tw-text-[#06100D] tw-text-sm tw-font-semibold tw-transition-colors focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2"
                    >
                        <i class="fas fa-save tw-text-xs"></i>
                        Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection