document.querySelectorAll('[data-password-toggle]').forEach((button) => {
    const inputId = button.dataset.passwordToggle;
    const password = document.getElementById(inputId);
    const eyeIcon = button.querySelector('i');

    if (!password || !eyeIcon) return;

    button.addEventListener('click', () => {
        const showPassword = password.type === 'password';

        password.type = showPassword ? 'text' : 'password';

        eyeIcon.classList.toggle('fa-eye', showPassword);
        eyeIcon.classList.toggle('fa-eye-slash', !showPassword);

        button.setAttribute(
            'aria-label',
            showPassword ? 'Hide password' : 'Show password'
        );

        button.setAttribute('aria-pressed', String(showPassword));
    });
});
