
const searchForm = document.getElementById("propertyFilters");

// Only initialize property filters on pages containing the property form.
if (searchForm) {
    const searchInput = searchForm.querySelector('input[name="search"]');

    // Handle status and other property filters.
    function setPropertyFilter(name, value) {
        if (name === "status") {
            document.getElementById("statusFilter").value = value;
            updateStatusHighlight(value);
        }

        searchForm.requestSubmit();
    }

    // Handle status filter buttons.
    document.querySelectorAll("[data-status]").forEach(button => {
        button.addEventListener("click", () => {
            setPropertyFilter("status", button.dataset.status);
        });
    });

    let searchTimeout;
    let activeController = null;

    // Fetch and update the property table without reloading.
    async function fetchProperties(url, updateHistory = true) {
        if (activeController) {
            activeController.abort();
        }

        activeController = new AbortController();

        try {
            const response = await fetch(url, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest",
                    Accept: "application/json",
                },
                signal: activeController.signal,
            });

            if (!response.ok) {
                throw new Error("Failed to fetch properties.");
            }

            const data = await response.json();

            document.getElementById("propertyResults").outerHTML = data.html;

            if (updateHistory) {
                window.history.pushState({}, "", url);
            }
        } catch (error) {
            if (error.name !== "AbortError") {
                console.error(error);
            }
        }
    }

    // Intercept form submission.
    searchForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const params = new URLSearchParams(new FormData(searchForm));
        const url = `${searchForm.action}?${params.toString()}`;

        fetchProperties(url);
    });

    // Automatically search after the user stops typing.
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                searchForm.requestSubmit();
            }, 400);
        });
    }

    // Restore previous results when navigating browser history.
    window.addEventListener("popstate", function () {
        fetchProperties(window.location.href, false);
    });

    function updateStatusHighlight(selectedStatus) {
        document.querySelectorAll("[data-status]").forEach(button => {
            const isActive = button.dataset.status === selectedStatus;

            button.setAttribute("aria-pressed", isActive);

            button.classList.toggle("tw-border-[#06100D]", isActive);
            button.classList.toggle("tw-bg-[#06100D]", isActive);
            button.classList.toggle("tw-text-white", isActive);

            button.classList.toggle("tw-border-[#C4C4C4]", !isActive);
            button.classList.toggle("tw-bg-white", !isActive);
            button.classList.toggle("tw-text-[#444444]", !isActive);
        });
    }
}
