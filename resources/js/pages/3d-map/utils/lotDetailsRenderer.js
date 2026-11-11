export function renderLotDetails(detailsPanel, lot) {
    const template = document.getElementById("lot-details-template");

    if (!template || !detailsPanel) {
        console.error("Lot details template or container not found.");
        return;
    }

    const fragment = template.content.cloneNode(true);

    fragment.querySelectorAll("[data-field]").forEach(element => {
        const field = element.dataset.field;

        element.textContent = lot[field] ?? "N/A";
    });

    detailsPanel.replaceChildren(fragment);
}