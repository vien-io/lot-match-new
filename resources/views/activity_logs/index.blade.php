@extends('layouts.app')

@section('content')
<div>
    <!-- Header -->
    <h1 class="tw-text-2xl tw-font-bold tw-text-center tw-mb-2">Activity Logs</h1>
    <p class="tw-text-center tw-text-gray-500 tw-mb-6">
        View and filter all user actions across the system.
    </p>

    <div class="tw-bg-white tw-shadow-md tw-rounded-lg tw-overflow-hidden">
        <!-- Toolbar / Filters -->
        <div class="tw-flex tw-justify-between tw-items-center tw-p-4 tw-border-b">
            <div class="tw-flex tw-gap-2">
                <!-- Filters -->
                <form method="GET" class="tw-flex tw-items-center tw-gap-2">
                    <select name="role" class="tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50">
                        <option value="">All Roles</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="owner" {{ request('role') === 'owner' ? 'selected' : '' }}>Owner</option>
                        <option value="buyer" {{ request('role') === 'buyer' ? 'selected' : '' }}>Buyer</option>
                    </select>

                    <input type="text" name="table_name" placeholder="Table name" value="{{ request('table_name') }}"
                        class="tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50" />

                    <input type="text" name="user_id" placeholder="User ID" value="{{ request('user_id') }}"
                        class="tw-border tw-rounded-lg tw-px-3 tw-py-1 tw-bg-gray-50" />

                    <button type="submit" class="tw-px-3 tw-py-1 tw-bg-emerald-800 tw-text-white tw-rounded-lg tw-hover:tw-bg-green-700">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="tw-overflow-x-auto">
            <table class="tw-w-full tw-text-sm">
                <thead class="tw-bg-emerald-800 tw-text-left">
                    <tr>
                        <th class="tw-p-2 tw-text-white">ID</th>
                        <th class="tw-p-2 tw-text-white">User</th>
                        <th class="tw-p-2 tw-text-white">Role</th>
                        <th class="tw-p-2 tw-text-white">Action</th>
                        <th class="tw-p-2 tw-text-white">Table</th>
                        <th class="tw-p-2 tw-text-white tw-whitespace-nowrap">Record ID</th>
                        <th class="tw-p-2 tw-text-white">Old Data</th>
                        <th class="tw-p-2 tw-text-white">New Data</th>
                        <th class="tw-p-2 tw-text-white">Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr class="tw-border-b hover:tw-bg-[#f7fdf7] tw-transition-colors">
                            <td class="tw-p-2">{{ $log->id }}</td>
                            <td class="tw-p-2">{{ $log->user_id }}</td>
                            <td class="tw-p-2">{{ $log->role }}</td>
                            <td class="tw-p-2">{{ $log->action }}</td>
                            <td class="tw-p-2">{{ $log->table_name }}</td>
                            <td class="tw-p-2">{{ $log->record_id }}</td>

                            <!-- Old Data -->
                            <td class="tw-p-2">
                                @php
                                    $jsonPretty = json_encode(json_decode($log->old_data), JSON_PRETTY_PRINT);
                                    $truncated = Str::limit($jsonPretty, 100, '...');
                                @endphp
                                <div 
                                    class="tw-rounded tw-p-1 tw-overflow-hidden expandable"
                                    data-expanded="false"
                                    data-full="{{ htmlspecialchars($jsonPretty, ENT_NOQUOTES) }}"
                                    data-truncated="{{ htmlspecialchars($truncated, ENT_NOQUOTES) }}"
                                    style="max-height: 1.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: max-height 0.3s;"
                                >
                                    {{ $truncated }}
                                </div>
                                @if(strlen($jsonPretty) > 150)
                                    <div class="tw-flex tw-justify-end tw-mt-1">
                                        <button class="tw-mt-1 tw-text-gray-700 tw-bg-gray-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs toggle-json">View More</button>
                                    </div>
                                    
                                @endif
                            </td>

                            <!-- New Data -->
                            <td class="tw-p-2">
                                @php
                                    $jsonPrettyNew = json_encode(json_decode($log->new_data), JSON_PRETTY_PRINT);
                                    $truncatedNew = Str::limit($jsonPrettyNew, 100, '...');
                                @endphp
                                <div 
                                    class="tw-rounded tw-p-1 tw-overflow-hidden expandable-new"
                                    data-expanded="false"
                                    data-full="{{ htmlspecialchars($jsonPrettyNew, ENT_NOQUOTES) }}"
                                    data-truncated="{{ htmlspecialchars($truncatedNew, ENT_NOQUOTES) }}"
                                    style="max-height: 1.5rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; transition: max-height 0.3s;"
                                >
                                    {{ $truncatedNew }}
                                </div>
                                @if(strlen($jsonPrettyNew) > 150)
                                    <div class="tw-flex tw-justify-end tw-mt-1">
                                        <button class="tw-mt-1 tw-text-gray-700 tw-bg-gray-100 tw-px-1 tw-py-0.5 tw-rounded tw-text-xs toggle-json">View More</button>
                                    </div>
                                @endif
                            </td>

                            <td class="tw-p-2">{{ $log->created_at }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="tw-text-center tw-p-4 tw-text-gray-500">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="tw-p-4 tw-border-t tw-flex tw-justify-between tw-items-center tw-text-sm tw-text-gray-500">
            <span>Rows per page: 10</span>
            {{ $logs->links('vendor.pagination.custom') }}
        </div>
    </div>
</div>

@endsection

@section('scripts')
    @vite([
        'resources/js/activity_logs/activityLogs.js'
    ])
@endsection

