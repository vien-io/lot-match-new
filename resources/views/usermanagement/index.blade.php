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
            <!-- Search Form -->
            <form method="GET" action="{{ route('usermanagement.index') }}" class="tw-flex tw-items-center tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-4 tw-h-4 tw-text-gray-400 tw-mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="tw-bg-transparent tw-outline-none tw-text-sm tw-w-full" />
            </form>

            <!-- Toolbar Buttons -->
            <div class="tw-flex tw-gap-2">
                <!-- Add User Modal Trigger -->
                <button type="button"
                    onclick="document.getElementById('addUserModal').classList.remove('tw-hidden')"
                    class="tw-bg-emerald-800 tw-text-white tw-px-4 tw-py-1 tw-rounded-lg hover:tw-bg-green-700">
                    + Add User
                </button>
            </div>
        </div>
        @if(session('success'))
            <div class="tw-bg-green-100 tw-text-green-700 tw-p-3 tw-rounded-lg tw-mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm">
                <thead class="tw-bg-emerald-800 tw-text-left">
                    <tr>
                        <th class="tw-p-2 tw-text-white">ID</th>
                        <th class="tw-p-2 tw-text-white">Username</th>
                        <th class="tw-p-2 tw-text-white">Full Name</th>
                        <th class="tw-p-2 tw-text-white">Email</th>
                        <th class="tw-p-2 tw-text-white">Role</th>
                        <th class="tw-p-2 tw-text-white">Verification</th>
                        <th class="tw-p-2 tw-text-white">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="tw-border-b hover:tw-bg-[#d1fae5] tw-transition-colors">
                            <td class="tw-p-2">{{ $user->id }}</td>
                            <td class="tw-p-2">{{ $user->username }}</td>
                            <td class="tw-p-2">{{ $user->name }}</td>
                            <td class="tw-p-2">{{ $user->email }}</td>

                            {{-- Role & Owner Lot Assignment --}}
                            <td class="tw-p-2"
                                x-data='userLotForm({{ $user->id }}, @json($user->role), @json($allLots))'>

                                
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('usermanagement.update', $user->id) }}" method="POST" x-ref="form">
                                        @csrf
                                        @method('PUT')

                                        <!-- Hidden user info -->
                                        <input type="hidden" name="username" value="{{ $user->username }}">
                                        <input type="hidden" name="name" value="{{ $user->name }}">
                                        <input type="hidden" name="email" value="{{ $user->email }}">

                                        <!-- Role dropdown -->
                                        <select name="role" x-model="role" class="tw-border tw-rounded tw-px-2 tw-py-1 tw-text-sm">
                                            <option value="admin" :selected="role === 'admin'">Admin</option>
                                            <option value="owner" :selected="role === 'owner'">Owner</option>
                                            <option value="buyer" :selected="role === 'buyer'">Buyer</option>
                                        </select>

                                        <!-- Lot assignment (only for owners) -->
                                        <div x-show="role === 'owner'" class="tw-mt-2">
                                            <!-- Search field -->
                                            <div class="tw-mt-2" x-data="">
                                                <input type="text"
                                                    x-model="query"
                                                    @input="filterLots()"
                                                    placeholder="Search lot/block..."
                                                    class="tw-w-full tw-border tw-rounded tw-px-2 tw-py-1 tw-text-sm"
                                                    @click.outside="query=''; filteredLots=[]"
                                                    @keydown.escape="query=''; filteredLots=[]">

                                                <div x-show="filteredLots.length > 0"
                                                    class="tw-border tw-rounded tw-bg-white tw-max-h-40 tw-overflow-y-auto tw-mt-1">
                                                    <template x-for="lot in filteredLots" :key="lot.id">
                                                        <div class="tw-px-2 tw-py-1 hover:tw-bg-gray-100 tw-cursor-pointer"
                                                            @click="selectLot(lot)">
                                                            <span x-text="lot.name + ' (' + lot.block + ')'"></span>
                                                        </div>
                                                    </template>
                                                </div>
                                            </div>

                                            <!-- Selected lots -->
                                            <template x-for="(lot, index) in selectedLots" :key="lot.id">
                                                <div class="tw-flex tw-items-center tw-mb-1">
                                                    <input type="hidden" name="lot_ids[]" :value="lot.id">
                                                    <div class="tw-flex-1 tw-px-2 tw-py-1 tw-border tw-rounded tw-bg-gray-100">
                                                        <span x-text="lot.name + ' (' + lot.block + ')'"></span>
                                                    </div>
                                                    <button type="button"
                                                            class="tw-ml-2 tw-text-red-500 hover:tw-text-red-700"
                                                            @click="removeLot(index)">✕</button>
                                                </div>
                                            </template>
                                        </div>

                                        <!-- Save & Cancel buttons -->
                                        <div class="tw-mt-2 tw-flex tw-gap-2" x-show="hasChanges">
                                            <button type="submit"
                                                class="tw-bg-blue-500 hover:tw-bg-blue-600 tw-text-white tw-px-3 tw-py-1 tw-rounded tw-text-sm">
                                                Save
                                            </button>

                                            <button type="button"
                                                class="tw-bg-gray-300 hover:tw-bg-gray-400 tw-text-gray-800 tw-px-3 tw-py-1 tw-rounded tw-text-sm"
                                                @click="resetForm()">
                                                Cancel
                                            </button>
                                        </div>

                                    </form>
                                @else
                                    {{ ucfirst($user->role) }}
                                @endif
                            </td>

                            {{-- Verification --}}
                            <td class="tw-p-2">
                                @if($user->email_verified_at)
                                    <span class="tw-bg-green-100 tw-text-green-800 tw-px-2 tw-py-1 tw-rounded tw-text-xs">Verified</span>
                                @else
                                    <span class="tw-bg-yellow-100 tw-text-yellow-800 tw-px-2 tw-py-1 tw-rounded tw-text-xs">Pending</span>
                                @endif
                            </td>

                            {{-- Edit / Delete --}}
                            <td class="tw-p-2">
                                <div class="tw-flex tw-gap-2 tw-items-center">
                                    <!-- Edit Modal Trigger -->
                                    <button type="button"
                                        onclick="openEditUserModal('{{ $user->id }}', '{{ $user->username }}', '{{ $user->name }}', '{{ $user->email }}')"
                                        class="tw-p-2 tw-rounded tw-hover:tw-bg-blue-100 tw-text-blue-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4.768l10.536-10.536a2 2 0 00-2.828-2.828L4 17.172V20z" />
                                        </svg>
                                    </button>

                                    <!-- Delete -->
                                    <form
                                        class="tw-flex tw-items-center" 
                                        action="{{ route('usermanagement.destroy', $user->id) }}" 
                                        method="POST" 
                                        onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tw-p-2 tw-items-center tw-rounded tw-hover:tw-bg-red-100 tw-text-red-600">
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

@section('scripts')
  @vite([
    'resources/js/userModals.js',
    'resources/sass/app.scss',
  ])
@endsection

{{-- Include Modals --}}
@include('usermanagement.modals.add')
@include('usermanagement.modals.edit')