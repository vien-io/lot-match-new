@extends('layouts.app')

@section('title', 'Verify Your Email')

@section('content')
<div class="tw-bg-gradient-to-br tw-from-green-50 tw-to-white tw-min-h-screen tw-flex tw-items-center tw-justify-center">

  <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-px-10 tw-py-12 tw-text-center tw-max-w-md tw-border tw-border-gray-100 tw-transition-all tw-duration-300 hover:tw-shadow-xl">

    {{-- Icon --}}
    <div class="tw-bg-blue-100 tw-rounded-full tw-p-4 tw-inline-flex tw-items-center tw-justify-center tw-mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-12 tw-w-12 tw-text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 12a4 4 0 11-8 0 4 4 0 018 0zM12 2v2m6.364 1.636l-1.414 1.414M22 12h-2M4 12H2m3.636-6.364L4.222 7.05M12 22v-2m6.364-1.636l-1.414-1.414" />
      </svg>
    </div>

    {{-- Title & Message --}}
    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800">Verify Your Email</h1>
    <p class="tw-text-gray-600 tw-mt-3">
      Before continuing, please check your inbox for a verification link.  
      Didn’t receive it? You can request another below.
    </p>

    {{-- Success Message --}}
    @if (session('message'))
      <p class="tw-text-green-600 tw-font-semibold tw-mt-4">{{ session('message') }}</p>
    @endif

    {{-- Resend Form --}}
    <form method="POST" action="{{ route('verification.send') }}" class="tw-mt-8">
      @csrf
      <button type="submit"
        class="tw-bg-blue-500 tw-text-white tw-px-8 tw-py-2.5 tw-rounded-full tw-font-semibold tw-transition-all tw-duration-300 hover:tw-bg-blue-600 hover:tw-scale-105">
        Resend Verification Email
      </button>
    </form>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" class="tw-mt-4">
      @csrf
      <button type="submit" class="tw-text-gray-500 tw-underline hover:tw-text-gray-700 tw-transition">
        Log Out
      </button>
    </form>

  </div>
</div>
@endsection
