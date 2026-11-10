@extends('layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <div class="tw-mx-auto tw-w-full tw-max-w-[2000px]">

        {{-- Page Header --}}
        <header class="lm-heading">
            <div>
                <span class="lm-eyebrow">Management / Activity Logs</span>
                <h1>Activity Logs</h1>
                <p>Monitor and review user activities and system changes.</p>
            </div>
        </header>

        {{-- Main Content --}}
        <div class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/60 tw-bg-white tw-shadow-sm">

            {{-- Section Header --}}
            <div
                class="tw-flex tw-flex-col tw-gap-3 tw-border-b tw-border-[#C4C4C4]/50 tw-bg-white tw-px-6 tw-py-5 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">
                <div>
                    <div class="tw-flex tw-items-center tw-gap-2">
                        <svg class="tw-h-5 tw-w-5 tw-text-[#087B60]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>

                        <h2 class="tw-text-base tw-font-semibold tw-text-[#111111]">
                            System Activity
                        </h2>
                    </div>

                    <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                        Review recorded actions, affected records, and changes made across the system.
                    </p>
                </div>

                {{-- Filters --}}
                <div class="tw-px-5">
                    <form method="GET" class="tw-flex tw-flex-col tw-gap-3 lg:tw-flex-row lg:tw-items-end">

                        {{-- Role Filter --}}
                        <div class="tw-w-full lg:tw-w-48">
                            <label for="role" class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#666666]">
                                User Role
                            </label>

                            <select id="role" name="role"
                                class="tw-h-10 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-colors focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                                <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                            </select>
                        </div>

                        {{-- Table Name --}}
                        <div class="tw-w-full lg:tw-w-52">
                            <label for="table_name"
                                class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#666666]">
                                Table Name
                            </label>

                            <input id="table_name" type="text" name="table_name" value="{{ request('table_name') }}"
                                placeholder="Search table..."
                                class="tw-h-10 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-colors placeholder:tw-text-gray-400 focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20" />
                        </div>

                        {{-- User ID --}}
                        <div class="tw-w-full lg:tw-w-44">
                            <label for="user_id" class="tw-mb-1.5 tw-block tw-text-xs tw-font-semibold tw-text-[#666666]">
                                User ID
                            </label>

                            <input id="user_id" type="text" name="user_id" value="{{ request('user_id') }}"
                                placeholder="Enter user ID..."
                                class="tw-h-10 tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-text-sm tw-text-[#111111] tw-outline-none tw-transition-colors placeholder:tw-text-gray-400 focus:tw-border-[#06EBB6] focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20" />
                        </div>

                        {{-- Filter Actions --}}
                        <div class="tw-flex tw-items-center tw-gap-2">
                            <button type="submit"
                                class="tw-inline-flex tw-h-10 tw-items-center tw-justify-center tw-gap-2 tw-rounded-lg tw-bg-[#06EBB6] tw-px-5 tw-text-sm tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus-visible:tw-outline-none focus-visible:tw-ring-2 focus-visible:tw-ring-[#06EBB6] focus-visible:tw-ring-offset-2">

                                <svg class="tw-h-4 tw-w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4h18M6 10h12m-9 6h6m-3 0v4" />
                                </svg>

                                Apply Filters
                            </button>

                            @if(request()->hasAny(['role', 'table_name', 'user_id']))
                                <a href="{{ url()->current() }}"
                                    class="tw-inline-flex tw-h-10 tw-items-center tw-justify-center tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-text-sm tw-font-medium tw-text-[#666666] tw-transition-colors hover:tw-bg-gray-100 hover:tw-text-[#111111]">
                                    Reset
                                </a>
                            @endif
                        </div>

                    </form>
                </div>
            </div>



            {{-- Table --}}
            <div class="tw-overflow-x-auto">
                <table class="tw-w-full tw-text-left tw-text-sm">

                    {{-- Dark Table Header --}}
                    <thead class="tw-bg-[#06100D]">
                        <tr class="tw-text-[11px] tw-font-semibold tw-uppercase tw-tracking-wider tw-text-white">
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">ID</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">User</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Role</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Action</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Table</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Record ID</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Old Data</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">New Data</th>
                            <th class="tw-whitespace-nowrap tw-px-5 tw-py-4">Timestamp</th>
                        </tr>
                    </thead>

                    <tbody class="tw-divide-y tw-divide-[#C4C4C4]/40">

                        @forelse($logs as $log)
                            <tr class="tw-transition-colors hover:tw-bg-[#F8FAF9]">

                                {{-- ID --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-font-semibold tw-tabular-nums tw-text-[#111111]">
                                        #{{ $log->id }}
                                    </span>
                                </td>

                                {{-- User --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-font-medium tw-text-[#111111]">
                                        {{ $log->user_id }}
                                    </span>
                                </td>

                                {{-- Role --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span
                                        class="tw-inline-flex tw-rounded-md tw-bg-[#F3F5F4] tw-px-2.5 tw-py-1 tw-text-xs tw-font-medium tw-capitalize tw-text-[#555555]">
                                        {{ $log->role }}
                                    </span>
                                </td>

                                {{-- Action --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-font-medium tw-text-[#111111]">
                                        {{ $log->action }}
                                    </span>
                                </td>

                                {{-- Table Name --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-text-[#666666]">
                                        {{ $log->table_name }}
                                    </span>
                                </td>

                                {{-- Record ID --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-font-medium tw-tabular-nums tw-text-[#111111]">
                                        {{ $log->record_id }}
                                    </span>
                                </td>

                                @php
                                    $oldData = json_decode($log->old_data ?? 'null', true);
                                    $newData = json_decode($log->new_data ?? 'null', true);

                                    $jsonOptions = JSON_PRETTY_PRINT
                                        | JSON_UNESCAPED_SLASHES
                                        | JSON_UNESCAPED_UNICODE;

                                    $oldJson = json_encode($oldData, $jsonOptions) ?: 'null';
                                    $newJson = json_encode($newData, $jsonOptions) ?: 'null';

                                    $oldFields = is_array($oldData) ? array_keys($oldData) : [];
                                    $newFields = is_array($newData) ? array_keys($newData) : [];

                                    $oldSummary = count($oldFields)
                                        ? implode(', ', array_map(fn($field) => Str::headline((string) $field), array_slice($oldFields, 0, 3)))
                                        : (is_null($oldData) ? 'No previous data' : 'Recorded value');

                                    $newSummary = count($newFields)
                                        ? implode(', ', array_map(fn($field) => Str::headline((string) $field), array_slice($newFields, 0, 3)))
                                        : (is_null($newData) ? 'No new data' : 'Recorded value');
                                @endphp

                                {{-- Old Data --}}
                                <td class="tw-max-w-[220px] tw-px-5 tw-py-2">
                                    <div class="tw-rounded-lg tw-border tw-border-[#E5E7EB] tw-bg-[#F8F9F9] tw-p-3">
                                        <p class="tw-text-xs tw-font-medium tw-text-[#333333]">
                                            {{ count($oldFields) }} {{ count($oldFields) === 1 ? 'field' : 'fields' }}
                                        </p>

                                        <p class="tw-mt-1 tw-truncate tw-text-xs tw-text-[#777777]">
                                            {{ $oldSummary }}
                                        </p>
                                    </div>
                                </td>

                                {{-- New Data --}}
                                <td class="tw-max-w-[300px] tw-px-5 tw-py-2">
                                    <div class="tw-flex  tw-justify-between tw-rounded-lg tw-border tw-border-[#E5E7EB] tw-bg-[#F8F9F9] tw-p-3">
                                        <div>
                                        <p class="tw-text-xs tw-font-medium tw-text-[#333333]">
                                            {{ count($newFields) }} {{ count($newFields) === 1 ? 'field' : 'fields' }}
                                        </p>

                                        <p class="tw-mt-1 tw-truncate tw-text-xs tw-text-[#777777]">
                                            {{ $newSummary }}
                                        </p>
                                        </div>

                                        <button type="button"
                                            class="view-change-details tw-mt-2 tw-text-xs tw-font-semibold tw-text-[#087B60] hover:tw-text-[#1ED9D7] tw-transition-colors"
                                            data-old="{{ $oldJson }}" data-new="{{ $newJson }}">
                                            View comparison
                                        </button>
                                    </div>
                                </td>

                                {{-- Timestamp --}}
                                <td class="tw-whitespace-nowrap tw-px-5 tw-py-4">
                                    <span class="tw-text-xs tw-text-[#666666]">
                                        {{ $log->created_at?->format('M d, Y') }}
                                    </span>

                                    <p class="tw-mt-1 tw-text-xs tw-text-[#999999]">
                                        {{ $log->created_at?->format('h:i A') }}
                                    </p>
                                </td>

                            </tr>

                        @empty

                            {{-- Empty State --}}
                            <tr>
                                <td colspan="9" class="tw-px-6 tw-py-20">
                                    <div class="tw-flex tw-flex-col tw-items-center tw-justify-center tw-text-center">

                                        <div
                                            class="tw-mb-4 tw-flex tw-h-14 tw-w-14 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#F3F5F4]">
                                            <svg class="tw-h-7 tw-w-7 tw-text-[#999999]" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </div>

                                        <h3 class="tw-text-sm tw-font-semibold tw-text-[#111111]">
                                            No activity logs found
                                        </h3>

                                        <p class="tw-mt-1 tw-max-w-sm tw-text-xs tw-text-[#666666]">
                                            No recorded activities match the selected filters.
                                        </p>

                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div
                class="tw-flex tw-flex-col tw-gap-3 tw-border-t tw-border-[#C4C4C4]/50 tw-bg-white tw-px-6 tw-py-4 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between">

                <span class="tw-text-xs tw-text-[#666666]">
                    Rows per page: <span class="tw-font-semibold tw-text-[#111111]">10</span>
                </span>

                <div class="tw-overflow-x-auto">
                    {{ $logs->links('vendor.pagination.custom') }}
                </div>

            </div>

        </div>
    </div>

    {{-- Change Details Modal --}}
    <div id="changeDetailsModal"
        class="tw-fixed tw-inset-0 tw-z-[100] tw-hidden tw-items-center tw-justify-center tw-bg-[#06100D]/60 tw-p-4"
        role="dialog" aria-modal="true" aria-labelledby="changeDetailsTitle">
        <div
            class="tw-w-full tw-max-w-4xl tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4] tw-bg-white tw-shadow-xl">

            {{-- Modal Header --}}
            <div class="tw-flex tw-items-center tw-justify-between tw-border-b tw-border-[#E5E7EB] tw-px-6 tw-py-4">
                <div>
                    <h2 id="changeDetailsTitle" class="tw-text-lg tw-font-semibold tw-text-[#111111]">
                        Change Details
                    </h2>

                    <p class="tw-mt-1 tw-text-xs tw-text-[#777777]">
                        Compare the previous and updated record data.
                    </p>
                </div>

                <button type="button" data-close-change-modal
                    class="tw-rounded-lg tw-p-2 tw-text-[#777777] hover:tw-bg-[#F3F4F6] hover:tw-text-[#111111] tw-transition-colors"
                    aria-label="Close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- Modal Content --}}
            <div class="tw-grid tw-grid-cols-1 md:tw-grid-cols-2 tw-gap-4 tw-p-6">

                {{-- Old Data --}}
                <div class="tw-min-w-0">
                    <div class="tw-mb-2 tw-flex tw-items-center tw-gap-2">
                        <span class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#D97706]"></span>
                        <h3 class="tw-text-sm tw-font-semibold tw-text-[#333333]">
                            Previous Data
                        </h3>
                    </div>

                    <pre id="oldChangeData"
                        class="tw-max-h-[350px] tw-overflow-auto tw-rounded-lg tw-border tw-border-[#E5E7EB] tw-bg-[#F8F9F9] tw-p-4 tw-font-mono tw-text-xs tw-leading-relaxed tw-text-[#444444] tw-whitespace-pre-wrap tw-break-words"></pre>
                </div>

                {{-- New Data --}}
                <div class="tw-min-w-0">
                    <div class="tw-mb-2 tw-flex tw-items-center tw-gap-2">
                        <span class="tw-h-2 tw-w-2 tw-rounded-full tw-bg-[#059669]"></span>
                        <h3 class="tw-text-sm tw-font-semibold tw-text-[#333333]">
                            Updated Data
                        </h3>
                    </div>

                    <pre id="newChangeData"
                        class="tw-max-h-[350px] tw-overflow-auto tw-rounded-lg tw-border tw-border-[#E5E7EB] tw-bg-[#F8F9F9] tw-p-4 tw-font-mono tw-text-xs tw-leading-relaxed tw-text-[#444444] tw-whitespace-pre-wrap tw-break-words"></pre>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="tw-flex tw-justify-end tw-border-t tw-border-[#E5E7EB] tw-bg-[#FAFAFA] tw-px-6 tw-py-4">
                <button type="button" data-close-change-modal
                    class="tw-rounded-lg tw-bg-[#06100D] tw-px-5 tw-py-2 tw-text-sm tw-font-medium tw-text-white hover:tw-bg-[#18352D] tw-transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite([
        'resources/js/activity_logs/activityLogs.js'
    ])
@endsection