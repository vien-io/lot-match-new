import { loadBlockSummary } from '../blockSummary';
import { fetchForecast } from './forecastHandler';

export function renderReviewSection(block) {
    const reviewSection = document.getElementById('block-review-section');
    const reviews = block.reviews ?? [];

    reviewSection.innerHTML = `
        <div class="tw-space-y-6">

    <!-- Leave a Review -->
    <div class="tw-rounded-2xl tw-border-2 tw-border-transparent 
                tw-bg-[linear-gradient(#1c1c1c,#1c1c1c)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-p-6 tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">

        <h3 class="tw-text-lg tw-font-semibold tw-text-[#22C55E] tw-mb-4">Leave a Review</h3>

        <form id="block-review-form" class="tw-flex tw-flex-col tw-gap-4">

            <input type="hidden" name="review_id" id="review-id">
            <input type="hidden" name="block_id" value="${block.id}"> 

            <!-- Comment Field -->
            <textarea 
                id="review-comment" 
                name="comment" 
                rows="3" 
                required 
                placeholder="Type your review here"
                class="tw-w-full tw-bg-transparent tw-border tw-border-[#414141] tw-rounded-lg tw-p-3
                       tw-text-white placeholder:tw-opacity-50 focus:tw-outline-none focus:tw-border-[#22C55E]">
            </textarea>

            <style>
                /* Star animation styling */
                .rating-stars input {
                display: none;
                }

                .rating-stars label svg {
                transition: transform 0.25s ease, color 0.25s ease;
                color: #717171;
                }

                .rating-stars label:hover svg,
                .rating-stars label:hover ~ label svg {
                color: hsl(142, 71%, 45%);
                transform: scale(1.2) rotate(-5deg);
                }

                /* when checked (clicked star or all before it) */
                .rating-stars input:checked ~ label svg {
                color: hsl(142, 71%, 45%);
                }

                /* subtle bounce animation on hover */
                .rating-stars label:hover svg {
                animation: star-pop 0.3s ease;
                }

                @keyframes star-pop {
                0% { transform: scale(1); }
                50% { transform: scale(1.3) rotate(-10deg); }
                100% { transform: scale(1.2) rotate(0deg); }
                }
            </style>

            <!-- Rating Stars -->
            <div class="rating-stars tw-flex tw-flex-row-reverse tw-gap-2 tw-justify-end tw-select-none">
            ${[5,4,3,2,1].map(num => `
                <input 
                type="radio" 
                name="stars" 
                id="st${num}" 
                value="${num}"
                class="tw-hidden">
                <label for="st${num}" class="tw-cursor-pointer tw-relative tw-transition-transform tw-duration-200">
                <div class="tw-w-8 tw-h-8 tw-flex tw-items-center tw-justify-center tw-rounded-full
                            tw-border tw-border-[#414141] tw-bg-[#2a2a2a]
                            hover:tw-border-[#22C55E] hover:tw-scale-110 tw-transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                        class="tw-w-5 tw-h-5 tw-text-[#717171] tw-transition-colors tw-duration-200">
                    <path d="M12 17.27L18.18 21 16.54 13.97 
                            22 9.24l-7.19-.61L12 2 
                            9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                </div>
                </label>
            `).join('')}
            </div>


            <input type="hidden" name="rating" id="rating-value" required>

            <!-- Submit Button -->
            <button type="submit"
                class="review-submit-btn tw-w-1/3 tw-bg-[#313131] tw-border tw-border-[#414141]
                       tw-text-[#bcbcbc] tw-font-semibold tw-rounded-md tw-py-2 tw-transition-all
                       hover:tw-bg-[#22C55E] hover:tw-text-black active:tw-scale-95">
                Submit Review
            </button>
        </form>
    </div>

    <style>
        /* --- Scrollbar Styling --- */
        #reviews-container {
        max-height: 350px;
        overflow-y: auto;
        padding-right: 5px;
        gap: 10px;
        }

        #reviews-container::-webkit-scrollbar {
        width: 8px;
        height: 8px;
        }

        #reviews-container::-webkit-scrollbar-track {
        background: hsla(220, 25%, 10%, 0.8);
        border-radius: 10px;
        }

        #reviews-container::-webkit-scrollbar-thumb {
        background: hsl(220, 30%, 20%);
        border-radius: 10px;
        border: 2px solid #888888;
        }

        #reviews-container::-webkit-scrollbar-thumb:hover {
        background: hsl(221, 61%, 68%);
        border: 2px solid #ffffff;
        }

        /* --- Individual Review Styling --- */
        .review {
        background-color: hsla(142, 71%, 45%, 0.04);
        border: 1px solid #333;
        border-radius: 10px;
        padding: 10px 15px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        font-size: 0.95rem;
        line-height: 1.4;
        transition: background-color 0.25s ease;
        }

        .review:hover {
        border-color: rgba(0, 255, 42, 0.8);
        }

        .review:not(:last-child) {
        border-bottom: 1px solid #444;
        }

        .review .reviewer {
        font-weight: bold;
        margin-bottom: 5px;
        color: #e0e0e0;
        }

        .review .rating {
        font-size: 0.85rem;
        color: hsla(177, 71%, 45%, 1.00);
        }

        .review .edit-review,
        .review .delete-review {
        background-color: #333;
        color: #fff;
        border: none;
        padding: 5px 10px;
        margin-top: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.2s ease;
        }

        .review .edit-review:hover,
        .review .delete-review:hover {
        background-color: #555;
        }
    </style>


    <!-- Reviews List -->
    <div class="tw-rounded-2xl tw-border-2 tw-border-transparent 
                tw-bg-[linear-gradient(#1c1c1c,#1c1c1c)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-px-6 tw-pb-6 tw-shadow-[0_0_20px_rgba(0,0,0,0.6)] tw-w-full tw-h-[250]">

    <h3 class="tw-text-lg tw-font-semibold tw-text-[hsl(142,71%,45%)] tw-mb-4">
        Reviews
    </h3>

    <div id="reviews-container" class="tw-flex tw-flex-col tw-gap-3">
        ${reviews.map(review => `
        <div class="review" data-review-id="${review.id}">
            <div class="tw-flex tw-items-center tw-justify-between">
            <strong class="reviewer">${review.user_name}</strong>
            <span class="rating">${review.rating}/5 ★</span>
            </div>

            <p class="tw-text-[#bcbcbc]">${review.comment}</p>

            <small class="tw-text-[#999]">
            ${new Date(review.created_at).toLocaleString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric',
                hour: 'numeric', minute: '2-digit', hour12: true
            })}
            </small>

            ${window.App && review.user_id === window.App.userId ? `
            <div class="tw-flex tw-gap-2 tw-mt-2">
                <button class="edit-review">Edit</button>
                <button class="delete-review">Delete</button>
            </div>
            ` : ''}
        </div>
        `).join('')}
    </div>
    </div>

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
    const aiPopup = document.getElementById("ai-status");
    const aiText = document.getElementById("ai-status-text");
    const aiEmoji = document.getElementById("ai-status-emoji");

    if (!reviewForm) return;

    function showAiPopup(message = "AI summarizing and forecasting...", emoji = "🤖", duration = 4000) {
        if (!aiPopup) return;

        aiText.textContent = message;
        aiEmoji.textContent = emoji;

        aiPopup.classList.remove("tw-hidden", "tw-opacity-0", "tw-translate-x-8");
        aiPopup.classList.add("tw-opacity-100", "tw-translate-x-0");

        setTimeout(() => {
            aiPopup.classList.remove("tw-opacity-100", "tw-translate-x-0");
            aiPopup.classList.add("tw-opacity-0", "tw-translate-x-8");
            setTimeout(() => aiPopup.classList.add("tw-hidden"), 500);
        }, duration);
    }

    function hideAiPopup(delay = 0) {
        if (!aiPopup) return;
        setTimeout(() => {
            aiPopup.classList.remove("tw-opacity-100", "tw-translate-x-0");
            aiPopup.classList.add("tw-opacity-0", "tw-translate-x-8");
            setTimeout(() => aiPopup.classList.add("tw-hidden"), 500);
        }, delay);
    }

    reviewForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const comment = document.getElementById('review-comment').value;
        const rating = ratingInput.value;

        if (!rating) {
            alert('Select a star rating before submitting!');
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
                formData.append('_method', 'POST');
            }

            const res = await fetch(url, {
                method,
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
                const blockId = data.block?.id || data.review?.block_id;

                if (data.block) {
                    renderReviewSection(data.block);
                } else if (blockId) {
                    try {
                        const fetchRes = await fetch(`/block/${blockId}`);
                        const updatedBlock = await fetchRes.json();
                        renderReviewSection(updatedBlock);
                    } catch {
                        alert('Review updated but failed to fetch block');
                    }
                }

                reviewForm.removeAttribute('data-editing');

                // wait for ai completion
                showAiPopup("AI summarizing and forecasting your review...", "🤖", 8000);

                if (!blockId) {
                    console.warn("No block ID found — skipping forecast polling.");
                    return;
                }
                
                const done = await pollForecastStatus(blockId, 10, 2000);

                if (done) {
                    showAiPopup("AI analysis complete — summary updated.", "✨", 4000);
                    fetchForecast(blockId);
                } else {
                    showAiPopup("AI is still processing — results will appear soon.", "⏳", 4000)
                }

            } else {
                alert('Error: ' + data.message);
                hideAiPopup(1000);
            }
        } catch (err) {
            console.error('Error submitting review:', err);
            alert('Something went wrong.');
            hideAiPopup(1000);
        }
    });
}

async function pollForecastStatus(blockId, maxAttempts = 10, delay = 2000) {
    for (let attempt = 0; attempt < maxAttempts; attempt++) {
        try {
            const res = await fetch(`/api/forecast/status/${blockId}`);
            if (res.ok) {
                const data = await res.json();
                console.log(`Attempt ${attempt + 1}: status =`, data.status); 
                
                if (data.status === 'done') {
                    console.log(`✅ Forecast job for block ${blockId} completed on attempt ${attempt + 1}`);
                    // Update the summary div immediately
                    loadBlockSummary(blockId);
                    updateForecastTimestamp();
                    return true;
                }
            } else {
                console.log(`Attempt ${attempt + 1}: HTTP error`, res.status);
            }
        } catch (err) {
            console.error(`Attempt ${attempt + 1}: fetch error`, err);
        }
        await new Promise(r => setTimeout(r, delay));
    }
    console.warn(`⚠️ Polling ended for block ${blockId}, forecast still not done after ${maxAttempts} attempts`);
    return false; 
}

function updateForecastTimestamp() {
    const timestampEl = document.getElementById('forecast-timestamp');
    if (!timestampEl) return;

    const now = new Date();
    timestampEl.dataset.updatedAt = now.getTime(); 

    const updateText = () => {
        const updatedAt = parseInt(timestampEl.dataset.updatedAt);
        if (!updatedAt) return;

        const diffMs = Date.now() - updatedAt;
        const diffSec = Math.floor(diffMs / 1000);
        let display = '';

        if (diffSec < 60) {
            display = `Updated ${diffSec}s ago`;
            timestampEl.style.color = ''; 
        } else if (diffSec < 3600) {
            display = `${Math.floor(diffSec / 60)}m ago`;
            timestampEl.style.color = diffSec >= 300 ? 'gray' : ''; 
        } else if (diffSec < 7200) { 
            display = `${Math.floor(diffSec / 3600)}h ago`;
            timestampEl.style.color = 'gray';
        } else {
            display = ''; 
        }

        timestampEl.textContent = display;
    };

    updateText();
    const interval = setInterval(() => {
        updateText();
        if (!timestampEl.textContent) clearInterval(interval);
    }, 10000);
}




function bindEditButtons(block) {
    document.querySelectorAll('.edit-review').forEach(btn => {
        btn.addEventListener('click', function () {
            const reviewId = this.closest('.review').dataset.reviewId;

            // convert to string for comparison
            const review = block.reviews.find(r => String(r.id) === reviewId);

            if (!review) {
                console.warn('Review not found for id:', reviewId);
            }

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
