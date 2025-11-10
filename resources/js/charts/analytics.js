/* // MIGHTVE BEEN USELESS -- DECIDE IF DELETE

import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {

    // ---------------- Destroy existing charts ----------------
    window.ratingsChartInstance?.destroy();
    window.topRatedChartInstance?.destroy();
    window.distChartInstance?.destroy();

    // ---------------- Block Ratings Chart ----------------
    const ratingsEl = document.getElementById('ratingsChart')?.getContext('2d');
    const ratingsDataEl = document.getElementById('ratings-data');

    if (ratingsEl && ratingsDataEl) {
        let delayedRatings = false;

        // Parse labels and data
        const blockLabels = JSON.parse(ratingsDataEl.dataset.blockLabels);
        const blockRatings = JSON.parse(ratingsDataEl.dataset.blockRatings);

        // Combine and sort by block number
        const combinedBlocks = blockLabels.map((label, i) => ({ block: parseInt(label), rating: blockRatings[i] }));
        combinedBlocks.sort((a, b) => a.block - b.block);

        const sortedBlockLabels = combinedBlocks.map(item => item.block);
        const sortedBlockRatings = combinedBlocks.map(item => item.rating);

        // Animation delays per block
        const blockDelays = {};
        combinedBlocks.forEach((item, i) => blockDelays[item.block] = i * 300);

        window.ratingsChartInstance = new Chart(ratingsEl, {
            type: 'bar',
            data: {
                labels: sortedBlockLabels,
                datasets: [{
                    label: 'Average Rating',
                    data: sortedBlockRatings,
                    backgroundColor: 'rgba(34,197,94,0.7)',
                    borderColor: 'rgba(34,197,94,1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: () => { delayedRatings = true; },
                    delay: (context) => {
                        if (context.type === 'data' && context.mode === 'default' && !delayedRatings) {
                            const blockNum = context.chart.data.labels[context.dataIndex];
                            return blockDelays[blockNum] + context.datasetIndex * 100;
                        }
                        return 0;
                    }
                },
                scales: { y: { beginAtZero: true, max: 5 } }
            }
        });
    }

    // ---------------- Top Rated Lots Chart ----------------
    const topRatedCtx = document.getElementById('topRatedLotsChart')?.getContext('2d');
    const topRatedDataEl = document.getElementById('top-rated-data');

    if (topRatedCtx && topRatedDataEl) {
        let delayedTopRated = false;

        // Parse names and ratings safely
        const lotNames = JSON.parse(topRatedDataEl.dataset.lotNames);
        const lotRatings = JSON.parse(topRatedDataEl.dataset.ratings);

        // Combine and sort by rating descending
        const topRatedCombined = lotNames.map((name, i) => ({ name, rating: lotRatings[i] }))
                                          .sort((a, b) => b.rating - a.rating);

        const sortedLotNames = topRatedCombined.map(item => item.name);
        const sortedLotRatings = topRatedCombined.map(item => item.rating);

        // Animation delays per lot
        const lotDelays = {};
        topRatedCombined.forEach((item, i) => lotDelays[item.name] = i * 300);

        window.topRatedChartInstance = new Chart(topRatedCtx, {
            type: 'bar',
            data: {
                labels: sortedLotNames,
                datasets: [{
                    label: 'Rating',
                    data: sortedLotRatings,
                    backgroundColor: 'rgba(253,224,71,0.7)',
                    borderColor: 'rgba(253,224,71,1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: () => { delayedTopRated = true; },
                    delay: (context) => {
                        if (context.type === 'data' && context.mode === 'default' && !delayedTopRated) {
                            const lotName = context.chart.data.labels[context.dataIndex];
                            return lotDelays[lotName] + context.datasetIndex * 100;
                        }
                        return 0;
                    }
                },
                scales: { y: { beginAtZero: true, max: 5 } }
            }
        });
    }

    // ---------------- Rating Distribution Chart ----------------
    const distCtx = document.getElementById('ratingDistributionChart')?.getContext('2d');

    if (distCtx && ratingsDataEl) {
        let delayedDist = false;

        const ratingLabels = JSON.parse(ratingsDataEl.dataset.ratingLabels);
        const ratingCounts = JSON.parse(ratingsDataEl.dataset.ratingCounts);

        window.distChartInstance = new Chart(distCtx, {
            type: 'bar',
            data: {
                labels: ratingLabels,
                datasets: [{
                    label: 'Count',
                    data: ratingCounts,
                    backgroundColor: 'rgba(59,130,246,0.7)',
                    borderColor: 'rgba(59,130,246,1)',
                    borderWidth: 1
                }]
            },
            options: {
                animation: {
                    onComplete: () => { delayedDist = true; },
                    delay: (context) => {
                        if (context.type === 'data' && context.mode === 'default' && !delayedDist) {
                            return context.dataIndex * 300 + context.datasetIndex * 100;
                        }
                        return 0;
                    }
                },
                scales: { x: { stacked: true }, y: { beginAtZero: true, stacked: true } }
            }
        });
    }
});
 */