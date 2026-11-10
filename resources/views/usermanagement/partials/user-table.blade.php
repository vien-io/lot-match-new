{{-- User directory --}}
<section
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

            <tbody class="tw-divide-y tw-divide-[#E8ECEA]">
                @forelse ($users as $user)
                    <tr class="tw-align-top tw-transition-colors hover:tw-bg-[#F8FBFA]">
                        <td
                            class="tw-whitespace-nowrap tw-px-4 tw-text-xs tw-font-medium tw-tabular-nums tw-text-[#666666]">
                            {{ $user->id }}
                        </td>

                        <td class="tw-whitespace-nowrap tw-px-4 tw-font-medium tw-text-[#111111]">
                            {{ $user->username }}
                        </td>

                        <td class="tw-whitespace-nowrap tw-px-4 tw-text-[#333333]">
                            {{ $user->first_name }}
                        </td>

                        <td class="tw-whitespace-nowrap tw-px-4 tw-text-[#333333]">
                            {{ $user->last_name }}
                        </td>

                        <td class="tw-px-4 tw-text-[#666666] tw-max-w-[200px]">
                            <span class="tw-block tw-max-w-5/6 tw-truncate" title="{{ $user->email }}">
                                {{ $user->email }}
                            </span>
                        </td>

                        {{-- Role and owner lot assignment --}}
                        <td class="tw-px-4" x-data='userLotForm({{ $user->id }}, @json($user->role), @json($allLots))'>
                            @if(auth()->user()->role === 'admin')
                                            <form class="form_button tw-w-full tw-max-w-[200px]" action="{{ route('usermanagement.role.update', $user->id) }}"
                                                method="POST" x-ref="form">

                                                @csrf
                                                @method('PATCH')

                                                {{-- Preserve existing user details --}}
                                                <input type="hidden" name="username" value="{{ $user->username }}">
                                                <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                                                <input type="hidden" name="last_name" value="{{ $user->last_name }}">
                                                <input type="hidden" name="email" value="{{ $user->email }}">

                                                <div class="tw-flex tw-w-full tw-min-w-0 tw-items-center tw-gap-3">

                                                    {{-- Role selection --}}
                                                    <select id="role-{{ $user->id }}" name="role" x-model="role" :class="{
                                                            'tw-bg-yellow-100': hasChanges,
                                                            'tw-bg-white': !hasChanges
                                                        }" class="tw-w-[85%] tw-min-w-0 tw-shrink-0 tw-py-2 tw-rounded-md tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-2.5 tw-text-sm tw-text-[#111111] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">

                                                        <option value="admin">Admin</option>
                                                        <option value="owner">Owner</option>
                                                        <option value="buyer">Buyer</option>
                                                    </select>

                                                    {{-- Action buttons and success message --}}
                                                    <div x-cloak class="tw-flex tw-min-w-0 tw-flex-1 tw-items-center tw-gap-2">

                                                        <button x-show="hasChanges" @click="save()" type="button" :disabled="saving"
                                                            class="tw-bg-gray-400 hover:tw-bg-green-400 tw-h-[20px] tw-w-[20px] tw-shrink-0 tw-rounded-full tw-flex tw-items-center tw-justify-center">

                                                            <i class="fa-solid fa-check fa-xs tw-text-white"></i>
                                                        </button>

                                                        <button x-show="hasChanges" @click="resetForm()" type="button"
                                                            class="tw-bg-gray-400 hover:tw-bg-red-400 tw-h-[20px] tw-w-[20px] tw-shrink-0 tw-rounded-full tw-flex tw-items-center tw-justify-center">

                                                            <i class="fa-solid fa-x fa-xs tw-text-white"></i>
                                                        </button>

                                                        {{-- Success message --}}
                                                        <span x-show="saveSuccess" x-cloak
                                                            class="tw-min-w-[70px] tw-flex-1 tw-truncate tw-text-xs tw-text-[#176B4D]/70"
                                                            title="Changes saved!">
                                                            Saved!
                                                        </span>

                                                    </div>
                                                </div>


                                                {{-- Lot assignment is only shown for owners --}}
                                                {{-- <div x-show="role === 'owner'" x-cloak class="tw-mt-3">
                                                    <label for="lot-search-{{ $user->id }}"
                                                        class="tw-mb-1 tw-block tw-text-xs tw-font-medium tw-text-[#666666]">
                                                        Assigned properties
                                                    </label>

                                                    <div class="tw-relative">
                                                        <input id="lot-search-{{ $user->id }}" type="text" x-model="query"
                                                            @input="filterLots()" placeholder="Search lot or block..." autocomplete="off"
                                                            class="tw-w-full tw-rounded-md tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2 tw-text-xs tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20"
                                                            @click.outside="query=''; filteredLots=[]"
                                                            @keydown.escape="query=''; filteredLots=[]">

                                                        <div x-show="filteredLots.length > 0" x-cloak
                                                            class="tw-absolute tw-left-0 tw-right-0 tw-z-20 tw-mt-1 tw-max-h-40 tw-overflow-y-auto tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-p-1 tw-shadow-lg">
                                                            <template x-for="lot in filteredLots" :key="lot.id">
                                                                <button type="button"
                                                                    class="tw-block tw-w-full tw-rounded-md tw-px-3 tw-py-2 tw-text-left tw-text-xs tw-text-[#333333] hover:tw-bg-[#EAFBF6] focus:tw-bg-[#EAFBF6] focus:tw-outline-none"
                                                                    @click="selectLot(lot)">
                                                                    <span x-text="lot.name + ' (' + lot.block + ')'"></span>
                                                                </button>
                                                            </template>
                                                        </div>
                                                    </div>

                                                    <div class="tw-mt-2 tw-space-y-1.5">
                                                        <template x-for="(lot, index) in selectedLots" :key="lot.id">
                                                            <div class="tw-flex tw-items-center tw-gap-2">
                                                                <input type="hidden" name="lot_ids[]" :value="lot.id">
                                                                <div
                                                                    class="tw-min-w-0 tw-flex-1 tw-rounded-md tw-border tw-border-[#DDE4E1] tw-bg-[#F5F8F7] tw-px-2.5 tw-py-1.5">
                                                                    <span class="tw-block tw-truncate tw-text-xs tw-text-[#333333]"
                                                                        x-text="lot.name + ' (' + lot.block + ')'"></span>
                                                                </div>
                                                                <button type="button"
                                                                    class="tw-rounded-md tw-p-1.5 tw-text-[#666666] hover:tw-bg-[#FDECEC] hover:tw-text-[#B42318] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-red-200"
                                                                    aria-label="Remove assigned property" @click="removeLot(index)">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-4 tw-w-4"
                                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                        stroke-width="2">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M6 18 18 6M6 6l12 12" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div> --}}

                                                {{-- <div x-show="hasChangess" x-cloak class="tw-mt-3 tw-flex tw-items-center tw-gap-2">
                                                    <button type="submit"
                                                        class="tw-rounded-md tw-bg-[#06EBB6] tw-px-3 tw-py-1.5 tw-text-xs tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-1">
                                                        Save changes
                                                    </button>
                                                    <button type="button"
                                                        class="tw-rounded-md tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-1.5 tw-text-xs tw-font-medium tw-text-[#333333] hover:tw-bg-[#F5F7F6] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#C4C4C4]"
                                                        @click="resetForm()">
                                                        Cancel
                                                    </button>
                                                </div> --}}
                                            </form>
                            @else
                                <span
                                    class="tw-inline-flex tw-items-center tw-rounded-md tw-bg-[#F0F3F2] tw-px-2.5 tw-py-1 tw-text-xs tw-font-medium tw-capitalize tw-text-[#333333]">
                                    {{ $user->role }}
                                </span>
                            @endif
                        </td>

                        {{-- Email verification --}}
                        <td class="tw-whitespace-nowrap tw-px-4">
                            @if($user->email_verified_at)
                                <span
                                    class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-full tw-bg-[#E8F8F1] tw-px-2.5 tw-py-1 tw-text-xs tw-font-medium tw-text-[#176B4D]">
                                    <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#1A9B68]"></span>
                                    Verified
                                </span>
                            @else
                                <span
                                    class="tw-inline-flex tw-items-center tw-gap-1.5 tw-rounded-full tw-bg-[#FFF6E5] tw-px-2.5 tw-py-1 tw-text-xs tw-font-medium tw-text-[#946200]">
                                    <span class="tw-h-1.5 tw-w-1.5 tw-rounded-full tw-bg-[#D99A19]"></span>
                                    Pending
                                </span>
                            @endif
                        </td>

                        {{-- Edit and delete actions --}}
                        <td class="tw-whitespace-nowrap tw-px-4">
                            <div class="tw-flex tw-gap-1">
                                <button type="button"
                                    onclick="openEditUserModal({{ Js::from($user->id) }}, {{ Js::from($user->username) }}, {{ Js::from($user->first_name) }}, {{ Js::from($user->last_name) }}, {{ Js::from($user->email) }})"
                                    class="tw-rounded-md tw-p-2 tw-text-[#52645D]/50 tw-transition-colors hover:tw-bg-[#EAFBF6] hover:tw-text-[#087A61] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/40"
                                    aria-label="Edit {{ $user->username }}" title="Edit user">
                                    <i class="fas fa-pen"></i>
                                </button>
                                <div class="tw-flex tw-items-center">
                                    <form class="form_button" action="{{ route('usermanagement.destroy', $user->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="tw-rounded-md tw-p-2 tw-text-[#8A5555]/50 tw-transition-colors hover:tw-bg-[#FDECEC] hover:tw-text-[#B42318] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-red-200"
                                            aria-label="Delete {{ $user->username }}" title="Delete user">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="tw-px-6 tw-py-14 tw-text-center">
                            <div class="tw-mx-auto tw-flex tw-max-w-sm tw-flex-col tw-items-center">
                                <div
                                    class="tw-mb-3 tw-flex tw-h-11 tw-w-11 tw-items-center tw-justify-center tw-rounded-full tw-bg-[#F0F3F2] tw-text-[#666666]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="tw-h-5 tw-w-5" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1.7">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2m6-10a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm8-1v6m3-3h-6" />
                                    </svg>
                                </div>
                                <p class="tw-text-sm tw-font-semibold tw-text-[#111111]">No users found</p>
                                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                                    @if(request('search'))
                                        Try another search term or clear the current search.
                                    @else
                                        There are no user accounts to display yet.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                @endforelse
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