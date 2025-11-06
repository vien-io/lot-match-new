import * as THREE from 'three';
import { OutlinePass } from 'three/examples/jsm/Addons.js';
import { contain } from 'three/src/extras/TextureUtils.js';
import { resetBlock } from './blockMarkers';
import { mergeGeometries } from 'three/examples/jsm/utils/BufferGeometryUtils.js';
import { modalOpen } from './detailsHandler';


/* 
    Raycaster for lots 
    using outlinepass for highlighting
*/

export function initRaycasterOutlinePass({
    container,
    scene,
    camera,
    renderer,
    selectableObjects,
    instanceMetadata,
    outlinePass
}) {
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();

    let hoveredInstanceId = null;
    let hoveredMarker = null;
    let hoveredBlockId = null;

    const tooltip = document.getElementById('tooltip');
    const tooltipText = document.getElementById('tooltip-text');
    
    // dummy mesh for merged block outlines
    const blockHoverDummy = new THREE.Mesh(
        undefined,
        new THREE.MeshBasicMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0
        })
    );
    blockHoverDummy.visible = false;
    scene.add(blockHoverDummy);

    // dummy mesh for outlining single lots
    const lotHoverDummy = new THREE.Mesh(
        undefined,
        new THREE.MeshBasicMaterial({
            color: 0x000000,
            transparent: true,
            opacity: 0
        })
    );
    lotHoverDummy.visible = false;
    scene.add(lotHoverDummy);

    // cache merged block geometries to avoid recomputing each hover
    const blockGeometryCache = new Map();


    window.addEventListener('mousemove', (event) => {
        if (window.settingsModalOpen) return;

        // prevent hover when mous is over side panel
        const leftPanel = document.getElementById('side-panel');
        const panelRect = leftPanel.getBoundingClientRect();
          if (
            event.clientX >= panelRect.left &&
            event.clientX <= panelRect.right &&
            event.clientY >= panelRect.top &&
            event.clientY <= panelRect.bottom
        ) return;

        // normalize mouse coords
        const rect = renderer.domElement.getBoundingClientRect();
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(selectableObjects, true);

        if (modalOpen) return;

        if (intersects.length > 0) {
            const hit = intersects[0];
            const obj = hit.object;

            // handle blocks (regular meshes)
            if (obj.userData.type === 'block') {
                const blockId = obj.userData.blockId;

                // highlight marker animation
                if (hoveredMarker && hoveredMarker !== obj) resetBlock(hoveredMarker);
                hoveredMarker = obj;

                if (hoveredMarker.userData.highlightTween) hoveredMarker.userData.highlightTween.play();

                // merge geometry for block if not cached
                if (!blockGeometryCache.has(blockId)) {
                    const geometries = [];
                    const matrix = new THREE.Matrix4();

                    // gather all lots in this block
                    const instancedObj = selectableObjects.find(o => o.isInstancedMesh);
                    if (!instancedObj) return;

                    for (const [id, data] of Object.entries(instanceMetadata)) {
                        if (data.blockId == blockId) {
                            instancedObj.getMatrixAt(parseInt(id), matrix);

                            const geom = instancedObj.geometry.clone();
                            geom.applyMatrix4(matrix);
                            geometries.push(geom);

                        }
                    }

                    // safety check to prevent crash
                    if (geometries.length === 0) {
                        console.warn(`No lots found for block ${blockId}. Skipping merge`);
                        return;
                    }

                    // merge all lots in block
                    const merged = mergeGeometries(geometries, true);
                    blockGeometryCache.set(blockId, merged);
                    geometries.forEach(g => g.dispose());
                }

                // assign merged geometry to dummy
                blockHoverDummy.geometry = blockGeometryCache.get(blockId);
                blockHoverDummy.matrix.identity();
                blockHoverDummy.matrixAutoUpdate = false;
                blockHoverDummy.visible = true;

                outlinePass.selectedObjects = [blockHoverDummy];

                // tooltip for block
                tooltipText.textContent = `Block: ${obj.userData.blockId}`;
                tooltip.style.display = 'block';
                const containerRect = container.getBoundingClientRect();
                tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;

                lotHoverDummy.visible = false;
                hoveredInstanceId = null;
                hoveredBlockId = null;
                return;
            }

            // handle lots (instancedmesh)
            if (obj.isInstancedMesh) {
                const instanceId = hit.instanceId;
                const metadata = instanceMetadata[instanceId];
                if (!metadata) return;

                // copy instance transform into lot dummy
                const dummyMatrix = new THREE.Matrix4();
                obj.getMatrixAt(instanceId, dummyMatrix);

                lotHoverDummy.geometry = obj.geometry;
                lotHoverDummy.matrix.copy(obj.matrixWorld).multiply(dummyMatrix);
                lotHoverDummy.matrixAutoUpdate = false;
                lotHoverDummy.visible = true;

                outlinePass.selectedObjects = [lotHoverDummy];

                // tooltip for lot
                tooltipText.textContent = `Lot: ${metadata.lotId}, Block: ${metadata.blockId}`;
                tooltip.style.display = 'block';
                const containerRect = container.getBoundingClientRect();
                tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;

                // reset marker animation
                if (hoveredMarker) {
                    resetBlock(hoveredMarker);
                    hoveredMarker = null;
                }

                blockHoverDummy.visible = false;
                hoveredInstanceId = instanceId;
                return;

            } 
        } 
            // nothing hovered -> reset all
            if (hoveredMarker) resetBlock(hoveredMarker);
            hoveredMarker = null;
            hoveredBlockId = null;
            hoveredInstanceId = null;
            outlinePass.selectedObjects = [];
            blockHoverDummy.visible = false;
            lotHoverDummy.visible = false;
            tooltip.style.display = 'none';
    });
}