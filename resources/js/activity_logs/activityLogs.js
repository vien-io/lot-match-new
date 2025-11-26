document.addEventListener('DOMContentLoaded', () => {
    const collapsedHeight = "1.5rem";

    // Select all toggle buttons for JSON boxes
    document.querySelectorAll('.toggle-json').forEach(button => {
        button.addEventListener('click', () => {
            // The JSON box is the previous sibling of the button
            const box = button.parentElement.previousElementSibling;

            if (box.dataset.expanded === 'true') {
                // ----------- COLLAPSE -----------
                box.textContent = box.dataset.truncated;
                box.dataset.expanded = 'false';

                box.style.whiteSpace = 'nowrap';
                box.style.overflow = 'hidden';
                box.style.textOverflow = 'ellipsis';
                box.style.maxHeight = collapsedHeight;

                button.textContent = 'View More';
            } else {
                // ----------- EXPAND -----------
                box.textContent = box.dataset.full;
                box.dataset.expanded = 'true';

                box.style.whiteSpace = 'pre-wrap';
                box.style.overflow = 'auto';
                box.style.textOverflow = 'unset';

                const scrollHeight = box.scrollHeight;
                box.style.maxHeight = (scrollHeight > 200 ? 200 : scrollHeight) + 'px';

                button.textContent = 'Hide';
            }
        });
    });
});
