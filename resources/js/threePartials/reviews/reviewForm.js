export function bindFormHandler(block) {
    const form = document.getElementById('block-review-form');
    const ratingInput = document.getElementById('rating-value');
    if (!form) return;

    document.querySelectorAll('input[name="stars"]').forEach(r => {
        r.addEventListener('change', () => ratingInput.value = r.value);
    });

    form.addEventListener('submit', async e => {
        e.preventDefault();
        const comment = document.getElementById('review-comment').value;
        const rating = ratingInput.value;
        if (!rating) return alert('Select a star rating');

        const formData = new FormData(form);
        try {
            const res = await fetch('/block-reviews', { method: 'POST', body: formData, credentials: 'same-origin' });
            if (res.ok) location.reload(); // re-render or fetch block
            else alert('Error submitting review');
        } catch(err) { console.error(err); alert('Something went wrong'); }
    });
}
