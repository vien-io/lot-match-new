window.openEditUserModal = function (id, username, first_name, last_name, email) {
    const modal = document.getElementById('editUserModal');
    const form = document.getElementById('editUserForm');
    document.getElementById('editUserName').value = username;
    document.getElementById('editFirstName').value = first_name;
    document.getElementById('editLastName').value = last_name;
    document.getElementById('editUserEmail').value = email;

    // dynamically set action URL
    form.action = `/usermanagement/users/${id}`;
    
    modal.classList.remove('tw-hidden');
};