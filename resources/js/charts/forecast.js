import Chart from 'chart.js/auto';

let sentimentChart = null;

function renderStars(el, rating) {
  const rounded = Math.round(rating ?? 0);
  el.innerHTML = '★'.repeat(rounded) + '☆'.repeat(5 - rounded);
}

/**
 * Transform your saved sentiment JSON shape:
 * {
 *   "2024-11": { "positive": 4, "neutral": 1, "negative": 0 },
 *   "2024-12": { "positive": 0, "neutral": 1, "negative": 1 },
 *   ...
 * }
 * into Chart.js-friendly arrays.
 */
function buildSentimentDatasets(sentimentObj) {
  if (!sentimentObj || typeof sentimentObj !== 'object') {
    return { labels: [], datasets: [] };
  }

  // YYYY-MM sorts correctly lexicographically
  const labels = Object.keys(sentimentObj).sort();

  const positives = labels.map(m => (sentimentObj[m]?.positive ?? 0));
  const neutrals  = labels.map(m => (sentimentObj[m]?.neutral  ?? 0));
  const negatives = labels.map(m => (sentimentObj[m]?.negative ?? 0));

  return {
    labels,
    datasets: [
      { label: 'Positive', data: positives, borderWidth: 2, fill: false },
      { label: 'Neutral',  data: neutrals,  borderWidth: 2, fill: false },
      { label: 'Negative', data: negatives, borderWidth: 2, fill: false },
    ]
  };
}

async function onBlockChange(blockId) {
  const summaryDiv  = document.getElementById('aiSummary');
  const narrativeDiv = document.getElementById('aiForecastNarrative');
  const forecastDiv  = document.getElementById('aiForecastRating');
  const starsDiv     = document.getElementById('forecastStars');

  if (!blockId) {
    summaryDiv.textContent   = 'Select a block to see the summary.';
    narrativeDiv.textContent = 'Select a block to see the full forecast.';
    forecastDiv.textContent  = '--';
    starsDiv.innerHTML       = '☆☆☆☆☆';
    if (sentimentChart) sentimentChart.destroy();
    return;
  }

  summaryDiv.textContent   = 'Loading summary...';
  narrativeDiv.textContent = 'Loading forecast...';
  forecastDiv.textContent  = '--';
  starsDiv.innerHTML       = '☆☆☆☆☆';

  try {
    const res = await fetch(`/api/forecast/db/${blockId}`, {
      headers: { 'Accept': 'application/json' }
    });
    const data = await res.json();

    // Fill text sections
    summaryDiv.textContent   = data.summary || 'No summary available.';
    narrativeDiv.textContent = data.detailed_report || 'No full forecast narrative available.';
    forecastDiv.textContent  = data.forecast !== null ? `${data.forecast} / 5` : '--';
    renderStars(starsDiv, data.forecast);


    // Build & render chart
    if (sentimentChart) sentimentChart.destroy();
    const { labels, datasets } = buildSentimentDatasets(data.sentiment);

    if (labels.length) {
  const ctx = document.getElementById('sentimentChart').getContext('2d');
  sentimentChart = new Chart(ctx, {
    type: 'line',
    data: { labels, datasets },
    options: {
      responsive: true,
      maintainAspectRatio: false, // let the container handle height
      plugins: {
        legend: { position: 'bottom' },
        title: {
          display: true,
          text: 'Sentiment Trends Over Time'
        },
      },
      interaction: {
        intersect: false,
        mode: 'index', // show all tooltips on hover
      },
      scales: {
        x: {
          display: true,
          title: {
            display: true,
            text: 'Month'
          }
        },
        y: {
          display: true,
          title: {
            display: true,
            text: 'Number of Comments'
          },
          beginAtZero: true,
          suggestedMin: 0,
          suggestedMax: 10,
          ticks: { precision: 0 }
        }
      }
    }
  });
}

  } catch (err) {
    console.error(err);
    summaryDiv.textContent   = 'Error fetching summary.';
    narrativeDiv.textContent = '';
    forecastDiv.textContent  = '--';
    starsDiv.innerHTML       = '☆☆☆☆☆';
    if (sentimentChart) sentimentChart.destroy();
  }
}

function init() {
  const selector = document.getElementById('summaryBlockSelector');
  if (!selector) return;

  selector.addEventListener('change', function() {
    onBlockChange(this.value);
  });
}

document.addEventListener('DOMContentLoaded', init);