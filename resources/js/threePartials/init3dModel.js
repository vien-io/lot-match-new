import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { OrbitControls } from 'three/examples/jsm/Addons.js';

let model, animationFrameId;

export function init3DModel(container, modelUrl) {
    // console.log("Initializing 3d model....");

    // clear container first
    while (container.firstChild) container.removeChild(container.firstChild);

    const width = 350;
    const height = 350;

    // scene + camera setup
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(100, width / height, 0.1, 1000);
    camera.position.set(6, 1.5, 6);
    camera.lookAt(0, 0, 0);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.setClearColor(0x000000, 0);
    renderer.domElement.style.clipPath = 'inset(50px 50px 50px 50px)';
    renderer.domElement.style.position = 'absolute';
    container.appendChild(renderer.domElement);
    // console.log("Container: ", container);

    // controller
    const controls = new OrbitControls(camera, renderer.domElement);

    controls.enableRotate = true;
    controls.enableDamping = true;
    controls.enableZoom = false;
    controls.dampingFactor = 0.05;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 2.0;
    controls.update();
    

   // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 1.5);
    scene.add(ambientLight);

    const dirLight = new THREE.DirectionalLight(0xffffff, 1.2);
    dirLight.position.set(5, 10, 5);
    scene.add(dirLight);

    
    const loader = new GLTFLoader();
    loader.load(modelUrl, (gltf) => {
        model = gltf.scene;

        const box = new THREE.Box3().setFromObject(model);
        const center = box.getCenter(new THREE.Vector3());

        model.position.x -= center.x;
        model.position.z -= center.z;

        const heightOffset = 1; 
        model.position.y -= center.y - heightOffset;


        model.traverse((child) => {
            if (child.isMesh) {
                child.castShadow = true;
                child.receiveShadow = true;
                child.material = child.material.clone();
                child.material.userData.originalColor = child.material.color.clone();
            }
        });

        const cutBox = box.clone();
        const heightCutTop = 0.7;
        cutBox.max.y -= heightCutTop;

        const boxHelper = new THREE.Box3Helper(cutBox, 0xffffff);
        boxHelper.visible = false;
        model.add(boxHelper);

        scene.add(model);
        animate();

        function setOriginalMaterial() {
            model.traverse((child) => {
                if (child.isMesh && child.material) {
                    child.material.wireframe = false;
                    child.material.color.copy(child.material.userData.originalColor);
                }
            });
            boxHelper.visible = false;
        }

        function setWireframeMaterial() {
            model.traverse((child) => {
                if (child.isMesh && child.material) {
                    child.material.wireframe = true;
                    child.material.color.set(0x00ff80);
                }
            });
            boxHelper.visible = true;
        }

        setOriginalMaterial();

        // hover event
        renderer.domElement.addEventListener('mousemove', (e) => {
            const rect = renderer.domElement.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            // define active hover area
            const zoneX = rect.width * 0.25;
            const zoneY = rect.height * 0.25;
            const zoneW = rect.width * 0.5;
            const zoneH = rect.height * 0.5;

            if (x >= zoneX && x <= zoneX + zoneW && y >= zoneY && y <= zoneY + zoneH) {
                setWireframeMaterial();
            } else {
                setOriginalMaterial();
            }
        });

/*         const midColumn = document.querySelector('.mid-column');
        const hoverTrigger = document.getElementById('hover-trigger');

        hoverTrigger.addEventListener('mouseenter', () => {
            midColumn.classList.add('hover:tw--translate-y-1', 'hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)]', 'hover:tw-bg-[#84ffb1]/30');
        });

        hoverTrigger.addEventListener('mouseleave', () => {
            midColumn.classList.remove('hover:tw--translate-y-1', 'hover:tw-shadow-[0_4px_20px_rgba(255,255,255,0.05)]', 'hover:tw-bg-[#84ffb1]/30');
        });
 */


        },
        undefined,
        (error) => {
            console.error("Error loading model:", error);
        }
    );



    function animate() {
        animationFrameId = requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }

    // Expose for cleanup
    window.scene = scene;
    window.camera = camera;
    window.renderer = renderer;
    window.model = model;
}

// proper cleanup
export function stop3DModel() {
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
    }

    if (window.scene) {
        if (window.model) {
            window.scene.remove(window.model);
            window.model.traverse((child) => {
                if (child.geometry) child.geometry.dispose();
                if (child.material) {
                    if (Array.isArray(child.material)) {
                        child.material.forEach((mat) => mat.dispose());
                    } else {
                        child.material.dispose();
                    }
                }
            });
            window.model = null;
        }

        if (window.renderer) {
            window.renderer.dispose();
            if (window.renderer.domElement) {
                window.renderer.domElement.remove();
            }
            window.renderer = null;
        }

        window.scene.clear();
        window.scene = null;
    }
}
