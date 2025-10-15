import * as THREE from 'three';
import { fill } from 'three/src/extras/TextureUtils.js';

export function initLights(scene) {
    const ambientLight = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambientLight);

    let light = new THREE.DirectionalLight(0xffffff, 3);
    light.position.set(20, 10, 20);
    light.target.position.set(0, 0, 0);
    scene.add(light);
    scene.add(light.target);
    
    // fill light
    const fillLight = new THREE.DirectionalLight(0xADD8E6, 0.3);
    fillLight.position.set(-20, -10, -20);
    fillLight.target.position.set(0, 0, 0);
    scene.add(fillLight);
    scene.add(fillLight.target);

    
    const lightHelper = new THREE.DirectionalLightHelper(light, 2);
    // scene.add(lightHelper);

    return { ambientLight, light, fillLight };
}