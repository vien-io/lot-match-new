import Chart from "chart.js/auto";
import { resolve } from "chart.js/helpers";
import { onBlockChange } from "../pages/forecast/block-forecast.js";

let sentimentChart = null;

// Render stars for forecast
export function renderStars(el, rating) {
    const rounded = Math.round(rating ?? 0);
    el.innerHTML = "★".repeat(rounded) + "☆".repeat(5 - rounded);
}

// Build sentiment datasets from backend
function buildSentimentDatasets(sentimentData) {
    if (!sentimentData || typeof sentimentData !== "object") {
        return { labels: [], datasets: [] };
    }

    const labels = Object.keys(sentimentData).sort();
    const positives = [];
    const neutrals = [];
    const negatives = [];

    for (const month of labels) {
        const entry = sentimentData[month];
        positives.push(entry.positive || 0);
        negatives.push(entry.negative || 0);
    }

    const datasets = [
        {
            label: "Positive",
            data: positives,
            borderColor: "rgba(75, 192, 192, 1)",
            tension: 0.3,
        },
        {
            label: "Negative",
            data: negatives,
            borderColor: "rgba(255, 99, 132, 1)",
            tension: 0.3,
        },
    ];

    return { labels, datasets };
}

// Render JSON forecast narrative nicely
function renderForecastNarrative(container, report) {
    if (!report) {
        container.innerHTML =
            '<p class="tw-text-gray-500">No forecast available.</p>';
        return;
    }

    let html = "";

    if (report.executive_summary) {
        html += `<div class="tw-mb-4">
      <h4 class="tw-font-semibold tw-text-[#1f2937] tw-mb-1">Executive Summary</h4>
      <p class="tw-text-sm tw-text-gray-700">${report.executive_summary}</p>
    </div>`;
    }

    if (report.sentiment_analysis) {
        html += `<div class="tw-mb-4">
      <h4 class="tw-font-semibold tw-text-[#1f2937] tw-mb-1">Sentiment Analysis</h4>
      <p class="tw-text-sm tw-text-gray-700">${report.sentiment_analysis}</p>
    </div>`;
    }

    if (report.monthly_sentiment && report.monthly_sentiment.length) {
        html += `<div class="tw-mb-4">
      <h4 class="tw-font-semibold tw-text-[#1f2937] tw-mb-1">Monthly Sentiment</h4>
      <table class="tw-w-full tw-text-sm tw-border tw-border-gray-200 tw-rounded">
        <thead class="tw-bg-gray-100">
          <tr>
            <th class="tw-px-3 tw-py-1 tw-text-left">Month</th>
            <th class="tw-px-3 tw-py-1 tw-text-left">Positive</th>
            <th class="tw-px-3 tw-py-1 tw-text-left">Negative</th>
          </tr>
        </thead>
        <tbody>
          ${report.monthly_sentiment
              .map(
                  (m) => `
            <tr class="tw-border-t tw-border-gray-200">
              <td class="tw-px-3 tw-py-1">${m.month}</td>
              <td class="tw-px-3 tw-py-1">${m.positive}</td>
              <td class="tw-px-3 tw-py-1">${m.negative}</td>
            </tr>`,
              )
              .join("")}
        </tbody>
      </table>
    </div>`;
    }

    if (report.forecast_details) {
        html += `<div class="tw-mb-4">
      <h4 class="tw-font-semibold tw-text-[#1f2937] tw-mb-1">Forecast Details</h4>
      <p class="tw-text-sm tw-text-gray-700">${report.forecast_details}</p>
    </div>`;
    }

    if (report.recommendations && report.recommendations.length) {
        html += `<div class="tw-mb-4">
      <h4 class="tw-font-semibold tw-text-[#1f2937] tw-mb-1">Recommendations</h4>
      <ul class="tw-list-disc tw-list-inside tw-text-sm tw-text-gray-700 tw-space-y-1">
        ${report.recommendations.map((r) => `<li>${r}</li>`).join("")}
      </ul>
    </div>`;
    }

    container.innerHTML = html;
}

export function renderSatisfaction(satisfaction) {
    const percentageDiv = document.getElementById("forecastPercentage");
    const ratingBar = document.getElementById("forecastRatingBar");

    if (!percentageDiv || !ratingBar) {
        return;
    }

    if (satisfaction == null || !Number.isFinite(Number(satisfaction))) {
        percentageDiv.textContent = "--";
        ratingBar.style.width = "0%";
        return;
    }

    // Keep the percentage within the valid 0–100 range.
    const percentage = Math.min(100, Math.max(0, Number(satisfaction)));

    percentageDiv.textContent = `${percentage.toFixed(1)}%`;
    ratingBar.style.width = `${percentage}%`;
}

// ON-BLOCK CHANGE
window.onBlockChange = onBlockChange;

// Initialize listener
function init() {
    const selector = document.getElementById("summaryBlockSelector");
    if (!selector) return;
    selector.addEventListener("change", () => onBlockChange(selector.value));
}

document.addEventListener("DOMContentLoaded", init);
