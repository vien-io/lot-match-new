const lotImageSection = document.getElementById("lot-images-section");
const lotImage = document.getElementById("lot-image");
const modal = document.getElementById("lot-image-modal");
const modalImage = document.getElementById("lot-image-full");

lotImageSection.addEventListener("click", () => {
    if (lotImage.src) {
        modalImage.src = lotImage.src;
        modal.classList.remove("tw-hidden");
    }
});

modal.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.classList.add("tw-hidden");
    }
});
