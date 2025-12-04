// quickGuideModal.js
import { setModalOpen, modalOpen } from '../threePartials/detailsHandler';

export function initQuickGuideModal() {
    const modal = document.getElementById('quickGuideModal');
    const modalContent = document.getElementById('quickGuideContent');
    const closeBtn = document.getElementById('quickGuideCloseBtn');

    if (!modal || !modalContent || !closeBtn) return;

    function closeModal() {
        modal.style.display = 'none';
        setModalOpen(false);
    }

    closeBtn.addEventListener('click', closeModal);

    modal.addEventListener('click', closeModal);

    modalContent.addEventListener('click', (e) => e.stopPropagation());
}
