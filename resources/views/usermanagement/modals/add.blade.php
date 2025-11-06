{{-- Add User Modal --}}
<div id="addUserModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
    <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-w-full sm:tw-w-[400px] tw-p-6">
    <h2 class="tw-text-xl tw-font-bold tw-mb-4">Add User</h2>
    <form method="POST" action="{{ route('usermanagement.store') }}">
        @csrf
        <div class="tw-mb-3">
            <label class="tw-block tw-font-medium">Username</label>
            <input type="text" name="username" class="tw-w-full tw-border tw-rounded tw-p-2" required>
        </div>
        <div class="tw-mb-3">
            <label class="tw-block tw-font-medium">Full Name</label>
            <input type="text" name="name" class="tw-w-full tw-border tw-rounded tw-p-2" required>
        </div>
        <div class="tw-mb-3">
            <label class="tw-block tw-font-medium">Email</label>
            <input type="email" name="email" class="tw-w-full tw-border tw-rounded tw-p-2" required>
        </div>
        <div class="tw-mb-3">
            <label class="tw-block tw-font-medium">Password</label>
            <input type="password" name="password" class="tw-w-full tw-border tw-rounded tw-p-2" minlength="6" required>
        </div>
        <div class="tw-flex tw-justify-end tw-gap-3">
            <button type="button" onclick="document.getElementById('addUserModal').classList.add('tw-hidden')" class="tw-px-4 tw-py-2 tw-border tw-rounded-lg hover:tw-bg-gray-100">Cancel</button>
            <button type="submit" class="tw-px-4 tw-py-2 tw-bg-green-600 hover:tw-bg-green-700 tw-text-white tw-rounded-lg">Save</button>
        </div>
    </form>
    </div>
</div>