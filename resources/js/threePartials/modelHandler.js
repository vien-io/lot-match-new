import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader';

let model, animationFrameId;

export function init3DModel(container, modelUrl) {
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

export function stop3DModel() {
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;  
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
                        child.material.forEach((mat) => mat.dispose());
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
