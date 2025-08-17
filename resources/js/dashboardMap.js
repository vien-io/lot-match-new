import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/Addons.js';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { contain } from 'three/src/extras/TextureUtils.js';

function initThreeJS() {
    console.log('initthreejs is called');
    const container = document.getElementById('dashboard-map-container');

    // container size
    const width = container.clientWidth;
    const height = container.clientHeight;

    // scene
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xFFFFFF);

    // camera
    const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
    camera.position.set(0, 90, 0);
    camera.lookAt(0, 0, 0);
    window.threeCamera = camera;

    // renderer
    const renderer = new THREE.WebGLRenderer();
    console.log('Container size: ', container.clientWidth, container.clientHeight);
    renderer.setSize(width, height);
    container.appendChild(renderer.domElement);

    // helper
    const axesHelper = new THREE.AxesHelper(10);
    const gridHelper = new THREE.GridHelper(90, 35, 0xEEEEEE, 0xEEEEEE);
    scene.add(axesHelper, gridHelper);

    // controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enablePan = true;
    controls.enableRotate = true;
    controls.enableZoom = false;
    controls.mouseButtons.LEFT = THREE.MOUSE.PAN;
    controls.mouseButtons.RIGHT = THREE.MOUSE.ROTATE;
    controls.screenSpacePanning = true;
    controls.panSpeed = 2;
    controls.update();

    // lightings
    const ambientLight = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambientLight);

    let light = new THREE.DirectionalLight(0xffffff, 3);
    light.position.set(20, 10, 20);
    light.target.position.set(0, 0, 0);
    scene.add(light);
    scene.add(light.target);
    const lightHelper = new THREE.DirectionalLightHelper(light, 2);
    scene.add(lightHelper);




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
        const spawnPoints = [];
        const spawnObjects = [];

        sceneModel.traverse((child) => {
            if (child.name.startsWith("lot")) { 
                // console.log(`Lot detected: ${child.name}`);
                spawnPoints.push(child.position.clone());

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
            const scaleFactor = 0.9;

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

    // raycaster logic
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    let selectedHouse = null;
    let selectedBlock = null;
    const tooltip = document.getElementById('tooltiip');
    const tooltipText = document.getElementById('tooltip-text');
    
    window.addEventListener("mousemove", (event) => {
        
       
        const rect = renderer.domElement.getBoundingClientRect();
        
        
        // updt mouse coords
        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = - ((event.clientY - rect.top) / rect.height) * 2 + 1;
    
        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(selectableObjects, true);
    
        if (intersects.length > 0) {
            let hoveredObject = intersects[0].object;
            // console.log("Hovered object name:", hoveredObject.name);
            

            // handle block highlightings
            if (hoveredObject.name.startsWith("block_")) {

                if (hoveredObject !== selectedBlock) {
                    // reset prev block glow
                    if (selectedBlock) {
                        selectedBlock.traverse(child => {
                            if (child.isMesh && child.material) {
                                if (Array.isArray(child.material)) {
                                    child.material.forEach(mat => {
                                        mat.emissive.set(0x800080);
                                        mat.emissiveIntensity = 0;
                                    });
                                } else {
                                    child.material.emissive.set(0x000000);
                                    child.material.emissiveIntensity = 0;
                                }
                            }
                        });
                    }

                    selectedBlock = hoveredObject; // set new block selection

                    const blockId = hoveredObject.name.split("_")[1];
                    

                    // apply emissive glow to all meshes in the block
                    selectedBlock.traverse(child => {
                        if (child.isMesh && child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    mat.emissive.set(0x800080); // purple glow for blocks
                                    mat.emissiveIntensity = 1;
                                });
                            } else {
                                child.material.emissive.set(0x800080);
                                child.material.emissiveIntensity = 1;
                            }
                        }
                    });

                    // highlight lots on that block
                    housesGroup.traverse(lot => {
                        if (lot.userData && lot.userData.blockId === blockId) {
                            lot.traverse(child => {
                                if (child.isMesh && child.material) {
                                    if (Array.isArray(child.material)) {
                                        child.material.forEach(mat => {
                                            mat.emissive.set(0xffff00);
                                            mat.emissiveIntensity = 1;
                                        });
                                    } else {
                                        child.material.emissive.set(0xffff00);
                                        child.material.emissiveIntensity = 1;
                                    }
                                }
                            });
                        } else if (lot.userData && lot.userData.blockId) {
                            // reset other lots
                            lot.traverse(child => {
                                if (child.isMesh && child.material){
                                    if (Array.isArray(child.material)) {
                                        child.material.forEach(mat => {
                                            mat.emissive.set(0x000000);
                                            mat.emissiveIntensity = 0;
                                        });
                                    } else {
                                        child.material.emissive.set(0x000000);
                                        child.material.emissiveIntensity = 0;
                                    }
                                }
                            });
                        }
                    });


                    // show tooltip for blocks
                    tooltipText.textContent = `Block: ${hoveredObject.name.split("_")[1]}`;
                    tooltip.style.display = 'block';
                }
                const containerRect = container.getBoundingClientRect();
                tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;
                return;
                
            }

            // reset block highlight when switching to a house
            if (selectedBlock) {
                selectedBlock.traverse(child => {
                    if (child.isMesh && child.material) {
                        if (Array.isArray(child.material)) {
                            child.material.forEach(mat => {
                                mat.emissive.set(0x000000);
                                mat.emissiveIntensity = 0;
                            });
                        } else {
                            child.material.emissive.set(0x000000);
                            child.material.emissiveIntensity = 0;
                        }
                    }
                });
                selectedBlock = null;
            }

            // find the top-level house group
            while (hoveredObject.parent && !selectableObjects.includes(hoveredObject)) {
                hoveredObject = hoveredObject.parent;
            }
    
            if (hoveredObject !== selectedHouse) {
                // reset prev house glow
                if (selectedHouse) {
                    selectedHouse.traverse(child => {
                        if (child.isMesh && child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    mat.emissive.set(0x000000);
                                    mat.emissiveIntensity = 0;
                                });
                            } else {
                                child.material.emissive.set(0x000000);
                                child.material.emissiveIntensity = 0;
                            }
                        }
                    });
                }
    
                selectedHouse = hoveredObject; // set new selection
    
                // apply glow to all meshes in the house grp
                selectedHouse.traverse(child => {
                    if (child.isMesh && child.material) {
                        if (Array.isArray(child.material)) {
                            child.material.forEach(mat => {
                                mat.emissive.set(0xffff00); // yellow
                                mat.emissiveIntensity = 1;
                            });
                        } else {
                            child.material.emissive.set(0xffff00);
                            child.material.emissiveIntensity = 1;
                        }
                    }
                });
            }

            
    

            // highlight lots tooltip
            // traverse up to find the group if necessary
            while (hoveredObject && !hoveredObject.userData.lotId && hoveredObject.parent) {
                hoveredObject = hoveredObject.parent;
            }
    
            // if hovered object has lotId
            if (hoveredObject.userData.lotId) {
                const lotId = hoveredObject.userData.lotId;
                const blockId = hoveredObject.userData.blockId; 
                tooltipText.textContent = `Lot: ${lotId}, Block: ${blockId}`;
                tooltip.style.display = 'block'; 
                
                const containerRect = container.getBoundingClientRect();
                tooltip.style.left = `${event.clientX - containerRect.left + 10}px`;
                tooltip.style.top = `${event.clientY - containerRect.top + 10}px`;
            }
    
        } else {
             // reset block highlight when hovering over nothing
            if (selectedBlock) {
                selectedBlock.traverse(child => {
                    if (child.isMesh && child.material) {
                        if (Array.isArray(child.material)) {
                            child.material.forEach(mat => {
                                mat.emissive.set(0x000000);
                                mat.emissiveIntensity = 0;
                            });
                        } else {
                            child.material.emissive.set(0x000000);
                            child.material.emissiveIntensity = 0;
                        }
                    }
                });
                selectedBlock = null;
            }

            // reset prev house glow when nothing is hovered
            if (selectedHouse) {
                selectedHouse.traverse(child => {
                    if (child.isMesh && child.material) {
                        if (Array.isArray(child.material)) {
                            child.material.forEach(mat => {
                                mat.emissive.set(0x000000);
                                mat.emissiveIntensity = 0;
                            });
                        } else {
                            child.material.emissive.set(0x000000);
                            child.material.emissiveIntensity = 0;
                        }
                    }
                });
                selectedHouse = null;
            }

            housesGroup.traverse(lot => {
                if (lot.userData && lot.userData.blockId) {
                    lot.traverse(child => {
                        if (child.isMesh && child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    mat.emissive.set(0x000000);
                                    mat.emissiveIntensity = 0;
                                });
                            } else {
                                child.material.emissive.set(0x000000);
                                child.material.emissiveIntensity = 0;
                            }
                            
                        }
                    });
                }
            });
    
            // hide tooltip when no object hovered
            tooltip.style.display = 'none';
        }


    });

    let modalOpen = false;
    let isDragging = false;
    let mouseDownPosition = { x: 0, y: 0 };
    const dragThreshold = 5; 

    document.addEventListener("mousemove", (event) => {
        // check if mouse moved
        const distance = Math.sqrt(
            Math.pow(event.clientX - mouseDownPosition.x, 2) +
            Math.pow(event.clientY - mouseDownPosition.y, 2)
        );
    
        if (distance > dragThreshold) {
            isDragging = true; 
        }
    });


    // animation loop
    function animate() {
        requestAnimationFrame(animate);
        renderer.render(scene, camera);
    }
    animate();


    // handle window resize
    window.addEventListener('resize', () => { 
        const newWidth = container.clientWidth;
        const newHeight = container.clientHeight;

        renderer.setSize(newWidth, newHeight);

        camera.aspect = newWidth / newHeight;
        camera.updateProjectionMatrix();
    });

}

 window.addEventListener('load', () => {
       console.log('Window load event triggered');
       initThreeJS();
   });