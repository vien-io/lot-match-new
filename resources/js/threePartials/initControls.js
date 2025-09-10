import * as THREE from 'three';
import { OrbitControls } from 'three/examples/jsm/Addons.js';

export function initControls(camera, renderer, container) {
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enablePAN = true;
    controls.enableRotate = true;
    controls.enableZoom = true;
    controls.mouseButtons.LEFT = THREE.MOUSE.PAN;
    controls.mouseButtons.RIGHT = THREE.MOUSE.ROTATE;
    controls.screenSpacePanning = true;
    controls.panSpeed = 2;

    container.addEventListener('contextmenu', (e) => e.preventDefault());
    return controls;
}