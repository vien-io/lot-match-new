{{-- resources/views/owner-verification/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Owner Verification Requests')

@section('content')
<div class="tw-bg-gray-50 tw-min-h-screen tw-p-6">

    <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-6">Owner Verification Requests</h1>

    @if(session('success'))
        <div class="tw-bg-green-100 tw-text-green-700 tw-p-4 tw-rounded tw-mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-overflow-x-auto">
        <table class="tw-w-full tw-text-sm">
            <thead class="tw-bg-gray-100 tw-text-left">
                <tr>
                    <th class="tw-p-3">ID</th>
                    <th class="tw-p-3">User</th>
                    <th class="tw-p-3">Lot</th>
                    <th class="tw-p-3">Proof</th>
                    <th class="tw-p-3">Status</th>
                    <th class="tw-p-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                <tr class="hover:tw-bg-gray-50 tw-border-b">
                    <td class="tw-p-3">{{ $request->id }}</td>
                    <td class="tw-p-3">{{ $request->user->name }} ({{ $request->user->email }})</td>
                    <td class="tw-p-3">{{ $request->lot->block->name }} - Lot {{ $request->lot->number }}</td>
                    <td class="tw-p-3">
                        <a href="{{ asset('storage/' . $request->proof_document) }}" target="_blank" class="tw-text-blue-600 tw-underline">View Document</a>
                    </td>
                    <td class="tw-p-3 tw-capitalize">{{ $request->status }}</td>
                    <td class="tw-p-3 tw-flex tw-gap-2">
                        @if($request->status === 'pending')
                            <form action="{{ route('owner-verification.approve', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="tw-bg-green-600 tw-text-white tw-px-3 tw-py-1 tw-rounded hover:tw-bg-green-700">Approve</button>
                            </form>
                            <form action="{{ route('owner-verification.reject', $request->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="tw-bg-red-600 tw-text-white tw-px-3 tw-py-1 tw-rounded hover:tw-bg-red-700">Reject</button>
                            </form>
                        @else
                            <span class="tw-text-gray-500">No actions</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="tw-text-center tw-p-4 tw-text-gray-500">No verification requests found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
