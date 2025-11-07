import * as THREE from 'three';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import 'chartjs-adapter-date-fns';
import Stats from 'three/examples/jsm/libs/stats.module.js';
import { EffectComposer } from 'three/examples/jsm/postprocessing/EffectComposer.js';
import { RenderPass } from 'three/examples/jsm/postprocessing/RenderPass.js';
import { OutlinePass } from 'three/examples/jsm/postprocessing/OutlinePass.js';
import { FXAAShader } from 'three/examples/jsm/shaders/FXAAShader.js';
import { ShaderPass } from 'three/examples/jsm/postprocessing/ShaderPass.js';
import gsap from "gsap";

import { initRenderer, addResizeHandler } from './threePartials/initRenderer';
import { initScene } from './threePartials/initScene';
import { initCamera } from './threePartials/initCamera';
import { initLights } from './threePartials/initLights';
import { initControls } from './threePartials/initControls';
import { initHelpers } from './threePartials/initHelpers';
import { loadHouses } from './threePartials/loadHouses';
import { initRaycasterOutlinePass } from './threePartials/initRaycasterOutlinePass';
import { initClickHandler } from './threePartials/initClickHandler';
import { fetchForecast } from './threePartials/forecastHandler';
import { showLotDetails, showBlockDetails } from './threePartials/detailsHandler';
import { initSky } from './threePartials/initSky';

export default async function initThreeJS() {
    const container = document.getElementById('threejs-container');

    // --- Scene / Renderer / Camera ---
    const scene = initScene();
    const renderer = initRenderer(container);
    renderer.outputColorSpace = THREE.SRGBColorSpace;
    renderer.toneMapping = THREE.ACESFilmicToneMapping;
    renderer.toneMappingExposure = 1.2;

    const camera = initCamera(container);
    addResizeHandler(container, camera, renderer);

    const controls = initControls(camera, renderer, container);
    initLights(scene);
    initHelpers(scene);
    initSky(scene);

    // --- Load houses asynchronously ---
    const { housesGroup, selectableObjects, instanceMetadata, uiState } = await loadHouses(scene);

    // --- Postprocessing / Outline ---
    const composer = new EffectComposer(renderer);
    const renderPass = new RenderPass(scene, camera);
    composer.addPass(renderPass);

    const outlinePass = new OutlinePass(
        new THREE.Vector2(container.clientWidth, container.clientHeight),
        scene,
        camera
    );
    outlinePass.edgeStrength = 5;
    outlinePass.edgeGlow = 0.5;
    outlinePass.edgeThickness = 2;
    outlinePass.visibleEdgeColor.set('#ffff00');
    outlinePass.hiddenEdgeColor.set('#ffff00');
    composer.addPass(outlinePass);

    const fxaaPass = new ShaderPass(FXAAShader);
    fxaaPass.material.uniforms['resolution'].value.set(
        1 / container.clientWidth,
        1 / container.clientHeight
    );
    composer.addPass(fxaaPass);


    // --- Raycaster & Outline interaction ---
    initRaycasterOutlinePass({
        container,
        scene,
        camera,
        renderer,
        housesGroup,
        selectableObjects,
        instanceMetadata,
        outlinePass,
        uiState
    });

    // --- Click handler ---
    initClickHandler({
        camera,
        renderer,
        housesGroup,
        selectableObjects,
        instanceMetadata,
        showLotDetails,
        showBlockDetails,
        fetchForecast,
        uiState
    });

    // --- Optional stats ---
    const statsOn = false;
    const stats = new Stats();
    if (statsOn) document.body.appendChild(stats.dom);

    // --- Animate ---
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        composer.render();
        if (statsOn) stats.update();
    }
    animate();
}
