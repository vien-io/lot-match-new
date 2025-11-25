import './bootstrap';
import { renderBlockRatingsChart, renderRatingDistributionChart, renderTopRatedLotsChart, renderTopRatedLotsCards } from './charts/blockRatingsChart';
import Alpine from 'alpinejs';
import "@fortawesome/fontawesome-free/css/all.min.css";
import './components/lotSelector.js';
import './components/userLotForm.js';



// ====================
// SEARCH PLACEHOLDER CYCLE
// ====================
window.searchPlaceholderCycle = function() {
    return {
        current: 0,
        placeholders: [
            "Search blocks by name or number...",
            "Search lots by lot number or address...",
            "Search homeowner reviews or ratings...",
            'Try "Block A", "Lot 15", or keywords...',
            "Find properties by area or floor size...",
            'Search for comments like "quiet neighborhood"...',
            "Look up recent reviews or ratings...",
            "Search blocks with high ratings...",
            "Find lots with specific forecasts...",
            "Search for your favorite property..."
        ],
        init() {
            setInterval(() => {
                this.current = (this.current + 1) % this.placeholders.length;
            }, 5000); 
        }
    }
};


// ====================
// ALPINE.JS
// ====================
document.addEventListener('DOMContentLoaded', () => {
    window.Alpine = Alpine;
    Alpine.start();
});



// ====================
// BUTTON PRESS ANIMATION
// ====================
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".btn-primary").forEach(button => {
        button.addEventListener("mousedown", () => button.style.transform = "scale(0.9)");
        button.addEventListener("mouseup", () => button.style.transform = "scale(1)");
        button.addEventListener("mouseleave", () => button.style.transform = "scale(1)");
    });
});


// ====================
// CONDITIONAL 3D MAP INITIALIZATION
// ====================
document.addEventListener('DOMContentLoaded', async () => {
    if (window.location.pathname === "/3dmap") {
        // Dynamically import ONLY when user visits /3dmap
        const { default: initThreeJS } = await import('./three');
        initThreeJS();

        // Fetch and populate block list dynamically
        const blockList = document.getElementById("block-list");
        if (!blockList) return;

        fetch('/blocks')
            .then(response => response.json())
            .then(blocks => {
                blockList.innerHTML = ""; // Clear default list
                blocks.forEach(block => {
                    const blockItem = document.createElement("li");
                    blockItem.textContent = block.name;
                    blockItem.dataset.blockId = block.id;
                    blockItem.dataset.blockName = block.name.toLowerCase().replace(" ", ""); // Normalize name
                    blockItem.classList.add("block-item");

                    // Click event to fetch lots and move camera
                    blockItem.addEventListener("click", function () {
                        fetchLots(block.id, blockItem);
                        moveCameraToBlock(blockItem.dataset.blockName);
                    });

                    blockList.appendChild(blockItem);
                });
            })
            .catch(error => console.error("Error fetching blocks:", error));
    }
});


// ====================
// TOGGLE SIDE PANEL
// ====================
document.addEventListener("DOMContentLoaded", function () {
    const toggleBtn = document.getElementById('toggle-panel');
    if (!toggleBtn) return;

    toggleBtn.addEventListener('click', function () {
        let panel = document.getElementById('side-panel');
        if (!panel) return;

        const currentTransform = window.getComputedStyle(panel).transform;
        panel.style.transform = (currentTransform === 'matrix(1, 0, 0, 1, 0, 0)')
            ? 'translateX(-100%)'
            : 'translateX(0)';
    });
});


// ====================
// FETCH LOTS HELPER
// ====================
function fetchLots(blockId, blockItem) {
    console.log(`Fetching lots for block ID: ${blockId}`);

    document.querySelectorAll(".lots-container").forEach(container => {
        if (container.parentElement !== blockItem) {
            container.style.display = "none";
        }
    });

    let lotsContainer = blockItem.querySelector(".lots-container");
    if (!lotsContainer) {
        lotsContainer = document.createElement("ul");
        lotsContainer.classList.add("lots-container");
        blockItem.appendChild(lotsContainer);
    }

    lotsContainer.style.display = lotsContainer.style.display === "block" ? "none" : "block";
    lotsContainer.innerHTML = "<li>Loading lots...</li>";

    fetch(`/lots/${blockId}`)
        .then(response => response.json())
        .then(lots => {
            lotsContainer.innerHTML = ""; 
            if (lots.length === 0) {
                lotsContainer.innerHTML = "<li>No lots available</li>";
                return;
            }

            lots.forEach(lot => {
                const lotItem = document.createElement("li");
                lotItem.textContent = `${lot.name}`;
                lotsContainer.appendChild(lotItem);
            });
        })
        .catch(error => {
            console.error("Error fetching lots:", error);
            lotsContainer.innerHTML = "<li>Error loading lots</li>";
        });
}
// ====================
// NOTIFICATION
// ====================

window.addNotification = function (message) {
    const event = new CustomEvent('new-notification', {
        detail: {
            message,
            time: new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })
        }
    });
    window.dispatchEvent(event);
};


// ====================
// PROFILE DROPDOWN
// ====================
document.addEventListener("DOMContentLoaded", function () {
    const profileIcon = document.getElementById("profile-icon");
    const profileDropdown = document.getElementById("profile-dropdown");

    if (!profileIcon || !profileDropdown) return;

    profileIcon.addEventListener("click", function () {
        profileDropdown.style.display = profileDropdown.style.display === "block" ? "none" : "block";
    });

    document.addEventListener("click", function (event) {
        if (!profileIcon.contains(event.target) && !profileDropdown.contains(event.target)) {
            profileDropdown.style.display = "none";
        }
    });
});


// ====================
// CHART INITIALIZATION
// ====================
document.addEventListener('DOMContentLoaded', () => {
    renderBlockRatingsChart();
    renderRatingDistributionChart();
    renderTopRatedLotsChart();
    renderTopRatedLotsCards();
});


document.addEventListener('DOMContentLoaded', () => {
    const settingsModal = document.getElementById('settings-modal');
    const openBtn = document.getElementById('settings-btn');
    const closeBtn = document.getElementById('settings-close');

    if (openBtn && settingsModal) {
        openBtn.addEventListener('click', () => {
            settingsModal.classList.remove('tw-hidden');
        });
    }

    if (closeBtn && settingsModal) {
        closeBtn.addEventListener('click', () => {
            settingsModal.classList.add('tw-hidden');
        });
    }

    // Optional: click outside modal to close
    settingsModal.addEventListener('click', (e) => {
        if (e.target === settingsModal) settingsModal.classList.add('tw-hidden');
    });
});