export function loadBlockSummary(blockId) {
    console.log("lBS called", blockId);
    fetch(`api/forecast/db/${blockId}`)
    .then(res => {
        if (!res.ok) {
            throw new Error(`HTTP ${res.status}`);
        }
        return res.json();
    })
    .then(data => {
        console.log("Fetched: ", data);
        const summaryDiv = document.getElementById('block-summary');
        summaryDiv.textContent = data.summary || "no summary available"; 
    })
    .catch(err => {
        console.error("error loading block summary:", err);
        document.getElementById('block-summary').textContent = "Unable to load summary.";
    });

}