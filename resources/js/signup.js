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
        eyeOpen.classList.remove('tw-hidden');
        eyeClosed.classList.add('tw-hidden')
    } else {
        eyeOpen.classList.add('tw-hidden')
        eyeClosed.classList.remove('tw-hidden')
    }
});