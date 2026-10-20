document.querySelectorAll('[data-modal-target]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const modal = document.getElementById(link.dataset.modalTarget);
        if (modal) {
            modal.classList.remove('tw-hidden');
            modal.classList.add('tw-flex');
        }
    });
});

document.querySelectorAll('[data-modal-close]').forEach(btn => {
   btn.addEventListener('click', () => {
    const modal = btn.closest('div[id$="Modal"]');

        if (modal) {
            modal.classList.add('tw-hidden');
            modal.classList.remove('tw-flex');
        }
    });
});

document.querySelectorAll('div[id$="Modal"]').forEach(modal => {
    modal.addEventListener('click', e => {
        if (e.target === modal) modal.classList.add('tw-hidden');
    });
});


const togglePassword = document.getElementById('togglePassword');
const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');

const eyeOpen = document.getElementById('eyeOpened');
const eyeClosed = document.getElementById('eyeClosed');
const eyeOpenConf = document.getElementById('eyeOpenedConf');
const eyeClosedConf = document.getElementById('eyeClosedConf');

const password = document.getElementById('password');
const strengthWrapper = document.getElementById('passwordStrengthWrapper');
const strengthBar = document.getElementById('passwordStrengthBar');
const strengthText = document.getElementById('passwordStrengthText');

const passwordConf = document.getElementById('password_confirmation');
const confirmStrengthWrapper = document.getElementById('confirmPasswordStrengthWrapper');
const confirmStrengthBar = document.getElementById('confirmPasswordStrengthBar');
const confirmStrengthText = document.getElementById('confirmPasswordStrengthText');

// Reusable password visibility toggle
function setupPasswordToggle(button, input, openEye, closedEye) {
    if (!button || !input || !openEye || !closedEye) return;

    button.addEventListener('click', () => {
        const showPassword = input.type === 'password';

        input.type = showPassword ? 'text' : 'password';

        openEye.classList.toggle('tw-hidden', !showPassword);
        closedEye.classList.toggle('tw-hidden', showPassword);

        button.setAttribute(
            'aria-label',
            showPassword ? 'Hide password' : 'Show password'
        );
        button.setAttribute('aria-pressed', String(showPassword));
    });
}

setupPasswordToggle(togglePassword, password, eyeOpen, eyeClosed);
setupPasswordToggle(togglePasswordConfirm, passwordConf, eyeOpenConf, eyeClosedConf);

// Reusable strength indicator
function getPasswordStrength(value) {
    let score = 0;

    if (value.length >= 3) score++;
    if (value.length >= 8) score++;
    if (/[A-Z]/.test(value)) score++;
    if (/[0-9]/.test(value)) score++;
    if (/[^A-Za-z0-9]/.test(value)) score++;

    const levels = [
        { label: 'Weak', color: 'tw-bg-red-500' },
        { label: 'Fair', color: 'tw-bg-yellow-400' },
        { label: 'Medium', color: 'tw-bg-yellow-500' },
        { label: 'Strong', color: 'tw-bg-green-400' },
        { label: 'Very Strong', color: 'tw-bg-green-500' }
    ];

    return {
        score,
        ...levels[Math.max(0, score - 1)]
    };
}

function updateStrengthIndicator(value, wrapper, bar, text) {
    if (!wrapper || !bar || !text) return;

    if (!value.length) {
        wrapper.classList.add('tw-hidden');
        text.classList.add('tw-hidden');
        return;
    }

    const strength = getPasswordStrength(value);

    wrapper.classList.remove('tw-hidden');
    text.classList.remove('tw-hidden');

    bar.style.width = `${(strength.score / 5) * 100}%`;
    bar.className =
        `tw-h-2 tw-rounded-full ${strength.color} tw-transition-all tw-duration-300`;

    text.textContent = strength.label;
    text.className = 'tw-text-xs tw-mt-2 tw-text-[#666666]';
}

// Main password strength
if (password && strengthWrapper && strengthBar && strengthText) {
    password.addEventListener('input', () => {
        updateStrengthIndicator(
            password.value,
            strengthWrapper,
            strengthBar,
            strengthText
        );

        updateConfirmation();
    });
}

// Confirmation strength and matching status
function updateConfirmation() {
    if (
        !passwordConf ||
        !password ||
        !confirmStrengthWrapper ||
        !confirmStrengthBar ||
        !confirmStrengthText
    ) return;

    const value = passwordConf.value;

    if (!value.length) {
        confirmStrengthWrapper.classList.add('tw-hidden');
        confirmStrengthText.classList.add('tw-hidden');
        return;
    }

    const strength = getPasswordStrength(value);

    confirmStrengthWrapper.classList.remove('tw-hidden');
    confirmStrengthText.classList.remove('tw-hidden');

    confirmStrengthBar.style.width = `${(strength.score / 5) * 100}%`;
    confirmStrengthBar.className =
        `tw-h-2 tw-rounded-full ${strength.color} tw-transition-all tw-duration-300`;

    if (value === password.value) {
        confirmStrengthText.textContent = 'Passwords match';
        confirmStrengthText.className =
            'tw-text-xs tw-mt-2 tw-text-green-600';
    } else {
        confirmStrengthText.textContent = strength.label;
        confirmStrengthText.className =
            'tw-text-xs tw-mt-2 tw-text-[#666666]';
    }
}

if (passwordConf) {
    passwordConf.addEventListener('input', updateConfirmation);
}

