import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/Addons.js';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import Stats from 'stats.js';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import 'chartjs-adapter-date-fns';
import { loadBlockSummary } from './blockSummary';


// gsap for cam animation
import gsap from "gsap";



function initThreeJS() {
    // scene
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xD3D3D3);

    // cam
    const camera = new THREE.PerspectiveCamera(
        40,
        window.innerWidth / window.innerHeight,
        0.1,
        1000,
    );
    camera.position.set(0 , 90, 0);
    camera.lookAt(0, 0, 0);
    window.threeCamera = camera; 

    // helpers
    const axesHelper = new THREE.AxesHelper(5);
    // scene.add(axesHelper);
    const gridHelper = new THREE.GridHelper(80, 20);
    // scene.add(gridHelper);

    // renderer
    const renderer = new THREE.WebGLRenderer();
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);
    // renderer.shadowMap.enabled = false; // pang alis ng shadows to optimize

   /*  
    
   // stats
    const stats = new Stats();
    stats.showPanel(0); 
    document.body.appendChild(stats.dom);
    stats.dom.style.position = 'fixed';
    stats.dom.style.bottom = '10px';
    stats.dom.style.right = '10px';
    stats.dom.style.zIndex = '10000';
    stats.dom.style.opacity = '0.9';
    stats.dom.style.transform = 'scale(1.5)';
    stats.dom.style.transformOrigin = 'bottom right';


    // cycle panels
    stats.dom.addEventListener('click', () => {
        stats.showPanel((stats.currentPanel + 1) % 3);
    });

 */





    // controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enablePAN = true;
    controls.enableRotate = true;
    controls.enableZoom = true;
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
    // scene.add(lightHelper);







    // house group
    const housesGroup = new THREE.Group();
    housesGroup.name = 'lotsGroup'; 
    scene.add(housesGroup);

   

    // house models
    const selectableObjects = [];

    const houseLoader = new GLTFLoader();
    const houseModelLoader = new GLTFLoader();

    // load the scene GLB (the one with Empty objects)
    houseLoader.load("/models/housespawn.glb", (gltf) => {
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
                // console.log(`Block detected: ${child.name}`);
                const blockId = child.name.split('_')[1];
                child.userData.blockId = blockId;
                // console.log(`Assigned blockId: ${blockId} to block: ${child.name}`);
                selectableObjects.push(child);
            }
        });
        // console.log('Selectable Objects:', selectableObjects);
        // console.log("Spawn points found:", spawnPoints);

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

            loadLODLevel("/models/modelH.glb", 0, (model, dist) => {
                model.frustumCulled = true;
                lod.addLevel(model, dist);
            });

            loadLODLevel("/models/modelH_medium.glb", 25, (model, dist) => {
                model.frustumCulled = true;
                lod.addLevel(model, dist);
            });

            loadLODLevel("/models/modelH_low.glb", 50, (model, dist) => {
                model.frustumCulled = true;
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

    
    
    







































    

    


    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();
    let selectedHouse = null;
    let selectedBlock = null;
    const tooltip = document.getElementById('tooltip');
    const tooltipText = document.getElementById('tooltip-text');
    
    window.addEventListener("mousemove", (event) => {
        // check if mouse is on left panel
        const leftPanel = document.getElementById("side-panel"); 
        const panelRect = leftPanel.getBoundingClientRect();
        if (
            event.clientX >= panelRect.left &&
            event.clientX <= panelRect.right &&
            event.clientY >= panelRect.top &&
            event.clientY <= panelRect.bottom
        ) {
            return;
        }




        // updt mouse coords
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
    
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

                    selectedBlock = hoveredObject; // set new block selection

                    // apply emissive glow to all meshes in the block
                    selectedBlock.traverse(child => {
                        if (child.isMesh && child.material) {
                            if (Array.isArray(child.material)) {
                                child.material.forEach(mat => {
                                    mat.emissive.set(0xffffff); // purple glow for blocks
                                    mat.emissiveIntensity = 1;
                                });
                            } else {
                                child.material.emissive.set(0xffffff);
                                child.material.emissiveIntensity = 1;
                            }
                        }
                    });

                    // show tooltip for blocks
                    tooltipText.textContent = `Block: ${hoveredObject.name.split("_")[1]}`;
                    tooltip.style.display = 'block';
                }
                tooltip.style.left = `${event.clientX + 10}px`;
                tooltip.style.top = `${event.clientY + 10}px`;
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
                
                tooltip.style.left = `${event.clientX + 10}px`; 
                tooltip.style.top = `${event.clientY + 10}px`; 
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
    
            // hide tooltip when no object hovered
            tooltip.style.display = 'none';
        }
    });
    
    let modalOpen = false;
    let isDragging = false;
    let mouseDownPosition = { x: 0, y: 0 };
    const dragThreshold = 5; 

    document.addEventListener("mousedown", (event) => {
        // reset position of mouse
        mouseDownPosition.x = event.clientX;
        mouseDownPosition.y = event.clientY;
        isDragging = false; 
    });

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

    document.addEventListener("mouseup", (event) => {
        if (isDragging) {
            return;
        }
        
        if (modalOpen) return;

        // ignore raycasting in left panel
        const leftPanel = document.getElementById("side-panel"); 
        const panelRect = leftPanel.getBoundingClientRect();
        
        if (
            event.clientX >= panelRect.left &&
            event.clientX <= panelRect.right &&
            event.clientY >= panelRect.top &&
            event.clientY <= panelRect.bottom
        ) {
            return;
        }

        const raycaster = new THREE.Raycaster();
        const mouse = new THREE.Vector2();
        
        // conv mouse pos to ndc (-1 to 1)
        mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
        mouse.y = -(event.clientY / window.innerHeight) * 2 + 1;
        
        raycaster.setFromCamera(mouse, camera);
        const intersects = raycaster.intersectObjects(housesGroup.children, true);

        
        


        if (intersects.length > 0) {
            
            let selectedObject = intersects[0].object;
            console.log('Selected Object:', selectedObject.userData);
            
            // traverse up to find the group 
            while (selectedObject && !selectedObject.userData.blockId && selectedObject.parent) {
                selectedObject = selectedObject.parent;
            }
            
    
            if (selectedObject.userData.lotId) {
                const lotId = selectedObject.userData.lotId;
                console.log(`clicked on house with lot id: ${lotId}`);
    
                // fetch lot details from backend
                fetch(`/lot/${lotId}`)
                    .then(response => response.json())
                    .then(data => {
                        console.log('Lot data received:', data); 
                        if (data.error) {
                            console.error('backend error:', data.error);
                        } else {
                            showLotDetails(data);
                        }
                    })
                    .catch(err => {
                        console.error('error fetching lot details:', err);
                    });
            } else if (selectedObject.userData.blockId) {  
                const blockId = selectedObject.userData.blockId;
                console.log(`clicked on block with id: ${blockId}`);
            
                // fetch block details from backend 
                fetch(`/block/${blockId}`)
                    .then(response => response.json())
                    .then(data => {  
                        console.log('Block data received:', data);
                        if (data.error) {
                            console.error('backend error:', data.error);
                        } else {
                            showBlockDetails(data);
                            fetchForecast(blockId);
                        }
                    })
                    .catch(err => {
                        console.error('error fetching block details:', err);
                    });
            } else {
                console.log("clicked on empty space or non-block object!");
            }
        } else {
            console.log("clicked on empty space.");
        }
    });








 

let forecastChart = null;

function fetchForecast(blockId) {
    const isAdmin = document.body.getAttribute('data-is-admin') === '1';

    if (!isAdmin) {
        console.log("User is not an admin");
        return;
    }

    console.log("User is an admin");
        
    fetch(`/forecast/block/${blockId}`)
        .then(response => response.json())
        .then(data => {
            const forecastDiv = document.getElementById('forecasting-data');

            if (data.forecasted_rating !== null) {
                forecastDiv.innerHTML = `
                    <p><strong>Forecasted Rating:</strong> <span id="forecast-value">${data.forecasted_rating}</span></p>
                    <canvas id="forecastChart" width="400" height="200"></canvas>
                `;

                const ratings = data.ratings.map(r => ({
                    x: new Date(r.created_at),
                    y: r.rating
                }));

                const lastDate = new Date(ratings[ratings.length - 1].x);
                const nextDate = new Date(lastDate);
                nextDate.setDate(lastDate.getDate() + 30);
                ratings.push({
                    x: nextDate,
                    y: data.forecasted_rating
                });
                console.log('Forecasted point:', ratings[ratings.length - 1]);


                if (forecastChart && typeof forecastChart.destroy === 'function') {
                    forecastChart.destroy();
                }

                const ctx = document.getElementById('forecastChart').getContext('2d');
                // split actual and 
                
                const actualRatings = ratings.slice(0, -1); // all except last
                const forecastPoint = ratings[ratings.length - 1]; // only last

                forecastChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        datasets: [
                            {
                                label: 'Rating Trend + Forecast',
                                data: ratings, // includes forecast at the end
                                parsing: {
                                    xAxisKey: 'x',
                                    yAxisKey: 'y'
                                },
                                borderColor: 'rgba(75, 192, 192, 1)',
                                backgroundColor: 'transparent',
                                tension: 0.3,
                                pointBackgroundColor: (ctx) => {
                                    const index = ctx.dataIndex;
                                    return index === ratings.length - 1
                                        ? 'rgba(255, 99, 132, 1)' 
                                        : 'rgba(75, 192, 192, 1)';
                                },
                                pointRadius: (ctx) => {
                                    const index = ctx.dataIndex;
                                    return index === ratings.length - 1 ? 6 : 0;
                                },
                                pointHoverRadius: (ctx) => {
                                    const index = ctx.dataIndex;
                                    return index === ratings.length - 1 ? 8 : 0;
                                },
                                pointHitRadius: (ctx) => {
                                    const index = ctx.dataIndex;
                                    return index === ratings.length - 1 ? 10 : 5; 
                                }
                            }
                        ]
                    },
                    options: {
                        scales: {
                            x: {
                                type: 'time',
                                time: {
                                    unit: 'month'
                                },
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            },
                            y: {
                                suggestedMin: 1,
                                suggestedMax: 5,
                                title: {
                                    display: true,
                                    text: 'Rating'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        responsive: false,
                        maintainAspectRatio: false,
                        layout: {
                            padding: 10
                        },
                    }
                });



            } else {
                forecastDiv.innerHTML = `<p>No forecast available for this block.</p>`;
            }
        })
        .catch(error => {
            console.error('Error fetching forecast:', error);
            document.getElementById('forecasting-data').innerHTML = `<p>Error loading forecast.</p>`;
        });
}

















    
    function showLotDetails(lot) {
        console.log("Lot data received:", lot);

        const detailsPanel = document.getElementById("lot-details");
        const modal = document.getElementById("lot-modal");
        const closeButton = document.querySelector(".lot-close");
    
        if (!detailsPanel || !modal) {
            console.error("Lot details panel or modal not found!");
            return;
        }
    
        modalOpen = true;
    
        detailsPanel.innerHTML = `
            <h3>Lot ID: ${lot.id}</h3>
            <p><strong>Name:</strong> ${lot.name}</p>
            <p><strong>Description:</strong> ${lot.description}</p>
            <p><strong>Size:</strong> ${lot.size} sqm</p>
            <p><strong>Price:</strong> ₱${lot.price}</p>
            <p><strong>Block Number:</strong> ${lot.block_id}</p>
        `;
    
        const rightColumn = modal.querySelector(".right-column");
        console.log("Right column found:", rightColumn);
    
        if (rightColumn) {
            console.log("LOT: Right column found:", rightColumn);

            const existing = rightColumn.querySelector("#house-3d-container");
            if (existing) existing.remove();
    
          
        }
    
        modal.classList.add("show");
    
        closeButton.onclick = () => {
            modal.classList.remove("show"); 
            stop3DModel();
            modalOpen = false;
        };
    
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.classList.remove("show");
                stop3DModel();
                modalOpen = false;
            }
        };
    
        delete lot.existingReview;
        renderReviewSection(lot);
    }
    






    function showBlockDetails(block) {
        console.log("showBlockDetails called with:", block);
        console.log("Block modelUrl:", block.modelUrl);
        
        const modal = document.getElementById("block-modal");
        const closeButton = modal.querySelector(".block-close");
    
        if (!modal) {  
            console.error("Block modal not found!");
            return;
        }
        modalOpen = true;
    
        // open modal
        modal.style.display = "flex";
    
        setTimeout(() => {
            const midColumn = modal.querySelector(".mid-column");
            console.log("Mid column found (delayed):", midColumn);

            if (midColumn) {
                const modelContainer = midColumn.querySelector("#block-3d-container");

                if (modelContainer) {
                    modelContainer.innerHTML = ""; 
                    modelContainer.style.width = "100%";
                    modelContainer.style.height = "150px";

                    if (block.modelUrl) {
                        init3DModel(modelContainer, block.modelUrl);
                    } else {
                        console.error("No model URL provided for block", block);
                    }
                } else {
                    console.error("block-3d-container not found inside midColumn");
                }
            }
        }, 50);
    
        const blockDetails = document.getElementById('block-details');
        if (blockDetails) {
            blockDetails.innerHTML = `
                <p><strong>Block Name:</strong> ${block.name ?? 'N/A'}</p>
                <p><strong>Total Lots:</strong> ${block.lots?.length ?? 0}</p>
                <p><strong>Description:</strong> ${block.description ?? 'No description provided.'}</p>
            `;
        }
    
        // show review section
        renderReviewSection(block);

        // load the summary
        loadBlockSummary(block.id);




    
        // close button
        closeButton.onclick = () => {
            modal.style.display = "none";
            stop3DModel();  
            modalOpen = false;
        };
    
        window.onclick = (event) => {
            if (event.target === modal) {
                modal.style.display = "none";
                stop3DModel();
                modalOpen = false;
            }
        };
    }
    
   
    







    var model, animationFrameId;

    function init3DModel(container, modelUrl) {
        console.log("Initializing 3D model...");
    
        // clear container
        while (container.firstChild) {
            container.removeChild(container.firstChild);
        }
    
        // get accurate container dimensions
        const width = container.clientWidth || 300;
        const height = container.clientHeight || 300;
        console.log("Container dimensions:", width, height);
    
        // scene setup
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
        camera.position.set(0, 1, 10);
        camera.lookAt(0, 0, 0);
    
        const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
        renderer.setSize(width, height);
        container.appendChild(renderer.domElement);
    
        // save globally if needed
        window.scene = scene;
        window.camera = camera;
        window.renderer = renderer;
    
        // lighting
        const ambientLight = new THREE.AmbientLight(0xffffff, 1);
        scene.add(ambientLight);
    
        const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
        directionalLight.position.set(5, 10, 5);
        scene.add(directionalLight);
    
        // load model
        const loader = new GLTFLoader();
        loader.load(
            modelUrl,
            (gltf) => {
                model = gltf.scene;
    
                model.traverse((child) => {
                    if (child.isMesh) {
                        child.castShadow = true;
                        child.receiveShadow = true;
                    }
                });
    
                scene.add(model);
                model.rotation.x = Math.PI / 6;
                model.rotation.y = Math.PI / 4;
    
                animate();
            },
            undefined,
            (error) => {
                console.error("Error loading model:", error);
            }
        );
        
        // animation loop
        let isAnimating = false;
        function animate() {
            animationFrameId = requestAnimationFrame(animate);
            if (model && isAnimating) {
                model.rotation.y += 0.009;
            }
            renderer.render(scene, camera);
        }
    }
    
    
    
    function stop3DModel() {
    
        if (animationFrameId) {
            cancelAnimationFrame(animationFrameId);
            animationFrameId = null;  
        } else {
        }
    
        if (window.scene) {
            if (window.model) {
                window.scene.remove(window.model);
                window.model.rotation.set(0, 0, 0); 
    
                window.model.traverse((child) => {
                    if (child.geometry) {
                        
                        child.geometry.dispose();
                    }
                    if (child.material) {
                        if (Array.isArray(child.material)) {
                            child.material.forEach((mat) => {
                                mat.dispose();
                            });
                        } else {
                            child.material.dispose();
                        }
                    }
                });
                window.model = null;
            }
    
            // dispose renderer
            if (window.renderer) {
                window.renderer.dispose();
                if (window.renderer.domElement) {
                    window.renderer.domElement.remove();
                }
                window.renderer = null;
            }
    
            // clear scene
            window.scene.clear();
            window.scene = null;
        }
    }
    
    



    function renderReviewSection(block) {
        
        const reviewSection = document.getElementById('block-review-section');
        const reviews = block.reviews ?? [];



        reviewSection.innerHTML = `
            <h3>Leave a review</h3>
            <form id="block-review-form">
                <input type="hidden" name="review_id" id="review-id">
                <input type="hidden" name="block_id" value="${block.id}"> 
                <label for="review-comment"></label>
                <textarea id="review-comment" name="comment" rows="3" required placeholder="Type your review here"></textarea>
    
                <div class="container__items rating-stars">
                ${[5,4,3,2,1].map(num => `
                    <input type="radio" name="stars" id="st${num}" value="${num}">
                    <label for="st${num}">
                        <div class="star-stroke">
                            <div class="star-fill"></div>
                        </div>
                        <div class="label-description" data-content="${["Excellent", "Good", "OK", "Bad", "Terrible"][5 - num]}"></div>
                    </label>
                `).join('')}
                </div>
    
                <input type="hidden" name="rating" id="rating-value" required>
    
                <button class="review-submit-btn" type="submit">Submit review</button>
            </form>
    
            <h3>Reviews</h3>
            <div id="reviews-container">
                ${reviews.map(review => `
                    <div class="review" data-review-id="${review.id}">
                        <strong>${review.user_name}</strong> - ${review.rating}/5<br>
                        <p>${review.comment}</p>
                        <small>${new Date(review.created_at).toLocaleString('en-US', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: 'numeric',
                            minute: '2-digit',
                            hour12: true
                        })}</small><br>
    
                        ${review.user_id === Auth.userId ? `
                            <button class="edit-review">Edit</button>
                            <button class="delete-review">Delete</button>
                        ` : ''}
                    </div>
                `).join('')}
            </div>
        `; 

        
        resetReviewForm();
    
        // rating logic
        document.querySelectorAll('input[name="stars"]').forEach(radio => {
            radio.addEventListener('change', function () {
                document.getElementById('rating-value').value = this.value;
            });
        });
    
        const reviewForm = document.getElementById('block-review-form');
        const ratingInput = document.getElementById('rating-value');
    
       
    
        // submit review form handling
        if (reviewForm) {
            reviewForm.addEventListener('submit', async function (e) {
                e.preventDefault();
    
                const comment = document.getElementById('review-comment').value;
                const rating = ratingInput.value;
    
                if (!rating) {
                    alert('select a star rating before submitting!');
                    return;
                }
    
                const formData = new FormData();
                formData.append('block_id', reviewForm.querySelector('[name="block_id"]').value);
                formData.append('rating', rating);
                formData.append('comment', comment);
    
                try {
                    const isEditing = reviewForm.hasAttribute('data-editing');
                    const reviewId = document.getElementById('review-id').value;
                    let url = '/block-reviews';
                    let method = 'POST';
    
                    if (isEditing && reviewId) {
                        url = `/block-reviews/${reviewId}`;
                        formData.append('_method', 'PUT');
                    }
    
                    const res = await fetch(url, {
                        method: method,
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
    
                    if (res.status === 401) {
                        window.location.href = '/login';
                        return;
                    }
    
                    const data = await res.json();
    
                    if (res.ok) {
                        if (data.block) {
                            renderReviewSection(data.block);
                            fetchForecast(data.block.id); 

                        } else if (data.review) {
                            const blockId = data.review.block_id;
    
                            try {
                                const fetchRes = await fetch(`/block/${blockId}`);
                                const updatedBlock = await fetchRes.json();
    
                                if (!updatedBlock || !updatedBlock.reviews) {
                                    alert('review updated but failed to refresh');
                                    return;
                                }
    
                                renderReviewSection(updatedBlock);
                                fetchForecast(data.block.id); 
                            } catch (err) {
                                alert('review updated but failed to fetch block');
                            }
                        }
    
                        reviewForm.removeAttribute('data-editing');
                    } else {
                        alert('error: ' + data.message);
                    }
                } catch (err) {
                    console.error('err submitting review:', err);
                    alert('something went wrong');
                }
            });
        }
    
        // edit btn
        document.querySelectorAll('.edit-review').forEach(btn => {
            btn.addEventListener('click', function () {
                const reviewId = this.closest('.review').getAttribute('data-review-id');
                const review = block.reviews.find(r => r.id == reviewId);
    
                document.getElementById('review-comment').value = review.comment;
                document.getElementById('rating-value').value = review.rating;
                document.getElementById('review-id').value = review.id;
    
                document.querySelectorAll('input[name="stars"]').forEach(radio => {
                    radio.checked = (radio.value == review.rating);
                });
    
                reviewForm.setAttribute('data-editing', reviewId);
            });
        });
    
        // delete btn
        document.querySelectorAll('.delete-review').forEach(btn => {
            btn.addEventListener('click', async function () {
                const reviewId = this.closest('.review').getAttribute('data-review-id');
    
                if (!confirm('delete this review?')) return;
    
                try {
                    const res = await fetch(`/block-reviews/${reviewId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });
    
                    if (res.ok) {
                        document.querySelector(`[data-review-id="${reviewId}"]`)?.remove();
    
                        document.getElementById('review-comment').value = '';
                        document.getElementById('rating-value').value = '';
                        document.getElementById('review-id').value = '';
                        reviewForm.removeAttribute('data-editing');
    
                        document.querySelectorAll('input[name="stars"]').forEach(r => r.checked = false);
                        // also remove edit flag if present
                        reviewForm.removeAttribute('data-editing');
                    } else {
                        alert('error deleting review');
                    }
                } catch (err) {
                    console.error('err deleting review:', err);
                    alert('something went wrong');
                }
            });
        });
    }
    
    


    const userId = document.body.dataset.userId;
    window.Auth = { userId: parseInt(userId) };
    

    function resetReviewForm() {
        document.getElementById('review-comment').value = '';
        document.getElementById('rating-value').value = '';
        document.getElementById('review-id').value = '';
        document.querySelectorAll('input[name="stars"]').forEach(r => r.checked = false);
    
        const reviewForm = document.getElementById('block-review-form');
        if (reviewForm) {
            reviewForm.removeAttribute('data-editing');
        }
    }
    









    // animation loop
    function animate() {
        // stats.begin();
       
        renderer.render(scene, camera);

        controls.update();
        // composer.render();
        // stats.end();
        requestAnimationFrame(animate);
    }
    animate();

    // adjust screen on window resize
    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    })
}

export default initThreeJS;