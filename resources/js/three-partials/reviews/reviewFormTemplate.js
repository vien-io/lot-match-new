
// templates/reviewFormTemplate.js

export function reviewFormTemplate(block) {
    return `
    <div class="tw-bg-white tw-rounded-xl tw-border tw-border-[#E3E8E5] tw-p-5">

        <!-- Header -->
        <div class="tw-mb-5">
            <h3 class="tw-text-sm tw-font-semibold tw-text-[#222222]">
                Leave a Review
            </h3>
            <p class="tw-text-xs tw-text-[#888888] tw-mt-1">
                Share your experience with this block.
            </p>
        </div>

        <form id="block-review-form" class="tw-flex tw-flex-col tw-gap-5">

            <input type="hidden" name="review_id" id="review-id">
            <input type="hidden" name="block_id" value="${block.id}">

            <!-- Review Comment -->
            <div class="tw-flex tw-flex-col tw-gap-2">
                <label for="review-comment"
                    class="tw-text-xs tw-font-semibold tw-text-[#222222]">
                    Your Review
                </label>

                <textarea
                    id="review-comment"
                    name="comment"
                    rows="4"
                    required
                    placeholder="Write your thoughts about this block..."
                    class="tw-w-full tw-bg-[#FAFBFA] tw-border tw-border-[#E3E8E5]
                           tw-rounded-lg tw-p-3 tw-text-sm tw-text-[#222222]
                           placeholder:tw-text-[#A1A1A1] tw-resize-none
                           focus:tw-outline-none focus:tw-border-[#06EBB6]
                           focus:tw-ring-2 focus:tw-ring-[#06EBB6]/10
                           tw-transition-all">
                </textarea>

                <span class="tw-text-[10px] tw-text-[#999999] tw-text-right">
                    Your feedback helps evaluate this block.
                </span>
            </div>

            <!-- Star Rating -->
            <div class="tw-flex tw-flex-col tw-gap-2">

                <span class="tw-text-xs tw-font-semibold tw-text-[#222222]">
                    Your Rating
                </span>

                <div class="rating-stars tw-flex tw-flex-row-reverse
                    tw-justify-end tw-gap-2 tw-select-none">

                    ${[5,4,3,2,1].map(num => `
                        <input
                            type="radio"
                            name="stars"
                            id="st${num}"
                            value="${num}"
                            class="tw-hidden">

                        <label for="st${num}"
                            class="tw-cursor-pointer tw-transition-transform
                                   hover:tw-scale-110">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 24 24"
                                fill="currentColor"
                                class="tw-w-7 tw-h-7 tw-text-[#D1D5D2]
                                       tw-transition-colors">

                                <path d="M12 17.27L18.18 21 16.54 13.97
                                    22 9.24l-7.19-.61L12 2 9.19 8.63
                                    2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>

                        </label>
                    `).join('')}

                </div>

                <input type="hidden" name="rating" id="rating-value" required>

                <span class="tw-text-[11px] tw-text-[#888888]">
                    Select a rating from 1 to 5 stars.
                </span>

            </div>

            <!-- Submit -->
            <div class="tw-flex tw-justify-end tw-pt-3
                tw-border-t tw-border-[#EDF0EE]">

                <button type="submit"
                    class="review-submit-btn tw-inline-flex tw-items-center
                           tw-justify-center tw-gap-2 tw-px-5 tw-py-2.5
                           tw-bg-[#06EBB6] tw-text-[#06100D]
                           tw-text-xs tw-font-semibold tw-rounded-lg
                           hover:tw-bg-[#1ED9D7]
                           active:tw-scale-[0.98]
                           tw-transition-all">

                    Submit Review

                    <svg xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        class="tw-w-4 tw-h-4">

                        <path d="M5 12h14M13 6l6 6-6 6"/>
                    </svg>

                </button>

            </div>

        </form>
    </div>
    `;
}
