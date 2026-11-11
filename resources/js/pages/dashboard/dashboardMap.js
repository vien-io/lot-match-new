import * as THREE from "three";
import { OrbitControls } from "three/examples/jsm/Addons.js";
import { GLTFLoader } from "three/examples/jsm/loaders/GLTFLoader.js";

function initThreeJS() {
    const container = document.getElementById("dashboard-map-container");

    // container size
    const width = container.clientWidth;
    const height = container.clientHeight;

    // scene
    const scene = new THREE.Scene();
    scene.background = null;

    // camera
    const camera = new THREE.PerspectiveCamera(60, width / height, 0.1, 1000);
    camera.position.set(7, 7, 7);
    camera.lookAt(0, 0, 0);
    window.threeCamera = camera;

    const gridHelper = new THREE.GridHelper(100, 50, 0xb0b0b0, 0xe5e7eb);

    gridHelper.position.y = -2.1;
    scene.add(gridHelper);

    const renderer = new THREE.WebGLRenderer({
        antialias: true,
        alpha: true,
    });

    renderer.setSize(width, height);
    container.appendChild(renderer.domElement);

    // controls
    const controls = new OrbitControls(camera, renderer.domElement);
    controls.enablePan = false;
    controls.enableRotate = true;
    controls.enableZoom = false;
    controls.mouseButtons.LEFT = THREE.MOUSE.ROTATE;
    controls.mouseButtons.RIGHT = THREE.MOUSE.ROTATE;
    controls.screenSpacePanning = true;
    controls.panSpeed = 2;
    controls.enableDamping = true;
    controls.dampingFactor = 0.05;
    controls.autoRotate = true;
    controls.autoRotateSpeed = 1.0;
    controls.update();

    // lightings
    const ambientLight = new THREE.AmbientLight(0xffffff, 1);
    scene.add(ambientLight);

    let light = new THREE.DirectionalLight(0xffffff, 3);
    light.position.set(20, 10, 20);
    light.target.position.set(0, 0, 0);
    scene.add(light);
    scene.add(light.target);

    // house group
    const housesGroup = new THREE.Group();
    housesGroup.name = "lotsGroup";
    scene.add(housesGroup);

    // house models
    const selectableObjects = [];

    const houseLoader = new GLTFLoader();
    const houseModelLoader = new GLTFLoader();

    // load the scene GLB (the one with Empty objects)
    const url = `/models/basic/housemodel.glb?ts=${Date.now()}`;
    houseLoader.load(url, (gltf) => {
        const sceneModel = gltf.scene;
        const box = new THREE.Box3().setFromObject(sceneModel);
        const center = box.getCenter(new THREE.Vector3());
        sceneModel.position.sub(center);

        const size = box.getSize(new THREE.Vector3());

        sceneModel.position.y -= size.y / 2 - 4;
        housesGroup.add(sceneModel);

        box.setFromObject(sceneModel);
        const boxHelper = new THREE.Box3Helper(box, 0x00ff00);
        boxHelper.visible = false;
        scene.add(boxHelper);
    });

    function animate() {
        requestAnimationFrame(animate);

        controls.update();

        renderer.render(scene, camera);
    }
    animate();
}

window.addEventListener("load", () => {
    initThreeJS();
});
