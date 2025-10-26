window.openEditUserModal = function (id, username, name, email) {
    const modal = document.getElementById('editUserModal');
    const form = document.getElementById('editUserForm');
    document.getElementById('editUserName').value = username;
    document.getElementById('editName').value = name;
    document.getElementById('editUserEmail').value = email;

    // dynamically set action URL
    form.action = `/usermanagement/users/${id}`;
    
    modal.classList.remove('tw-hidden');
};