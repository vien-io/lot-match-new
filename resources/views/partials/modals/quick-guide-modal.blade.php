{{-- views/partials/modals/quick-guide-modal.blade.php --}}
<div id="quickGuideModal" class="tw-fixed tw-inset-0 tw-bg-black/60 tw-flex tw-items-center tw-justify-center tw-hidden z-50">
    <div class="tw-bg-gradient-to-b tw-from-white tw-to-gray-50 tw-p-6 tw-rounded-2xl tw-shadow-2xl tw-max-w-3xl tw-w-full tw-max-h-[90vh] tw-overflow-y-auto tw-ring-1 tw-ring-gray-200"
         id="quickGuideContent">
        
        <!-- Modal Header -->
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-6">
            <h2 class="tw-text-2xl tw-font-bold tw-text-gray-900 tw-tracking-tight">LotMatch 3D Map Quick Guide</h2>
            <button id="quickGuideCloseBtn" class="tw-text-red-600 hover:tw-text-red-800 tw-p-1 tw-cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="tw-space-y-8 tw-text-gray-700 tw-text-sm tw-leading-relaxed">

            <!-- Section 1 -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">1. Explore the Subdivision in 3D</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>Rotate:</strong> Click and drag the map to see different angles.</li>
                    <li><strong>Zoom:</strong> Scroll in/out to get closer to houses or see the whole block.</li>
                    <li><strong>Pan:</strong> Move the map by dragging with two fingers or right-clicking.</li>
                </ul>
                <p class="tw-italic tw-text-gray-500 mt-1">Tip: Rotate and zoom a little—it helps you understand the layout better!</p>
            </section>

            <!-- Section 2 -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">2. Understanding Blocks and Lots</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>Block markers:</strong> Colorful markers indicate each block. Hover to highlight.</li>
                    <li><strong>Lots:</strong> Houses are lined up in 3D. Hover to see them glow.</li>
                    <li><strong>Click a lot:</strong> Opens a pop-up with house images and block summaries.</li>
                    <li><strong>Click a block marker:</strong> Opens a pop-up with reviews, insights, and charts.</li>
                </ul>
            </section>

            <!-- Section 3 -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">3. Reviews & Commenting</h3>
                <p>Reviews cover the whole block, not just individual streets. You can also leave feedback or share your experience directly on individual lots or entire blocks. Here's how it works:</p>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>Hover a lot or block:</strong> Review and comment options appear.</li>
                    <li><strong>Click “Add Comment”:</strong> Opens the comment modal.</li>
                    <li><strong>Owner tags:</strong>
                        <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                            <li><em>Owner on this block:</em> Someone living in the block.</li>
                            <li><em>Owner elsewhere:</em> Someone with experience in other blocks.</li>
                        </ul>
                    </li>
                    <li><strong>Submit:</strong> Click the “Submit” button to add your comment. Your feedback appears in the block summary, and an AI-generated insight is triggered to help summarize trends for that block.</li>
                </ul>
                <p class="tw-italic tw-text-gray-500 mt-1">Tip: Hover over existing comments to see more context before posting your own.</p>
            </section>


            <!-- Section 4: Charts -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">4. Charts and Forecasts</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Simple line charts show past and predicted block ratings.</li>
                    <li>Hover over points on the chart to see exact numbers.</li>
                    <li>Charts update automatically as new reviews are added.</li>
                </ul>
            </section>

            <!-- Section 5: Quick Tips -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">5. Quick Tips</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Hover before clicking: Hovering often shows helpful info without opening pop-ups.</li>
                    <li>Click to learn more: Modals show details and summaries.</li>
                    <li>Explore every angle: Zoom and rotate—the 3D view helps you spot trends.</li>
                </ul>
            </section>

            <!-- Section 6: Troubleshooting -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">6. Troubleshooting</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Map not loading? Refresh the page or try a different browser.</li>
                    <li>3D interaction slow? Close other tabs or apps using a lot of memory.</li>
                    <li>Comment not appearing? Wait a few seconds; it updates automatically.</li>
                </ul>
            </section>

            <!-- Section 7: Quick Reference Table -->
            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2 tw-text-gray-900 border-b border-gray-200 pb-1">7. Quick Reference Table</h3>
                <div class="tw-overflow-x-auto tw-rounded-lg tw-border tw-border-gray-200">
                    <table class="tw-w-full tw-text-left tw-text-sm">
                        <thead class="tw-bg-gray-100">
                            <tr>
                                <th class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">What to Do</th>
                                <th class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">How to Do It</th>
                            </tr>
                        </thead>
                        <tbody class="tw-text-gray-700">
                            <tr class="hover:tw-bg-gray-50"><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Rotate the map</td><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Click + drag</td></tr>
                            <tr class="hover:tw-bg-gray-50"><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Zoom in/out</td><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Scroll</td></tr>
                            <tr class="hover:tw-bg-gray-50"><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Hover a block</td><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Highlight and see tooltip</td></tr>
                            <tr class="hover:tw-bg-gray-50"><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Click a lot</td><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Open lot details</td></tr>
                            <tr class="hover:tw-bg-gray-50"><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Click a block</td><td class="tw-px-3 tw-py-2 tw-border-b tw-border-gray-200">Open block details, reviews, summary</td></tr>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </div>
</div>
