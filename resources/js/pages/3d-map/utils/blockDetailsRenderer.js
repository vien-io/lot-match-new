export function renderBlockDetails(block) {
    const container = document.getElementById('block-details');

    if (!container || !block) return;

    const lots = block.lots ?? [];
    const reviews = block.reviews ?? [];

    // Calculate total lot area
    const totalLotArea = lots.reduce(
        (sum, lot) => sum + (parseFloat(lot.lot_area) || 0),
        0
    );

    // Calculate lot statuses
    const availableLots = lots.filter(
        lot => lot.status === 'available'
    ).length;

    const soldLots = lots.filter(
        lot => lot.status === 'sold'
    ).length;

    // Update Blade elements
    const fields = {
        'block-number': block.id ?? 'N/A',
        'total-lots': lots.length,
        'total-area': totalLotArea.toFixed(2),
        'available-lots': availableLots,
        'sold-lots': soldLots,
        'total-reviews': reviews.length,
    };

    Object.entries(fields).forEach(([key, value]) => {
        const element = container.querySelector(
            `[data-field="${key}"]`
        );

        if (element) {
            element.textContent = value;
        }
    });
}