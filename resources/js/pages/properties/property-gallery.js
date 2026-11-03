// LOT IMAGE GALLERY
const lotImageModal = document.getElementById("lotImageModal");
const counter = document.getElementById("lotImageCounter");

let currentPropertyId = null;
let currentImageIndex = 0;
let currentImages = [];

// Close gallery modal when clicking backdrop
lotImageModal?.addEventListener("click", (event) => {
    if (event.target === lotImageModal) {
        closeLotImageModal();
    }
});

// OPEN GALLERY
window.openLotImageGallery = function (propertyId, images) {
    currentImages = images || [];
    currentPropertyId = propertyId;
    currentImageIndex = 0;
    showLotImage();
    document
        .getElementById("lotImageModal")
        .classList.replace("tw-hidden", "tw-flex");
};

// CLOSE GALLERY
window.closeLotImageModal = function () {
    document.getElementById("lotImageModal").classList.add("tw-hidden");
};

// DISPLAY CURRENT IMAGE
window.showLotImage = function () {
    const imgEl = document.getElementById("lotImage");
    const fallback = document.getElementById("lotImageFallback");

    if (currentImages.length > 0) {
        imgEl.src = currentImages[currentImageIndex].url;
        imgEl.classList.remove("tw-hidden");
        fallback.classList.add("tw-hidden");
    } else {
        imgEl.src = "";
        imgEl.classList.add("tw-hidden");
        fallback.classList.remove("tw-hidden");
    }

    // Update image counter
    counter.textContent = currentImages.length
        ? `${String(currentImageIndex + 1).padStart(2, "0")} / ${String(currentImages.length).padStart(2, "0")}`
        : "No images";

    renderLotImageThumbnails();
};

// PREVIOUS IMAGE
window.prevLotImage = function () {
    if (!currentImages.length) return;
    currentImageIndex =
        (currentImageIndex - 1 + currentImages.length) % currentImages.length;
    showLotImage();
};

// NEXT IMAGE
window.nextLotImage = function () {
    if (!currentImages.length) return;

    currentImageIndex = (currentImageIndex + 1) % currentImages.length;
    showLotImage();
};

// RENDER IMAGE THUMBNAILS
function renderLotImageThumbnails() {
    const container = document.getElementById("lotImageThumbnails");

    container.innerHTML = "";

    currentImages.forEach((image, index) => {
        const button = document.createElement("button");

        button.type = "button";

        button.className = `
            tw-relative
            tw-aspect-[4/3]
            tw-overflow-hidden
            tw-rounded-xl
            tw-border-2
            tw-transition-all
            ${
                index === currentImageIndex
                    ? "tw-border-[#06EBB6]"
                    : "tw-border-transparent hover:tw-border-white/30"
            }
        `;

        button.innerHTML = `
            <img
                src="${image.url}"
                alt="Property image ${index + 1}"
                class="tw-h-full tw-w-full tw-object-cover"
            >
        `;

        button.addEventListener("click", () => {
            currentImageIndex = index;

            showLotImage();
            renderLotImageThumbnails();
        });

        container.appendChild(button);
    });
}

// DELETE CURRENT IMAGE
const deleteButton = document.getElementById("deleteLotImageButton");

deleteButton?.addEventListener("click", async () => {
    const image = currentImages[currentImageIndex];

    if (!image) return;

    if (!confirm("Are you sure you want to delete this image?")) {
        return;
    }

    deleteButton.disabled = true;

    try {
        const response = await fetch(`/property-images/${image.id}`, {
            method: "DELETE",
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]',
                ).content,
                Accept: "application/json",
            },
        });

        const result = await response.json();

        if (!response.ok) {
            throw new Error(result.message || "Failed to delete image.");
        }

        // Remove deleted image from the array
        currentImages.splice(currentImageIndex, 1);

        // Adjust index if the deleted image was the last one
        if (currentImageIndex >= currentImages.length) {
            currentImageIndex = Math.max(0, currentImages.length - 1);
        }

        // Refresh gallery
        showLotImage();
    } catch (error) {
        alert(error.message);
    } finally {
        deleteButton.disabled = false;
    }
});
