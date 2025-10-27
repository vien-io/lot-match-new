import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "./init3dModel";
import { loadLotImages } from "../modals/addImageModal";

export let modalOpen = false;

export async function showLotDetails(lot) {
    console.log("showLotDetails called with:", lot);
    window.currentLotId = lot.id; 
    console.log("Opening modal for lot: ", currentLotId);

    const modal = document.getElementById("lot-modal");
    const closeButton = modal?.querySelector(".lot-close");
    const detailsPanel = document.getElementById("lot-details");

    // populate lot attributes dynamically
    document.getElementById("lot-size").textContent = lot.size + " sqm";
    document.getElementById("lot-floor-area").textContent = lot.floor_area ? lot.floor_area + " sqm" : "N/A";
    document.getElementById("lot-orientation").textContent = lot.orientation || "N/A";
    document.getElementById("lot-elevation").textContent = lot.elevation || "N/A";
    document.getElementById("lot-sunlight").textContent = lot.sunlight || "N/A";
    document.getElementById("lot-view").textContent = lot.view || "N/A";
    document.getElementById("lot-proximity").textContent = lot.proximity || "N/A";
    document.getElementById("lot-flood-risk").textContent = lot.flood_risk || "N/A";

    await loadLotImages(lot.id);
    window.currentLotId = lot.id;

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
        <p>
        <strong>Status:</strong> 
        <span class="${lot.status === 'sold' ? 'tw-text-red-500' : 'tw-text-green-500'}">
            ${lot.status ?? 'N/A'}
        </span>
        </p>
        <p><strong>Price:</strong> ₱${lot.price ?? 'N/A'}</p>
        <p><strong>Block Number:</strong> ${lot.block_id ?? 'N/A'}</p>
        <h5 class="tw-text-sm">Lot ID: ${lot.id}</h5>
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
    window.currentBlockId = block.id;
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


const viewFullReportBtn = document.getElementById('view-full-report-btn');
viewFullReportBtn.addEventListener('click', async () => {
    const blockId = window.currentBlockId;

    if (!blockId) return alert("Block ID not set!");

    try {
        const res = await fetch(`api/forecast/db/${blockId}`);
        if (!res.ok) throw new Error('Failed to fetch report');
        const data = await res.json();

        const modal = document.getElementById('full-report-modal');
        const contentDiv = document.getElementById('full-report-content');

        contentDiv.textContent = data.detailed_report || "No report available";
        modal.classList.remove('tw-hidden');
    } catch (err) {
        console.error(err);
        alert('Unable to load full report.');
    }
});

// Close button
document.getElementById('close-full-report').addEventListener('click', () => {
    document.getElementById('full-report-modal').classList.add('tw-hidden');
});

// Close on outside click
document.getElementById('full-report-modal').addEventListener('click', (event) => {
    if (event.target.id === 'full-report-modal') {
        event.currentTarget.classList.add('tw-hidden');
    }
});
