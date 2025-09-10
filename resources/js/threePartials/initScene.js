import * as THREE from 'three';

export function initScene() {
    // scene
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xD3D3D3);
    return scene;
}
