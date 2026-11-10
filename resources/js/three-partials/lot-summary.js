export function loadLotSummary(lotId) {
    const summaryDiv = document.getElementById('lot-summary-text');
    summaryDiv.innerHTML = 'Loading AI summary...';

    fetch(`/lot/${lotId}/summary`)
        .then(res => res.json())
        .then(data => {
            if (data.summary) {
                displayLotSummary(data.summary);
            } else {
                summaryDiv.innerHTML = '<p>No summary available.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            summaryDiv.innerHTML = '<p>Failed to load AI summary.</p>';
        });
}

function highlightKeywords(text) {
    const keywords = {
        welcoming: 'tw-text-[#a3ffce] tw-font-semibold tw-text-glow',
        charming: 'tw-text-[#84ffb1] tw-font-medium tw-text-glow',
        spacious: 'tw-text-[#84ffb1] tw-font-medium tw-text-glow',
        serene: 'tw-text-[#a3ffce] tw-font-medium tw-text-glow',
        peaceful: 'tw-text-[#9affbf] tw-font-semibold tw-text-glow',
        ideal: 'tw-text-[#84ffb1] tw-font-medium',
        cozy: 'tw-text-[#a3ffce] tw-font-medium',
        bright: 'tw-text-[#a3ffce] tw-font-medium tw-text-glow',
        beautiful: 'tw-text-[#84ffb1]',
        elegant: 'tw-text-[#a3ffce]',
        modern: 'tw-text-[#b1ffe0]',
        perfect: 'tw-text-[#9affbf] tw-font-semibold',
        family: 'tw-text-[#84ffb1] tw-font-medium',
        opportunity: 'tw-text-[#84ffb1] tw-font-semibold tw-text-glow',
        paradise: 'tw-text-[#84ffb1] tw-font-semibold tw-text-glow',
        private: 'tw-text-[#84ffb1]',
        vibrant: 'tw-text-[#9affbf]',
        dream: 'tw-text-[#a3ffce] tw-font-medium tw-text-glow',
        home: 'tw-text-[#84ffb1] tw-font-medium',
        thrive: 'tw-text-[#9affbf] tw-font-semibold',
        generous: 'tw-text-[#84ffb1]',
        sunlight: 'tw-text-[#a3ffce] tw-font-medium',
        low: 'tw-text-[#a3ffce]',
        risk: 'tw-text-[#ffb184] tw-font-medium'
    };

    let html = text;
    let highlightCount = 0;

    for (const [word, classes] of Object.entries(keywords)) {
        if (highlightCount >= 3) break; 

        const regex = new RegExp(`\\b(${word})\\b`, 'i'); 
        const match = html.match(regex);

        if (match) {
            html = html.replace(regex, `<span class="${classes}">$1</span>`);
            highlightCount++;
        }
    }

    return html;
}


function displayLotSummary(summaryText) {
    const summaryContainer = document.getElementById('lot-summary-text');
    summaryContainer.innerHTML = highlightKeywords(summaryText);
}