import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "./init3dModel";

export let modalOpen = false;

export function showLotDetails(lot) {
    console.log("Lot data received:", lot);

    const detailsPanel = document.getElementById("lot-details");
    const modal = document.getElementById("lot-modal");
    const closeButton = document.querySelector(".lot-close");

    if (!detailsPanel || !modal) {
        console.error("Lot details panel or modal not found!");
        return;
    }

    modalOpen = true;

    modal.style.display = "flex";
    const tooltip = document.getElementById("tooltip");
    if (tooltip) tooltip.style.display = "none";

    detailsPanel.innerHTML = `
        <h3>Lot ID: ${lot.id}</h3>
        <p><strong>Name:</strong> ${lot.name}</p>
        <p><strong>Description:</strong> ${lot.description}</p>
        <p><strong>Size:</strong> ${lot.size} sqm</p>
        <p><strong>Price:</strong> ₱${lot.price}</p>
        <p><strong>Block Number:</strong> ${lot.block_id}</p>
    `;

    const rightColumn = modal.querySelector(".right-column");
    if (rightColumn) {
        const existing = rightColumn.querySelector("#house-3d-container");
        if (existing) existing.remove();
    }

    modal.classList.add("show");

    closeButton.onclick = () => {
        modal.classList.remove("show");
        // stop3DModel();
        modalOpen = false;
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.classList.remove("show");
            // stop3DModel();
            modalOpen = false;
        }
    };

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


/*     closeButton.addEventListener("click", (event) => {
        console.log("close button clicked!");
        event.stopPropagation();
        modal.style.display = "none";
        stop3DModel();
        modalOpen = false;
    });

    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            console.log("clicked outside modal, slosing...");
            event.stopPropagation();
            modal.style.display = "none";
            stop3DModel();
            modalOpen = false;
        }
    }); */

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
