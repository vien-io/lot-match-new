import * as THREE from 'three';
import { modalOpen } from './detailsHandler';
import { loadLotSummary } from './lot-summary.js';

export function initClickHandler({ 
    camera, 
    renderer, 
    housesGroup, 
    selectableObjects,  
    instanceMetadata,
    showLotDetails, 
    showBlockDetails, 
    fetchForecast,
    uiState
}) {
    let isDragging = false;
    let mouseDownPosition = { x: 0, y: 0 };
    const dragThreshold = 5;

    document.addEventListener("mousedown", (event) => {
        mouseDownPosition.x = event.clientX;
        mouseDownPosition.y = event.clientY;
        isDragging = false;
    });

    document.addEventListener("mousemove", (event) => {
        const distance = Math.sqrt(
            Math.pow(event.clientX - mouseDownPosition.x, 2) +
            Math.pow(event.clientY - mouseDownPosition.y, 2)
        );
        if (distance > dragThreshold) {
            isDragging = true;
        }
    });

    document.addEventListener("mouseup", (event) => {
        if (isDragging || modalOpen || window.settingsModalOpen || uiState.isActive) return;

        // ignore raycasting inside left panel
        const leftPanel = document.getElementById("side-panel");
        if (leftPanel) {
            const panelRect = leftPanel.getBoundingClientRect();
            if (
                event.clientX >= panelRect.left &&
                event.clientX <= panelRect.right &&
                event.clientY >= panelRect.top &&
                event.clientY <= panelRect.bottom
            ) {
                return;
            }
        }

        // setup raycaster
        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();

        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(
            [...housesGroup.children, ...selectableObjects], 
            true
        );


        if (intersects.length > 0) {
            let selectedObject = intersects[0].object;

             // detect InstancedMesh clicks
            if (selectedObject.isInstancedMesh && intersects[0].instanceId !== undefined) {
                const instanceId = intersects[0].instanceId;
                const meta = instanceMetadata[instanceId]; 
                console.log(meta.id);

                if (meta) {
                    console.log(`Clicked lot ${meta.lotId} (block ${meta.blockId})`);
                    fetch(`/block/${meta.blockId}/lot/${meta.lotId}`)
                        .then(res => res.json())
                        .then(data => {
                            showLotDetails(data);
                            loadLotSummary(meta.id);
                        })
                        .catch(console.error);
                }
                return;
            }

            // console.log("clicked on: ", selectedObject.name, selectedObject.userData);

            // traverse upward until group with lotId or blockId
            while (selectedObject &&
                !selectedObject.userData.lotId && 
                !selectedObject.userData.blockId && 
                selectedObject.parent
            ) {
                selectedObject = selectedObject.parent;
            }

            if (selectedObject.userData.type === "lot") {
                const lotId = selectedObject.userData.lotId;
                console.log(`Clicked lot: ${lotId}`);
                console.log('block is', selectedObject.userData.blockId);
               


                fetch(`/block/${selectedObject.userData.blockId}/lot/${selectedObject.userData.lotId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            console.error("Backend error:", data.error);
                        } else {
                            showLotDetails(data);
                        }
                    })
                    .catch(err => console.error("Error fetching lot:", err));

            } else if (selectedObject.userData.type === "block") {
                const blockId = selectedObject.userData.blockId;
                // console.log(`Clicked block: ${blockId}`);

                fetch(`/block/${blockId}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.error) {
                            console.error("Backend error:", data.error);
                        } else {
                            showBlockDetails(data);
                            fetchForecast(blockId);
                        }
                    })
                    .catch(err => console.error("Error fetching block:", err));

            } else {
                // console.log("Clicked on non-block object!", selectedObject);
            }
        } else {
            console.log("Clicked empty space.");
        }
    });

    // return toggle functions if needed elsewhere
    return {
        setModalOpen: (state) => { modalOpen = state; },
    };
}