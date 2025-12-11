document.querySelectorAll('[data-modal-target]').forEach(link => {
    link.addEventListener('click', e => {
        e.preventDefault();
        const modal = document.getElementById(link.dataset.modalTarget);
        if (modal) modal.classList.remove('tw-hidden');
    });
});

document.querySelectorAll('[data-modal-close]').forEach(btn => {
    btn.addEventListener('click', () => {
        btn.closest('div[id$="Modal"]').classList.add('tw-hidden');
    });
});

document.querySelectorAll('div[id$="Modal"]').forEach(modal => {
    modal.addEventListener('click', e => {
        if (e.target === modal) modal.classList.add('tw-hidden');
    });
});

const togglePassword = document.getElementById('togglePassword');
const togglePasswordConfirm = document.getElementById('togglePasswordConfirm');
const password = document.getElementById('password');
const passwordConf = document.getElementById('password_confirmation');
const eyeOpen = document.getElementById('eyeOpened');
const eyeClosed = document.getElementById('eyeClosed');
const eyeOpenConf = document.getElementById('eyeOpenedConf');
const eyeClosedConf = document.getElementById('eyeClosedConf');
const strengthWrapper = document.getElementById('passwordStrengthWrapper');
const strengthBar = document.getElementById('passwordStrengthBar');
const strengthText = document.getElementById('passwordStrengthText');

togglePassword.addEventListener('click', () => {
    const type = password.type === 'password' ? 'text' : 'password';
    password.type = type;
    
    if (type === 'text') {
        eyeOpen.classList.remove('tw-hidden');
        eyeClosed.classList.add('tw-hidden')
    } else {
        eyeOpen.classList.add('tw-hidden')
        eyeClosed.classList.remove('tw-hidden')
    }
});

togglePasswordConfirm.addEventListener('click', () => {
    const type = passwordConf.type === 'password' ? 'text' : 'password';
    passwordConf.type = type;
    if (type === 'text') {
        eyeOpenConf.classList.remove('tw-hidden');
        eyeClosedConf.classList.add('tw-hidden')
    } else {
        eyeOpenConf.classList.add('tw-hidden')
        eyeClosedConf.classList.remove('tw-hidden')
    }
});

password.addEventListener('input', () => {
    const val = password.value;

    if(val.length === 0) {
        strengthWrapper.classList.add('tw-hidden');
        strengthText.classList.add('tw-hidden');
        return;
    }

    strengthWrapper.classList.remove('tw-hidden');
    strengthText.classList.remove('tw-hidden');

    let score = 0;
    if (val.length >= 3) score++;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    let width = (score / 5) * 100;
    strengthBar.style.width = width + '%';

    let color = 'tw-bg-red-500';
    let text = 'Weak';
    if(score === 2) { color = 'tw-bg-yellow-400'; text = 'Fair'; }
    if(score === 3) { color = 'tw-bg-yellow-500'; text = 'Medium'; }
    if(score === 4) { color = 'tw-bg-green-400'; text = 'Strong'; }
    if(score === 5) { color = 'tw-bg-green-500'; text = 'Very Strong'; }

    strengthBar.className = `tw-h-2 tw-rounded-full ${color} tw-transition-all tw-duration-300`;
    strengthText.textContent = text;
});


