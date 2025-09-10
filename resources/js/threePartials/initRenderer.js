import * as THREE from 'three';

export function initRenderer(container) {
    const width = container.clientWidth;
    const height = container.clientHeight;

    console.log("Container size: ", width, height);

    const renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(width, height);
    container.appendChild(renderer.domElement);
    // renderer.shadowMap.enabled = false; // pang alis ng shadows to optimize

    return renderer;
}

export function addResizeHandler(container, camera, renderer) {
    window.addEventListener('resize', () => {
        const width = container.clientWidth;
        const height = container.clientHeight;

        console.log("Resized:", width, height);

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });
}