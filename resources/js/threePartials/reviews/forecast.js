let forecastTimestampInterval = null;

export async function pollForecastStatus(blockId, maxAttempts=20, delay=2000){
    for(let i=0;i<maxAttempts;i++){
        try {
            const res = await fetch(`/api/forecast/status/${blockId}`);
            if(res.ok){
                const data = await res.json();
                if(data.status==='done') return true;
            }
        } catch(err){ console.error(err); }
        await new Promise(r=>setTimeout(r, delay));
    }
    return false;
}

export function updateForecastTimestamp(forecastUpdatedAt=null){
    const el = document.getElementById('forecast-timestamp');
    if(!el) return;
    el.dataset.updatedAt = forecastUpdatedAt ? new Date(forecastUpdatedAt).getTime() : Date.now();
    clearInterval(forecastTimestampInterval);
    const updateText = () => {
        const diff = Math.floor((Date.now() - el.dataset.updatedAt)/1000);
        el.textContent = diff<60? `Updated ${diff}s ago` : `${Math.floor(diff/60)}m ago`;
    };
    updateText();
    forecastTimestampInterval = setInterval(updateText, 10000);
}
