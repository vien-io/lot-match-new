import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);
import 'chartjs-adapter-date-fns';
import { updateForecastTimestamp } from './reviews/forecast.js';

let forecastChart = null;

export function fetchForecast(blockId) {
    const isAdmin = document.body.getAttribute('data-is-admin') === '1';
/*     if (!isAdmin) {
        console.log("User is not an admin");
        return;
    } */


    /* fetch(`/forecast/data/${blockId}`)
        .then(response => response.json())
        .then(data => {
            renderForecast(data)
            updateForecastTimestamp(data.forecast_updated_at);
        })
        .catch(error => {
            console.error('Error fetching forecast:', error);
            document.getElementById('forecasting-data').innerHTML = `<p>Error loading forecast.</p>`;
        }); */

    fetch(`/forecast/block/${blockId}`)
    .then(response => response.json())
    .then(data => renderForecast(data))
    .catch(error => {
        console.error('Error fetching forecast:', error);
        document.getElementById('forecasting-data').innerHTML = `<p>Error loading forecast.</p>`;
    });
}



/* ---------- HELPERS ---------- */
function renderForecast(data) {
    const forecastDiv = document.getElementById('forecasting-data');
    if (!forecastDiv) {
        console.log("forecasting container not found");
        return;
    }

    if (data.forecasted_rating !== null) {
        forecastDiv.innerHTML = `
            <p><strong>Forecasted Rating:</strong> <span id="forecast-value">${data.forecasted_rating}</span></p>
            <canvas id="forecastChart" width="400" height="200"></canvas>
        `;

        const ratings = data.ratings.map(r => ({
            x: new Date(r.created_at),
            y: r.rating
        }));

        // add forecast point
        const lastDate = new Date(ratings[ratings.length - 1].x);
        const nextDate = new Date(lastDate);
        nextDate.setDate(lastDate.getDate() + 30);
        ratings.push({ x: nextDate, y: data.forecasted_rating });
        console.log('Forecasted point:', ratings[ratings.length - 1]);

        // destroy old chart if exists
        if (forecastChart && typeof forecastChart.destroy === 'function') {
            forecastChart.destroy();
        }

        const ctx = document.getElementById('forecastChart').getContext('2d');
        forecastChart = createForecastChart(ctx, ratings);

    } else {
        forecastDiv.innerHTML = `<p>No forecast available for this block.</p>`;
    }
}

function createForecastChart(ctx, ratings) {
    const gradient = ctx.createLinearGradient(0, 0, 0, ctx.canvas.height);
        gradient.addColorStop(0, 'hsla(142, 74%, 30%, 1.00)');   
        gradient.addColorStop(1, 'hsla(86, 96%, 40%, 1.00)');   

        return new Chart(ctx, {
            type: 'line',
            data: {
                datasets: [
                    {
                        label: 'Rating Trend + Forecast',
                        data: ratings,
                        parsing: { xAxisKey: 'x', yAxisKey: 'y' },
                        borderColor: gradient,
                        backgroundColor: 'transparent',
                        borderWidth: 2.5,
                        tension: 0.3,
                        pointBackgroundColor: (ctx) => {
                            const index = ctx.dataIndex;
                            return index === ratings.length - 1
                                ? 'rgba(255, 255, 255, 1)'
                                : 'hsl(142, 71%, 45%)'; 
                        },
                        pointRadius: (ctx) => ctx.dataIndex === ratings.length - 1 ? 6 : 0,
                        pointHoverRadius: (ctx) => ctx.dataIndex === ratings.length - 1 ? 8 : 0,
                        pointHitRadius: (ctx) => ctx.dataIndex === ratings.length - 1 ? 10 : 5
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        type: 'time',
                        time: { unit: 'month' },
                        title: { display: true, text: 'Date' },
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#ccc' }
                    },
                    y: {
                        suggestedMin: 1,
                        suggestedMax: 5,
                        title: { display: true, text: 'Rating' },
                        grid: { color: 'rgba(255,255,255,0.05)' },
                        ticks: { color: '#ccc' }
                    }
                },
                plugins: {
                    legend: { display: false }
                },
                responsive: false,
                maintainAspectRatio: false,
                layout: { padding: 10 }
            }
        });

}