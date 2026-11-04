import Chart from 'chart.js/auto';
import { renderBlockRatingsChart } from '../pages/analytics/block-ratings-chart.js';
import { renderRatingDistributionChart } from '../pages/analytics/rating-distribution-chart.js';

document.addEventListener('DOMContentLoaded', () => {
    renderBlockRatingsChart();
    renderRatingDistributionChart();
});

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




