import * as THREE from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { contain } from 'three/src/extras/TextureUtils.js';

function initThreeJS() {
    // container first
    const container = document.getElementById('dashboard-map-container');

    // scene
    const scene = new THREE.Scene();
    scene.background = new THREE.Color(0xD3D3D3);

    // camera
    const width = container.clientWidth;
    const height = container.clientHeight;
    const camera = new THREE.PerspectiveCamera(40, width / height, 0.1, 1000);
    camera.position.set(0, 90, 0);
    camera.lookAt(0, 0, 0);
    window.threeCamera = camera;

    // helper
    const axesHelper = new THREE.AxesHelper(5);
    const gridHelper = new THREE.GridHelper(80, 20);
    scene.add(axesHelper, grdiHelper);



    // renderer
    const renderer = new THREE.WebGLRenderer();
    renderer.setSize(width, height);
    container.appendChild(render.domElement);

    // continue hereeeeee (u can erase this comment lol)
}