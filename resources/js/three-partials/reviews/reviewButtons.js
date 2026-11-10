import { renderReviewSection } from '../reviewHandler';

export function bindEditButtons(block) {
    document.querySelectorAll('.edit-review').forEach(btn => {
        btn.addEventListener('click', function () {
            const reviewId = this.closest('.review').dataset.reviewId;
            const review = block.reviews.find(r => String(r.id) === reviewId);
            if (!review) return console.warn('Review not found:', reviewId);

            document.getElementById('review-comment').value = review.comment;
            document.getElementById('rating-value').value = review.rating;
            document.getElementById('review-id').value = review.id;

            document.querySelectorAll('input[name="stars"]').forEach(r => {
                r.checked = (r.value == review.rating);
            });

            document.getElementById('block-review-form').setAttribute('data-editing', reviewId);
        });
    });
}

export function bindDeleteButtons() {
    document.querySelectorAll('.delete-review').forEach(btn => {
        btn.addEventListener('click', async function () {
            const reviewId = this.closest('.review').dataset.reviewId;
            if (!confirm('delete this review?')) return;

            try {
                const res = await fetch(`/block-reviews/${reviewId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin'
                });

                if (res.ok) {
                    document.querySelector(`[data-review-id="${reviewId}"]`)?.remove();
                } else {
                    alert('Error deleting review');
                }
            } catch (err) {
                console.error('Error deleting review:', err);
                alert('Something went wrong');
            }
        });
    });
}