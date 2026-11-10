document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('changeDetailsModal');
    const oldDataContainer = document.getElementById('oldChangeData');
    const newDataContainer = document.getElementById('newChangeData');

    if (!modal || !oldDataContainer || !newDataContainer) return;

    const openModal = (oldData, newData) => {
        oldDataContainer.textContent = oldData || 'No previous data';
        newDataContainer.textContent = newData || 'No new data';

        modal.classList.remove('tw-hidden');
        modal.classList.add('tw-flex');

        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.add('tw-hidden');
        modal.classList.remove('tw-flex');

        document.body.style.overflow = '';
    };

    // Open comparison modal
    document.addEventListener('click', (event) => {
        const button = event.target.closest('.view-change-details');

        if (!button) return;

        openModal(
            button.dataset.old,
            button.dataset.new
        );
    });

    // Close buttons
    modal.querySelectorAll('[data-close-change-modal]').forEach(button => {
        button.addEventListener('click', closeModal);
    });

    // Close when clicking the backdrop
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Close with Escape
    document.addEventListener('keydown', (event) => {
        if (
            event.key === 'Escape' &&
            !modal.classList.contains('tw-hidden')
        ) {
            closeModal();
        }
    });
});