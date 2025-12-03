@extends('layouts.app')

@section('content')
<div class="tw-flex tw-items-center tw-justify-center tw-min-h-[calc(100vh-4rem)] tw-w-full tw-pr-20">


    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-overflow-hidden tw-w-full tw-max-w-xl tw-mx-[10rem] tw-p-8">

        <h2 class="tw-text-2xl tw-font-bold tw-mb-2">Edit Profile</h2>
        <p class="tw-text-gray-500 tw-mb-6">Update your account information</p>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="tw-bg-green-100 tw-text-green-800 tw-px-4 tw-py-2 tw-rounded tw-mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- VALIDATION ERRORS --}}
        @if ($errors->any())
            <div class="tw-bg-red-100 tw-text-red-800 tw-px-4 tw-py-2 tw-rounded tw-mb-4">
                <ul class="tw-list-disc tw-ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- EDIT FORM --}}
        <form action="{{ route('profile.update') }}" method="POST" class="tw-space-y-4">
            @csrf

            {{-- Name --}}
            <div class="tw-relative">
                <span class="tw-absolute tw-left-3 tw-top-3 tw-text-gray-400">
                    <i class="fas fa-user"></i>
                </span>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       placeholder="Full Name"
                       class="tw-w-full tw-pl-10 tw-px-3 tw-py-2 tw-rounded-full tw-border tw-bg-gray-100 focus:tw-ring-2 focus:tw-ring-green-500 focus:tw-border-green-500">
            </div>

            {{-- Username --}}
            <div class="tw-relative">
                <span class="tw-absolute tw-left-3 tw-top-3 tw-text-gray-400">
                    <i class="fas fa-id-badge"></i>
                </span>
                <input type="text"
                       name="username"
                       value="{{ old('username', $user->username) }}"
                       placeholder="Username"
                       class="tw-w-full tw-pl-10 tw-px-3 tw-py-2 tw-rounded-full tw-border tw-bg-gray-100 focus:tw-ring-2 focus:tw-ring-green-500 focus:tw-border-green-500">
            </div>

            {{-- Email --}}
            <div class="tw-relative">
                <span class="tw-absolute tw-left-3 tw-top-3 tw-text-gray-400">
                    <i class="fas fa-envelope"></i>
                </span>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       placeholder="Email Address"
                       class="tw-w-full tw-pl-10 tw-px-3 tw-py-2 tw-rounded-full tw-border tw-bg-gray-100 focus:tw-ring-2 focus:tw-ring-green-500 focus:tw-border-green-500">
            </div>

            {{-- BUTTONS --}}
            <div class="tw-flex tw-justify-between tw-mt-6">
                <a href="{{ route('profile') }}"
                   class="tw-w-1/2 tw-text-center tw-bg-gray-200 tw-text-gray-800 tw-py-2 tw-rounded-full hover:tw-bg-gray-300">
                    Cancel
                </a>

                <button type="submit"
                        class="tw-w-1/2 tw-ml-3 tw-bg-green-600 tw-text-white tw-py-2 tw-rounded-full hover:tw-bg-green-700">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Font Awesome Icons --}}
<script src="https://kit.fontawesome.com/your-kit-id.js" crossorigin="anonymous"></script>
@endsection
