window.fillDemo = function (username, password) {
    const usernameInput = document.querySelector('input[name="username"]');
    const passwordInput = document.querySelector('input[name="password"]');

    if (!usernameInput || !passwordInput) {
        console.error('Login form inputs not found.');
        return;
    }

    usernameInput.value = username;
    passwordInput.value = password;

    usernameInput.dispatchEvent(new Event('input', { bubbles: true }));
    usernameInput.dispatchEvent(new Event('change', { bubbles: true }));

    passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
    passwordInput.dispatchEvent(new Event('change', { bubbles: true }));
};