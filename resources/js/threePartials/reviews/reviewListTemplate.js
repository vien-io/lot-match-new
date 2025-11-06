// templates/reviewListTemplate.js
export function reviewListTemplate(block) {
    const reviews = block.reviews ?? [];
    const showOwnerTags = window.showOwnerTags ?? false;

    return `
    <div class="tw-rounded-2xl tw-border-2 tw-border-transparent 
                tw-bg-[linear-gradient(#1c1c1c,#1c1c1c)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-px-6 tw-pb-6 tw-shadow-[0_0_20px_rgba(0,0,0,0.6)] tw-w-full">
        <h3 class="tw-text-lg tw-font-semibold tw-text-[hsl(142,71%,45%)]">Reviews</h3>

        <div id="reviews-container" class="tw-flex tw-flex-col tw-gap-3">
            ${reviews.map(review => {
                let ownerTag = '';
                const ownsBlock = Array.isArray(block?.lots)
                    ? block.lots.some(lot => lot.owner_id === review.user_id)
                    : false;

                if (review.role === 'owner' && ownsBlock) {
                    ownerTag = `<span class="owner-tag tw-inline-block tw-text-green-900 tw-bg-green-200 tw-rounded tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2"
                                    style="opacity: ${showOwnerTags ? 1 : 0}; transform: scale(${showOwnerTags ? 1 : 0});">
                        Owner on this block
                    </span>`;
                } else if (review.role === 'owner') {
                    ownerTag = `<span class="owner-tag tw-inline-block tw-text-orange-900 tw-bg-orange-200 tw-rounded tw-px-2 tw-py-0.5 tw-text-xs tw-ml-2"
                                    style="opacity: ${showOwnerTags ? 1 : 0}; transform: scale(${showOwnerTags ? 1 : 0});">
                        Owner from another block
                    </span>`;
                }

                const showAdminButtons = window.App?.role === 'admin';
                const showOwnerButtons = window.App?.userId === review.user_id;
                let buttons = '';

                if (showOwnerButtons) {
                    buttons = `
                        <div class="tw-flex tw-gap-2 tw-mt-2">
                            <button class="edit-review tw-bg-[#2a2a2a] tw-text-white tw-font-semibold tw-rounded-md tw-px-3 tw-py-1 hover:tw-bg-[#22C55E]">Edit</button>
                            <button class="delete-review tw-bg-[#2a2a2a] tw-text-white tw-font-semibold tw-rounded-md tw-px-3 tw-py-1 hover:tw-bg-[#ef4444]">Delete</button>
                        </div>`;
                } else if (showAdminButtons) {
                    buttons = `<div class="tw-flex tw-gap-2 tw-mt-2">
                        <button class="delete-review tw-bg-[#2a2a2a] tw-text-white tw-font-semibold tw-rounded-md tw-px-3 tw-py-1 hover:tw-bg-[#ef4444]">Delete</button>
                    </div>`;
                }

                return `
                <div class="review tw-bg-[#1c1c1c] tw-border tw-border-[#333] tw-rounded-lg tw-p-3 tw-shadow-sm"
                    data-review-id="${review.id}">
                    <div class="tw-flex tw-items-center tw-justify-between">
                        <div class="tw-flex tw-items-center">
                            <strong class="reviewer tw-text-white">${review.user_name}</strong>
                            ${ownerTag}
                        </div>
                        <span class="rating tw-text-[#22C55E]">${review.rating}/5 ★</span>
                    </div>
                    <p class="tw-text-[#bcbcbc] tw-mt-1">${review.comment}</p>
                    <small class="tw-text-[#999]">
                        ${new Date(review.created_at).toLocaleString()}
                    </small>
                    ${buttons}
                </div>
                `;
            }).join('')}
        </div>
    </div>
    `;
}
