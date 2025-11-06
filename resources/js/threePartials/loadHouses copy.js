import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { addBlockMarkers } from './blockMarkers.js';

export function loadHouses(scene) {
    const housesGroup = new THREE.Group();
    housesGroup.name = 'lotsGroup';
    scene.add(housesGroup);

    const selectableObjects = [];
    const houseLoader = new GLTFLoader();

    // Metadata for each instance (to preserve uniqueness)
    const instanceMetadata = [];

    // Load the base spawn layout (with empties)
    const url = `/models/basic/housespawn.glb?ts=${Date.now()}`;
    houseLoader.load(url, (gltf) => {
        const sceneModel = gltf.scene;
        housesGroup.add(sceneModel);

        const spawnObjects = [];

        // --- Gather spawn data (lot positions/rotations) ---
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

        // --- Load the house model once ---
        const modelUrl = '/models/basic/boxie8.glb';
        const modelLoader = new GLTFLoader();

        modelLoader.load(modelUrl, (houseGltf) => {
            const baseModel = houseGltf.scene.children[0];
            const geometry = baseModel.geometry.clone();
            const material = baseModel.material.clone();

            const count = spawnObjects.length;
            const instancedMesh = new THREE.InstancedMesh(geometry, material, count);
            instancedMesh.frustumCulled = true;
            instancedMesh.instanceMatrix.setUsage(THREE.DynamicDrawUsage);
            instancedMesh.userData.type = 'lot';

            const dummy = new THREE.Object3D();

            spawnObjects.forEach(({ position, rotation, lotId, blockId, shouldMirror }, i) => {
                dummy.position.copy(position);
                dummy.rotation.copy(rotation);
                dummy.scale.set(shouldMirror ? -0.7 : 0.7, 0.7, 0.7);
                dummy.updateMatrix();
                instancedMesh.setMatrixAt(i, dummy.matrix);

                // Store metadata
                instanceMetadata[i] = { lotId, blockId };
            });

            housesGroup.add(instancedMesh);
            selectableObjects.push(instancedMesh);
``
/*             console.log(`🏘️  Instanced lots: ${count}`);
            console.log(`🔹  Each lot unique (via metadata array).`); */
        });
    });

    // Return both scene objects and metadata (for raycaster)
    return { housesGroup, selectableObjects, instanceMetadata };
}
