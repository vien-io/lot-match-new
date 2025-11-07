import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/Addons.js';
import { OrbitControls } from 'three/examples/jsm/Addons.js';

let animationFrameId;

export function init3DModel(container, modelUrl) {
    // Clear container
    while (container.firstChild) container.removeChild(container.firstChild);

    // Scene, camera, renderer
    const width = 350, height = 350;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.set(7, 2, 7);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    // Controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 1.0;
    controls.enableZoom = false;
    controls.enablePan = false;

    // Lights
    scene.add(new THREE.AmbientLight(0xffffff, 1.2));
    const dirLight = new THREE.DirectionalLight(0xffffff, 1.0);
    dirLight.position.set(5, 10, 5);
    scene.add(dirLight);

    // Load model
    const loader = new GLTFLoader();
    loader.load(
        modelUrl,
        (gltf) => {
            const model = gltf.scene;

            // Center model
            const box = new THREE.Box3().setFromObject(model);
            const center = box.getCenter(new THREE.Vector3());
            model.position.sub(center);

            scene.add(model);

            // Animate
            function animate() {
                animationFrameId = requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }
            animate();
        },
        undefined,
        (err) => console.error('Error loading model:', err)
    );

    // Save refs for cleanup
    window.scene = scene;
    window.renderer = renderer;
}

export function stop3DModel() {
    if (animationFrameId) cancelAnimationFrame(animationFrameId);

    if (window.scene) {
        window.scene.traverse((obj) => {
            if (obj.geometry) obj.geometry.dispose();
            if (obj.material) {
                if (Array.isArray(obj.material)) obj.material.forEach((m) => m.dispose());
                else obj.material.dispose();
            }
        });
        window.scene.clear();
    }

    if (window.renderer) {
        window.renderer.dispose();
        window.renderer.domElement.remove();
    }

    window.scene = null;
    window.renderer = null;
    animationFrameId = null;
}
