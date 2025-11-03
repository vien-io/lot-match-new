{{-- resources/views/owner-verification/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Request Property Ownership')

@section('content')
<div class="tw-bg-gray-50 tw-min-h-screen tw-flex tw-items-start tw-justify-center tw-p-6">
    <div class="tw-w-full sm:tw-w-3/4 md:tw-w-2/3 lg:tw-w-1/2 xl:tw-w-1/3">
        <h1 class="tw-text-3xl tw-font-bold tw-text-gray-800 tw-mb-6 tw-text-center">Request Property Ownership</h1>

        @if(session('success'))
            <div class="tw-bg-green-100 tw-text-green-700 tw-p-4 tw-rounded tw-mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="tw-bg-white tw-rounded-2xl tw-shadow-md tw-p-6">
            <form action="{{ route('owner-verification.store') }}" method="POST" enctype="multipart/form-data" class="tw-space-y-4">
                @csrf

                <div>
                    <label for="lot_id" class="tw-block tw-font-medium tw-text-gray-700">Select Lot</label>
                    <select name="lot_id" id="lot_id" required class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-lg tw-p-2">
                        @foreach($lots as $lot)
                            <option value="{{ $lot->id }}">{{ $lot->block->name }} - {{ $lot->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="proof_document" class="tw-block tw-font-medium tw-text-gray-700">Upload Proof Document</label>
                    <input type="file" name="proof_document" id="proof_document" accept=".pdf,.jpg,.png" required class="tw-mt-1 tw-w-full tw-border tw-border-gray-300 tw-rounded-lg tw-p-2">
                </div>

                <button type="submit" class="tw-bg-blue-600 tw-text-white tw-px-4 tw-py-2 tw-rounded-lg hover:tw-bg-blue-700 tw-w-full">
                    Submit Request
                </button>
            </form>
        </div>
    </div>
</div>

@endsection
