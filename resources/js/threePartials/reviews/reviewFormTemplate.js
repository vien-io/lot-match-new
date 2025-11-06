// templates/reviewFormTemplate.js
export function reviewFormTemplate(block) {
    return `
    <div class="tw-rounded-2xl tw-border-2 tw-border-transparent 
                tw-bg-[linear-gradient(#1c1c1c,#1c1c1c)_padding-box,linear-gradient(145deg,transparent_35%,#e81cff,#40c9ff)_border-box]
                tw-p-6 tw-shadow-[0_0_20px_rgba(0,0,0,0.6)]">
        <h3 class="tw-text-lg tw-font-semibold tw-text-[#22C55E] tw-mb-4">Leave a Review</h3>

        <form id="block-review-form" class="tw-flex tw-flex-col tw-gap-4">
            <input type="hidden" name="review_id" id="review-id">
            <input type="hidden" name="block_id" value="${block.id}"> 

            <textarea 
                id="review-comment" 
                name="comment" 
                rows="3" 
                required 
                placeholder="Type your review here"
                class="tw-w-full tw-bg-transparent tw-border tw-border-[#414141] tw-rounded-lg tw-p-3
                       tw-text-white placeholder:tw-opacity-50 focus:tw-outline-none focus:tw-border-[#22C55E]">
            </textarea>

            <div class="rating-stars tw-flex tw-flex-row-reverse tw-gap-2 tw-justify-end tw-select-none">
                ${[5,4,3,2,1].map(num => `
                    <input type="radio" name="stars" id="st${num}" value="${num}" class="tw-hidden">
                    <label for="st${num}" class="tw-cursor-pointer">
                        <div class="tw-w-8 tw-h-8 tw-flex tw-items-center tw-justify-center tw-rounded-full
                                    tw-border tw-border-[#414141] tw-bg-[#2a2a2a]
                                    hover:tw-border-[#22C55E] hover:tw-scale-110">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="tw-w-5 tw-h-5 tw-text-[#717171]">
                                <path d="M12 17.27L18.18 21 16.54 13.97 22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                            </svg>
                        </div>
                    </label>
                `).join('')}
            </div>

            <input type="hidden" name="rating" id="rating-value" required>

            <button type="submit"
                class="review-submit-btn tw-w-1/3 tw-bg-[#313131] tw-border tw-border-[#414141]
                       tw-text-[#bcbcbc] tw-font-semibold tw-rounded-md tw-py-2 tw-transition-all
                       hover:tw-bg-[#22C55E] hover:tw-text-black active:tw-scale-95">
                Submit Review
            </button>
        </form>
    </div>
    `;
}
