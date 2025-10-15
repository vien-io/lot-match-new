import * as THREE from 'three';

export function initRenderer(container) {
    const width = container.clientWidth;
    const height = container.clientHeight;

    const renderer = new THREE.WebGLRenderer({ antialias: true });
/*     renderer.setPixelRatio(window.devicePixelRatio > 1 ? 1.5 : 1);
    renderer.outputEncoding = THREE.LinearEncoding; */
    renderer.setSize(width, height);
    container.appendChild(renderer.domElement);
    renderer.shadowMap.enabled = false; 

    return renderer;
}

export function addResizeHandler(container, camera, renderer) {
    window.addEventListener('resize', () => {
        const width = container.clientWidth;
        const height = container.clientHeight;

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
        renderer.setSize(width, height);
    });
}