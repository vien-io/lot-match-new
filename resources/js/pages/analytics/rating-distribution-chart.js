
import Chart from "chart.js/auto";

let distChartInstance = null;

// ---------------- Rating Distribution Chart ----------------
export function renderRatingDistributionChart() {
    const dataEl = document.getElementById("ratings-data");
    if (!dataEl) return;

    const labels = JSON.parse(dataEl.dataset.ratingLabels);
    const counts = JSON.parse(dataEl.dataset.ratingCounts);

    const canvas = document.getElementById("ratingDistributionChart");
    const ctx = canvas?.getContext("2d");
    if (!ctx) return;

    distChartInstance?.destroy();

    const delays = {};
    labels.forEach((r, i) => {
        delays[r] = i * 200;
    });

    // Restrained LotMatch color palette
    const backgroundColors = [
        "#06100D", // Deep forest
        "#1D3830", // Dark green
        "#06EBB6", // Primary mint
        "#1ED9D7", // Teal
        "#A6EDE0", // Soft mint
    ];

    distChartInstance = new Chart(ctx, {
        type: "doughnut",

        data: {
            labels: labels.map((l) => `${l}-Star`),

            datasets: [
                {
                    label: "Rating Distribution",
                    data: counts,

                    backgroundColor: backgroundColors,

                    borderColor: "#FFFFFF",
                    borderWidth: 4,
                    borderRadius: 4,
                    hoverOffset: 7,

                    spacing: 2,
                },
            ],
        },

        options: {
            responsive: true,
            maintainAspectRatio: false,

            cutout: "68%",

            animation: {
                animateRotate: true,
                animateScale: true,

                delay: (ctx) =>
                    ctx.type === "data" && ctx.mode === "default"
                        ? delays[labels[ctx.dataIndex]] || 0
                        : 0,
            },

            interaction: {
                intersect: true,
                mode: "nearest",
            },

            plugins: {
                legend: {
                    position: "bottom",

                    labels: {
                        color: "#666666",
                        boxWidth: 10,
                        boxHeight: 10,
                        padding: 18,

                        usePointStyle: true,
                        pointStyle: "circle",

                        font: {
                            family: "Nunito, sans-serif",
                            size: 11,
                            weight: "600",
                        },
                    },
                },

                tooltip: {
                    backgroundColor: "#06100D",
                    titleColor: "#FFFFFF",
                    bodyColor: "#D9D9D9",

                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,

                    titleFont: {
                        family: "Nunito, sans-serif",
                        size: 12,
                        weight: "700",
                    },

                    bodyFont: {
                        family: "Nunito, sans-serif",
                        size: 11,
                        weight: "500",
                    },

                    callbacks: {
                        label: (tooltipItem) => {
                            const total = counts.reduce(
                                (sum, value) => sum + value,
                                0
                            );

                            const count = tooltipItem.raw;
                            const percentage = total
                                ? ((count / total) * 100).toFixed(1)
                                : 0;

                            return ` ${count} reviews (${percentage}%)`;
                        },
                    },
                },
            },
        },
    });
}
