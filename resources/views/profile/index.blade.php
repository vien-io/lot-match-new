@extends('layouts.app')

@section('content')
<div class="tw-flex tw-items-center tw-justify-center tw-min-h-[calc(100vh-4rem)] tw-w-full tw-pr-20">



    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-overflow-hidden tw-w-full tw-max-w-2xl tw-p-8">

        <h2 class="tw-text-2xl tw-font-bold tw-mb-2">My Profile</h2>
        <p class="tw-text-gray-500 tw-mb-6">Manage your account details</p>

        <div class="tw-space-y-4">

            <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-gap-3">
                <span class="tw-text-gray-600"><i class="fas fa-user"></i></span>
                <div>
                    <p class="tw-text-xs tw-text-gray-500">First Name</p>
                    <p class="tw-font-semibold">{{ $user->first_name }}</p>
                </div>
            </div>

            <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-gap-3">
                <span class="tw-text-gray-600"><i class="fas fa-user"></i></span>
                <div>
                    <p class="tw-text-xs tw-text-gray-500">Last Name</p>
                    <p class="tw-font-semibold">{{ $user->last_name }}</p>
                </div>
            </div>

            <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-gap-3">
                <span class="tw-text-gray-600"><i class="fas fa-id-badge"></i></span>
                <div>
                    <p class="tw-text-xs tw-text-gray-500">Username</p>
                    <p class="tw-font-semibold">{{ $user->username }}</p>
                </div>
            </div>

            <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-gap-3">
                <span class="tw-text-gray-600"><i class="fas fa-envelope"></i></span>
                <div>
                    <p class="tw-text-xs tw-text-gray-500">Email Address</p>
                    <p class="tw-font-semibold">{{ $user->email }}</p>
                </div>
            </div>

            <div class="tw-bg-gray-50 tw-rounded-xl tw-p-4 tw-flex tw-items-center tw-gap-3">
                <span class="tw-text-gray-600"><i class="fas fa-user-shield"></i></span>
                <div>
                    <p class="tw-text-xs tw-text-gray-500">Role</p>
                    <p class="tw-font-semibold">{{ ucfirst($user->role) }}</p>
                </div>
            </div>

            <div class="tw-mt-6">
                <a href="{{ route('profile.edit') }}" 
                    class="tw-w-full tw-block tw-text-center tw-py-2 tw-rounded-full tw-bg-gradient-to-r tw-from-green-500 tw-to-emerald-600 tw-text-white tw-font-semibold hover:tw-opacity-90">
                    Edit Profile
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Font Awesome Icons --}}
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
@endsection
