import Chart from 'chart.js/auto';

let ratingsChartInstance = null;

// ---------------- Block Ratings Chart ----------------
export function renderBlockRatingsChart(callback) {
    const dataEl = document.getElementById("ratings-data");
    const canvas = document.getElementById("ratingsChart");

    if (!dataEl || !canvas) return;

    const blockIds = JSON.parse(dataEl.dataset.blockIds);
    const labels = JSON.parse(dataEl.dataset.blockLabels);
    const ratings = JSON.parse(dataEl.dataset.blockRatings);
    const reviews = JSON.parse(dataEl.dataset.blockReviews);

    const ctx = canvas.getContext("2d");
    if (!ctx) return;

    // Prepare chart data
    const blocks = blockIds.map((id, i) => ({
        id: Number(id),
        name: labels[i],
        rating: Number(ratings[i]),
        review: Number(reviews[i]),
    }));

    // Current filter
    let activeFilter = "top";

    // Filter buttons
    const filterButtons = document.querySelectorAll("[data-rating-filter]");

    // Chart container
    const chartContainer = canvas.closest("[data-chart-container]");

    function updateChart(filter = activeFilter) {
        activeFilter = filter;

        let filteredBlocks = [...blocks];

        // Apply selected filter
        if (filter === "top") {
            filteredBlocks.sort(
                (a, b) =>
                    b.rating - a.rating || b.review - a.review || a.id - b.id,
            );

            filteredBlocks = filteredBlocks.slice(0, 10);
        } else if (filter === "lowest") {
            filteredBlocks.sort(
                (a, b) =>
                    a.rating - b.rating || b.review - a.review || a.id - b.id,
            );

            filteredBlocks = filteredBlocks.slice(0, 10);
        } else {
            // All blocks: maintain block number order
            filteredBlocks.sort((a, b) => a.id - b.id);
        }

        const isHorizontal = filter === "all";

        const chartLabels = filteredBlocks.map((block) => block.name);
        const chartRatings = filteredBlocks.map((block) => block.rating);
        const chartReviews = filteredBlocks.map((block) => block.review);

        // Update filter button states
        filterButtons.forEach((button) => {
            const isActive = button.dataset.ratingFilter === filter;
            button.setAttribute("aria-pressed", String(isActive));
        });

        // Give all 37 horizontal bars enough vertical space
        if (chartContainer) {
            chartContainer.style.height = isHorizontal
                ? `${Math.max(600, filteredBlocks.length * 30 + 100)}px`
                : "360px";
        }

        // Destroy previous chart before rendering
        ratingsChartInstance?.destroy();

        // Axis configuration changes based on orientation
        const scales = isHorizontal
            ? {
                  x: {
                      type: "linear",
                      position: "bottom",
                      beginAtZero: true,
                      min: 0,
                      max: 5,

                      grid: {
                          color: "#EEF1EF",
                          drawTicks: false,
                      },

                      border: {
                          display: false,
                      },

                      title: {
                          display: true,
                          text: "Average Rating",
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 12,
                              weight: "600",
                          },
                      },

                      ticks: {
                          stepSize: 1,
                          color: "#666666",
                          padding: 8,
                      },
                  },

                  x1: {
                      type: "linear",
                      position: "top",
                      beginAtZero: true,
                      suggestedMax: Math.max(...chartReviews) * 1.5,

                      grid: {
                          drawOnChartArea: false,
                      },

                      border: {
                          display: false,
                      },

                      title: {
                          display: true,
                          text: "Number of Reviews",
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 12,
                              weight: "600",
                          },
                      },

                      ticks: {
                          precision: 0,
                          color: "#666666",
                          padding: 8,
                      },
                  },

                  y: {
                      grid: {
                          display: false,
                      },

                      border: {
                          display: false,
                      },

                      ticks: {
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 11,
                          },
                      },
                  },
              }
            : {
                  x: {
                      grid: {
                          display: false,
                      },

                      border: {
                          display: false,
                      },

                      title: {
                          display: true,
                          text: "Blocks",
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 12,
                              weight: "600",
                          },
                          padding: { top: 12 },
                      },

                      ticks: {
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 11,
                          },
                      },
                  },

                  y: {
                      beginAtZero: true,
                      min: 0,
                      max: 5,

                      position: "left",

                      grid: {
                          color: "#EEF1EF",
                          drawTicks: false,
                      },

                      border: {
                          display: false,
                      },

                      title: {
                          display: true,
                          text: "Average Rating",
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 12,
                              weight: "600",
                          },
                      },

                      ticks: {
                          stepSize: 1,
                          color: "#666666",
                          padding: 10,
                      },
                  },

                  y1: {
                      beginAtZero: true,
                      position: "right",
                      suggestedMax: Math.max(...chartReviews) * 1.5,

                      grid: {
                          drawOnChartArea: false,
                      },

                      border: {
                          display: false,
                      },

                      title: {
                          display: true,
                          text: "Number of Reviews",
                          color: "#666666",
                          font: {
                              family: "Nunito, sans-serif",
                              size: 12,
                              weight: "600",
                          },
                      },

                      ticks: {
                          precision: 0,
                          color: "#666666",
                          padding: 10,
                      },
                  },
              };

        ratingsChartInstance = new Chart(ctx, {
            type: "bar",

            data: {
                labels: chartLabels,

                datasets: [
                    {
                        label: "Average Rating",
                        data: chartRatings,

                        ...(isHorizontal ? { xAxisID: "x" } : { yAxisID: "y" }),

                        backgroundColor: "#06EBB6",
                        hoverBackgroundColor: "#1ED9D7",

                        borderRadius: 5,
                        borderSkipped: false,

                        barPercentage: 0.7,
                        categoryPercentage: 0.75,
                    },
                    {
                        label: "Number of Reviews",
                        data: chartReviews,

                        ...(isHorizontal
                            ? { xAxisID: "x1" }
                            : { yAxisID: "y1" }),

                        backgroundColor: "#06100D",
                        hoverBackgroundColor: "#1D3830",

                        borderRadius: 5,
                        borderSkipped: false,

                        barPercentage: 0.7,
                        categoryPercentage: 0.75,
                    },
                ],
            },

            options: {
                indexAxis: isHorizontal ? "y" : "x",

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
                            pointStyle: "rectRounded",
                            boxWidth: 8,
                            boxHeight: 8,
                            padding: 20,
                            color: "#666666",

                            font: {
                                family: "Nunito, sans-serif",
                                size: 12,
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
                        boxPadding: 5,

                        callbacks: {
                            title(context) {
                                return chartLabels[context[0].dataIndex];
                            },

                            label(context) {
                                const value = isHorizontal
                                    ? context.parsed.x
                                    : context.parsed.y;

                                if (
                                    context.dataset.label === "Average Rating"
                                ) {
                                    return ` Average Rating: ${value.toFixed(2)} / 5`;
                                }

                                return ` Reviews: ${value}`;
                            },
                        },
                    },
                },

                animation: {
                    duration: 600,

                    onComplete: () => {
                        if (callback) callback();
                    },
                },

                scales,
            },
        });
    }

    // Attach filter listeners only once
    const filterGroup = document.getElementById("blockRatingFilters");

    if (filterGroup && !filterGroup.dataset.initialized) {
        filterGroup.addEventListener("click", (event) => {
            const button = event.target.closest("[data-rating-filter]");

            if (!button) return;

            updateChart(button.dataset.ratingFilter);
        });

        filterGroup.dataset.initialized = "true";
    }

    // Initial chart
    updateChart("top");
}
