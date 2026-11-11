
import { Chart, registerables } from 'chart.js';
import 'chartjs-adapter-date-fns';

Chart.register(...registerables);

let forecastChart = null;

export function fetchForecast(blockId) {
    fetch(`/forecast/block/${blockId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error: ${response.status}`);
            }

            return response.json();
        })
        .then(data => renderForecast(data))
        .catch(error => {
            console.error('Error fetching forecast:', error);

            const forecastValue = document.getElementById('forecast-value');

            if (forecastValue) {
                forecastValue.textContent = 'Unavailable';
            }

            if (forecastChart) {
                forecastChart.destroy();
                forecastChart = null;
            }
        });
}

/* ---------- RENDER FORECAST ---------- */
function renderForecast(data) {
    const forecastDiv = document.getElementById('forecasting-data');
    const forecastValue = document.getElementById('forecast-value');
    const canvas = document.getElementById('forecastChart');

    if (!forecastDiv || !forecastValue || !canvas) {
        console.warn('Forecast elements not found in the DOM.');
        return;
    }

    // No forecast available
    if (data.forecasted_rating === null ||
        data.forecasted_rating === undefined) {

        forecastValue.textContent = 'N/A';

        if (forecastChart) {
            forecastChart.destroy();
            forecastChart = null;
        }

        return;
    }

    // Update the existing Blade element.
    forecastValue.textContent = Number(data.forecasted_rating).toFixed(2);

    // Prepare historical ratings.
    const ratings = (data.ratings ?? []).map(r => ({
        x: new Date(r.created_at),
        y: Number(r.rating)
    })).filter(r =>
        !Number.isNaN(r.x.getTime()) && Number.isFinite(r.y)
    );

    // Add forecast point 30 days after the latest rating.
    if (ratings.length > 0) {
        const lastDate = ratings[ratings.length - 1].x;
        const nextDate = new Date(lastDate);

        nextDate.setDate(nextDate.getDate() + 30);

        ratings.push({
            x: nextDate,
            y: Number(data.forecasted_rating)
        });
    } else {
        // Display the forecast even when there is no historical data.
        ratings.push({
            x: new Date(),
            y: Number(data.forecasted_rating)
        });
    }

    // Destroy previous chart before creating another one.
    if (forecastChart) {
        forecastChart.destroy();
        forecastChart = null;
    }

    const ctx = canvas.getContext('2d');

    forecastChart = createForecastChart(ctx, ratings);
}

/* ---------- CHART CONFIGURATION ---------- */
function createForecastChart(ctx, ratings) {
    return new Chart(ctx, {
        type: 'line',

        data: {
            datasets: [
                {
                    label: 'Rating Trend + Forecast',
                    data: ratings,

                    parsing: {
                        xAxisKey: 'x',
                        yAxisKey: 'y'
                    },

                    borderColor: '#06EBB6',
                    backgroundColor: 'transparent',
                    borderWidth: 2,

                    tension: 0.3,

                    pointBackgroundColor: (context) => {
                        const isForecast =
                            context.dataIndex === ratings.length - 1;

                        return isForecast ? '#06100D' : '#06EBB6';
                    },

                    pointBorderColor: '#06EBB6',

                    pointRadius: (context) =>
                        context.dataIndex === ratings.length - 1 ? 5 : 3,

                    pointHoverRadius: 6,
                    pointHitRadius: 10
                }
            ]
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            interaction: {
                intersect: false,
                mode: 'index'
            },

            layout: {
                padding: 8
            },

            plugins: {
                legend: {
                    display: false
                },

                tooltip: {
                    backgroundColor: '#06100D',
                    titleColor: '#FFFFFF',
                    bodyColor: '#E5EAE8',
                    borderColor: '#263B33',
                    borderWidth: 1,
                    padding: 10,
                    displayColors: false
                }
            },

            scales: {
                x: {
                    type: 'time',

                    time: {
                        unit: 'month'
                    },

                    title: {
                        display: true,
                        text: 'Date',
                        color: '#666666',
                        font: {
                            size: 10,
                            weight: '600'
                        }
                    },

                    grid: {
                        color: '#F0F2F1',
                        drawBorder: false
                    },

                    border: {
                        display: false
                    },

                    ticks: {
                        color: '#888888',
                        font: {
                            size: 10
                        },
                        maxRotation: 0
                    }
                },

                y: {
                    min: 1,
                    max: 5,

                    title: {
                        display: true,
                        text: 'Rating',
                        color: '#666666',
                        font: {
                            size: 10,
                            weight: '600'
                        }
                    },

                    grid: {
                        color: '#F0F2F1',
                        drawBorder: false
                    },

                    border: {
                        display: false
                    },

                    ticks: {
                        stepSize: 1,
                        color: '#888888',
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });
}
