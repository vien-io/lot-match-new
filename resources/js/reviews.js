document.addEventListener('DOMContentLoaded', function() {

    const blockSelector = document.getElementById('blockSelector');
    const reviewsContainer = document.getElementById('reviewsContainer');
    const averageRatingEl = document.getElementById('averageRating');
    const averageStarsEl = document.getElementById('averageStars');
    const totalReviewsEl = document.getElementById('totalReviews');

    if (!blockSelector || !reviewsContainer) return;

    // Render multiple reviews
    function renderReviews(reviews) {
        reviewsContainer.innerHTML = '';
        reviews.forEach(review => {
            const div = document.createElement('div');
            div.classList.add('tw-flex','tw-gap-3');

            const avatar = review.user?.avatar 
                || `https://ui-avatars.com/api/?name=${encodeURIComponent(review.user.name)}&background=34d399&color=fff&rounded=true`;

            const blockName = review.block?.name || `Block ${review.block_id}`;

            div.innerHTML = `
                <img src="${avatar}" class="tw-w-10 tw-h-10 tw-rounded-full" alt="user">
                <div>
                    <h3 class="tw-font-semibold tw-text-sm tw-text-[#1f2937]">
                        ${review.user.name} → ${blockName}
                    </h3>
                    <div class="tw-flex tw-text-yellow-400 tw-text-xs">
                        ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
                    </div>
                    <p class="tw-text-xs tw-text-gray-500 tw-mt-1">${review.comment || 'No comment'}</p>
                    <span class="tw-text-gray-400 tw-text-xs">${new Date(review.created_at).toLocaleString()}</span>
                </div>
            `;
            reviewsContainer.appendChild(div);
        });
    }

    // Fetch reviews for a specific block (or all blocks)
    async function fetchBlockReviews(blockId) {
        try {
            const url = blockId 
                ? `/blocks/${blockId}/reviews` 
                : `/blocks/all/reviews`; // Use the “all” route
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();

            averageRatingEl.textContent = data.averageRating.toFixed(1);
            averageStarsEl.innerHTML = '★'.repeat(Math.round(data.averageRating)) + '☆'.repeat(5 - Math.round(data.averageRating));
            totalReviewsEl.textContent = `Based on ${data.totalReviews} reviews`;

            renderReviews(data.reviews);
        } catch(err) {
            console.error(err);
        }
    }


    // Trigger fetch when user selects a block
    blockSelector.addEventListener('change', function() {
        fetchBlockReviews(this.value);
    });






    const form = document.getElementById('reviewForm');
    if (!form) return;

    const successMsg = document.getElementById('reviewSuccessMsg');
    const container = document.getElementById('reviewsContainer');

    // Function to render a single review at the top
    function renderNewReview(review) {
        if (!container || !review) return;

        const div = document.createElement('div');
        div.classList.add('tw-flex', 'tw-gap-3');

        const avatar = review.user.avatar 
            || `https://ui-avatars.com/api/?name=${encodeURIComponent(review.user.name)}&background=34d399&color=fff&rounded=true`;

        div.innerHTML = `
            <img src="${avatar}" class="tw-w-10 tw-h-10 tw-rounded-full" alt="user">
            <div>
                <h3 class="tw-font-semibold tw-text-sm tw-text-[#1f2937]">
                    ${review.user.name} → ${review.block.name}
                </h3>
                <div class="tw-flex tw-text-yellow-400 tw-text-xs">
                    ${'★'.repeat(review.rating)}${'☆'.repeat(5 - review.rating)}
                </div>
                <p class="tw-text-xs tw-text-gray-500 tw-mt-1">${review.comment || 'No comment'}</p>
                <span class="tw-text-gray-400 tw-text-xs">${new Date(review.created_at).toLocaleString()}</span>
            </div>
        `;

        container.prepend(div); // Add newest review on top
    }

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: formData
            });

            const data = await response.json();

            if (response.ok) {
                // Show success message without affecting layout
                if(successMsg){
                    successMsg.textContent = 'Review submitted successfully!';
                    successMsg.style.display = 'block';
                    setTimeout(() => successMsg.style.display = 'none', 3000); // hide after 3s
                }

                renderNewReview(data.review); // prepend new review
                form.reset();
            } else {
                if (data.errors) {
                    let messages = Object.values(data.errors).flat().join("\n");
                    alert(messages);
                } else {
                    alert('Error submitting review. Check console for details.');
                }
            }
        } catch (err) {
            console.error(err);
            alert('Unexpected error occurred.');
        }
    });
});