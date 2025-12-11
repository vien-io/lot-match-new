import Chart from 'chart.js/auto';

let ratingsChartInstance = null;
let topRatedChartInstance = null;
let distChartInstance = null;

// ---------------- Block Ratings Chart ----------------
export function renderBlockRatingsChart(callback) {
    const dataEl = document.getElementById('ratings-data');
    if (!dataEl) return;

    const blockIds = JSON.parse(dataEl.dataset.blockIds);
    const labels = JSON.parse(dataEl.dataset.blockLabels);
    const ratings = JSON.parse(dataEl.dataset.blockRatings);
    const reviews = JSON.parse(dataEl.dataset.blockReviews);

    const ctx = document.getElementById('ratingsChart')?.getContext('2d');
    if (!ctx) return;

    ratingsChartInstance?.destroy();

    const combined = blockIds.map((id, i) => ({ 
        id: id,
        name: labels[i], 
        rating: ratings[i], 
        review: reviews[i] 
    }));

    combined.sort((a, b) => parseInt(a.id) - parseInt(b.id));

    const sortedIds = combined.map(c => c.id);
    const sortedRatings = combined.map(c => c.rating);
    const sortedReviews = combined.map(c => c.review);

    const delays = {};
    sortedIds.forEach((b, i) => { delays[b] = i * 300; });

    ratingsChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sortedIds,
            datasets: [
                { label: 'Average Rating', data: sortedRatings, yAxisID: 'y', backgroundColor: 'rgba(75, 192, 192, 0.6)', borderColor: 'rgba(75, 192, 192, 1)', borderWidth: 1 },
                { label: 'Number of Reviews', data: sortedReviews, yAxisID: 'y1', backgroundColor: 'rgba(255, 159, 64, 0.6)', borderColor: 'rgba(255, 159, 64, 1)', borderWidth: 1 }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        title: function(context) {
                            const index = context[0].dataIndex;
                            return `Block ${sortedIds[index]}`;
                        }
                    }
                }
            },
            animation: {
                delay: (ctx) => ctx.type === 'data' && ctx.mode === 'default' ? delays[ctx.chart.data.labels[ctx.dataIndex]] || 0 : 0,
                onComplete: () => { if (callback) callback(); }  
            },
            scales: {
                x: {
                    title: {
                        display: true,
                        text: 'Blocks',
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    }
                },
                y: { beginAtZero: true, min: 0, max: 5, title: { display: true, text: 'Average Rating' } },
                y1: { beginAtZero: true, position: 'right', title: { display: true, text: 'Number of Reviews' }, grid: { drawOnChartArea: false } }
            }
        }
    });
}

// ---------------- Top Rated Lots Chart ----------------
/* export function renderTopRatedLotsChart(callback) {
    const dataEl = document.getElementById('top-rated-data');
    if (!dataEl) return;

    const lotNames = JSON.parse(dataEl.dataset.lotNames);
    const ratings = JSON.parse(dataEl.dataset.ratings);

    const ctx = document.getElementById('topRatedLotsChart')?.getContext('2d');
    if (!ctx) return;

    topRatedChartInstance?.destroy();

    const combined = lotNames.map((name, i) => ({ name, rating: ratings[i] }))
                             .sort((a, b) => b.rating - a.rating);

    const sortedNames = combined.map(c => c.name);
    const sortedRatings = combined.map(c => c.rating);

    const delays = {};
    sortedNames.forEach((name, i) => { delays[name] = i * 300; });

    topRatedChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sortedNames,
            datasets: [{
                label: 'Average Rating',
                data: sortedRatings,
                backgroundColor: sortedRatings.map((r, i) => i === 0 ? 'rgba(255,99,99,0.6)' : 'rgba(255,99,132,0.6)'),
                borderColor: sortedRatings.map((r, i) => i === 0 ? 'rgb(222,71,71)' : 'rgba(255,99,132,1)'),
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                delay: (ctx) => ctx.type === 'data' && ctx.mode === 'default' ? delays[ctx.chart.data.labels[ctx.dataIndex]] || 0 : 0,
                onComplete: () => { if (callback) callback(); }  // call next chart
            },
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Top 5 Highest Rated Lots' }
            },
            scales: {
                x: { beginAtZero: true, max: 5, title: { display: true, text: 'Average Rating' } },
                y: { title: { display: true, text: 'Lot Name' } }
            }
        }
    });
} */


// ---------------- Top Rated Blocks Chart ----------------
export function renderTopRatedBlocksChart(callback) {
    const dataEl = document.getElementById('top-rated-blocks-data');
    if (!dataEl) return;

    const blockNames = JSON.parse(dataEl.dataset.blockNames);
    // console.log(dataEl.dataset.rate);
    const ratings = JSON.parse(dataEl.dataset.blockRate);

    const ctx = document.getElementById('topRatedBlocksChart')?.getContext('2d');
    if (!ctx) return;

    topRatedChartInstance?.destroy();

    const combined = blockNames.map((name, i) => ({
        name,
        rating: ratings[i]
    })).sort((a, b) => b.rating - a.rating);

    const sortedNames = combined.map(c => c.name);
    const sortedRatings = combined.map(c => c.rating);

    const delays = {};
    sortedNames.forEach((name, i) => { delays[name] = i * 300; });

    topRatedChartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: sortedNames,
            datasets: [{
                label: 'Average Rating',
                data: sortedRatings,
                backgroundColor: sortedRatings.map((r, i) =>
                    i === 0 ? 'rgba(255,99,99,0.6)' : 'rgba(255,99,132,0.6)'
                ),
                borderColor: sortedRatings.map((r, i) =>
                    i === 0 ? 'rgb(222,71,71)' : 'rgba(255,99,132,1)'
                ),
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                delay: (ctx) => (
                    ctx.type === 'data' &&
                    ctx.mode === 'default'
                ) ? delays[ctx.chart.data.labels[ctx.dataIndex]] || 0 : 0,
                onComplete: () => { if (callback) callback(); }
            },
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                    text: 'Top 5 Highest Rated Blocks'
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    max: 5,
                    title: { display: true, text: 'Average Rating' }
                },
                y: {
                    title: { display: true, text: 'Block Name' }
                }
            }
        }
    });
}


// ---------------- Rating Distribution Chart ----------------
export function renderRatingDistributionChart() {
    const dataEl = document.getElementById('ratings-data');
    if (!dataEl) return;

    const labels = JSON.parse(dataEl.dataset.ratingLabels);
    const counts = JSON.parse(dataEl.dataset.ratingCounts);

    const ctx = document.getElementById('ratingDistributionChart')?.getContext('2d');
    if (!ctx) return;

    distChartInstance?.destroy();

    const delays = {};
    labels.forEach((r, i) => { delays[r] = i * 300; });

    const backgroundColors = ['#FF6384','#FF9F40','#FFCD56','#4BC0C0','#36A2EB'];

    distChartInstance = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels.map(l => `${l}-Star`),
            datasets: [{ label: 'Rating Distribution', data: counts, backgroundColor: backgroundColors, borderWidth: 1, hoverOffset: 20 }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                animateRotate: true,
                animateScale: true,
                delay: (ctx) => ctx.type === 'data' && ctx.mode === 'default' ? delays[labels[ctx.dataIndex]] || 0 : 0
            },
            plugins: {
                legend: { position: 'bottom', labels: { boxWidth: 20, padding: 15 } },
                tooltip: { callbacks: { label: (tooltipItem) => `${tooltipItem.label}: ${tooltipItem.raw} reviews` } }
            }
        }
    });
}

// ---------------- Initialize in Sequence ----------------
/* document.addEventListener('DOMContentLoaded', () => {
    renderBlockRatingsChart(() => {
        renderTopRatedLotsChart(() => {
            renderRatingDistributionChart();  
        });
    });
}); */



export function renderTopRatedLotsCards() {
    const dataElement = document.getElementById('top-rated-data');
    if (!dataElement) return;

    const labels = JSON.parse(dataElement.dataset.labels); 
    const ratings = JSON.parse(dataElement.dataset.ratings); 

    const container = document.getElementById('top-rated-lots');
    if (!container) return;

    container.innerHTML = '';

    labels.forEach((label, index) => {
     
        const card = document.createElement('div');
        card.classList.add('card');

        // Fill card content
        card.innerHTML = `
            <h4>Lot ID: ${label}</h4>
            <p>Average Rating: ${ratings[index].toFixed(2)}</p>
        `;

       
        container.appendChild(card);
    });
}


document.addEventListener('DOMContentLoaded', () => {
    renderTopRatedLotsCards();
});




