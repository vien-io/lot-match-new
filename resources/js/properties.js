// edit modal

window.openEditModal = function(id, name, lotArea, floorArea, blockId, images = []) {
    document.getElementById('editPropertyId').value = id;
    let lotNumber = name.replace(/Lot\s*/i, '');
    document.getElementById('editLotNumbers').value = lotNumber;
    document.getElementById('editLotArea').value = lotArea;
    document.getElementById('editFloorArea').value = floorArea;
    document.getElementById('editBlockId').value = blockId;
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


// interior modal
    let currentPropertyId = null;
    let currentImageIndex = 0;
    let currentImages = [];

    window.openInteriorGallery = function(propertyId, images) {
        currentImages = images || [];
        currentPropertyId = propertyId;
        currentImageIndex = 0;
        showInteriorImage();
        document.getElementById('interiorModal').classList.remove('tw-hidden');
    }

    window.closeInteriorModal = function() {
        document.getElementById('interiorModal').classList.add('tw-hidden');
    }

    window.showInteriorImage = function() {
      const imgEl = document.getElementById('interiorImage');
      const fallback = document.getElementById('interiorFallback');

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

    window.prevInteriorImage = function() {
        if (!currentImages.length) return;
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        showInteriorImage();
    }

    window.nextInteriorImage = function() {
        if (!currentImages) return;
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        showInteriorImage();
    }