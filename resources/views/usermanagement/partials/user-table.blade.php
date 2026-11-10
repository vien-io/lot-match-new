{{-- User directory --}}
<section x-data="{ allLots: @js($allLots) }"
    class="tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/70 tw-bg-white tw-shadow-[0_2px_8px_rgba(6,16,13,0.04)]">
    @include('usermanagement.partials.toolbar')

    {{-- Users table --}}
    <div class="tw-overflow-x-auto">
        <table class="tw-w-full tw-min-w-[1050px] tw-border-collapse tw-text-left tw-text-sm">
            <thead class="tw-bg-[#06100D] tw-text-white">
                <tr class="tw-border-b tw-border-[#C4C4C4]/70">
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        ID</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Username</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        First name</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Last name</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Email</th>
                    <th scope="col" class="tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Role & property access</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Verification</th>
                    <th scope="col"
                        class="tw-whitespace-nowrap tw-px-4 tw-py-3 tw-text-xs tw-font-semibold tw-uppercase tw-tracking-wide">
                        Actions</th>
                </tr>
            </thead>

            <tbody id="userTableBody" class="tw-divide-y tw-divide-[#E8ECEA]">
                @include('usermanagement.partials.user-table-rows', ['users' => $users])
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($users->hasPages())
        <div
            class="tw-flex tw-flex-col tw-gap-3 tw-border-t tw-border-[#C4C4C4]/60 tw-px-4 tw-py-3 sm:tw-flex-row sm:tw-items-center sm:tw-justify-between sm:px-5">
            <p class="tw-text-xs tw-text-[#666666]">
                Showing
                <span class="tw-font-semibold tw-text-[#333333]">{{ $users->firstItem() ?? 0 }}</span>
                to
                <span class="tw-font-semibold tw-text-[#333333]">{{ $users->lastItem() ?? 0 }}</span>
                of
                <span class="tw-font-semibold tw-text-[#333333]">{{ $users->total() }}</span>
                users
            </p>
            <div class="tw-text-sm">
                {{ $users->appends(request()->query())->links('vendor.pagination.custom') }}
            </div>
        </div>
    @elseif($users->total() > 0)
        <div class="tw-border-t tw-border-[#C4C4C4]/60 tw-px-5 tw-py-3">
            <p class="tw-text-xs tw-text-[#666666]">
                {{ $users->total() }} {{ \Illuminate\Support\Str::plural('user', $users->total()) }}
            </p>
        </div>
    @endif
</section>