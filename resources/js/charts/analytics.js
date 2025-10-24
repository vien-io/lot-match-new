import Chart from 'chart.js/auto';

document.addEventListener('DOMContentLoaded', function() {

    // Store chart instances globally so you can destroy them later
    window.ratingsChartInstance?.destroy();
    window.topRatedChartInstance?.destroy();
    window.distChartInstance?.destroy();

    // ---------------- Block Ratings Chart ----------------
    let delayedRatings;
    const ratingsEl = document.getElementById('ratingsChart').getContext('2d');
    const ratingsDataEl = document.getElementById('ratings-data');
    const ratingsData = {
        labels: JSON.parse(ratingsDataEl.dataset.blockLabels),
        datasets: [{
            label: 'Average Rating',
            data: JSON.parse(ratingsDataEl.dataset.blockRatings),
            backgroundColor: 'rgba(34,197,94,0.7)',
            borderColor: 'rgba(34,197,94,1)',
            borderWidth: 1
        }]
    };
    window.ratingsChartInstance = new Chart(ratingsEl, {
        type: 'bar',
        data: ratingsData,
        options: {
            animation: {
                onComplete: () => { delayedRatings = true; },
                delay: (context) => {
                    let delay = 0;
                    if(context.type === 'data' && context.mode === 'default' && !delayedRatings) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                        console.log(`Bar ${context.dataIndex} delay: ${delay}ms`);
                    }
                    return delay;
                }
            },
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });

    // ---------------- Top Rated Lots Chart ----------------
    let delayedTopRated;
    const topRatedCtx = document.getElementById('topRatedLotsChart').getContext('2d');
    const topRatedDataEl = document.getElementById('top-rated-data');
    const topRatedData = {
        labels: JSON.parse(topRatedDataEl.dataset.labels),
        datasets: [{
            label: 'Rating',
            data: JSON.parse(topRatedDataEl.dataset.ratings),
            backgroundColor: 'rgba(253,224,71,0.7)',
            borderColor: 'rgba(253,224,71,1)',
            borderWidth: 1
        }]
    };
    window.topRatedChartInstance = new Chart(topRatedCtx, {
        type: 'bar',
        data: topRatedData,
        options: {
            animation: {
                onComplete: () => { delayedTopRated = true; },
                delay: (context) => {
                    let delay = 0;
                    if(context.type === 'data' && context.mode === 'default' && !delayedTopRated) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                }
            },
            scales: { y: { beginAtZero: true, max: 5 } }
        }
    });

    // ---------------- Rating Distribution Chart ----------------
    let delayedDist;
    const distCtx = document.getElementById('ratingDistributionChart').getContext('2d');
    const distData = {
        labels: JSON.parse(ratingsDataEl.dataset.ratingLabels),
        datasets: [{
            label: 'Count',
            data: JSON.parse(ratingsDataEl.dataset.ratingCounts),
            backgroundColor: 'rgba(59,130,246,0.7)',
            borderColor: 'rgba(59,130,246,1)',
            borderWidth: 1
        }]
    };
    window.distChartInstance = new Chart(distCtx, {
        type: 'bar',
        data: distData,
        options: {
            animation: {
                onComplete: () => { delayedDist = true; },
                delay: (context) => {
                    let delay = 0;
                    if(context.type === 'data' && context.mode === 'default' && !delayedDist) {
                        delay = context.dataIndex * 300 + context.datasetIndex * 100;
                    }
                    return delay;
                }
            },
            scales: { x: { stacked: true }, y: { beginAtZero: true, stacked: true } }
        }
    });
});
