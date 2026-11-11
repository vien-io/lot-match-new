import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "../pages/3d-map/three/init3dModel.js";
import { loadLotImages } from "../modals/addImageModal";
import { renderLotDetails } from "../pages/3d-map/utils/lotDetailsRenderer";
import { renderLotStatus } from "../pages/3d-map/utils/lotStatusRenderer.js";
import { renderBlockDetails } from "../pages/3d-map/utils/blockDetailsRenderer.js";

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

        // Parse the detailed_report JSON string
        let report = null;
        if (data.detailed_report) {
            try {
                report = JSON.parse(data.detailed_report);
            } catch (err) {
                console.error(
                    "Failed to parse detailed_report:",
                    err,
                    data.detailed_report,
                );
            }
        }

        if (!report)
            return alert(
                "No detailed report available. Try submitting a review to trigger report generation!",
            );

        const modal = document.getElementById("full-report-modal");
        const contentDiv = document.getElementById("full-report-content");

        const html = `
    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#FACC15] tw-mt-4">Executive Summary</h2>
        <p class="tw-mt-2 tw-text-gray-200">${report.executive_summary}</p>
    </div>

    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#3B82F6] tw-mt-6">Sentiment Trend Analysis</h2>
        <p class="tw-mt-2 tw-text-gray-200">${report.sentiment_analysis}</p>
    </div>

    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#10B981] tw-mt-6">
            Monthly Sentiment Data
        </h2>
        <ul class="tw-list-disc tw-pl-5 tw-mt-2">
            ${report.monthly_sentiment
                .map(
                    (m) => `
                <li class="tw-text-gray-200">
                    <span class="tw-font-medium">${m.month}</span>:
                    <span class="tw-text-gray-400 group-hover:tw-text-green-400">${m.positive} positive</span>,
                    <span class="tw-text-gray-400 group-hover:tw-text-red-400">${m.negative} negative</span>
                </li>
            `,
                )
                .join("")}
        </ul>
    </div>


    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#F97316] tw-mt-6">Forecast Details</h2>
        <p class="tw-mt-2 tw-text-gray-200">${report.forecast_details}</p>
    </div>

    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#8B5CF6] tw-mt-6">Recommendations</h2>
        <ul class="tw-list-disc tw-pl-5 tw-mt-2">
            ${report.recommendations.map((r) => `<li class="tw-text-gray-200">${r}</li>`).join("")}
        </ul>
    </div>
`;

        contentDiv.innerHTML = html;
        modal.classList.remove("tw-hidden");
    } catch (err) {
        console.error("Error loading report:", err);
        alert("Unable to load full report.");
    }
});

// Close button
document.getElementById("close-full-report").addEventListener("click", () => {
    document.getElementById("full-report-modal").classList.add("tw-hidden");
});

// Close on outside click
document
    .getElementById("full-report-modal")
    .addEventListener("click", (event) => {
        if (event.target.id === "full-report-modal") {
            event.currentTarget.classList.add("tw-hidden");
        }
    });
