{{-- views/partials/modals/quick-guide-modal.blade.php --}}
<div id="quickGuideModal" class="tw-fixed tw-inset-0 tw-bg-black/50 tw-flex tw-items-center tw-justify-center tw-hidden">
    <div class="tw-bg-white tw-p-6 tw-rounded-xl tw-shadow-lg tw-max-w-3xl tw-w-full tw-max-h-[90vh] tw-overflow-y-auto"
         id="quickGuideContent">
        <!-- Modal Header -->
        <div class="tw-flex tw-justify-between tw-items-center tw-mb-4">
            <h2 class="tw-text-2xl tw-font-bold tw-flex tw-items-center tw-gap-2">
                <span>🏡</span> LotMatch 3D Map Quick Guide
            </h2>
            <button id="quickGuideCloseBtn" class="tw-text-red-600 hover:tw-text-red-800 tw-p-1">
            <svg xmlns="http://www.w3.org/2000/svg" class="tw-w-5 tw-h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            </button>


        </div>

        <!-- Modal Body -->
        <div class="tw-space-y-6 tw-text-gray-800 tw-text-sm">
            <p>Welcome to the LotMatch 3D Map, your interactive way to explore blocks, houses, and community feedback. This guide will help you get started in minutes.</p>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">1. Explore the Subdivision in 3D</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>Rotate:</strong> Click and drag the map to see different angles.</li>
                    <li><strong>Zoom:</strong> Scroll in/out to get closer to houses or see the whole block.</li>
                    <li><strong>Pan:</strong> Move the map by dragging with two fingers or right-clicking.</li>
                </ul>
                <p class="tw-italic tw-text-gray-600">Tip: Spend a few moments rotating and zooming — it helps you understand the layout better!</p>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">2. Understanding Blocks and Lots</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>Block markers:</strong> Colorful markers indicate each block. Hover to highlight.</li>
                    <li><strong>Lots:</strong> Houses are lined up in 3D. Hover to see them glow.</li>
                    <li><strong>Click a lot:</strong> Opens a pop-up with:
                        <ul class="tw-list-disc tw-ml-5">
                            <li>House images</li>
                            <li>Owner info (if available)</li>
                            <li>Short summary of block performance</li>
                        </ul>
                    </li>
                    <li><strong>Click a block marker:</strong> Opens a pop-up with:
                        <ul class="tw-list-disc tw-ml-5">
                            <li>Reviews from residents</li>
                            <li>AI-generated insights</li>
                            <li>Simple rating charts</li>
                        </ul>
                    </li>
                </ul>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">3. Reading Reviews</h3>
                <p>Reviews cover the whole block, not just individual streets.</p>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li><strong>“Owner on this block”</strong> → someone living there</li>
                    <li><strong>“Owner elsewhere”</strong> → someone with experience elsewhere</li>
                </ul>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">4. AI Insights</h3>
                <p>Some summaries and charts are AI-generated.</p>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Look for the AI logo near “View Full Forecast Report.”</li>
                    <li>Hover over it to read a short note: <em>“This summary is AI-generated to help you understand trends.”</em></li>
                </ul>
                <p class="tw-italic tw-text-gray-600">Tip: Use AI insights as guidance, but always consider your own judgment.</p>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">5. Charts and Forecasts</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Simple line charts show past and predicted block ratings.</li>
                    <li>Hover over points on the chart to see exact numbers.</li>
                    <li>Charts update automatically as new reviews are added.</li>
                </ul>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">6. Quick Tips</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Hover before clicking: Hovering often shows helpful info without opening pop-ups.</li>
                    <li>Click to learn more: Modals (pop-ups) show details and AI summaries.</li>
                    <li>Explore every angle: Zoom and rotate — the 3D view helps you spot trends.</li>
                    <li>Check AI info: Hover the AI icon to understand which content is AI-generated.</li>
                </ul>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">7. Troubleshooting</h3>
                <ul class="tw-list-disc tw-ml-5 tw-space-y-1">
                    <li>Map not loading? Refresh the page or try a different browser.</li>
                    <li>3D interaction slow? Close other tabs or apps using a lot of memory.</li>
                    <li>AI summary not showing? Wait a few seconds; it updates automatically.</li>
                </ul>
            </section>

            <section>
                <h3 class="tw-font-semibold tw-text-lg tw-mb-2">8. Quick Reference Table</h3>
                <div class="tw-overflow-x-auto">
                    <table class="tw-w-full tw-border tw-border-gray-300 tw-text-left tw-text-sm">
                        <thead>
                            <tr class="tw-bg-gray-100">
                                <th class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">What to Do</th>
                                <th class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">How to Do It</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Rotate the map</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Click + drag</td>
                            </tr>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Zoom in/out</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Scroll</td>
                            </tr>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Hover a block</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Highlight and see tooltip</td>
                            </tr>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Click a lot</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Open lot details</td>
                            </tr>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Click a block</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Open block details, reviews, AI summary</td>
                            </tr>
                            <tr>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">Hover AI logo</td>
                                <td class="tw-border tw-border-gray-300 tw-px-2 tw-py-1">See AI-generated note</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</div>
