<?php
/**
 * Before & After Detail — inline detail view showing all pairs for a category.
 * Toggled by JS when a grid item is clicked.
 */
?>
<div class="beaf-detail" id="beafDetail" aria-hidden="true">
    <div class="beaf-detail__content">
        <div class="beaf-detail__header">
            <button class="beaf-detail__back" id="beafDetailBack">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M10 3L5 8L10 13" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                Before / After
            </button>
            <h1 class="beaf-detail__title" id="beafDetailTitle"></h1>
        </div>
        <div class="beaf-detail__sliders" id="beafDetailSliders">
            <!-- Sliders injected by JS -->
        </div>
        <p class="beaf-detail__description" id="beafDetailDescription"></p>
    </div>
</div>
