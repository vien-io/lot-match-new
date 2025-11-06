import { updateForecastTimestamp } from "./threePartials/reviews/forecast.js";

export function loadBlockSummary(blockId) {
    fetch(`api/forecast/db/${blockId}`)
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        // console.log("Fetched: ", data);
        const summaryDiv = document.getElementById('block-summary');
        summaryDiv.textContent = data.summary || "Oops! Looks like there's no summary yet. Try to trigger the AI by submitting a review! 😄";


        if (data.forecast_updated_at) {
            updateForecastTimestamp(data.forecast_updated_at);
        }
    })
    .catch(err => {
        console.error("error loading block summary:", err);
        document.getElementById('block-summary').textContent = "Unable to load summary.";
    });

   

}