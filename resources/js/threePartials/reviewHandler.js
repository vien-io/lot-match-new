import { fetchForecast } from './forecastHandler';

export function renderReviewSection(block) {
    const reviewSection = document.getElementById('block-review-section');
    const reviews = block.reviews ?? [];

    reviewSection.innerHTML = `
        <h3>Leave a review</h3>
        <form id="block-review-form">
            <input type="hidden" name="review_id" id="review-id">
            <input type="hidden" name="block_id" value="${block.id}"> 
            <textarea id="review-comment" name="comment" rows="3" required placeholder="Type your review here"></textarea>

            <div class="container__items rating-stars">
            ${[5,4,3,2,1].map(num => `
                <input type="radio" name="stars" id="st${num}" value="${num}">
                <label for="st${num}">
                    <div class="star-stroke"><div class="star-fill"></div></div>
                    <div class="label-description" data-content="${["Excellent","Good","OK","Bad","Terrible"][5 - num]}"></div>
                </label>
            `).join('')}
            </div>

            <input type="hidden" name="rating" id="rating-value" required>
            <button class="review-submit-btn" type="submit">Submit review</button>
        </form>

        <h3>Reviews</h3>
        <div id="reviews-container">
            ${reviews.map(review => `
                <div class="review" data-review-id="${review.id}">
                    <strong>${review.user_name}</strong> - ${review.rating}/5<br>
                    <p>${review.comment}</p>
                    <small>${new Date(review.created_at).toLocaleString('en-US', {
                        year: 'numeric', month: 'long', day: 'numeric',
                        hour: 'numeric', minute: '2-digit', hour12: true
                    })}</small><br>
                    ${window.App && review.user_id === window.App.userId ? `
                        <button class="edit-review">Edit</button>
                        <button class="delete-review">Delete</button>
                    ` : ''}
                </div>
            `).join('')}
        </div>
    `;

    resetReviewForm();
    bindRatingLogic();
    bindFormHandler(block);
    bindEditButtons(block);
    bindDeleteButtons();
}

function bindRatingLogic() {
    document.querySelectorAll('input[name="stars"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('rating-value').value = this.value;
        });
    });
}

function bindFormHandler(block) {
    const reviewForm = document.getElementById('block-review-form');
    const ratingInput = document.getElementById('rating-value');

    if (!reviewForm) return;

    reviewForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const comment = document.getElementById('review-comment').value;
        const rating = ratingInput.value;

        if (!rating) {
            alert('select a star rating before submitting!');
            return;
        }

        const formData = new FormData();
        formData.append('block_id', reviewForm.querySelector('[name="block_id"]').value);
        formData.append('rating', rating);
        formData.append('comment', comment);

        try {
            const isEditing = reviewForm.hasAttribute('data-editing');
            const reviewId = document.getElementById('review-id').value;
            let url = '/block-reviews';
            let method = 'POST';

            if (isEditing && reviewId) {
                url = `/block-reviews/${reviewId}`;
                formData.append('_method', 'PUT');
            }

            const res = await fetch(url, {
                method: method,
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                credentials: 'same-origin'
            });

            if (res.status === 401) {
                window.location.href = '/login';
                return;
            }

            const data = await res.json();

            if (res.ok) {
                if (data.block) {
                    renderReviewSection(data.block);
                    fetchForecast(data.block.id);
                } else if (data.review) {
                    const blockId = data.review.block_id;
                    try {
                        const fetchRes = await fetch(`/block/${blockId}`);
                        const updatedBlock = await fetchRes.json();
                        renderReviewSection(updatedBlock);
                        fetchForecast(blockId);
                    } catch {
                        alert('review updated but failed to fetch block');
                    }
                }
                reviewForm.removeAttribute('data-editing');
            } else {
                alert('error: ' + data.message);
            }
        } catch (err) {
            console.error('err submitting review:', err);
            alert('something went wrong');
        }
    });
}

function bindEditButtons(block) {
    document.querySelectorAll('.edit-review').forEach(btn => {
        btn.addEventListener('click', function () {
            const reviewId = this.closest('.review').dataset.reviewId;
            const review = block.reviews.find(r => r.id == reviewId);

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

function bindDeleteButtons() {
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
                    resetReviewForm();
                } else {
                    alert('error deleting review');
                }
            } catch (err) {
                console.error('err deleting review:', err);
                alert('something went wrong');
            }
        });
    });
}

export function resetReviewForm() {
    document.getElementById('review-comment').value = '';
    document.getElementById('rating-value').value = '';
    document.getElementById('review-id').value = '';
    document.querySelectorAll('input[name="stars"]').forEach(r => r.checked = false);

    const reviewForm = document.getElementById('block-review-form');
    if (reviewForm) {
        reviewForm.removeAttribute('data-editing');
    }
}
