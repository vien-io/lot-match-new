import { loadBlockSummary } from '../../blockSummary';

let forecastTimestampInterval = null;

/**
 * Poll the forecast status for a block until done or maxAttempts reached.
 * Returns true if done, false otherwise.
 */
export async function pollForecastStatus(blockId, maxAttempts = 20, delay = 2000) {
    for (let attempt = 0; attempt < maxAttempts; attempt++) {
        try {
            const res = await fetch(`/api/forecast/status/${blockId}`);
            if (res.ok) {
                const data = await res.json();
                console.log(`Attempt ${attempt + 1}: status =`, data.status); 
                
                if (data.status === 'done') {
                    console.log(`✅ Forecast job for block ${blockId} completed on attempt ${attempt + 1}`);
                    loadBlockSummary(blockId);
                    updateForecastTimestamp(data.forecast_updated_at);
                    return true;
                }
            } else {
                console.log(`Attempt ${attempt + 1}: HTTP error`, res.status);
            }
        } catch (err) {
            console.error(`Attempt ${attempt + 1}: fetch error`, err);
        }
        await new Promise(r => setTimeout(r, delay));
    }
    console.warn(`⚠️ Polling ended for block ${blockId}, forecast still not done after ${maxAttempts} attempts`);
    return false; 
}

/**
 * Update the "forecast-timestamp" element with elapsed time since last update.
 */
export function updateForecastTimestamp(forecastUpdatedAt = null) {
    const timestampEl = document.getElementById('forecast-timestamp');
    if (!timestampEl) return;

    if (forecastUpdatedAt) {
        timestampEl.dataset.updatedAt = new Date(forecastUpdatedAt).getTime();
    } else if (!timestampEl.dataset.updatedAt) {
        timestampEl.dataset.updatedAt = Date.now();
    }

    if (forecastTimestampInterval) {
        clearInterval(forecastTimestampInterval);
        forecastTimestampInterval = null;
    }

    const updateText = () => {
        const updatedAt = parseInt(timestampEl.dataset.updatedAt);
        if (!updatedAt) return;

        const diffMs = Date.now() - updatedAt;
        const diffSec = Math.floor(diffMs / 1000);
        let display = '';

        if (diffSec < 60) display = `Updated ${diffSec}s ago`;
        else if (diffSec < 3600) display = `${Math.floor(diffSec / 60)}m ago`;
        else if (diffSec < 7200) display = `${Math.floor(diffSec / 3600)}h ago`;
        else display = '';

        timestampEl.textContent = display;
        timestampEl.style.color = (diffSec >= 300) ? 'gray' : '';
    };

    updateText();
    forecastTimestampInterval = setInterval(() => {
        updateText();
        if (!timestampEl.textContent) {
            clearInterval(forecastTimestampInterval);
            forecastTimestampInterval = null;
        } 
    }, 10000);
}

// Optional: update on DOM load
if (document.readyState === "loading") {
    window.addEventListener("DOMContentLoaded", updateForecastTimestamp);
} else {
    updateForecastTimestamp();
}
