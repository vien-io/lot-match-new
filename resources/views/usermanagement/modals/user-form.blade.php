{{-- User Modal --}}
<div x-data="userModal" x-cloak x-show="isOpen" x-transition.opacity @click.self="close()"
    @open-add-user.window="openAdd()" @edit-user.window="openEdit($event.detail)" @keydown.escape.window="close()"
    class="tw-fixed tw-inset-0 tw-z-50 tw-flex tw-items-center tw-justify-center tw-bg-[#06100D]/50 tw-p-4">
    <div class="tw-w-full tw-max-w-[440px] tw-overflow-hidden tw-rounded-xl tw-border tw-border-[#C4C4C4]/50 tw-bg-white tw-shadow-2xl"
        @click.stop>
        {{-- Modal Header --}}
        <div class="tw-flex tw-items-start tw-justify-between tw-border-b tw-border-[#C4C4C4]/50 tw-px-6 tw-py-5">
            <div>
                <h2 class="tw-text-lg tw-font-semibold tw-text-[#111111]" x-text="isEditing ? 'Edit User' : 'Add User'">
                </h2>
                <p class="tw-mt-1 tw-text-xs tw-text-[#666666]">
                    Create a new account and configure its access level.
                </p>
            </div>

            <button type="button" @click="close()"
                class="tw-rounded-md tw-p-1.5 tw-text-[#666666] tw-transition-colors hover:tw-bg-[#F3F5F4] hover:tw-text-[#111111] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]"
                aria-label="Close modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        {{-- Modal Body --}}
        <form :action="formAction" method="POST" autocomplete="off">
            @csrf

            <input type="hidden" name="_method" :value="isEditing ? 'PATCH' : 'POST'">

            <div class="tw-space-y-4 tw-px-6 tw-py-5">

                {{-- Username --}}
                <div>
                    <label for="add-username" class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                        Username <span class="tw-text-red-500">*</span>
                    </label>

                    <input id="add-username" type="text" name="username" x-model="form.username"
                        value="{{ old('username') }}" autocomplete="off" placeholder="Enter username" required
                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] tw-transition-colors focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                </div>

                {{-- First and Last Name --}}
                <div class="tw-grid tw-grid-cols-2 tw-gap-3">
                    <div>
                        <label for="add-first-name"
                            class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                            First Name <span class="tw-text-red-500">*</span>
                        </label>

                        <input id="add-first-name" type="text" name="first_name" x-model="form.first_name"
                            value="{{ old('first_name') }}" autocomplete="off" placeholder="First name" required
                            class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                    </div>

                    <div>
                        <label for="add-last-name"
                            class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                            Last Name <span class="tw-text-red-500">*</span>
                        </label>

                        <input id="add-last-name" type="text" name="last_name" x-model="form.last_name"
                            value="{{ old('last_name') }}" autocomplete="off" placeholder="Last name" required
                            class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="add-email" class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                        Email Address <span class="tw-text-red-500">*</span>
                    </label>

                    <input id="add-email" type="email" name="email" x-model="form.email" value="{{ old('email') }}"
                        autocomplete="off" placeholder="name@example.com" required
                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                </div>

                {{-- Password --}}
                <div>
                    <label for="add-password" class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                        Password <span class="tw-text-red-500">*</span>
                    </label>

                    <input id="add-password" type="password" name="password" x-model="form.password"
                        :required="!isEditing"
                        :placeholder="isEditing ? 'Leave blank to keep current password' : 'Enter password'"
                        autocomplete="off" placeholder="Enter password" minlength="6" required
                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] placeholder:tw-text-[#999999] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                    <p class="tw-mt-1 tw-text-[11px] tw-text-[#888888]">
                        Must contain at least 6 characters.
                    </p>
                </div>

                {{-- Role --}}
                <div>
                    <label for="add-role" class="tw-mb-1.5 tw-block tw-text-xs tw-font-medium tw-text-[#333333]">
                        Account Role <span class="tw-text-red-500">*</span>
                    </label>

                    <select id="add-role" name="role" x-model="form.role" required
                        class="tw-w-full tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-3 tw-py-2.5 tw-text-sm tw-text-[#111111] focus:tw-border-[#06B995] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6]/20">
                        <option value="buyer" @selected(old('role', 'buyer') === 'buyer')>
                            Buyer
                        </option>
                        <option value="owner" @selected(old('role') === 'owner')>
                            Owner
                        </option>
                        <option value="admin" @selected(old('role') === 'admin')>
                            Admin
                        </option>
                    </select>

                    <p class="tw-mt-1 tw-text-[11px] tw-text-[#888888]">
                        Determines the user's permissions and available features.
                    </p>
                </div>
            </div>

            {{-- Modal Footer --}}
            <div
                class="tw-flex tw-items-center tw-justify-end tw-gap-2 tw-border-t tw-border-[#C4C4C4]/50 tw-bg-[#F9FAF9] tw-px-6 tw-py-4">
                <button type="button" @click="close()"
                    class="tw-rounded-lg tw-border tw-border-[#C4C4C4] tw-bg-white tw-px-4 tw-py-2.5 tw-text-xs tw-font-medium tw-text-[#444444] tw-transition-colors hover:tw-bg-[#F3F5F4] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#C4C4C4]">
                    Cancel
                </button>

                <button type="submit"
                    class="tw-rounded-lg tw-bg-[#06EBB6] tw-px-4 tw-py-2.5 tw-text-xs tw-font-semibold tw-text-[#06100D] tw-transition-colors hover:tw-bg-[#1ED9D7] focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-[#06EBB6] focus:tw-ring-offset-2">
                    <span x-text="isEditing ? 'Save Changes' : 'Create User'"></span>
                </button>
            </div>
        </form>
    </div>
</div>