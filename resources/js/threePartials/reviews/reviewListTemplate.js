// templates/reviewListTemplate.js
export function reviewListTemplate(block) {
    const reviews = block.reviews ?? [];
    const showOwnerTags = window.showOwnerTags ?? false;

    // console.log(reviews);

    // --- SORT REVIEWS ---
    const sortedReviews = reviews.sort((a, b) => {
        if (a.justCreated && !b.justCreated) return -1;
        if (!a.justCreated && b.justCreated) return 1;

        const aOwnsBlock = block.lots?.some(lot => lot.owner_id === a.user_id) ?? false;
        const bOwnsBlock = block.lots?.some(lot => lot.owner_id === b.user_id) ?? false;
        
        const getPriority = (review, ownsBlock) => {
            if (review.role === 'owner' && ownsBlock) return 3;
            if (review.role === 'owner') return 2;
            return 1;
        };

        const priorityDiff = getPriority(b, bOwnsBlock) - getPriority(a, aOwnsBlock);
        if (priorityDiff !== 0) return priorityDiff;

        return new Date(b.created_at) - new Date(a.created_at);
    });


    /* block.lots.forEach(lot => {
        console.log(lot.name, 'Owner ID:', lot.owner_id);
    }); */
    
    // --- RENDER REVIEWS ---
    return `
    <div class="tw-rounded-2xl tw-border-2 tw-border-transparent 
                tw-bg-[linear-gradient(#1c1c1c,#1c1c1c)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-px-6 tw-pb-6 tw-shadow-[0_0_20px_rgba(0,0,0,0.6)] tw-w-full">
        <div class="tw-flex tw-items-center tw-justify-between tw-mb-4 tw-mt-4">
            <h3 class="tw-text-lg tw-font-semibold tw-text-[hsl(142,71%,45%)]">Reviews</h3>

            <!-- Notice icon with tooltip -->
            <div class="tw-relative tw-group tw-cursor-pointer">
                <!-- Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5 tw-text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>

                <!-- Tooltip -->
                <div class="tw-absolute tw-right-0 tw-bottom-full tw-mb-2 tw-w-64 tw-bg-gray-100 tw-text-gray-800 tw-text-xs tw-rounded tw-p-2 tw-opacity-0 group-hover:tw-opacity-100 tw-transition-opacity tw-shadow-sm">
                    Reviews describe the overall experience within this block, including all houses on both streets.
                </div>

            </div>
        </div>



        <div id="reviews-container" class="tw-flex tw-flex-col tw-gap-3">
            ${reviews.length === 0
                ? `<p class="tw-text-[#ccc] tw-text-center tw-py-4">There are no reviews yet on this block. Be the first one!</p>`
                : sortedReviews.map(review => {
                let ownerTag = '';
                const ownsBlock = Array.isArray(block?.lots)
                    ? block.lots.some(lot => lot.owner_id === review.user_id)
                    : false;

                // console.log('Review: ', review);

                if (review.role === 'owner' && ownsBlock) {
                    ownerTag = `<span class="owner-tag tw-inline-block tw-text-green-900 tw-bg-green-200 tw-rounded tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2"
                                    style="opacity: ${showOwnerTags ? 1 : 0}; transform: scale(${showOwnerTags ? 1 : 0});">
                        Owner on this block
                    </span>`;
                } else if (review.role === 'owner') {
                    ownerTag = `<span class="owner-tag tw-inline-block tw-text-orange-900 tw-bg-orange-200 tw-rounded tw-px-1 tw-py-0.5 tw-text-xs tw-ml-2"
                                    style="opacity: ${showOwnerTags ? 1 : 0}; transform: scale(${showOwnerTags ? 1 : 0});">
                        Owner elsewhere
                    </span>`;
                }

                const isAdmin = window.App?.role === 'admin';
                const isOwner = window.App?.userId === review.user_id;
                let buttons = '';

                if (isOwner) {
                    buttons = `
                        <div class="tw-flex tw-gap-2 tw-mt-2 tw-justify-end">
                            <button class="edit-review tw-bg-[#2a2a2a] tw-text-[#ccc] tw-rounded tw-px-2 tw-py-1 tw-text-sm 
                                        tw-transition tw-transform tw-duration-150 tw-ease-in-out hover:tw-bg-[#22C55E] hover:tw-text-black hover:tw-scale-105">
                                Edit
                            </button>
                            <button class="delete-review tw-bg-[#2a2a2a] tw-text-[#ccc] tw-rounded tw-px-2 tw-py-1 tw-text-sm
                                        tw-transition tw-transform tw-duration-150 tw-ease-in-out hover:tw-bg-[#ef4444] hover:tw-scale-105">
                                Delete
                            </button>
                        </div>`;
                } else if (isAdmin) {
                    buttons = `
                        <div class="tw-flex tw-gap-2 tw-mt-2 tw-justify-end tw-items-center">
                            <button class="delete-review tw-bg-[#2a2a2a] tw-text-[#ccc] tw-rounded tw-px-2 tw-py-1 tw-text-sm
                                        tw-transition tw-transform tw-duration-150 tw-ease-in-out hover:tw-bg-[#ef4444] hover:tw-scale-105">
                                Delete
                            </button>
                        </div>`;
                }

                // --- HIGHLIGH FOR NEW REVIEWS ---
                const highlightClass = review.justCreated
                ? 'tw-border-l-4 tw-border-yellow-400 tw-bg-[#262626]'
                : 'tw-bg-[#1c1c1c]';

                return `
                <div class="review tw-border tw-border-[#333] tw-rounded-lg tw-p-3 tw-shadow-sm ${highlightClass}"
                    data-review-id="${review.id}">
                    
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <div class="tw-flex tw-items-center">
                            <strong class="reviewer tw-text-white">${review.user_name}</strong>
                            ${ownerTag}
                        </div>
                        <span class="rating tw-text-[#22C55E]">${review.rating}/5 ★</span>
                    </div>

                    <p class="tw-text-[#bcbcbc] tw-mt-1">${review.comment}</p>

                    <div class="tw-flex tw-items-center tw-justify-between tw-mt-1">
                        <small class="tw-text-[#999]">
                            ${new Date(review.created_at).toLocaleString()}
                        </small>
                        ${buttons}
                    </div>
                </div>
                `;
            }).join('')
            }
        </div>
    </div>
    `;
}
