import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { addBlockMarkers } from './blockMarkers.js';

export async function loadHouses(scene) {
    const housesGroup = new THREE.Group();
    const selectableObjects = [];
    const instanceMetadata = [];
    const houseLoader = new GLTFLoader();
    const showLotStatusColor = true;

    housesGroup.name = 'lotsGroup';
    scene.add(housesGroup);

    // --- Lights for standard material ---
    const ambient = new THREE.AmbientLight(0xffffff, 0.6);
    scene.add(ambient);
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

            // --- Gather spawn data ---
            sceneModel.traverse((child) => {
                if (child.name.startsWith('lot')) {
                    const parts = child.name.split('_');
                    const lotId = parts[1];
                    const blockId = parts[3];
                    const shouldMirror = child.name.endsWith('_r');

                    spawnObjects.push({
                        position: child.position.clone(),
                        rotation: child.rotation.clone(),
                        lotId,
                        blockId,
                        shouldMirror,
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

                spawnObjects.forEach(({ position, rotation, lotId, blockId, shouldMirror }, i) => {
                    dummy.position.copy(position);
                    dummy.rotation.copy(rotation);
                    dummy.scale.set(shouldMirror ? -0.7 : 0.7, 0.7, 0.7);
                    dummy.updateMatrix();
                    instancedMesh.setMatrixAt(i, dummy.matrix);

                    instanceMetadata[i] = { lotId, blockId };

                    const lotData = lotStatuses.find(l => l.id == lotId);
                    let color = new THREE.Color(0xffffff);
                    if (lotData?.status === 'sold') color.set(0xff0000);
                    else if (lotData?.status === 'available') color.set(0x00ff00);
                    basicInstanceColor.setXYZ(i, color.r, color.g, color.b);
                });

                basicMaterial.instanceColor = basicInstanceColor;

                housesGroup.add(instancedMesh);
                selectableObjects.push(instancedMesh);

                const controlsDiv = document.createElement('div');
                controlsDiv.className = `
                    tw-fixed tw-top-24 tw-right-8 tw-bg-white/90 tw-px-4 tw-py-2
                    tw-rounded-xl tw-text-gray-900 tw-font-sans tw-flex tw-items-center tw-gap-2
                    tw-shadow-[0_0_15px_rgba(0,0,0,0.2)] tw-cursor-pointer tw-select-none
                    tw-backdrop-blur-sm
                `;
                document.body.appendChild(controlsDiv);

                const label = document.createElement('span');
                label.innerText = 'Show Available: OFF';
                label.className = 'tw-font-semibold';
                controlsDiv.appendChild(label);

                const toggle = document.createElement('div');
                toggle.className = `
                    tw-w-12 tw-h-6 tw-bg-gray-300 tw-rounded-full tw-relative tw-transition-colors tw-duration-300
                `;
                controlsDiv.appendChild(toggle);

                const knob = document.createElement('div');
                knob.className = `
                    tw-w-5 tw-h-5 tw-bg-white tw-rounded-full tw-absolute tw-top-0.5 tw-left-0.5
                    tw-transition-all tw-duration-300 tw-shadow-[0_2px_4px_rgba(0,0,0,0.2)]
                `;
                toggle.appendChild(knob);

                let isFlat = false;
                toggle.onclick = () => {
                    isFlat = !isFlat;
                    if (isFlat) {
                        instancedMesh.material = basicMaterial;
                        instancedMesh.instanceColor = basicInstanceColor;
                        toggle.classList.replace('tw-bg-gray-300', 'tw-bg-green-400/80');
                        knob.style.transform = 'translateX(1.5rem)';
                        label.innerText = 'Show Available: ON';
                        label.classList.replace('tw-text-gray-900', 'tw-text-green-800');
                    } else {
                        instancedMesh.material = texturedMaterial;
                        instancedMesh.instanceColor = null;
                        toggle.classList.replace('tw-bg-green-400/80', 'tw-bg-gray-300');
                        knob.style.transform = 'translateX(0)';
                        label.innerText = 'Show Available: OFF';
                        label.classList.replace('tw-text-green-800', 'tw-text-gray-900');
                    }
                };


                resolve({ housesGroup, selectableObjects, instanceMetadata });
            });
        });
    });
}
