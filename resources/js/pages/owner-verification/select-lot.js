document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("owner-verification-form");
    const blockSelect = document.getElementById("block_id");
    const lotSelect = document.getElementById("lot_id");

    if (!form || !blockSelect || !lotSelect) return;

    // Read Laravel data from HTML attributes
    const lots = JSON.parse(form.dataset.lots || "[]");
    const oldBlockId = form.dataset.oldBlock;
    const oldLotId = form.dataset.oldLot;

    function updateLots(blockId, selectedLotId = null) {
        lotSelect.innerHTML = "";

        const filteredLots = lots.filter(
            lot => String(lot.block_id) === String(blockId)
        );

        if (!blockId || filteredLots.length === 0) {
            lotSelect.disabled = true;
            lotSelect.innerHTML =
                '<option value="">No available lots</option>';
            return;
        }

        lotSelect.disabled = false;

        const placeholder = document.createElement("option");
        placeholder.value = "";
        placeholder.textContent = "Choose a lot";
        placeholder.disabled = true;
        placeholder.selected = !selectedLotId;

        lotSelect.appendChild(placeholder);

        filteredLots.forEach(lot => {
            const option = document.createElement("option");

            option.value = lot.id;
            option.textContent = lot.name;

            if (String(lot.id) === String(selectedLotId)) {
                option.selected = true;
            }

            lotSelect.appendChild(option);
        });
    }

    blockSelect.addEventListener("change", () => {
        updateLots(blockSelect.value);
    });

    // Restore previous selections after validation errors
    if (oldBlockId) {
        blockSelect.value = oldBlockId;
        updateLots(oldBlockId, oldLotId);
    }
});
