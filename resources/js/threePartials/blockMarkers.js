import * as THREE from 'three';
import gsap from 'gsap';

export function addBlockMarkers(sceneModel, scene, markerData, selectableObjects) {
    markerData.forEach(({ emptyName, color, blockId }) => {
        const blockEmpty = sceneModel.getObjectByName(emptyName);

        if (!blockEmpty) {
            console.warn(`Empty "${emptyName}" NOT found in sceneModel!`);
            return;
        }


        const map = new THREE.TextureLoader().load('/images/selector.png');
        const spriteMaterial = new THREE.SpriteMaterial({
            map,
            color: color,
            opacity: 0.4,
            transparent: true,
            depthTest: false,
            sizeAttenuation: false
        });

        const sprite = new THREE.Sprite(spriteMaterial);
        sprite.scale.set(0.03, 0.03, 1);
        sprite.renderOrder = 999;
        sprite.position.copy(blockEmpty.position);

        // assign name for raycasting
        sprite.name = `block_${blockId}`;
        sprite.userData = {
            type: "block",
            blockId: blockId
        };
        selectableObjects.push(sprite);

        scene.add(sprite);


        // animation: pulsing effect
        sprite.userData.highlightTween = gsap.to(sprite.scale, {
            x: 0.05,
            y: 0.05,
            duration: 0.8,
            yoyo: true,
            repeat: -1,
            paused: true 
        });
    });
}

// helper functions for hover highlight
export function highlightBlock(sprite) {
    if (sprite.userData.highlightTween) sprite.userData.highlightTween.play();
}

export function resetBlock(sprite) {
    if (sprite.userData.highlightTween) sprite.userData.highlightTween.pause();
    sprite.scale.set(0.03, 0.03, 1);
}
