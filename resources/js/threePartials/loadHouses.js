import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';

export function loadHouses(scene) {
    // house group
    const housesGroup = new THREE.Group();
    housesGroup.name = 'lotsGroup'; 
    scene.add(housesGroup);
    
    // house models
    const selectableObjects = [];

    const houseLoader = new GLTFLoader();
    const houseModelLoader = new GLTFLoader();

    // load the scene GLB (the one with Empty objects)
    const url = `/models/basic/housespawn.glb?ts=${Date.now()}`;
    houseLoader.load(url, (gltf) => {
        const sceneModel = gltf.scene;
        housesGroup.add(sceneModel);


        // find all empties
        /* const spawnPoints = []; */
        const spawnObjects = [];

        sceneModel.traverse((child) => {
            if (child.name.startsWith("lot")) { 
                /* spawnPoints.push(child.position.clone()); */

                // extract lot id and block id from obj name
                const parts = child.name.split("_"); 
                const lotId = parts[1];  
                const blockId = parts[3]; 

                // for reversed models
                const shouldMirror = child.name.endsWith("_r");

                // store rotation of spawn point
                spawnObjects.push({ 
                    position: child.position.clone(), 
                    rotation: child.rotation.clone(), 
                    lotId, 
                    blockId, 
                    shouldMirror 
                });
            }

            // detect & add blocks
            if (child.name.startsWith("block_")) {
                const blockId = child.name.split('_')[1];
                child.userData.blockId = blockId;
                selectableObjects.push(child);
            }
        });

        // load the house model and place them at the spawn points
        spawnObjects.forEach(({ position, rotation, lotId, blockId, shouldMirror }) => {

            const lod = new THREE.LOD();

            // helper func to load and add to lod
            const loadLODLevel = (url, distance, onLoad) => {
                houseModelLoader.load(url, (gltf) => {
                    const model = gltf.scene;
                    model.position.set(0, 0, 0);
                    model.scale.set(1, 1, 1);
                    if (shouldMirror) model.scale.x *= -1;
                    onLoad(model, distance);
                });
            };
            const scaleFactor = 1.4;

            loadLODLevel("/models/basic/modelH_low.glb", 0, (model, dist) => {
                model.frustumCulled = true;
                model.scale.set(scaleFactor, scaleFactor, scaleFactor);
                lod.addLevel(model, dist);
            });

            loadLODLevel("/models/basic/modelH_low.glb", 25, (model, dist) => {
                model.frustumCulled = true;
                model.scale.set(scaleFactor, scaleFactor, scaleFactor);
                lod.addLevel(model, dist);
            });

            loadLODLevel("/models/basic/modelH_low.glb", 50, (model, dist) => {
                model.frustumCulled = true;
                model.scale.set(scaleFactor, scaleFactor, scaleFactor);
                lod.addLevel(model, dist);
            });

            // set global rot and pos
            lod.position.copy(position);
            lod.rotation.copy(rotation);

            // assign id 
            lod.userData.lotId = lotId;
            lod.userData.blockId = blockId;

            lod.frustumCulled = true;

            housesGroup.add(lod);
            selectableObjects.push(lod);
            
        }); 
    });

    return { housesGroup, selectableObjects };

}