@extends('layouts.app')

@section('content')
<div class="tw-min-h-[calc(100vh-4rem)] tw-w-full tw-flex tw-items-center tw-justify-center tw-px-4 sm:tw-px-6 tw-py-10">

    <div class="tw-w-full tw-max-w-2xl tw-bg-white tw-rounded-2xl tw-border tw-border-[#C4C4C4]/60 tw-shadow-sm tw-overflow-hidden">

        {{-- Header --}}
        <div class="tw-p-6 sm:tw-p-8 tw-border-b tw-border-[#C4C4C4]/50">
            <div class="tw-flex tw-items-center tw-gap-3">
                <div class="tw-w-11 tw-h-11 tw-rounded-xl tw-bg-[#06EBB6]/15 tw-flex tw-items-center tw-justify-center tw-text-[#06100D]">
                    <i class="fas fa-user-circle tw-text-xl"></i>
                </div>

                <div>
                    <h2 class="tw-text-xl tw-font-bold tw-text-[#111111]">
                        My Profile
                    </h2>
                    <p class="tw-text-sm tw-text-[#666666] tw-mt-0.5">
                        Manage your account information
                    </p>
                </div>
            </div>
        </div>

        {{-- Profile Details --}}
        <div class="tw-p-6 sm:tw-p-8">

            {{-- Account Summary --}}
            <div class="tw-flex tw-items-center tw-gap-4 tw-p-4 tw-mb-6 tw-bg-[#F7FAF9] tw-rounded-xl tw-border tw-border-[#C4C4C4]/40">
                <img
                    src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->first_name . ' ' . $user->last_name) . '&background=06EBB6&color=06100D&rounded=true' }}"
                    alt="User Avatar"
                    class="tw-w-14 tw-h-14 tw-rounded-full tw-object-cover tw-border tw-border-[#C4C4C4]/60"
                >

                <div class="tw-min-w-0">
                    <p class="tw-font-semibold tw-text-[#111111] tw-truncate">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </p>
                    <p class="tw-text-sm tw-text-[#666666] tw-truncate">
                        {{ $user->email }}
                    </p>
                    <span class="tw-inline-flex tw-items-center tw-mt-1 tw-px-2.5 tw-py-1 tw-rounded-full tw-bg-[#06EBB6]/15 tw-text-[#06100D] tw-text-xs tw-font-semibold">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            {{-- Information Section --}}
            <div class="tw-mb-5">
                <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                    Personal Information
                </h3>
                <p class="tw-text-xs tw-text-[#666666] tw-mt-1">
                    Your registered account details
                </p>
            </div>

            <div class="tw-grid tw-grid-cols-1 sm:tw-grid-cols-2 tw-gap-4">

                {{-- First Name --}}
                <div class="tw-p-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/60">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-user tw-text-[#666666] tw-text-sm"></i>
                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">First Name</span>
                    </div>
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        {{ $user->first_name }}
                    </p>
                </div>

                {{-- Last Name --}}
                <div class="tw-p-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/60">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-user tw-text-[#666666] tw-text-sm"></i>
                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">Last Name</span>
                    </div>
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        {{ $user->last_name }}
                    </p>
                </div>

                {{-- Username --}}
                <div class="tw-p-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/60">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-id-badge tw-text-[#666666] tw-text-sm"></i>
                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">Username</span>
                    </div>
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        {{ $user->username }}
                    </p>
                </div>

                {{-- Email --}}
                <div class="tw-p-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/60">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-envelope tw-text-[#666666] tw-text-sm"></i>
                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">Email Address</span>
                    </div>
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111] tw-break-all">
                        {{ $user->email }}
                    </p>
                </div>

                {{-- Role --}}
                <div class="tw-p-4 tw-rounded-xl tw-border tw-border-[#C4C4C4]/60 sm:tw-col-span-2">
                    <div class="tw-flex tw-items-center tw-gap-2 tw-mb-2">
                        <i class="fas fa-shield-alt tw-text-[#666666] tw-text-sm"></i>
                        <span class="tw-text-xs tw-font-medium tw-text-[#666666]">Account Role</span>
                    </div>
                    <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                        {{ ucfirst($user->role) }}
                    </p>
                </div>

            </div>

            {{-- Actions --}}
            <div class="tw-flex tw-flex-col-reverse sm:tw-flex-row sm:tw-justify-end tw-gap-3 tw-mt-8 tw-pt-6 tw-border-t tw-border-[#C4C4C4]/50">
                <a
                    href="{{ route('profile.edit') }}"
                    class="tw-inline-flex tw-items-center tw-justify-center tw-gap-2 tw-px-6 tw-py-2.5 tw-rounded-lg tw-bg-[#06EBB6] hover:tw-bg-[#1ED9D7] tw-text-[#06100D] tw-text-sm tw-font-semibold tw-transition-colors tw-duration-150 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2"
                >
                    <i class="fas fa-pen tw-text-xs"></i>
                    Edit Profile
                </a>
            </div>

        </div>
    </div>
</div>
@endsection