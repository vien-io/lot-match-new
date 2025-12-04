import { requestRender } from '../../three';

// --- Create toggle helper ---
export function createToggle(labelText, mesh, texturedMaterial, basicMaterial, basicInstanceColor, uiState) {
    const controlsDiv = document.createElement('div');
    controlsDiv.className = `
        tw-fixed tw-top-24 tw-right-8 tw-bg-white/90 tw-px-4 tw-py-2
        tw-rounded-xl tw-text-gray-900 tw-font-sans tw-flex tw-items-center tw-gap-2
        tw-shadow-[0_0_15px_rgba(0,0,0,0.2)] tw-cursor-pointer tw-select-none
        tw-backdrop-blur-sm
    `;
    document.body.appendChild(controlsDiv);

    const label = document.createElement('span');
    label.innerText = `${labelText}: OFF`;
    label.className = 'tw-font-semibold';
    controlsDiv.appendChild(label);

    const toggle = document.createElement('div');
    toggle.className = `
        tw-w-12 tw-h-6 tw-bg-gray-300 tw-rounded-full tw-relative tw-transition-colors tw-duration-300
    `;
    controlsDiv.appendChild(toggle);

    controlsDiv.addEventListener('mouseenter', () => uiState.isActive = true);
    controlsDiv.addEventListener('mouseleave', () => uiState.isActive = false);

    const knob = document.createElement('div');
    knob.className = `
        tw-w-5 tw-h-5 tw-bg-white tw-rounded-full tw-absolute tw-top-0.5 tw-left-0.5
        tw-transition-all tw-duration-300 tw-shadow-[0_2px_4px_rgba(0,0,0,0.2)]
    `;
    toggle.appendChild(knob);

    // --- Legend element ---
    const legendDiv = document.createElement('div');
    legendDiv.className = `
        tw-fixed tw-top-20 tw-left-28 tw-bg-white/80 tw-px-4 tw-py-2
        tw-rounded-xl tw-shadow-[0_0_10px_rgba(0,0,0,0.15)] tw-font-sans tw-text-sm
        tw-flex tw-gap-4 tw-items-center tw-backdrop-blur-sm tw-z-50
    `;
    legendDiv.style.display = 'none'; 
    legendDiv.innerHTML = `
        <div class="tw-flex tw-items-center tw-gap-1">
            <div class="tw-w-4 tw-h-4 tw-bg-green-400/80 tw-rounded-sm"></div>
            <span>Available</span>
        </div>
        <div class="tw-flex tw-items-center tw-gap-1">
            <div class="tw-w-4 tw-h-4 tw-bg-red-400/80 tw-rounded-sm"></div>
            <span>Sold</span>
        </div>
    `;
    document.body.appendChild(legendDiv);

    // --- Knob toggle logic ---
    let isOn = false;
    function toggleKnob() {
        isOn = !isOn;
        if (isOn) {
            mesh.material = basicMaterial;
            mesh.instanceColor = basicInstanceColor;
            toggle.classList.replace('tw-bg-gray-300', 'tw-bg-green-400/80');
            knob.style.transform = 'translateX(1.5rem)';
            label.innerText = `${labelText}: ON`;
            label.classList.replace('tw-text-gray-900', 'tw-text-green-800');
            legendDiv.style.display = 'flex'; 
        } else {
            mesh.material = texturedMaterial;
            mesh.instanceColor = null;
            toggle.classList.replace('tw-bg-green-400/80', 'tw-bg-gray-300');
            knob.style.transform = 'translateX(0)';
            label.innerText = `${labelText}: OFF`;
            label.classList.replace('tw-text-green-800', 'tw-text-gray-900');
            legendDiv.style.display = 'none';
        }

        requestRender();
    }

    toggle.onclick = toggleKnob;

    return { controlsDiv, toggle, knob, toggleKnob, legendDiv };
}
