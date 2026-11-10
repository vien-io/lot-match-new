import { setModalOpen, modalOpen } from '../detailsHandler.js';

// quickGuideButton.js
export function createQuickGuideButton(uiState, logoSrc, onClickCallback) {
    const buttonDiv = document.createElement('div');
    buttonDiv.className = `
        tw-fixed tw-top-44 tw-right-8 tw-w-12 tw-h-12
        tw-cursor-pointer tw-flex tw-items-center tw-justify-center
        tw-rounded-full tw-transition-all tw-duration-300 tw-ease-in-out
        tw-bg-transparent tw-border-2 tw-border-white/0
        hover:tw-bg-gray-800/90 hover:tw-border-white
        hover:tw-shadow-[0_0_20px_rgba(0,255,0,0.8)]
        hover:tw-scale-110
    `;

    const logoImg = document.createElement('img');
    logoImg.src = logoSrc; 
    logoImg.alt = 'Quick Guide';
    logoImg.className = `
        tw-w-17 tw-h-10
        tw-transition-all tw-duration-300 tw-ease-in-out
        hover:tw-drop-shadow-[0_0_12px_rgba(0,255,0,0.9)]
        hover:tw-drop-shadow-[0_0_24px_rgba(0,255,0,0.8)]
        hover:tw-drop-shadow-[0_0_36px_rgba(0,255,0,1)]
        hover:tw-[filter:invert(47%)_sepia(100%)_saturate(750%)_hue-rotate(80deg)_brightness(100%)_contrast(100%)]
    `;


    
    buttonDiv.appendChild(logoImg);

    buttonDiv.addEventListener('mouseenter', () => uiState.isActive = true);
    buttonDiv.addEventListener('mouseleave', () => uiState.isActive = false);

    buttonDiv.addEventListener('click', () => {
        setModalOpen(true);
        const modal = document.getElementById('quickGuideModal');
        if (modal) modal.style.display = 'flex';
    });

    document.body.appendChild(buttonDiv);
    return buttonDiv;
}
