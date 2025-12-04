import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { addBlockMarkers } from './blockMarkers.js';
import { createToggle } from './utils/materialToggle.js';
import { createQuickGuideButton } from './utils/quickGuideButton.js'; 
import { initQuickGuideModal } from '../modals/guickGuideModal.js'

export async function loadHouses(scene) {
    const housesGroup = new THREE.Group();
    const selectableObjects = [];
    const instanceMetadata = [];
    const houseLoader = new GLTFLoader();
    const uiState = { isActive: false };

    housesGroup.name = 'lotsGroup';
    scene.add(housesGroup);

    // --- Lights for standard material ---
    scene.add(new THREE.AmbientLight(0xffffff, 0.6));
    const dirLight = new THREE.DirectionalLight(0xffffff, 0.8);
    dirLight.position.set(10, 20, 10);
    scene.add(dirLight);

    // --- Fetch lot statuses ---
    async function fetchLotStatuses() {
        try {
            const res = await fetch('/api/lots/statuses');
            return await res.json();
        } catch (e) {
            console.error("Failed to load lot statuses:", e);
            return [];
        }
    }
    const lotStatuses = await fetchLotStatuses();
    const url = `/models/basic/housespawn.glb?ts=${Date.now()}`;
    return new Promise((resolve) => {
        houseLoader.load(url, (gltf) => {
            const sceneModel = gltf.scene;
            housesGroup.add(sceneModel);

            const spawnObjects = [];
            sceneModel.traverse((child) => {
                if (child.name.startsWith('lot')) {
                    const parts = child.name.split('_');
                    spawnObjects.push({
                        position: child.position.clone(),
                        rotation: child.rotation.clone(),
                        lotId: parts[1],
                        blockId: parts[3],
                        shouldMirror: child.name.endsWith('_r'),
                    });
                }
                if (child.name.startsWith('block_')) {
                    const blockId = child.name.split('_')[1];
                    child.userData.blockId = blockId;
                    child.userData.type = 'block';
                    selectableObjects.push(child);
                }
            });

            // --- Block markers ---
            const baseColors = [
                0xff5733, 0x33ff57, 0x3357ff, 0xff33a8, 0xffd633,
                0x33fff2, 0xa833ff, 0x009688, 0x607d8b, 0x795548,
                0x8d6e63, 0xcddc39, 0x03a9f4, 0xe91e63, 0x9c27b0,
                0x4caf50, 0xff9800, 0x2196f3, 0x00bcd4, 0x9e9e9e,
                0xffeb3b, 0x8bc34a, 0xff5722, 0x3f51b5, 0x00e676,
                0xba68c8, 0xf06292, 0x4dd0e1, 0xfbc02d, 0xcddc39,
                0x2196f3, 0x00bcd4, 0x9e9e9e, 0xffeb3b, 0x8bc34a,
                0xff5722, 0x3f51b5
            ];

            const markerData = baseColors.map((color, i) => ({
                emptyName: `block_${i + 1}_selector`,
                color,
                blockId: i + 1,
            }));

            addBlockMarkers(sceneModel, scene, markerData, selectableObjects);

            // --- Load house geometry ---
            const modelLoader = new GLTFLoader();
            modelLoader.load('/models/basic/boxie8.glb', (houseGltf) => {
                const baseModel = houseGltf.scene.children[0];
                const geometry = baseModel.geometry.clone();

                // --- Materials ---
                const texturedMaterial = baseModel.material.clone();
                const basicMaterial = new THREE.MeshBasicMaterial({
                    color: 0xffffff,
                    transparent: true,
                    opacity: 0.7,
                });

                const count = spawnObjects.length;
                const instancedMesh = new THREE.InstancedMesh(geometry, texturedMaterial, count);
                instancedMesh.frustumCulled = true;
                instancedMesh.instanceMatrix.setUsage(THREE.DynamicDrawUsage);
                instancedMesh.userData.type = 'lot';

                const basicInstanceColor = new THREE.InstancedBufferAttribute(
                    new Float32Array(count * 3),
                    3
                );

                const dummy = new THREE.Object3D();


                /* const spawnBlocks = [...new Set(spawnObjects.map(o => o.blockId))];
                console.log("Blocks in spawnObjects:", spawnBlocks);  */

                // --- LOG LOTS ON BLOCK 1 ---
                const blk = 10;
                const blockLots = lotStatuses.filter(lot => lot.block_id === blk);
                /* console.log(`Lots in Block ${blk}:`, blockLots.map(l => ({
                    name: l.name,
                    status: l.status
                }))); */

                spawnObjects.forEach(({ position, rotation, lotId, blockId, shouldMirror }, i) => {
                    dummy.position.copy(position);
                    dummy.rotation.copy(rotation);
                    dummy.scale.set(shouldMirror ? -0.7 : 0.7, 0.7, 0.7);
                    dummy.updateMatrix();
                    instancedMesh.setMatrixAt(i, dummy.matrix);

                    const lotData = lotStatuses.find(
                        l => l.block_id === Number(blockId) && l.name === `Lot ${lotId}`
                    );

                    if (!lotData) {
                        console.warn(`Lot not found: block=${blockId}, lot=${lotId}`);
                        return;
                    }

                    instanceMetadata[i] = { id: lotData.id, lotId, blockId };

                    const color = new THREE.Color(0xffffff);
                    if (lotData.status === 'sold') color.set(0xff0000);
                    else if (lotData.status === 'available') color.set(0x00ff00);

                    /* if (Number(blockId) === 1) {
                        console.log(`Spawn #${i}: lotId=${lotId}, block=${blockId}, status=${lotData.status}, color=${color.getHexString()}`);
                    } */

                    basicInstanceColor.setXYZ(i, color.r, color.g, color.b);
                });

                basicMaterial.instanceColor = basicInstanceColor;

                housesGroup.add(instancedMesh);
                selectableObjects.push(instancedMesh);

                initQuickGuideModal();

                createToggle('Show Available', instancedMesh, texturedMaterial, basicMaterial, basicInstanceColor, uiState);
                createQuickGuideButton(uiState, '/images/guide_logo.png', () => {
                    const modal = document.getElementById('quickGuideModal');
                    if (modal) modal.style.display = 'flex';
                });


                resolve({ housesGroup, selectableObjects, instanceMetadata, uiState });
            });
        });
    });
}

