@extends('layouts.app')

@section('title', 'Email Verified Successfully')

@section('content')
<div class="tw-bg-gradient-to-br tw-from-green-50 tw-to-white tw-min-h-screen tw-flex tw-items-center tw-justify-center">

  <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-px-10 tw-py-12 tw-text-center tw-max-w-md tw-border tw-border-gray-100 tw-transition-all tw-duration-300 hover:tw-shadow-xl">

    {{-- Icon --}}
    <div class="tw-bg-green-100 tw-rounded-full tw-p-4 tw-inline-flex tw-items-center tw-justify-center tw-mb-6">
      <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-12 tw-w-12 tw-text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
      </svg>
    </div>

    {{-- Title & Message --}}
    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800">Email Verified!</h1>
    <p class="tw-text-gray-600 tw-mt-3">
      Your email has been successfully verified. You can now explore all features of your account.
    </p>

    {{-- Button --}}
    <a href="/dashboard"
       class="tw-inline-block tw-mt-8 tw-bg-green-500 tw-text-white tw-px-8 tw-py-2.5 tw-rounded-full tw-font-semibold tw-transition-all tw-duration-300 hover:tw-bg-green-600 hover:tw-scale-105">
       Go to Dashboard
    </a>

  </div>
</div>
@endsection
