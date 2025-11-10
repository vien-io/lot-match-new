// MIGHT NOT BE USED. MIGHT BE DELETABLE

/* 
import reviewTemplate from './reviewSection.html?raw';
import { bindFormHandler } from './reviewForm.js';
import { bindEditButtons, bindDeleteButtons } from './reviewButtons.js';
import { updateForecastTimestamp } from './forecast.js';

export function renderReviewSection(block) {
    const reviewSection = document.getElementById('block-review-section');
    if (!reviewSection) return;

    // Inject HTML template and replace placeholder
    reviewSection.innerHTML = reviewTemplate.replace('{{block_id}}', block.id);

    injectStars();
    injectReviews(block.reviews ?? [], block);

    bindFormHandler(block);
    bindEditButtons(block);
    bindDeleteButtons();
    updateForecastTimestamp();
}

// Inject star rating buttons
function injectStars() {
    const starContainer = document.querySelector('.rating-stars');
    if (!starContainer) return;

    starContainer.innerHTML = [5,4,3,2,1].map(num => `
        <input type="radio" name="stars" id="st${num}" value="${num}" class="tw-hidden">
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
    `).join('');
}

// Inject reviews dynamically
function injectReviews(reviews, block) {
    const container = document.getElementById('reviews-container');
    console.log("Block here is: ", block);
    if (!container) return;

    container.innerHTML = reviews.map(review => {
        let ownerTag = '';
        const ownsBlock = Array.isArray(block?.lots)
            ? block.lots.some(lot => lot.owner_id === review.user_id)
            : false;

        if (review.role === 'owner' && ownsBlock) {
            ownerTag = `<span class="owner-tag tw-text-green-900 tw-bg-green-200 tw-rounded tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2">Owner on this block</span>`;
        } else if (review.role === 'owner') {
            ownerTag = `<span class="owner-tag tw-text-orange-900 tw-bg-orange-200 tw-rounded tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2">Owner from another block</span>`;
        }

        const showAdminButtons = window.App?.role === 'admin';
        const showOwnerButtons = window.App?.userId === review.user_id;
        const buttons = (showAdminButtons || showOwnerButtons) ? `
            <div class="tw-flex tw-gap-2 tw-mt-2">
                <button class="edit-review tw-bg-[#2a2a2a] tw-text-white tw-font-semibold tw-rounded-md tw-px-3 tw-py-1 hover:tw-bg-[#22C55E] hover:tw-text-black">Edit</button>
                <button class="delete-review tw-bg-[#2a2a2a] tw-text-white tw-font-semibold tw-rounded-md tw-px-3 tw-py-1 hover:tw-bg-[#ef4444]">Delete</button>
            </div>
        ` : '';

        return `
            <div class="review tw-bg-[#1c1c1c] tw-border tw-border-[#333] tw-rounded-lg tw-p-3 tw-shadow-sm" data-review-id="${review.id}">
                <div class="tw-flex tw-items-center tw-justify-between">
                    <div class="tw-flex tw-items-center">
                        <strong class="reviewer tw-text-white">${review.user_name}</strong>
                        ${ownerTag}
                    </div>
                    <span class="rating tw-text-[#22C55E]">${review.rating}/5 ★</span>
                </div>
                <p class="tw-text-[#bcbcbc] tw-mt-1">${review.comment}</p>
                <small class="tw-text-[#999]">${new Date(review.created_at).toLocaleString()}</small>
                ${buttons}
            </div>
        `;
    }).join('');
}
 */