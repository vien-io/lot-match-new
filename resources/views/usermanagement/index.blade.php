@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="tw-p-6">
    <!-- Header -->
    <h1 class="tw-text-2xl tw-font-bold tw-text-center tw-mb-2">User Management</h1>
    <p class="tw-text-center tw-text-gray-500 tw-mb-6">
        Manage system users, their accounts, and permissions.
    </p>

    <div class="tw-bg-white tw-shadow-md tw-rounded-lg tw-overflow-hidden">
        <!-- Toolbar -->
        <div class="tw-flex tw-justify-between tw-items-center tw-p-4 tw-border-b">
            <div class="tw-flex tw-items-center tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input placeholder="Search users..." class="tw-bg-transparent tw-outline-none tw-text-sm" />
            </div>

            <div class="tw-flex tw-gap-2">
                <a href="{{ route('usermanagement.create') }}" 
                   class="tw-px-3 tw-py-1 tw-text-sm tw-rounded-lg tw-bg-emerald-800 tw-hover:tw-bg-green-700 tw-text-white">
                    + Add User
                </a>
               {{--  <button class="tw-px-3 tw-py-1 tw-text-sm tw-border tw-rounded-lg tw-hover:tw-bg-gray-100">
                    Export
                </button> --}}
            </div>
        </div>

        <!-- Users Table -->
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm">
                <thead class="tw-bg-emerald-800 tw-text-left">
                    <tr>
                        <th class="tw-p-2 tw-text-white">ID</th>
                        <th class="tw-p-2 tw-text-white">Name</th>
                        <th class="tw-p-2 tw-text-white">Email</th>
                        <th class="tw-p-2 tw-text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="tw-border-b hover:tw-bg-[#d1fae5] tw-transition-colors">
                            <td class="tw-p-2">{{ $user->id }}</td>
                            <td class="tw-p-2">{{ $user->name }}</td>
                            <td class="tw-p-2">{{ $user->email }}</td>
                            <td class="tw-p-2">
                                <div class="tw-flex tw-gap-2">
                                    <!-- Edit -->
                                    <a href="{{ route('usermanagement.edit', $user->id) }}" 
                                       class="tw-p-2 tw-rounded tw-hover:tw-bg-blue-100 tw-text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                        </svg>
                                    </a>

                                    <!-- Delete -->
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
                    @empty
                        <tr>
                            <td colspan="4" class="tw-text-center tw-p-4 tw-text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="tw-p-4 tw-border-t tw-flex tw-justify-end tw-items-center tw-text-sm tw-text-gray-500">
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>
@endsection