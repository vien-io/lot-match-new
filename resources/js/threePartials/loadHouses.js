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

    // --- Lights for textured material ---
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
            const modelUrl = '/models/basic/boxie8.glb';

            modelLoader.load(modelUrl, (houseGltf) => {
                const baseModel = houseGltf.scene.children[0];
                const geometry = baseModel.geometry.clone();

                // --- Materials ---
                const texturedMaterial = baseModel.material.clone(); // preserves texture
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

                // Only set instanceColor for flat basic material
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

                    // ✅ Only populate basicInstanceColor (for flat material)
                    const lotData = lotStatuses.find(l => l.id == lotId);
                    let color = new THREE.Color(0xffffff);
                    if (lotData?.status === 'sold') color.set(0xff0000);
                    else if (lotData?.status === 'available') color.set(0x00ff00);
                    basicInstanceColor.setXYZ(i, color.r, color.g, color.b);
                });

                // Attach instanceColor for basic material only
                basicMaterial.instanceColor = basicInstanceColor;

                

                housesGroup.add(instancedMesh);
                selectableObjects.push(instancedMesh);

                // --- Material toggle controls (mutually exclusive) ---
                const controlsDiv = document.createElement('div');
                controlsDiv.style.position = 'absolute';
                controlsDiv.style.left = '200px';
                controlsDiv.style.bottom = '10px';
                controlsDiv.style.background = 'rgba(255,255,255,0.8)';
                controlsDiv.style.padding = '5px';
                controlsDiv.style.fontFamily = 'sans-serif';
                controlsDiv.style.fontSize = '12px';
                document.body.appendChild(controlsDiv);

                let checkboxes = [];

                const makeMaterialSwitch = (labelText, mesh, material) => {
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.checked = mesh.material === material;

                    checkbox.onchange = () => {
                        if (checkbox.checked) {
                            mesh.material = material;

                            // --- If switching to textured, remove instanceColor temporarily ---
                            if (material === texturedMaterial) {
                                mesh.instanceColor = null;
                            } else {
                                mesh.instanceColor = basicInstanceColor;
                            }

                            // uncheck other checkbox
                            checkboxes.forEach(cb => {
                                if (cb !== checkbox) cb.checked = false;
                            });
                        } else {
                            // prevent unchecking both
                            checkbox.checked = true;
                        }
                    };

                    const label = document.createElement('label');
                    label.innerText = labelText;
                    label.style.marginRight = '10px';

                    controlsDiv.appendChild(checkbox);
                    controlsDiv.appendChild(label);

                    checkboxes.push(checkbox);
                };


                makeMaterialSwitch('Textured Material', instancedMesh, texturedMaterial);
                makeMaterialSwitch('Flat Basic Material', instancedMesh, basicMaterial);

                resolve({ housesGroup, selectableObjects, instanceMetadata });
            });
        });
    });
}
