document
    .getElementById("addPropertyButton")
    ?.addEventListener("click", openAddModal);

// Open Add Property Modal
function openAddModal() {
    const modal = document.getElementById("addPropertyModal");
    const form = document.getElementById("propertyForm");

    form.reset();

    form.action = "/properties";
    document.getElementById("propertyMethod").value = "POST";

    document.getElementById("propertyModalTitle").textContent = "Add Property";
    document.getElementById("propertySubmitButton").textContent =
        "Add Property";

    // Clear existing images
    document.getElementById("existingImagesContainer").innerHTML = "";

    modal.classList.replace("tw-hidden", "tw-flex");
}

// Open Edit Property Modal
window.openEditModal = function (
    id,
    name,
    lotArea,
    floorArea,
    blockId,
    price,
    status,
    orientation,
    sunlight,
    floodRisk,
    images = [],
) {
    const modal = document.getElementById("addPropertyModal");
    const form = document.getElementById("propertyForm");

    form.reset();

    // Update form action and method
    form.action = `/properties/${id}`;
    document.getElementById("propertyMethod").value = "PUT";

    // Update modal heading and button
    document.getElementById("propertyModalTitle").textContent = "Edit Property";
    document.getElementById("propertySubmitButton").textContent =
        "Save Changes";

    // Populate existing fields
    document.getElementById("addBlockId").value = blockId;

    document.getElementById("addLotNumber").value = name.replace(/Lot\s*/i, "");

    document.getElementById("addLotArea").value = lotArea;
    document.getElementById("addFloorArea").value = floorArea;
    document.getElementById("price").value = price;
    document.getElementById("addStatus").value = status;
    document.getElementById("addOrientation").value = orientation ?? "";
    document.getElementById("addSunlight").value = sunlight ?? "";
    document.getElementById("addFloodRisk").value = floodRisk ?? "";

    // Populate existing images
    const container = document.getElementById("existingImagesContainer");
    container.innerHTML = "";

    images.forEach((img) => {
        const div = document.createElement("div");
        div.className = "tw-relative";

        const image = document.createElement("img");
        image.src = img.url;
        image.alt = "Existing property image";
        image.className = "tw-h-20 tw-w-20 tw-rounded-lg tw-object-cover";

        const button = document.createElement("button");
        button.type = "button";
        button.className =
            "tw-absolute tw-right-0 tw-top-0 tw-flex tw-h-5 tw-w-5 tw-items-center tw-justify-center tw-rounded-full tw-bg-red-500 tw-text-white hover:tw-bg-red-600";
        button.textContent = "×";
        button.setAttribute("aria-label", "Remove existing image");
        button.onclick = () => removeExistingImage(img.id, button);

        div.append(image, button);
        container.appendChild(div);
    });

    modal.classList.replace("tw-hidden", "tw-flex");
};

window.removeExistingImage = function (imageId, btn) {
    // mark the image for deletion
    const input = document.createElement("input");
    input.type = "hidden";
    input.name = "delete_images[]";
    input.value = imageId;
    document.getElementById("editPropertyForm").appendChild(input);

    // remove from UI
    btn.parentElement.remove();
};

window.closeEditModal = function () {
    document.getElementById("editPropertyModal").classList.add("tw-hidden");
};

// lot images modal
let currentPropertyId = null;
let currentImageIndex = 0;
let currentImages = [];

window.openLotImageGallery = function (propertyId, images) {
    console.log("Images received:", images);
    currentImages = images || [];
    currentPropertyId = propertyId;
    currentImageIndex = 0;
    showLotImage();
    document.getElementById("lotImageModal").classList.remove("tw-hidden");
};

window.closeLotImageModal = function () {
    document.getElementById("lotImageModal").classList.add("tw-hidden");
};

window.showLotImage = function () {
    const imgEl = document.getElementById("lotImage");
    const fallback = document.getElementById("lotImageFallback");

    if (currentImages.length > 0) {
        imgEl.src = currentImages[currentImageIndex];
        imgEl.classList.remove("tw-hidden");
        fallback.classList.add("tw-hidden");
    } else {
        imgEl.src = "";
        imgEl.classList.add("tw-hidden");
        fallback.classList.remove("tw-hidden");
    }
};

window.prevLotImage = function () {
    if (!currentImages.length) return;
    currentImageIndex =
        (currentImageIndex - 1 + currentImages.length) % currentImages.length;
    showLotImage();
};

window.nextLotImage = function () {
    if (!currentImages) return;
    currentImageIndex = (currentImageIndex + 1) % currentImages.length;
    showLotImage();
};

const priceInput = document.getElementById("price");
const editPriceInput = document.getElementById("editPrice");
const editPriceError = document.getElementById("editPriceError");
const priceError = document.getElementById("priceError");

priceInput.addEventListener("input", () => {
    const value = parseFloat(priceInput.value);
    if (value > 999999999999999.99) {
        priceError.textContent = "Price is too high!";
    } else {
        priceError.textContent = "";
    }
});

editPriceInput.addEventListener("input", () => {
    const value = parseFloat(editPriceInput.value);
    if (value > 999999999999999.99) {
        editPriceError.textContent = "Price is too high!";
    } else {
        editPriceError.textContent = "";
    }
});
