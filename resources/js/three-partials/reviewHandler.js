import { reviewFormTemplate } from './reviews/reviewFormTemplate';
import { reviewListTemplate } from './reviews/reviewListTemplate';
import './reviews/reviewStyles.css';
import { bindFormHandler, bindRatingLogic, resetReviewForm } from './reviews/reviewForm';
import { bindEditButtons, bindDeleteButtons } from './reviews/reviewButtons';

export function renderReviewSection(block) {
    const reviewSection = document.getElementById('block-review-section');
    reviewSection.innerHTML = `
        <div class="tw-space-y-6">
            ${reviewFormTemplate(block)}
            ${reviewListTemplate(block)}
        </div>
    `;

    resetReviewForm();
    bindRatingLogic();
    bindFormHandler(block);
    bindEditButtons(block);
    bindDeleteButtons();
}