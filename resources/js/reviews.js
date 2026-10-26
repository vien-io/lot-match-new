document.addEventListener('DOMContentLoaded', function() {

    const blockSelector = document.getElementById('blockSelector');
    const reviewsContainer = document.getElementById('reviewsContainer');
    const averageRatingEl = document.getElementById('averageRating');
    const averageStarsEl = document.getElementById('averageStars');
    const totalReviewsEl = document.getElementById('totalReviews');

    if (!blockSelector || !reviewsContainer) return;

    function createReviewElement(review) {
        const article = document.createElement('article');

        article.className = `
            tw-flex tw-gap-3 tw-p-5 tw-transition-colors
            hover:tw-bg-[#D9D9D9]/15 sm:tw-gap-4 sm:tw-px-6
        `.trim().replace(/\s+/g, ' ');

        const userName = [
            review.user?.first_name,
            review.user?.last_name
        ].filter(Boolean).join(' ') || 'Deleted User';

        const avatar = review.user?.avatar ||
            `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=06100D&color=06EBB6&rounded=true`;

        const blockName = review.block?.name || 'Unknown Block';
        const rating = Math.max(0, Math.min(5, Number(review.rating) || 0));

        const date = review.created_at
            ? new Date(review.created_at)
            : null;

        const validDate = date && !Number.isNaN(date.getTime());

        const formattedDate = validDate
            ? date.toLocaleString('en-US', {
                month: 'short',
                day: 'numeric',
                year: 'numeric',
                hour: 'numeric',
                minute: '2-digit',
                hour12: true
            })
            : 'Date unavailable';

        // Avatar
        const avatarImg = document.createElement('img');
        avatarImg.src = avatar;
        avatarImg.alt = userName;
        avatarImg.loading = 'lazy';
        avatarImg.className =
            'tw-h-10 tw-w-10 tw-shrink-0 tw-rounded-full tw-border tw-border-[#C4C4C4]/60 tw-object-cover';

        // Content
        const content = document.createElement('div');
        content.className = 'tw-min-w-0 tw-flex-1';

        // Header
        const header = document.createElement('div');
        header.className =
            'tw-flex tw-flex-col tw-gap-2 sm:tw-flex-row sm:tw-items-start sm:tw-justify-between';

        const identity = document.createElement('div');
        identity.className = 'tw-min-w-0';

        const name = document.createElement('h3');
        name.className =
            'tw-break-words tw-text-sm tw-font-semibold tw-text-[#111111]';
        name.textContent = userName;

        const block = document.createElement('p');
        block.className = 'tw-mt-1 tw-text-xs tw-text-[#666666]';
        block.textContent = blockName;

        identity.append(name, block);

        const time = document.createElement('time');
        time.className = 'tw-shrink-0 tw-text-xs tw-text-[#666666]';
        time.textContent = formattedDate;

        if (validDate) {
            time.dateTime = date.toISOString();
        }

        header.append(identity, time);

        // Rating
        const ratingRow = document.createElement('div');
        ratingRow.className = 'tw-mt-2 tw-flex tw-items-center tw-gap-2';

        const stars = document.createElement('div');
        stars.className =
            'tw-flex tw-text-base tw-leading-none tw-text-[#B7791F]';
        stars.setAttribute('aria-label', `${rating} out of 5 stars`);
        stars.textContent = '★'.repeat(rating) + '☆'.repeat(5 - rating);

        const score = document.createElement('span');
        score.className =
            'tw-text-xs tw-font-medium tw-text-[#666666]';
        score.textContent = `${rating}.0 / 5`;

        ratingRow.append(stars, score);

        // Comment
        const comment = document.createElement('p');
        comment.className =
            'tw-mt-3 tw-whitespace-pre-line tw-break-words tw-text-sm tw-leading-6 tw-text-[#444444]';
        comment.textContent = review.comment || 'No comment provided.';

        content.append(header, ratingRow, comment);
        article.append(avatarImg, content);

        return article;
    }


    function renderReviews(reviews) {
        reviewsContainer.innerHTML = '';

        if (!reviews || reviews.length === 0) {
            reviewsContainer.innerHTML = `
                <div class="tw-flex tw-flex-col tw-items-center tw-px-6 tw-py-14 tw-text-center">
                    <div class="tw-flex tw-h-12 tw-w-12 tw-items-center tw-justify-center tw-rounded-xl tw-bg-[#D9D9D9]/50 tw-text-xl tw-text-[#666666]"
                        aria-hidden="true">
                        ★
                    </div>

                    <h3 class="tw-mt-4 tw-text-sm tw-font-semibold tw-text-[#111111]">
                        No reviews yet
                    </h3>

                    <p class="tw-mt-1 tw-max-w-sm tw-text-sm tw-leading-6 tw-text-[#666666]">
                        Be the first to share your experience and help the community make informed decisions.
                    </p>

                    <a href="#reviewForm"
                    class="tw-mt-4 tw-text-sm tw-font-semibold tw-text-[#111111] tw-underline tw-decoration-[#06EBB6] tw-decoration-2 tw-underline-offset-4 hover:tw-text-[#666666]">
                        Write the first review
                    </a>
                </div>
            `;
            return;
        }

        const fragment = document.createDocumentFragment();

        reviews.forEach(review => {
            fragment.appendChild(createReviewElement(review));
        });

        reviewsContainer.appendChild(fragment);
    }


    function renderNewReview(review) {
        if (!reviewsContainer || !review) return;

        // Remove the empty state if present.
        const emptyState = reviewsContainer.querySelector(
            '.tw-flex.tw-flex-col.tw-items-center.tw-px-6.tw-py-14'
        );

        if (emptyState) {
            emptyState.remove();
        }

        // Insert the new review at the top.
        reviewsContainer.prepend(createReviewElement(review));
    }

    // Fetch reviews for a specific block (or all blocks)
    async function fetchBlockReviews(blockId) {
        try {
            const url = blockId 
                ? `/blocks/${blockId}/reviews` 
                : `/blocks/all/reviews`; 
            const res = await fetch(url, { headers: { 'Accept': 'application/json' } });
            const data = await res.json();

            console.log("Fetched data: ", data);

            averageRatingEl.textContent = data.averageRating.toFixed(1);
            averageStarsEl.innerHTML = '★'.repeat(Math.round(data.averageRating)) + '☆'.repeat(5 - Math.round(data.averageRating));
            totalReviewsEl.textContent = `Based on ${data.totalReviews} reviews`;

            for (let i=5; i>=1; i--) {
                const bar = document.getElementById(`rating-bar-${i}`);
                const percent = data.totalReviews
                    ? (data.ratingCounts[i] / data.totalReviews) * 100
                    : 0;
                if (bar) bar.style.width = percent + '%';
            }

            renderReviews(data.reviews);
        } catch(err) {
            console.error(err);
        }
    }

    // Trigger fetch when user selects a block
    blockSelector.addEventListener('change', function() {
        console.log("Selected block id: ", this.value)
        fetchBlockReviews(this.value);
    });


    const form = document.getElementById('reviewForm');
    if (!form) return;

    const successMsg = document.getElementById('reviewSuccessMsg');

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
                const commentError = document.getElementById('commentError');

                if (data.message && commentError) {
                    commentError.textContent = data.message;
                    commentError.classList.remove('tw-hidden');
                } else if (data.errors?.comment && commentError) {
                    commentError.textContent = data.errors.comment.join(' ');
                    commentError.classList.remove('tw-hidden');
                } else if (data.errors) {
                    alert(Object.values(data.errors).flat().join('\n'));
                } else {
                    alert(data.message || 'Error submitting review. Please try again.');
                }
            }
        } catch (err) {
            console.error(err);
            alert('Unexpected error occurred.');
        }
    });
});