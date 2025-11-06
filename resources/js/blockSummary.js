import { updateForecastTimestamp } from "./threePartials/reviews/forecast.js";

export function loadBlockSummary(blockId) {
    console.log("loadBlockSynnay");
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
        summaryDiv.textContent = data.summary || "no summary available";

        if (data.forecast_updated_at) {
            updateForecastTimestamp(data.forecast_updated_at);
        }
    })
    .catch(err => {
        console.error("error loading block summary:", err);
        document.getElementById('block-summary').textContent = "Unable to load summary.";
    });

   

}