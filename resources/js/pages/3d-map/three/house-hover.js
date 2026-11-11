import * as THREE from "three";
import { OutlinePass } from "three/examples/jsm/postprocessing/OutlinePass.js";

export function initHouseHover(composer, camera, model, renderer) {
    const raycaster = new THREE.Raycaster();
    const mouse = new THREE.Vector2();

    const outlinePass = new OutlinePass(
        new THREE.Vector2(
            renderer.domElement.clientWidth,
            renderer.domElement.clientHeight,
        ),
        composer.renderPass.scene,
        camera,
    );

    outlinePass.edgeStrength = 3.0;
    outlinePass.edgeGlow = 0;
    outlinePass.edgeThickness = 1.0;
    outlinePass.pulsePeriod = 0;

    outlinePass.visibleEdgeColor.set("#c4c4c4");
    outlinePass.hiddenEdgeColor.set("#c4c4c4");

    composer.addPass(outlinePass);

    function onPointerMove(event) {
        const rect = renderer.domElement.getBoundingClientRect();

        mouse.x = ((event.clientX - rect.left) / rect.width) * 2 - 1;
        mouse.y = -((event.clientY - rect.top) / rect.height) * 2 + 1;

        raycaster.setFromCamera(mouse, camera);

        const intersects = raycaster.intersectObject(model, true);

        outlinePass.selectedObjects = intersects.length ? [model] : [];
    }

    function onPointerLeave() {
        outlinePass.selectedObjects = [];
    }

    renderer.domElement.addEventListener("pointermove", onPointerMove);
    renderer.domElement.addEventListener("pointerleave", onPointerLeave);

    return {
        destroy() {
            renderer.domElement.removeEventListener(
                "pointermove",
                onPointerMove,
            );
            renderer.domElement.removeEventListener(
                "pointerleave",
                onPointerLeave,
            );

            outlinePass.selectedObjects = [];
            composer.removePass(outlinePass);
        },
    };
}
