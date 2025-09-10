import * as THREE from 'three';

export function initRaycaster({ container, camera, renderer, housesGroup, selectableObjects }) {
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    let selectedHouse = null;
    let selectedBlock = null;

    const tooltip = document.getElementById('tooltip');
    const tooltipText = document.getElementById('tooltip-text');

    window.addEventListener("mousemove", (event) => {
        // prevent hover when mouse is over side panel
        const leftPanel = document.getElementById("side-panel"); 
        const panelRect = leftPanel.getBoundingClientRect();
        if (
            event.clientX >= panelRect.left &&
            event.clientX <= panelRect.right &&
            event.clientY >= panelRect.top &&
            event.clientY <= panelRect.bottom
        ) {
            return;
        }

        // update normalized mouse coords
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(selectableObjects, true);

        if (intersects.length > 0) {
            let hoveredObject = intersects[0].object;

            // 🔹 Handle block highlighting
            if (hoveredObject.name.startsWith("block_")) {
                ({ selectedBlock } = handleBlockHover({
                    hoveredObject, selectedBlock, housesGroup, tooltip, tooltipText, container, event
                }));
                return;
            } else {
                // reset block if switching to house
                if (selectedBlock) {
                    resetEmissive(selectedBlock);
                    selectedBlock = null;
                }
            }

            // 🔹 Handle house highlighting
            ({ selectedHouse } = handleHouseHover({
                hoveredObject, selectedHouse, housesGroup, tooltip, tooltipText, container, event, selectableObjects
            }));

        } else {
            // reset everything when nothing hovered
            if (selectedBlock) {
                resetEmissive(selectedBlock);
                selectedBlock = null;
            }
            if (selectedHouse) {
                resetEmissive(selectedHouse);
                selectedHouse = null;
            }
            resetLots(housesGroup);
            tooltip.style.display = 'none';
        }
    });
}

/* ---------- HELPERS ---------- */
function resetEmissive(object) {
    object.traverse(child => {
        if (child.isMesh && child.material) {
            if (Array.isArray(child.material)) {
                child.material.forEach(mat => {
                    mat.emissive.set(0x000000);
                    mat.emissiveIntensity = 0;
                });
            } else {
                child.material.emissive.set(0x000000);
                child.material.emissiveIntensity = 0;
            }
        }
    });
}

function resetLots(housesGroup) {
    housesGroup.traverse(lot => {
        if (lot.userData && lot.userData.blockId) resetEmissive(lot);
    });
}

function handleBlockHover({ hoveredObject, selectedBlock, housesGroup, tooltip, tooltipText, container, event }) {
    if (hoveredObject !== selectedBlock) {
        if (selectedBlock) resetEmissive(selectedBlock);
        selectedBlock = hoveredObject;

        const blockId = hoveredObject.name.split("_")[1];
        highlightObject(hoveredObject, 0x800080); // purple glow for block
        highlightLotsByBlock(housesGroup, blockId);

        // tooltip
        tooltipText.textContent = `Block: ${blockId}`;
        tooltip.style.display = 'block';
    }
    const containerRect = container.getBoundingClientRect();
    tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
    tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;

    return { selectedBlock };
}

function handleHouseHover({ hoveredObject, selectedHouse, housesGroup, tooltip, tooltipText, container, event, selectableObjects }) {
    while (hoveredObject.parent && !selectableObjects.includes(hoveredObject)) {
        hoveredObject = hoveredObject.parent;
    }

    if (hoveredObject !== selectedHouse) {
        if (selectedHouse) resetEmissive(selectedHouse);
        selectedHouse = hoveredObject;
        highlightObject(selectedHouse, 0xffff00); // yellow glow
    }

    // ensure we get lot root with userData
    while (hoveredObject && !hoveredObject.userData.lotId && hoveredObject.parent) {
        hoveredObject = hoveredObject.parent;
    }

    if (hoveredObject.userData.lotId) {
        resetLots(housesGroup);
        highlightObject(hoveredObject, 0xffff00);

        // tooltip
        const lotId = hoveredObject.userData.lotId;
        const blockId = hoveredObject.userData.blockId;
        tooltipText.textContent = `Lot: ${lotId}, Block: ${blockId}`;
        tooltip.style.display = 'block';

        const containerRect = container.getBoundingClientRect();
        tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
        tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;
    }

    return { selectedHouse };
}

function highlightObject(object, color) {
    object.traverse(child => {
        if (child.isMesh && child.material) {
            if (Array.isArray(child.material)) {
                child.material.forEach(mat => {
                    mat.emissive.set(color);
                    mat.emissiveIntensity = 1;
                });
            } else {
                child.material.emissive.set(color);
                child.material.emissiveIntensity = 1;
            }
        }
    });
}

function highlightLotsByBlock(housesGroup, blockId) {
    housesGroup.traverse(lot => {
        if (lot.userData && lot.userData.blockId === blockId) {
            highlightObject(lot, 0xffff00); // yellow for lots
        } else if (lot.userData && lot.userData.blockId) {
            resetEmissive(lot);
        }
    });
}

