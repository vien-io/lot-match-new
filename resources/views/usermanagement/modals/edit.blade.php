{{-- Edit User Modal --}}
<div id="editUserModal" class="tw-hidden tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-z-50">
  <div class="tw-bg-white tw-rounded-2xl tw-shadow-lg tw-w-full sm:tw-w-[400px] tw-p-6">
    <h2 class="tw-text-xl tw-font-bold tw-mb-4">Edit User</h2>
    <form id="editUserForm" method="POST">
      @csrf
      @method('PUT')
      <div class="tw-mb-3">
        <label class="tw-block tw-font-medium">Username</label>
        <input type="text" id="editUserName" name="username" class="tw-w-full tw-border tw-rounded tw-p-2" required>
      </div>
      <div class="tw-mb-3">
        <label class="tw-block tw-font-medium">Full Name</label>
        <input type="text" id="editName" name="name" class="tw-w-full tw-border tw-rounded tw-p-2" required>
      </div>
      <div class="tw-mb-3">
        <label class="tw-block tw-font-medium">Email</label>
        <input type="email" id="editUserEmail" name="email" class="tw-w-full tw-border tw-rounded tw-p-2" required>
      </div>
      <div class="tw-flex tw-justify-end tw-gap-3">
        <button type="button" onclick="document.getElementById('editUserModal').classList.add('tw-hidden')" class="tw-px-4 tw-py-2 tw-border tw-rounded-lg hover:tw-bg-gray-100">Cancel</button>
        <button type="submit" class="tw-px-4 tw-py-2 tw-bg-blue-600 hover:tw-bg-blue-700 tw-text-white tw-rounded-lg">Update</button>
      </div>
    </form>
  </div>
</div>