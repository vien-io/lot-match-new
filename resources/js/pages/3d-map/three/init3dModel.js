import * as THREE from "three";
import { GLTFLoader } from "three/examples/jsm/Addons.js";
import { OrbitControls } from "three/examples/jsm/Addons.js";
import { initHouseHover } from "./house-hover.js";
import { EffectComposer } from "three/examples/jsm/postprocessing/EffectComposer.js";
import { RenderPass } from "three/examples/jsm/postprocessing/RenderPass.js";

let animationFrameId;
let houseHoverInstance = null;

export function init3DModel(container, modelUrl) {
    // Clear container
    while (container.firstChild) container.removeChild(container.firstChild);

    // Scene, camera, renderer
    const width = 450,
        height = 450;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, width / height, 0.1, 1000);
    camera.position.set(7, 2, 7);

    const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
    renderer.setSize(width, height);
    renderer.setClearColor(0x000000, 0);
    container.appendChild(renderer.domElement);

    // Composer
    const composer = new EffectComposer(renderer);

    const renderPass = new RenderPass(scene, camera);
    composer.addPass(renderPass);

    composer.renderPass = renderPass;

    // Controls
    const controls = new OrbitControls(camera, renderer.domElement);
    renderer.domElement.style.cursor = "grab";
    controls.addEventListener("start", () => {
        renderer.domElement.style.cursor = "grabbing";
    });

    controls.addEventListener("end", () => {
        renderer.domElement.style.cursor = "grab";
    });

    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 1.0;
    controls.enableZoom = false;
    controls.enablePan = false;

    // Lighting
    scene.add(new THREE.AmbientLight(0xffffff, 3.0));

    const dirLight = new THREE.DirectionalLight(0xffffff, 2.5);
    dirLight.position.set(5, 10, 7);
    scene.add(dirLight);

    const fillLight = new THREE.DirectionalLight(0xffffff, 1.5);
    fillLight.position.set(-5, 3, -5);
    scene.add(fillLight);

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

            // Reduce material reflectivity
            model.traverse((child) => {
                if (!child.isMesh) return;

                const materials = Array.isArray(child.material)
                    ? child.material
                    : [child.material];

                materials.forEach((material) => {
                    if (material.isMeshStandardMaterial || material.isMeshPhysicalMaterial) {
                        material.metalness = 0;
                        material.roughness = 0.9;
                        material.envMapIntensity = 0.2;
                        material.needsUpdate = true;
                    }
                });
            });

            scene.add(model);
            houseHoverInstance = initHouseHover(
                composer,
                camera,
                model,
                renderer,
            );

            // Animate
            function animate() {
                animationFrameId = requestAnimationFrame(animate);
                controls.update();
                composer.render();
            }
            animate();
        },
        undefined,
        (err) => console.error("Error loading model:", err),
    );

    // Save refs for cleanup
    window.scene = scene;
    window.renderer = renderer;
}

export function stop3DModel() {
    if (animationFrameId) cancelAnimationFrame(animationFrameId);

    if (houseHoverInstance) {
        houseHoverInstance.destroy();
        houseHoverInstance = null;
    }

    if (composer) {
        composer.dispose();
    }

    if (window.scene) {
        window.scene.traverse((obj) => {
            if (obj.geometry) obj.geometry.dispose();
            if (obj.material) {
                if (Array.isArray(obj.material))
                    obj.material.forEach((m) => m.dispose());
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
