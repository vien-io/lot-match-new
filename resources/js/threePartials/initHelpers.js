import * as THREE from 'three';

export function initHelpers(scene) {
    const axesHelper = new THREE.AxesHelper(5);
    const gridHelper = new THREE.GridHelper(80, 20);

    // scene.add(gridHelper);
    // scene.add(axesHelper);

    return { axesHelper, gridHelper };
}