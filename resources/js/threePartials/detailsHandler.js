import { renderReviewSection } from "./reviewHandler";
import { loadBlockSummary } from "../blockSummary";
import { init3DModel, stop3DModel } from "./init3dModel";
import { loadLotImages } from "../modals/addImageModal";

export const modalOpen = { value: false };

export function setModalOpen(state) {
    modalOpen.value = state;
}

export async function showLotDetails(lot) {
    // console.log("showLotDetails called with:", lot);
    window.currentLotId = lot.id; 

    // Determine which modal to show
    const isSold = lot.status?.toLowerCase() === "sold";
    const modalId = isSold ? "lot-sold-modal" : "lot-modal";
    const modal = document.getElementById(modalId);

    // console.log(lot.name, "Block:", lot.block_id, "Status:", lot.status);

    if (!modal) {
        console.error(`Modal ${modalId} not found!`);
        return;
    }

    const closeButton = modal.querySelector(".lot-close");
    const detailsPanel = modal.querySelector(isSold ? "#lot-details-sold" : "#lot-details");

    // Populate lot attributes
    if (isSold) {
        document.getElementById("lot-price-sold").textContent = "----";
        document.getElementById("lot-lot-area-sold").textContent = lot.lot_area + " sqm";
        document.getElementById("lot-floor-area-sold").textContent = lot.floor_area ? lot.floor_area + " sqm" : "N/A";
        document.getElementById("lot-orientation-sold").textContent = lot.orientation || "N/A";

        detailsPanel.innerHTML = `
            <p><strong>Name:</strong> ${lot.name ?? 'N/A'}</p>
            <p><strong>Block Number:</strong> ${lot.block_id ?? 'N/A'}</p>
        `;
    } else {
        const priceEl = document.getElementById("lot-price");
        priceEl.textContent = lot.price ? `₱${parseFloat(lot.price).toLocaleString()}` : "N/A";

        const statusEl = document.getElementById("lot-status");
        statusEl.innerHTML = `
            <span class="${lot.status.toLowerCase() === 'sold' ? 'tw-text-red-500' : 'tw-text-green-500'}">
                ${lot.status.charAt(0).toUpperCase() + lot.status.slice(1)}
            </span>
        `;

        document.getElementById("lot-lot-area").textContent = lot.lot_area + " sqm";
        document.getElementById("lot-floor-area").textContent = lot.floor_area ? lot.floor_area + " sqm" : "N/A";
        document.getElementById("lot-orientation").textContent = lot.orientation || "N/A";
        document.getElementById("lot-sunlight").textContent = lot.sunlight || "N/A";
        document.getElementById("lot-flood-risk").textContent = lot.flood_risk || "N/A";

        await loadLotImages(lot.id);

        detailsPanel.innerHTML = `
            <p><strong>Name:</strong> ${lot.name ?? 'N/A'}</p>
            <p><strong>Block Number:</strong> ${lot.block_id ?? 'N/A'}</p>
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
        const lots = block.lots ?? [];
        const reviews = block.reviews ?? [];

        const totalLotArea = lots.reduce((sum, lot) => sum + parseFloat(lot.lot_area || 0), 0);
        const availableLots = lots.filter(lot => lot.status === 'available').length;
        const soldLots = lots.filter(lot => lot.status === 'sold').length;
        const totalReviews = reviews.length;

        blockDetails.innerHTML = `
            <div class="tw-flex tw-flex-col tw-gap-1 tw-text-sm">
                <div class="tw-flex tw-justify-between">
                    <span>Block Number:</span>
                    <span class="tw-text-right tw-text-[#a1a1a1]">${block.id ?? 'N/A'}</span>
                </div>
                <div class="tw-flex tw-justify-between">
                    <span>Total Lots:</span>
                    <span class="tw-text-right tw-text-[#a1a1a1]">${lots.length}</span>
                </div>
                <div class="tw-flex tw-justify-between">
                    <span>Total Lot Area:</span>
                    <span class="tw-text-right tw-text-[#a1a1a1]">
                        ${totalLotArea.toFixed(2)} <span class="tw-text-[0.55rem]">sqm</span>
                    </span>

                </div>
                <div class="tw-flex tw-justify-between">
                    <span>Available Lots:</span>
                    <span class="tw-text-right tw-text-[#22C55E]">${availableLots}</span>
                </div>
                <div class="tw-flex tw-justify-between">
                    <span>Sold Lots:</span>
                    <span class="tw-text-right tw-text-[#ef4444]">${soldLots}</span>
                </div>
                <div class="tw-flex tw-justify-between">
                    <span>Total Reviews:</span>
                    <span class="tw-text-right tw-text-[#a1a1a1]">${totalReviews}</span>
                </div>
            </div>
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

        // Parse the detailed_report JSON string
        let report = null;
        if (data.detailed_report) {
            try {
                report = JSON.parse(data.detailed_report);
            } catch (err) {
                console.error('Failed to parse detailed_report:', err, data.detailed_report);
            }
        }

        if (!report) return alert('No detailed report available. Try submitting a review to trigger report generation!');

        const modal = document.getElementById('full-report-modal');
        const contentDiv = document.getElementById('full-report-content');

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
            ${report.monthly_sentiment.map(m => `
                <li class="tw-text-gray-200">
                    <span class="tw-font-medium">${m.month}</span>:
                    <span class="tw-text-gray-400 group-hover:tw-text-green-400">${m.positive} positive</span>,
                    <span class="tw-text-gray-400 group-hover:tw-text-red-400">${m.negative} negative</span>
                </li>
            `).join('')}
        </ul>
    </div>


    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#F97316] tw-mt-6">Forecast Details</h2>
        <p class="tw-mt-2 tw-text-gray-200">${report.forecast_details}</p>
    </div>

    <div class="tw-group tw-p-3 tw-rounded-xl tw-transition-colors tw-duration-300 hover:tw-bg-[#1f1f1f]">
        <h2 class="tw-text-lg tw-font-bold tw-text-white group-hover:tw-text-[#8B5CF6] tw-mt-6">Recommendations</h2>
        <ul class="tw-list-disc tw-pl-5 tw-mt-2">
            ${report.recommendations.map(r => `<li class="tw-text-gray-200">${r}</li>`).join('')}
        </ul>
    </div>
`;



        contentDiv.innerHTML = html;
        modal.classList.remove('tw-hidden');

    } catch (err) {
        console.error('Error loading report:', err);
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
