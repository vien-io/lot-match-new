// threePartials/initSky.js
import * as THREE from 'three';
import { Sky } from 'three/addons/objects/Sky.js';

export function initSky(scene) {
    const sky = new Sky();
    sky.scale.setScalar(450000);
    scene.add(sky);

    const sun = new THREE.Vector3();
    sun.setFromSphericalCoords(1, Math.PI / 4, Math.PI / 4);
    sky.material.uniforms['sunPosition'].value.copy(sun);

    return sky;
}
