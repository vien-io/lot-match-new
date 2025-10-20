import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "./init3dModel";

export let modalOpen = false;

export function showLotDetails(lot) {
    console.log("showLotDetails called with:", lot);

    const modal = document.getElementById("lot-modal");
    const closeButton = modal?.querySelector(".lot-close");
    const detailsPanel = document.getElementById("lot-details");

    if (!modal || !closeButton || !detailsPanel) {
        console.error("Lot modal, close button, or details panel not found!");
        return;
    }

    modalOpen = true;
    modal.style.display = "flex";

    const tooltip = document.getElementById("tooltip");
    if (tooltip) tooltip.style.display = "none";

    detailsPanel.innerHTML = `
        <p><strong>Name:</strong> ${lot.name ?? 'N/A'}</p>
        <p><strong>Size:</strong> ${lot.size ?? 'N/A'} sqm</p>
        <p><strong>Status:</strong> ${lot.status ?? 'N/A'}</p>
        <p><strong>Price:</strong> ₱${lot.price ?? 'N/A'}</p>
        <p><strong>Block Number:</strong> ${lot.block_id ?? 'N/A'}</p>
        <h3>Lot ID: ${lot.id}</h3>
    `;

    closeButton.onclick = () => {
        modal.style.display = "none";
        modalOpen = false;
        console.log("Lot modal closed via button");
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            modalOpen = false;
            console.log("Lot modal closed via outside click");
        }
    };

    const rightColumn = modal.querySelector(".right-column");
    if (rightColumn) {
        const existing3D = rightColumn.querySelector("#house-3d-container");
        if (existing3D) existing3D.remove();
    }

    delete lot.existingReview;

    renderReviewSection(lot);
}


export function showBlockDetails(block) {
    console.log("showBlockDetails called with:", block);

    const modal = document.getElementById("block-modal");
    const closeButton = modal.querySelector(".block-close");

    if (!modal) {
        console.error("Block modal not found!");
        return;
    }
    modalOpen = true;

    modal.style.display = "flex";
    const tooltip = document.getElementById("tooltip");
    if (tooltip) tooltip.style.display = "none";


    closeButton.onclick = () => {
        modal.style.display = "none";
        // stop3DModel();
        modalOpen = false;
        console.log("Close button clicked!");
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            // stop3DModel();
            modalOpen = false;
        }
    };

    setTimeout(() => {
        const midColumn = modal.querySelector(".mid-column");
        if (midColumn) {
            const modelContainer = midColumn.querySelector("#block-3d-container");
            if (modelContainer) {
                modelContainer.innerHTML = "";
                modelContainer.style.width = "150px";
                modelContainer.style.height = "150px";
                // modelContainer.style.pointerEvents = "none";


                if (block.modelUrl) {
                    init3DModel(modelContainer, block.modelUrl);
                } else {
                    console.error("No model URL provided for block", block);
                }
            }
        }
    }, 50);

    const blockDetails = document.getElementById("block-details");
    if (blockDetails) {
        blockDetails.innerHTML = `
            <p><strong>Block Name:</strong> ${block.name ?? 'N/A'}</p>
            <p><strong>Total Lots:</strong> ${block.lots?.length ?? 0}</p>
        `;
    }

    renderReviewSection(block);
    loadBlockSummary(block.id);
}
