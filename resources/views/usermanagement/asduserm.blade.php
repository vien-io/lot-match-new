{{-- MIGHT BE UNUSED --}}
@extends('layouts.app')

@section('title', 'User Management')

@section('content')
<div class="tw-bg-gray-50 tw-min-h-screen tw-p-6">

    {{-- Page Header --}}
    <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
        <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800">User Management</h1>
        <a href="{{ route('users.create') }}" 
           class="tw-bg-green-500 tw-text-white tw-rounded tw-px-4 tw-py-2 hover:tw-bg-green-600">
           Add New User
        </a>
    </div>

    {{-- User Table --}}
    <div class="tw-bg-white tw-shadow-md tw-rounded-2xl tw-overflow-x-auto">
        <table class="tw-min-w-full tw-divide-y tw-divide-gray-200">
            <thead class="tw-bg-gray-100">
                <tr>
                    <th class="tw-px-6 tw-py-3 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-700">Name</th>
                    <th class="tw-px-6 tw-py-3 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-700">Email</th>
                    <th class="tw-px-6 tw-py-3 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-700">Role</th>
                    <th class="tw-px-6 tw-py-3 tw-text-left tw-text-sm tw-font-semibold tw-text-gray-700">Status</th>
                    <th class="tw-px-6 tw-py-3 tw-text-center tw-text-sm tw-font-semibold tw-text-gray-700">Actions</th>
                </tr>
            </thead>
            <tbody class="tw-bg-white tw-divide-y tw-divide-gray-200">
                @foreach($users as $user)
                <tr>
                    {{-- <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">{{ $user->name }}</td> --}}
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">{{ $user->first_name }}</td>
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">{{ $user->last_name }}</td>
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">{{ $user->email }}</td>
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                        <span class="tw-bg-blue-100 tw-text-blue-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs">{{ $user->role }}</span>
                    </td>
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap">
                        @if($user->is_active)
                            <span class="tw-bg-green-100 tw-text-green-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs">Active</span>
                        @else
                            <span class="tw-bg-red-100 tw-text-red-800 tw-px-2 tw-py-1 tw-rounded-full tw-text-xs">Inactive</span>
                        @endif
                    </td>
                    <td class="tw-px-6 tw-py-4 tw-whitespace-nowrap tw-text-center tw-space-x-2">
                        <a href="{{ route('users.edit', $user->id) }}" 
                           class="tw-text-blue-600 hover:tw-underline">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="tw-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="tw-text-red-600 hover:tw-underline" onclick="return confirm('Are you sure?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@endsection
