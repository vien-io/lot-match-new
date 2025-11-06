import * as THREE from 'three';
import { resetBlock } from './blockMarkers';

/**
 * Raycaster for lots (InstancedMesh) and blocks (regular Mesh)
 */
export function initRaycaster({ container, camera, renderer, housesGroup, selectableObjects, instanceMetadata }) {
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();

    let hoveredInstanceId = null;
    let hoveredBlock = null;

    const tooltip = document.getElementById('tooltip');
    const tooltipText = document.getElementById('tooltip-text');

    window.addEventListener('mousemove', (event) => {
        console.log(settingsModalOpen);

        // Prevent hover when mouse is over side panel
        const leftPanel = document.getElementById('side-panel'); 
        const panelRect = leftPanel.getBoundingClientRect();
        if (
            event.clientX >= panelRect.left &&
            event.clientX <= panelRect.right &&
            event.clientY >= panelRect.top &&
            event.clientY <= panelRect.bottom
        ) return;

        // Normalized mouse coordinates
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(selectableObjects, true);

        if (intersects.length > 0) {
            const obj = intersects[0].object;

            // --- Handle blocks (regular meshes) ---
            if (obj.userData.type === 'block') {
                if (hoveredBlock && hoveredBlock !== obj) {
                    resetBlock(hoveredBlock);
                }

                if (hoveredBlock !== obj) {
                    hoveredBlock = obj;
                    // animate block highlight via gsap inside resetBlock / addBlockMarkers
                    obj.userData.highlightTween?.play?.();
                }

                // tooltip
                tooltipText.textContent = `Block: ${obj.userData.blockId}`;
                tooltip.style.display = 'block';
                const containerRect = container.getBoundingClientRect();
                tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;

                // reset hoveredInstanceId for lots
                hoveredInstanceId = null;
                return;
            }

            // --- Handle lots (InstancedMesh) ---
            if (obj.isInstancedMesh) {
                const instanceId = intersects[0].instanceId;

                if (hoveredInstanceId !== null && hoveredInstanceId !== instanceId) {
                    resetInstanceColor(obj, hoveredInstanceId);
                }

                hoveredInstanceId = instanceId;
                highlightInstance(obj, instanceId);

                const metadata = instanceMetadata[instanceId];
                if (metadata) {
                    tooltipText.textContent = `Lot: ${metadata.lotId}, Block: ${metadata.blockId}`;
                    tooltip.style.display = 'block';
                    const containerRect = container.getBoundingClientRect();
                    tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                    tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;
                }

                // reset hoveredBlock
                hoveredBlock = null;
            }

        } else {
            // Nothing hovered → reset all
            if (hoveredBlock) {
                resetBlock(hoveredBlock);
                hoveredBlock = null;
            }
            if (hoveredInstanceId !== null) {
                const mesh = selectableObjects.find(obj => obj.isInstancedMesh);
                if (mesh) resetInstanceColors(mesh);
                hoveredInstanceId = null;
            }
            tooltip.style.display = 'none';
        }
    });
}

/* ------------------ Helpers ------------------ */

// Highlight a single instance
function highlightInstance(instancedMesh, instanceId, color = 0xffff00) {
    const c = new THREE.Color(color);
    instancedMesh.setColorAt(instanceId, c);
    instancedMesh.instanceColor.needsUpdate = true;
}

// Reset a single instance color to white
function resetInstanceColor(instancedMesh, instanceId) {
    const white = new THREE.Color(1, 1, 1);
    instancedMesh.setColorAt(instanceId, white);
    instancedMesh.instanceColor.needsUpdate = true;
}

// Reset all instances
function resetInstanceColors(instancedMesh) {
    const white = new THREE.Color(1, 1, 1);
    for (let i = 0; i < instancedMesh.count; i++) {
        instancedMesh.setColorAt(i, white);
    }
    instancedMesh.instanceColor.needsUpdate = true;
}
