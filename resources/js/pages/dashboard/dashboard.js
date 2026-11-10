function initializeRatingsChart() {
    const canvas = document.getElementById('ratingsChart');

    if (!canvas || typeof Chart === 'undefined') {
        return;
    }

    // Uses the existing controller-provided ratings data.
    const rawRatings = JSON.parse(canvas.dataset.ratings || '[]');

    let labels = [];
    let values = [];

    if (Array.isArray(rawRatings)) {
        labels = rawRatings.map((item, index) =>
            item.label ?? item.rating ?? `${index + 1}`
        );

        values = rawRatings.map(item =>
            Number(item.count ?? item.total ?? item.value ?? 0)
        );
    } else if (rawRatings && typeof rawRatings === 'object') {
        labels = Object.keys(rawRatings);
        values = Object.values(rawRatings).map(Number);
    }

    const styles = getComputedStyle(document.documentElement);
    const mint = styles.getPropertyValue('--lm-mint').trim() || '#06EBB6';
    const teal = styles.getPropertyValue('--lm-teal').trim() || '#1ED9D7';

    Chart.defaults.color = '#A6B6B0';
    Chart.defaults.font.family = 'inherit';

    new Chart(canvas, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Reviews',
                data: values,
                backgroundColor: [
                    'rgba(6, 235, 182, 0.45)',
                    'rgba(30, 217, 215, 0.55)',
                    'rgba(6, 235, 182, 0.65)',
                    'rgba(30, 217, 215, 0.80)',
                    mint
                ],
                borderColor: [mint, teal, mint, teal, mint],
                borderWidth: 1,
                borderRadius: 5,
                maxBarThickness: 42
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#111A16',
                    titleColor: '#FFFFFF',
                    bodyColor: '#D9E5DF',
                    borderColor: '#294238',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        color: '#A6B6B0'
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(255,255,255,0.08)'
                    },
                    border: {
                        display: false
                    },
                    ticks: {
                        precision: 0,
                        color: '#A6B6B0'
                    }
                }
            }
        }
    });
}


function initializeDashboard3D() {
    const container = document.getElementById('dashboard-map-container');
    const loading = document.getElementById('map-loading');

    if (!container) return;

    // Your existing Three.js initialization here.

    // Once the model and scene are ready:
    loading?.classList.add('hidden');
}



document.addEventListener('DOMContentLoaded', () => {
    // Initialize lightweight chart first.
    initializeRatingsChart();

    // Allow the browser to render before starting Three.js.
    requestAnimationFrame(() => {
        initializeDashboard3D();
    });
});
