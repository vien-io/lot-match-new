import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "../pages/3d-map/three/init3dModel.js";
import { loadLotImages } from "../modals/addImageModal";
import { renderLotDetails } from "../pages/3d-map/utils/lotDetailsRenderer";
import { renderLotStatus } from "../pages/3d-map/utils/lotStatusRenderer.js";
import { renderBlockDetails } from "../pages/3d-map/utils/blockDetailsRenderer.js";
import { marked } from "marked";
import DOMPurify from "dompurify";

export const modalOpen = { value: false };

export function setModalOpen(state) {
    modalOpen.value = state;
}

export async function showLotDetails(lot) {
    window.currentLotId = lot.id;

    // Determine which modal to show
    const isSold = lot.status?.toLowerCase() === "sold";
    const modalId = isSold ? "lot-sold-modal" : "lot-modal";
    const modal = document.getElementById(modalId);

    if (!modal) {
        console.error(`Modal ${modalId} not found!`);
        return;
    }

    const closeButton = modal.querySelector(".lot-close");
    const detailsPanel = modal.querySelector(
        isSold ? "#lot-details-sold" : "#lot-details",
    );

    // Populate lot attributes
    if (isSold) {
        document.getElementById("lot-price-sold").textContent = "----";
        document.getElementById("lot-lot-area-sold").textContent =
            lot.lot_area + " sqm";
        document.getElementById("lot-floor-area-sold").textContent =
            lot.floor_area ? lot.floor_area + " sqm" : "N/A";
        document.getElementById("lot-orientation-sold").textContent =
            lot.orientation || "N/A";

        renderLotDetails(detailsPanel, lot);
    } else {
        const priceEl = document.getElementById("lot-price");
        priceEl.textContent = lot.price
            ? `₱${parseFloat(lot.price).toLocaleString()}`
            : "N/A";

        const statusEl = document.getElementById("lot-status");
        renderLotStatus(statusEl, lot.status);

        document.getElementById("lot-lot-area").textContent =
            lot.lot_area + " sqm";
        document.getElementById("lot-floor-area").textContent = lot.floor_area
            ? lot.floor_area + " sqm"
            : "N/A";
        document.getElementById("lot-orientation").textContent =
            lot.orientation || "N/A";
        document.getElementById("lot-sunlight").textContent =
            lot.sunlight || "N/A";
        document.getElementById("lot-flood-risk").textContent =
            lot.flood_risk || "N/A";

        await loadLotImages(lot.id);

        detailsPanel.innerHTML = `
            <p><strong>Name:</strong> ${lot.name ?? "N/A"}</p>
            <p><strong>Block Number:</strong> ${lot.block_id ?? "N/A"}</p>
        `;

        // Cleanup right column for 3D container
        const rightColumn = modal.querySelector(".right-column");
        if (rightColumn) {
            const existing3D = rightColumn.querySelector("#house-3d-container");
            if (existing3D) existing3D.remove();
        }

        delete lot.existingReview;
        renderReviewSection(lot);
    }

    // Show modal
    setModalOpen(true);
    modal.style.display = "flex";

    // Hide tooltip
    const tooltip = document.getElementById("tooltip");
    if (tooltip) tooltip.style.display = "none";

    // Close handlers
    closeButton.onclick = () => {
        modal.style.display = "none";
        setModalOpen(false);
        console.log(`${modalId} closed via button`);
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            setModalOpen(false);
            // console.log(`${modalId} closed via outside click`);
        }
    };
}

export function showBlockDetails(block) {
    window.currentBlockId = block.id;
    // console.log("showBlockDetails called with:", block);

    const modal = document.getElementById("block-modal");
    const closeButton = modal.querySelector(".block-close");

    if (!modal) {
        console.error("Block modal not found!");
        return;
    }
    setModalOpen(true);

    modal.style.display = "flex";
    const tooltip = document.getElementById("tooltip");
    if (tooltip) tooltip.style.display = "none";

    closeButton.onclick = () => {
        modal.style.display = "none";
        // stop3DModel();
        setModalOpen(false);
        console.log("Close button clicked!");
    };

    window.onclick = (event) => {
        if (event.target === modal) {
            modal.style.display = "none";
            // stop3DModel();
            setModalOpen(false);
        }
    };

    setTimeout(() => {
        const midColumn = modal.querySelector(".mid-column");
        if (midColumn) {
            const modelContainer = midColumn.querySelector(
                "#block-3d-container",
            );

            if (block.modelUrl) {
                init3DModel(modelContainer, block.modelUrl);
            } else {
                console.error("No model URL provided for block", block);
            }
        }
    }, 50);

    renderBlockDetails(block);
    renderReviewSection(block);
    loadBlockSummary(block.id);
}

const viewFullReportBtn = document.getElementById("view-full-report-btn");

viewFullReportBtn.addEventListener("click", async () => {
    const blockId = window.currentBlockId;
    if (!blockId) return alert("Block ID not set!");

    try {
        const res = await fetch(`api/forecast/db/${blockId}`);
        if (!res.ok) throw new Error("Failed to fetch report");

        const data = await res.json();
        const report = data.detailed_report;

        if (!report) {
            return alert("No detailed report available.");
        }

        const modal = document.getElementById("full-report-modal");
        const reportContainer = document.getElementById("full-report-content");

        // Convert Markdown to HTML and sanitize
        const cleanedReport = report.replace(/^[ \t]+/gm, "").trim();

        const parsedHTML = marked.parse(cleanedReport);

        reportContainer.innerHTML = DOMPurify.sanitize(parsedHTML);

        modal.classList.remove("tw-hidden");
    } catch (err) {
        console.error("Error loading report:", err);
        alert("Unable to load full report.");
    }
});

const modal = document.getElementById("full-report-modal");

// Close on outside click
document
    .getElementById("full-report-modal")
    .addEventListener("click", (event) => {
        if (event.target.id === "full-report-modal") {
            event.currentTarget.classList.add("tw-hidden");
        }
    });

function closeFullReport() {
    modal.classList.add("tw-hidden");
}

document
    .getElementById("close-full-report")
    .addEventListener("click", closeFullReport);

document
    .getElementById("close-full-report-footer")
    .addEventListener("click", closeFullReport);
