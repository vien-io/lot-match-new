import { pollForecastStatus, updateForecastTimestamp } from './forecast.js';
import { renderReviewSection } from '../reviewHandler';
import { fetchForecast } from '../forecastHandler';

export function bindRatingLogic() {
    document.querySelectorAll('input[name="stars"]').forEach(radio => {
        radio.addEventListener('change', function () {
            document.getElementById('rating-value').value = this.value;
        });
    });
}

export function bindFormHandler(block) {
    const reviewForm = document.getElementById('block-review-form');
    const ratingInput = document.getElementById('rating-value');
    const aiPopup = document.getElementById("ai-status");
    const aiText = document.getElementById("ai-status-text");
    const aiEmoji = document.getElementById("ai-status-emoji");

    if (!reviewForm) return;

    let mainPopupTimer = null;

    function showAiPopup(message = "AI summarizing and forecasting...", emoji = "🤖", duration = 4000, isMain = false) {
        if (!aiPopup) return;

        aiText.textContent = message;
        aiEmoji.textContent = emoji;

        aiPopup.classList.remove("tw-hidden", "tw-opacity-0", "tw-translate-x-8");
        aiPopup.classList.add("tw-opacity-100", "tw-translate-x-0");

        if (isMain) {
            clearTimeout(mainPopupTimer); 
            mainPopupTimer = setTimeout(() => {
                aiPopup.classList.remove("tw-opacity-100", "tw-translate-x-0");
                aiPopup.classList.add("tw-opacity-0", "tw-translate-x-8");
                setTimeout(() => {
                    if (!aiPopup.classList.contains("tw-hidden")) {
                        aiPopup.classList.add("tw-hidden");
                        addNotification("AI is still processing your request. Please wait a moment…");
                    }
                }, 500);
            }, duration);
            return;
        }

        setTimeout(() => {
            aiPopup.classList.remove("tw-opacity-100", "tw-translate-x-0");
            aiPopup.classList.add("tw-opacity-0", "tw-translate-x-8");
            setTimeout(() => aiPopup.classList.add("tw-hidden"), 500);
        }, duration);
    }


    reviewForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        console.log('Block BEFORE submit:', structuredClone(block));

        const comment = document.getElementById('review-comment').value;
        const rating = ratingInput.value;

        if (!rating) {
            alert('Select a star rating before submitting!');
            return;
        }

        // --- cache original lots for ownsblock omputation
        const cachedLots = Array.isArray(block.lots) ? block.lots : [];

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
                // console.log("data:", data);
                const blockId = data.block?.id || data.review?.block_id;
                if (!blockId) return;

                let blockData;

                // --- use the block returned by backend if available, if not then fetch
                if (data.block) {
                    blockData = data.block;
                }
                else {
                    try {
                        const fetchRes = await fetch(`/block/${blockId}`);
                        blockData = await fetchRes.json();
                    } catch {
                        alert('Review updated but failed to fetch block');
                    }
                }
                
                blockData.lots = Array.isArray(blockData.lots) ? blockData.lots : cachedLots;
                console.log('block AFTER submit fetch:', structuredClone(blockData));

                // --- mark new review as temporary

                if (data.review) {
                    const newReview = blockData.reviews.find(r => r.id === data.review.id);
                    if (newReview) {
                        newReview.justCreated = true;
                        newReview.ownsBlock = blockData.lots?.some(lot => lot.owner_id === newReview.user_id) ?? false;
                        setTimeout(() => {
                            newReview.justCreated = false;
                            renderReviewSection(blockData);
                        }, 5000);
                    }
                }

                // render block reviews
                renderReviewSection(blockData);

                reviewForm.removeAttribute('data-editing');
                showAiPopup("AI summarizing and forecasting your review...", "🤖", 8000, true);

                if (!blockId) return;

                const done = await pollForecastStatus(blockId, 20, 2000);

                if (done) {
                    showAiPopup("AI analysis complete — summary updated.", "✨", 4000);
                    fetchForecast(blockId);
                } else {
                    showAiPopup("AI is still processing — results will appear soon.", "⏳", 4000);
                }
            } else {
                alert('Error: ' + data.message);
            }
        } catch (err) {
            console.error('Error submitting review:', err);
            alert('Something went wrong.');
        }
    });
}

export function resetReviewForm() {
    document.getElementById('review-comment').value = '';
    document.getElementById('rating-value').value = '';
    document.getElementById('review-id').value = '';
    document.querySelectorAll('input[name="stars"]').forEach(r => r.checked = false);

    const reviewForm = document.getElementById('block-review-form');
    if (reviewForm) reviewForm.removeAttribute('data-editing');
}