export function bindEditButtons(block) {
    document.querySelectorAll('.edit-review').forEach(btn => {
        btn.addEventListener('click', () => {
            const reviewId = btn.closest('.review').dataset.reviewId;
            const r = block.reviews.find(r => String(r.id) === reviewId);
            if(!r) return;
            document.getElementById('review-comment').value = r.comment;
            document.getElementById('rating-value').value = r.rating;
            document.getElementById('review-id').value = r.id;
            document.getElementById('block-review-form').setAttribute('data-editing', reviewId);
        });
    });
}

export function bindDeleteButtons() {
    document.querySelectorAll('.delete-review').forEach(btn => {
        btn.addEventListener('click', async () => {
            const reviewId = btn.closest('.review').dataset.reviewId;
            if(!confirm('Delete this review?')) return;
            await fetch(`/block-reviews/${reviewId}`, { method: 'DELETE', credentials: 'same-origin' });
            document.querySelector(`[data-review-id="${reviewId}"]`)?.remove();
        });
    });
}
