
import {
    showSummaryLoading,
    showNarrativeLoading,
    showRatingLoading,
    showSentimentChartLoading
} from './forecast-skeletons.js';

// Save the original empty states once.
const summaryDiv = document.getElementById('aiSummary');
const narrativeDiv = document.getElementById('aiForecastNarrative');
const ratingCard = document.getElementById('satisfactionRatingCard');
const sentimentEmptyState = document.getElementById('sentimentChartEmptyState');

const summaryEmptyState = summaryDiv.innerHTML;
const narrativeEmptyState = narrativeDiv.innerHTML;
const ratingCardOriginalHTML = ratingCard.innerHTML;
const sentimentEmptyStateHTML = sentimentEmptyState.innerHTML;

export async function onBlockChange(blockId) {
    const forecastDiv = document.getElementById('aiForecastRating');
    const starsDiv = document.getElementById('forecastStars');

    // Display independent loading animations.
    showSummaryLoading(summaryDiv);
    showNarrativeLoading(narrativeDiv);
    showRatingLoading(ratingCard);
    showSentimentChartLoading(sentimentEmptyState);

    try {
        const res = await fetch(`/api/forecast/db/${blockId}`, {
            headers: { Accept: 'application/json' }
        });

        if (!res.ok) {
            throw new Error(`Forecast request failed: ${res.status}`);
        }

        const data = await res.json();

        // TESTING ONLY: simulate a 32-second delay.
        await new Promise(resolve => setTimeout(resolve, 32000));

        console.log('Forecast data:', data);

        // Summary
        if (data.summary != null) {
            summaryDiv.textContent = data.summary;
        } else {
            summaryDiv.innerHTML = summaryEmptyState;
        }

        // Detailed report
        if (data.detailed_report != null) {
            narrativeDiv.textContent = data.detailed_report;
        } else {
            narrativeDiv.innerHTML = narrativeEmptyState;
        }

        // Rating
        if (data.forecast != null) {
            // The loading function may have replaced the card's inner HTML.
            // Restore the original card structure before updating its values.
            ratingCard.innerHTML = ratingCardOriginalHTML;

            const updatedForecastDiv = document.getElementById('aiForecastRating');
            const updatedStarsDiv = document.getElementById('forecastStars');

            if (updatedForecastDiv) {
                updatedForecastDiv.textContent = data.forecast;
            }

            if (updatedStarsDiv) {
                // Replace this with your actual rating-to-stars logic if needed.
                updatedStarsDiv.textContent = '☆☆☆☆☆';
            }
        } else {
            ratingCard.innerHTML = ratingCardOriginalHTML;
        }

        // Sentiment chart
        if (data.sentiment?.length > 0) {
            // Hide the empty state and show the chart container.
            const chartEmptyState = document.getElementById('sentimentChartEmptyState');
            const chartContainer = document.getElementById('sentimentChartContainer');

            if (chartEmptyState) chartEmptyState.classList.add('tw-hidden');
            if (chartContainer) chartContainer.classList.remove('tw-hidden');

            // TODO: Update your Chart.js chart using data.sentiment.
        } else {
            sentimentEmptyState.innerHTML = sentimentEmptyStateHTML;
        }

        // Last updated
        if (data.forecast_updated_at != null) {
            // TODO: Update your timestamp element.
        }
    } catch (error) {
        console.error('Failed to load forecast:', error);

        summaryDiv.innerHTML = summaryEmptyState;
        narrativeDiv.innerHTML = narrativeEmptyState;
        ratingCard.innerHTML = ratingCardOriginalHTML;
        sentimentEmptyState.innerHTML = sentimentEmptyStateHTML;
    }
}
