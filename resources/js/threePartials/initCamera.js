import * as THREE from 'three';

export function initCamera(container) {
    const width = container.clientWidth;
    const height = container.clientHeight;

    const camera = new THREE.PerspectiveCamera(
        40,
        width / height,
        0.1,
        1000,
    );
    camera.position.set(0 , 590, 0);
    camera.lookAt(0, 0, 0);

    // expose globally for debugging
    window.threeCamera = camera;

    return camera;
}