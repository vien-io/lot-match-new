// templates/reviewListTemplate.js
export function reviewListTemplate(block) {
    const reviews = block.reviews ?? [];
    const showOwnerTags = window.showOwnerTags ?? false;

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
        <h3 class="tw-text-lg tw-font-semibold tw-text-[hsl(142,71%,45%)] tw-mt-4 tw-mb-4">Reviews</h3>

        <div id="reviews-container" class="tw-flex tw-flex-col tw-gap-3">
            ${reviews.length === 0
                ? `<p class="tw-text-[#ccc] tw-text-center tw-py-4">There are no reviews yet on this block. Be the first one!</p>`
                : sortedReviews.map(review => {
                let ownerTag = '';
                const ownsBlock = Array.isArray(block?.lots)
                    ? block.lots.some(lot => lot.owner_id === review.user_id)
                    : false;

                    /* console.log(
                        "block:", block,
                        "block_lots:", block.lots,
                        "block_reviews:", block.reviews,
                        "lot owner id:", block.lots.owner_id,
                        "review user id:", block.reviews.user_id,
                    ) */
                    // console.log(review);

                    /* console.log(
                        'Rendering review:',
                        review.user_name,
                        'role:', review.role,
                        'user_id:', review.user_id,
                        'ownsBlock:', ownsBlock,
                        'justCreated:', review.justCreated
                    ); */

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
                // console.log('Rendering review:', review.user_name, 'justCreated:', review.justCreated);


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
