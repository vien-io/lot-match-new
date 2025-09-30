import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import 'chartjs-adapter-date-fns';

// gsap for cam animation
import gsap from "gsap";

import { initRenderer, addResizeHandler } from './threePartials/initRenderer';
import { initScene } from './threePartials/initScene';
import { initCamera } from './threePartials/initCamera';
import { initLights } from './threePartials/initLights';
import { initControls } from './threePartials/initControls';
import { initHelpers } from './threePartials/initHelpers';
import { loadHouses } from './threePartials/loadHouses';
import { initRaycaster } from './threePartials/initRaycaster';
import { initClickHandler } from './threePartials/initClickHandler';
import { fetchForecast } from './threePartials/forecastHandler';
import { showLotDetails, showBlockDetails } from './threePartials/detailsHandler';

function initThreeJS() {
    const container = document.getElementById('threejs-container');

    const scene = initScene();
    const renderer = initRenderer(container);
    const camera = initCamera(container);
    addResizeHandler(container, camera, renderer);

    const controls = initControls(camera, renderer, container);
    initLights(scene);
    initHelpers(scene);

    const { housesGroup, selectableObjects } = loadHouses(scene);


    initRaycaster({ container, camera, renderer, housesGroup, selectableObjects });
    initClickHandler({
        camera,
        renderer,
        housesGroup,
        selectableObjects,
        showLotDetails,
        showBlockDetails,
        fetchForecast
    });

    // animation loop
    function animate() {
        requestAnimationFrame(animate);
        controls.update();
        renderer.render(scene, camera);
    }
    animate();
}

export default initThreeJS;
