const addImageBtn = document.getElementById('add-image-btn');
const addImageModal = document.getElementById('addImageModal');
const lotIdInput = document.getElementById('lot_id_input');
const addImageForm = document.getElementById('addImageForm');

addImageBtn.addEventListener('click', () => {
    // pass current lot ID dynamically
    lotIdInput.value = currentLotId; 
    addImageModal.classList.remove('tw-hidden');
});

function closeAddImageModal() {
    addImageModal.classList.add('tw-hidden');
}
window.closeAddImageModal = closeAddImageModal;

// handle AJAX upload to avoid page refresh
addImageForm.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(addImageForm);
    
    const res = await fetch('/lots/add-image', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: formData
    });
    
    if (res.ok) {
        selectedImageName.textContent = 'Upload successful!';
        closeAddImageModal();
        loadLotImages(currentLotId);
    } else {
        alert('Failed to upload image');
    }
});

const imageInput = document.getElementById('lotImageInput');
const selectedImageName = document.getElementById('selectedImageName');

/* imageInput.addEventListener('change', ()=> {
    if (imageInput.files.length > 0) {
        selectedImageName.textContent = `Selected: ${imageInput.files[0].name}`;
    } else {
        selectedImageName.textContent = '';
    }
}); */

let currentImageIndex = 0;
let currentImages = [];
const imgEl = document.getElementById('lot-image');
const imgBox = document.getElementById('lot-images-section');

const prevBtn = document.getElementById('prev-image-btn');
const nextBtn = document.getElementById('next-image-btn');
const fullscreenModal = document.getElementById('lot-image-modal');
const fullscreenImage = document.getElementById('lot-image-full');
const fullscreenPrev = document.getElementById('fullscreen-prev-btn');
const fullscreenNext = document.getElementById('fullscreen-next-btn');

// Attach navigation handlers once
if (prevBtn && nextBtn && imgEl) {
    prevBtn.onclick = () => {
        if (currentImages.length === 0) return;
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        imgEl.src = currentImages[currentImageIndex];
    };

    nextBtn.onclick = () => {
        if (currentImages.length === 0) return;
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        imgEl.src = currentImages[currentImageIndex];
    };
}

export async function loadLotImages(lotId) {
    console.log("loading images:", lotId);
    const res = await fetch(`/lots/${lotId}/images`);
    if (!res.ok) return;

    const images = await res.json();
    currentImages = images.map(img => `/storage/${img.path}`);
    currentImageIndex = 0;

    if (!imgEl) return;

    if (currentImages.length > 0) {
        imgEl.src = currentImages[0];
        imgEl.alt = `Lot Image 1 of ${currentImages.length}`;
        console.log(`Displaying image: ${imgEl.src}`);
    } else {
        imgEl.src = '';
        imgEl.alt = 'No images available';
        // console.log("No images to display for this lot");
    }
}

if (imgBox && fullscreenModal) {
    imgBox.addEventListener('click', () => {
    if (imgEl.src && imgEl.src !== window.location.href) {
        fullscreenImage.src = imgEl.src;
        fullscreenImage.alt = imgEl.alt || "No image available";
    } else {
        fullscreenImage.src = "/images/no-image.png"; 
        fullscreenImage.alt = "No image available";
    }
    fullscreenModal.classList.remove('tw-hidden');
});

}


// close fullscreen on background click
if (fullscreenModal) {
    fullscreenModal.addEventListener('click', (e) => {
        if (e.target === fullscreenModal) {
            fullscreenModal.classList.add('tw-hidden');
        }
    });
}

// fullscreen image navigation
if (fullscreenPrev && fullscreenNext && fullscreenImage) {
    fullscreenPrev.onclick = () => {
        if (currentImages.length === 0) return;
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        fullscreenImage.src = currentImages[currentImageIndex];
    };

    fullscreenNext.onclick = () => {
        if (currentImages.length === 0) return;
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        fullscreenImage.src = currentImages[currentImageIndex];
    };
}