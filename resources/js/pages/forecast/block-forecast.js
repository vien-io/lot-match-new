
import {
    showSummaryLoading,
    showNarrativeLoading
} from './forecast-skeletons.js';

// Save the original empty states once.
const summaryDiv = document.getElementById('aiSummary');
const narrativeDiv = document.getElementById('aiForecastNarrative');

const summaryEmptyState = summaryDiv.innerHTML;
const narrativeEmptyState = narrativeDiv.innerHTML;

export async function onBlockChange(blockId) {
    const forecastDiv = document.getElementById('aiForecastRating');
    const starsDiv = document.getElementById('forecastStars');

    // Display independent loading animations.
    showSummaryLoading(summaryDiv);
    showNarrativeLoading(narrativeDiv);

    forecastDiv.textContent = '--';
    starsDiv.textContent = '☆☆☆☆☆';

    try {
        const res = await fetch(`/api/forecast/db/${blockId}`, {
            headers: { Accept: 'application/json' }
        });

        if (!res.ok) {
            throw new Error(`Forecast request failed: ${res.status}`);
        }

        const data = await res.json();
        await new Promise(resolve => setTimeout(resolve, 3000));

        console.log('Forecast data:', data);

        if (data.summary != null) {
            summaryDiv.textContent = data.summary;
        } else {
            summaryDiv.innerHTML = summaryEmptyState;
        }

        if (data.detailed_report != null) {
            narrativeDiv.textContent = data.detailed_report;
        } else {
            narrativeDiv.innerHTML = narrativeEmptyState;
        }

        if (data.forecast != null) {
            forecastDiv.textContent = data.forecast;
            // Update forecast stars here if needed.
        }

        if (data.sentiment?.length > 0) {
            // Update your sentiment chart here.
        }

        if (data.forecast_updated_at != null) {
            // Update your timestamp element here.
        }
    } catch (error) {
        console.error('Failed to load forecast:', error);

        summaryDiv.innerHTML = summaryEmptyState;
        narrativeDiv.innerHTML = narrativeEmptyState;
        forecastDiv.textContent = '--';
        starsDiv.textContent = '☆☆☆☆☆';
    }
}
