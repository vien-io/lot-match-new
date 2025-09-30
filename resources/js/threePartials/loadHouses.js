import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { addBlockMarkers } from './blockMarkers.js';

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



        // check for the empty
        const emptyName = "block_11_selector"; 
        const blockEmpty = sceneModel.getObjectByName(emptyName);

  



        // block markers
        const markerData = [
            { emptyName: 'block_1_selector',  color: 0xff5733, blockId: 1 },
            { emptyName: 'block_2_selector',  color: 0x33ff57, blockId: 2 },
            { emptyName: 'block_3_selector',  color: 0x3357ff, blockId: 3 },
            { emptyName: 'block_4_selector',  color: 0xff33a8, blockId: 4 },
            // { emptyName: 'block_5_selector',  color: 0xffd633, blockId: 5 },
            { emptyName: 'block_6_selector',  color: 0x33fff2, blockId: 6 },
            { emptyName: 'block_7_selector',  color: 0xa833ff, blockId: 7 },
            { emptyName: 'block_8_selector',  color: 0x009688, blockId: 8 },

            { emptyName: 'block_11_selector', color: 0x8d6e63, blockId: 11 },
            { emptyName: 'block_12_selector', color: 0xcddc39, blockId: 12 },
            { emptyName: 'block_13_selector', color: 0x03a9f4, blockId: 13 },
            { emptyName: 'block_14_selector', color: 0xe91e63, blockId: 14 },
            { emptyName: 'block_15_selector', color: 0x9c27b0, blockId: 15 },
            { emptyName: 'block_16_selector', color: 0x4caf50, blockId: 16 },
            { emptyName: 'block_17_selector', color: 0xff9800, blockId: 17 }


        ];

        addBlockMarkers(sceneModel, scene, markerData, selectableObjects);



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
            lod.userData = {
                type: "lot",
                lotId: lotId,
                blockId: blockId
            };

           

            lod.frustumCulled = true;

            housesGroup.add(lod);
            selectableObjects.push(lod);
            
        }); 
    });

    return { housesGroup, selectableObjects };

}