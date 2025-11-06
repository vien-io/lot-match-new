window.settingsModalOpen = false;

document.addEventListener('DOMContentLoaded', () => {
    const settingsModal = document.getElementById('settings-modal');
    const openBtn = document.getElementById('settings-btn');
    const closeBtn = document.getElementById('settings-close');

    openBtn?.addEventListener('click', () => {
        settingsModal.classList.remove('tw-hidden');
        window.settingsModalOpen = true;
    });

    closeBtn?.addEventListener('click', () => {
        settingsModal.classList.add('tw-hidden');
        window.settingsModalOpen = false;
    });

    settingsModal?.addEventListener('click', (e) => {
        if (e.target === settingsModal) {
            settingsModal.classList.add('tw-hidden');
            window.settingsModalOpen = false;
        }
    });

    window.showOwnerTags = false;

    const ownerToggle = document.getElementById('toggle-owner-tags-global');
  

    async function saveUserSettings(){
        try {
            const res = await fetch('/user/settings', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ show_owner_tags: window.showOwnerTags })
            });

            const data = await res.json();
            console.log('Settings saved:', data);
        } catch (err) {
            console.error('Error saving settings:', err);
        }
    }

    // toggle handler
    ownerToggle?.addEventListener('change', (e) => {

        window.showOwnerTags = e.target.checked;
        console.log("Owner tags toggle is now:", window.showOwnerTags);

        document.querySelectorAll('.owner-tag').forEach(tag => {
            tag.style.opacity = window.showOwnerTags ? '1' : '0';
            tag.style.display = window.showOwnerTags ? 'inline-block' : 'none';
            tag.style.transform = 'scale(1)'; 
        });

        saveUserSettings();
    });

    // load saved settings on page load
    window.addEventListener('DOMContentLoaded', async () => {
        
        try {
            const res = await fetch('/user/settings', { headers: { 'Accept': 'application/json' } });
            const data = await res.json();

            if (data.show_owner_tags !== undefined) {
                window.showOwnerTags = data.show_owner_tags;
                ownerToggle.checked = data.show_owner_tags;

            document.querySelectorAll('.owner-tag').forEach(tag => {
                    tag.style.opacity = window.showOwnerTags ? '1' : '0';
                    tag.style.display = window.showOwnerTags ? 'inline-block' : 'none';
                    tag.style.transform = 'scale(1)'; 
                });
            }
        } catch (err) {
            console.error('Error loading user settings:', err);
        }
    });
});