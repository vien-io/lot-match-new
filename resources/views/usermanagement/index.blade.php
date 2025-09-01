@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="tw-flex tw-flex-col lg:tw-flex-row tw-gap-8 tw-mt-12 tw-px-6">

    {{-- Left Column: User List --}}
    <div class="tw-flex-1 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
        <h1 class="tw-text-2xl tw-font-bold tw-mb-6">User Management</h1>
    
        {{-- Users Table --}}
        <div class="tw-overflow-x-auto">
            <table class="tw-min-w-full tw-bg-white tw-rounded-xl tw-shadow-sm text-sm">
                <thead class="tw-bg-gray-100">
                    <tr>
                        <th class="tw-text-left tw-px-4 tw-py-2">ID</th>
                        <th class="tw-text-left tw-px-4 tw-py-2">Name</th>
                        <th class="tw-text-left tw-px-4 tw-py-2">Email</th>
                        <th class="tw-text-left tw-px-4 tw-py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="tw-border-b hover:tw-bg-[#d1fae5] tw-transition-colors">
                            <td class="tw-px-4 tw-py-2">{{ $user->id }}</td>
                            <td class="tw-px-4 tw-py-2">{{ $user->name }}</td>
                            <td class="tw-px-4 tw-py-2">{{ $user->email }}</td>
                            <td class="tw-px-4 tw-py-2">
                                <div class="tw-flex tw-gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('usermanagement.edit', $user->id) }}" 
                                       class="tw-p-2 tw-rounded tw-hover:tw-bg-blue-100 tw-text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form action="{{ route('usermanagement.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tw-p-2 tw-rounded tw-hover:tw-bg-red-100 tw-text-red-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @endforeach 
                </tbody>
            </table>
        </div>
    </div>



    {{-- Right Column: Quick Actions --}}  
    <div class="tw-w-full lg:tw-w-96 tw-bg-white tw-rounded-3xl tw-shadow-md tw-p-6">
    <h2 class="tw-font-bold tw-mb-4">Quick Actions</h2>

    <div class="tw-flex tw-flex-col tw-gap-3">
        <a href="{{ route('usermanagement.create') }}" 
           class="tw-bg-green-500 tw-text-white tw-font-semibold tw-px-4 tw-py-2 tw-rounded-xl hover:tw-bg-green-600 text-center">
            + Add New User
        </a>

        <button class="tw-bg-gray-200 tw-text-gray-700 tw-font-semibold tw-px-4 tw-py-2 tw-rounded-xl hover:tw-bg-gray-300">
            Export Users
        </button>
    </div>
  </div>
</div>
@endsection