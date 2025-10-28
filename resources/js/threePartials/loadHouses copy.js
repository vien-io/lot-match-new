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
    blockId: i + 1
    }));


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
            const scaleFactor = 0.7;

            const model = "/models/basic/boxie.glb";

            loadLODLevel(model, 0, (model, dist) => {
                model.frustumCulled = true;
                model.scale.set(scaleFactor, scaleFactor, scaleFactor);
                lod.addLevel(model, dist);
            });

            loadLODLevel(model, 100, (model, dist) => {
                model.frustumCulled = true;
                model.scale.set(scaleFactor, scaleFactor, scaleFactor);
                lod.addLevel(model, dist);
            });

            loadLODLevel(model, 200, (model, dist) => {
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