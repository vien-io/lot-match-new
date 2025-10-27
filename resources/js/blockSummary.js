import { updateForecastTimestamp } from "./threePartials/reviewHandler";

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
        console.log("asdasdasdasda");

        if (data.forecast_updated_at) {
            updateForecastTimestamp(data.forecast_updated_at);
        }
    })
    .catch(err => {
        console.error("error loading block summary:", err);
        document.getElementById('block-summary').textContent = "Unable to load summary.";
    });

   

}