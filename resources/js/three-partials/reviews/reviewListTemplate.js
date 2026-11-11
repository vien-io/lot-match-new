
// templates/reviewListTemplate.js
export function reviewListTemplate(block) {
    const reviews = block.reviews ?? [];
    const showOwnerTags = window.showOwnerTags ?? false;

    // --- SORT REVIEWS ---
    const sortedReviews = [...reviews].sort((a, b) => {
        if (a.justCreated && !b.justCreated) return -1;
        if (!a.justCreated && b.justCreated) return 1;

        const aOwnsBlock = block.lots?.some(
            lot => lot.owner_id === a.user_id
        ) ?? false;

        const bOwnsBlock = block.lots?.some(
            lot => lot.owner_id === b.user_id
        ) ?? false;

        const getPriority = (review, ownsBlock) => {
            if (review.role === 'owner' && ownsBlock) return 3;
            if (review.role === 'owner') return 2;
            return 1;
        };

        const priorityDiff =
            getPriority(b, bOwnsBlock) - getPriority(a, aOwnsBlock);

        if (priorityDiff !== 0) return priorityDiff;

        return new Date(b.created_at) - new Date(a.created_at);
    });

    // --- RENDER REVIEWS ---
    return `
    <div class="tw-w-full tw-rounded-xl tw-border tw-border-[#E3E8E5]
                tw-bg-white tw-p-5">

        <!-- HEADER -->
        <div class="tw-flex tw-items-center tw-justify-between tw-mb-4">
            <div>
                <h3 class="tw-text-base tw-font-semibold tw-text-[#222222]">
                    Reviews
                </h3>
                <p class="tw-text-xs tw-text-[#888888] tw-mt-0.5">
                    Experiences shared by residents and visitors
                </p>
            </div>

            <!-- INFORMATION TOOLTIP -->
            <div class="tw-relative tw-group tw-cursor-help">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="tw-w-5 tw-h-5 tw-text-[#A0AAA4]
                           group-hover:tw-text-[#555555] tw-transition-colors"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        stroke-width="1.8"
                        d="M13 16h-1v-4h-1m1-4h.01M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z" />
                </svg>

                <div class="tw-absolute tw-right-0 tw-bottom-full tw-mb-2
                            tw-w-64 tw-p-3 tw-rounded-lg tw-bg-[#06100D]
                            tw-text-white tw-text-xs tw-leading-relaxed
                            tw-opacity-0 tw-invisible group-hover:tw-opacity-100
                            group-hover:tw-visible tw-transition-all
                            tw-duration-150 tw-shadow-lg tw-z-20">
                    Reviews describe the overall experience within this block,
                    including all houses on both streets.
                </div>
            </div>
        </div>

        <!-- REVIEW LIST -->
        <div id="reviews-container" class="tw-flex tw-flex-col tw-gap-3">
            ${
                reviews.length === 0
                    ? `
                        <div class="tw-flex tw-flex-col tw-items-center
                                    tw-justify-center tw-py-10 tw-text-center
                                    tw-border tw-border-dashed
                                    tw-border-[#DDE4DF] tw-rounded-lg">
                            <div class="tw-w-10 tw-h-10 tw-rounded-full
                                        tw-bg-[#F1F5F2] tw-flex tw-items-center
                                        tw-justify-center tw-mb-3">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="tw-w-5 tw-h-5 tw-text-[#89958E]"
                                    fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="1.8"
                                        d="M7 8h10M7 12h6m-8 8 3.5-3H17a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v8a3 3 0 0 0 3 3h1" />
                                </svg>
                            </div>

                            <p class="tw-text-sm tw-font-semibold
                                      tw-text-[#333333]">
                                No reviews yet
                            </p>
                            <p class="tw-text-xs tw-text-[#888888] tw-mt-1">
                                Be the first to share your experience
                                with this block.
                            </p>
                        </div>
                    `
                    : sortedReviews.map(review => {
                        let ownerTag = '';

                        const ownsBlock = Array.isArray(block?.lots)
                            ? block.lots.some(
                                lot => lot.owner_id === review.user_id
                            )
                            : false;

                        if (review.role === 'owner' && ownsBlock) {
                            ownerTag = `
                                <span class="owner-tag tw-inline-block
                                    tw-text-[10px] tw-font-semibold
                                    tw-text-[#087A5B] tw-bg-[#E6F7F1]
                                    tw-rounded-md tw-px-2 tw-py-1
                                    tw-ml-2 tw-whitespace-nowrap"
                                    style="opacity: ${showOwnerTags ? 1 : 0};
                                           transform: scale(${showOwnerTags ? 1 : 0});">
                                    Owner on this block
                                </span>
                            `;
                        } else if (review.role === 'owner') {
                            ownerTag = `
                                <span class="owner-tag tw-inline-block
                                    tw-text-[10px] tw-font-semibold
                                    tw-text-[#98651C] tw-bg-[#FFF5E5]
                                    tw-rounded-md tw-px-2 tw-py-1
                                    tw-ml-2 tw-whitespace-nowrap"
                                    style="opacity: ${showOwnerTags ? 1 : 0};
                                           transform: scale(${showOwnerTags ? 1 : 0});">
                                    Owner elsewhere
                                </span>
                            `;
                        }

                        const isAdmin = window.App?.role === 'admin';
                        const isOwner = window.App?.userId === review.user_id;

                        let buttons = '';

                        if (isOwner) {
                            buttons = `
                                <div class="tw-flex tw-items-center tw-gap-2">
                                    <button class="edit-review tw-px-3 tw-py-1.5
                                        tw-rounded-md tw-text-xs tw-font-semibold
                                        tw-text-[#444444] tw-bg-[#F2F4F3]
                                        hover:tw-bg-[#E6F7F1]
                                        hover:tw-text-[#087A5B]
                                        tw-transition-colors">
                                        Edit
                                    </button>

                                    <button class="delete-review tw-px-3 tw-py-1.5
                                        tw-rounded-md tw-text-xs tw-font-semibold
                                        tw-text-[#B54747] tw-bg-[#FDF0F0]
                                        hover:tw-bg-[#FBE0E0]
                                        tw-transition-colors">
                                        Delete
                                    </button>
                                </div>
                            `;
                        } else if (isAdmin) {
                            buttons = `
                                <div class="tw-flex tw-items-center">
                                    <button class="delete-review tw-px-3 tw-py-1.5
                                        tw-rounded-md tw-text-xs tw-font-semibold
                                        tw-text-[#B54747] tw-bg-[#FDF0F0]
                                        hover:tw-bg-[#FBE0E0]
                                        tw-transition-colors">
                                        Delete
                                    </button>
                                </div>
                            `;
                        }

                        // --- NEW REVIEW HIGHLIGHT ---
                        const highlightClass = review.justCreated
                            ? 'tw-border-[#A6E8D1] tw-bg-[#F5FCF9]'
                            : 'tw-border-[#E8ECE9] tw-bg-white';

                        return `
                            <div class="review tw-relative tw-border
                                        tw-rounded-lg tw-p-4
                                        ${highlightClass}"
                                data-review-id="${review.id}">

                                <!-- REVIEW HEADER -->
                                <div class="tw-flex tw-items-start
                                            tw-justify-between tw-gap-3">

                                    <div class="tw-flex tw-items-center
                                                tw-flex-wrap tw-min-w-0">
                                        <strong class="reviewer tw-text-sm
                                            tw-font-semibold tw-text-[#222222]">
                                            ${review.user_name}
                                        </strong>

                                        ${ownerTag}
                                    </div>

                                    <span class="rating tw-flex tw-items-center
                                        tw-gap-1 tw-text-sm tw-font-semibold
                                        tw-text-[#087A5B] tw-whitespace-nowrap">
                                        ${review.rating}/5
                                        <span class="tw-text-[#06A77D]">★</span>
                                    </span>
                                </div>

                                <!-- REVIEW COMMENT -->
                                <p class="tw-text-sm tw-leading-relaxed
                                          tw-text-[#555555] tw-mt-2
                                          tw-whitespace-pre-line">
                                    ${review.comment}
                                </p>

                                <!-- REVIEW FOOTER -->
                                <div class="tw-flex tw-items-center
                                            tw-justify-between tw-flex-wrap
                                            tw-gap-2 tw-mt-3
                                            tw-pt-3 tw-border-t
                                            tw-border-[#EEF1EF]">

                                    <small class="tw-text-[11px]
                                                  tw-text-[#929B95]">
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
