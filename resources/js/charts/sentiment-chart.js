import { Chart } from "chart.js";

let sentimentChartInstance = null;

export function renderSentimentChart(sentiment) {
    const sentimentEmptyState = document.getElementById("sentimentEmptyState");
    const sentimentChartContainer = document.getElementById(
        "sentimentChartContainer",
    );
    const sentimentCanvas = document.getElementById("sentimentChart");

    // Convert the monthly sentiment object into sorted entries.
    const entries = Object.entries(sentiment ?? {}).sort(([monthA], [monthB]) =>
        monthA.localeCompare(monthB),
    );

    // No sentiment data available.
    if (entries.length === 0) {
        sentimentEmptyState.classList.remove("tw-hidden");
        sentimentChartContainer.classList.add("tw-hidden");

        if (sentimentChartInstance) {
            sentimentChartInstance.destroy();
            sentimentChartInstance = null;
        }

        return;
    }

    // Format YYYY-MM into readable labels, e.g. Jan 2026.
    const labels = entries.map(([month]) => {
        const [year, monthNumber] = month.split("-");

        return new Date(
            Number(year),
            Number(monthNumber) - 1,
            1,
        ).toLocaleDateString("en-US", {
            month: "short",
            year: "numeric",
        });
    });

    // Extract the sentiment counts for each month.
    const positiveData = entries.map(([, values]) =>
        Number(values.positive ?? 0),
    );

    const negativeData = entries.map(([, values]) =>
        Number(values.negative ?? 0),
    );

    // Show the chart and hide the empty state.
    sentimentEmptyState.classList.add("tw-hidden");
    sentimentChartContainer.classList.remove("tw-hidden");

    const chartData = {
        labels: labels,
        datasets: [
            {
                label: "Positive",
                data: positiveData,
                borderColor: "#06B88D",
                backgroundColor: "rgba(6, 184, 141, 0.10)",
                pointBackgroundColor: "#06B88D",
                pointBorderColor: "#FFFFFF",
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
            },
            {
                label: "Negative",
                data: negativeData,
                borderColor: "#E56B6F",
                backgroundColor: "rgba(229, 107, 111, 0.10)",
                pointBackgroundColor: "#E56B6F",
                pointBorderColor: "#FFFFFF",
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6,
                borderWidth: 2,
                tension: 0.3,
                fill: false,
            },
        ],
    };

    // Update the existing chart instead of creating duplicates.
    if (sentimentChartInstance) {
        sentimentChartInstance.data = chartData;
        sentimentChartInstance.update();
        return;
    }

    // Create the chart for the first time.
    sentimentChartInstance = new Chart(sentimentCanvas, {
        type: "line",
        data: chartData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: "index",
                intersect: false,
            },
            plugins: {
                legend: {
                    position: "top",
                    align: "end",
                    labels: {
                        usePointStyle: true,
                        pointStyle: "circle",
                        boxWidth: 8,
                        boxHeight: 8,
                        color: "#69736C",
                        padding: 16,
                        font: {
                            size: 11,
                        },
                    },
                },
                tooltip: {
                    backgroundColor: "#06100D",
                    padding: 10,
                    cornerRadius: 8,
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                    ticks: {
                        color: "#788179",
                    },
                    border: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        precision: 0,
                        stepSize: 1,
                        color: "#788179",
                    },
                    grid: {
                        color: "#E8EBE8",
                    },
                    border: {
                        display: false,
                    },
                },
            },
        },
    });
}
