export function renderLotStatus(statusElement, status) {
    const template = document.getElementById("lot-status-template");

    if (!template || !statusElement) {
        console.error("Lot status template or element not found.");
        return;
    }

    const fragment = template.content.cloneNode(true);
    const badge = fragment.querySelector("[data-field='status']");

    const normalizedStatus = status?.toLowerCase() ?? "unknown";

    // Set badge text
    badge.textContent = status
        ? status.charAt(0).toUpperCase() + status.slice(1)
        : "Unknown";

    // Set badge appearance
    badge.classList.remove(
        "tw-bg-green-50",
        "tw-text-green-700",
        "tw-bg-red-50",
        "tw-text-red-700",
    );

    if (normalizedStatus === "sold") {
        badge.classList.add("tw-bg-red-50", "tw-text-red-700");
    } else {
        badge.classList.add("tw-bg-green-50", "tw-text-green-700");
    }

    statusElement.replaceChildren(fragment);
}
