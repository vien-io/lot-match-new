// edit modal
window.openEditModal = function(id, name, lotArea, floorArea, blockId, price, status, orientation, sunlight, floodRisk, images = []) {
    document.getElementById('editPropertyId').value = id;
    let lotNumber = name.replace(/Lot\s*/i, '');
    document.getElementById('editLotNumbers').value = lotNumber;
    document.getElementById('editLotArea').value = lotArea;
    document.getElementById('editFloorArea').value = floorArea;
    document.getElementById('editPrice').value = price;
    document.getElementById('editStatus').value = status;
    document.getElementById('editOrientation').value = orientation;
    document.getElementById('editBlockId').value = blockId;
    document.getElementById('editSunlight').value = sunlight;
    document.getElementById('editFloodRisk').value = floodRisk;
    document.getElementById('editPropertyForm').action = '/properties/' + id;

    // populate existing images
    const container = document.getElementById('existingImagesContainer');
    container.innerHTML = ''; // clear previous
    images.forEach(img => {
        const div = document.createElement('div');
        div.className = 'tw-relative';
        div.innerHTML = `
            <img src="${img.url}" class="tw-w-20 tw-h-20 tw-object-cover tw-rounded">
            <button type="button" class="tw-absolute tw-top-0 tw-right-0 tw-bg-red-500 tw-text-white tw-rounded-full tw-w-5 tw-h-5 tw-flex tw-items-center tw-justify-center hover:tw-bg-red-600" onclick="removeExistingImage(${img.id}, this)">×</button>
        `;
        container.appendChild(div);
    });

    document.getElementById('editPropertyModal').classList.remove('tw-hidden');
}

window.removeExistingImage = function(imageId, btn) {
    // mark the image for deletion
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'delete_images[]';
    input.value = imageId;
    document.getElementById('editPropertyForm').appendChild(input);

    // remove from UI
    btn.parentElement.remove();
}

window.closeEditModal = function() {
    document.getElementById('editPropertyModal').classList.add('tw-hidden');
}


// lot images modal
    let currentPropertyId = null;
    let currentImageIndex = 0;
    let currentImages = [];

    window.openLotImageGallery = function(propertyId, images) {
        console.log("Images received:", images);
        currentImages = images || [];
        currentPropertyId = propertyId;
        currentImageIndex = 0;
        showLotImage();
        document.getElementById('lotImageModal').classList.remove('tw-hidden');
    }

    window.closeLotImageModal = function() {
        document.getElementById('lotImageModal').classList.add('tw-hidden');
    }

    window.showLotImage = function() {
      const imgEl = document.getElementById('lotImage');
      const fallback = document.getElementById('lotImageFallback');

      if (currentImages.length > 0) {
          imgEl.src = currentImages[currentImageIndex];
          imgEl.classList.remove('tw-hidden');   
          fallback.classList.add('tw-hidden');    
      } else {
          imgEl.src = "";
          imgEl.classList.add('tw-hidden');    
          fallback.classList.remove('tw-hidden'); 
      }
    }

    window.prevLotImage = function() {
        if (!currentImages.length) return;
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        showLotImage();
    }

    window.nextLotImage = function() {
        if (!currentImages) return;
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        showLotImage();
    }